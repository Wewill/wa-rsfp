/**
 * Retrieves the translation of text.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-i18n/
 */
import { __ } from '@wordpress/i18n';

/**
 * React hook that is used to mark the block wrapper element.
 * It provides all the necessary props like the class name.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/packages/packages-block-editor/#useblockprops
 */
import { useBlockProps, RichText, InnerBlocks } from '@wordpress/block-editor';

/**
 * Retrieving the post
 */
import { useEntityProp } from '@wordpress/core-data';

/**
 * Listening
 */
import { useEffect } from '@wordpress/element';

/**
 * Lets webpack process CSS, SASS or SCSS files referenced in JavaScript files.
 * Those files can contain any CSS code that gets applied to the editor.
 *
 * @see https://www.npmjs.com/package/@wordpress/scripts#using-css
 */
import './editor.scss';

/**
 * The edit function describes the structure of your block in the context of the
 * editor. This represents what the editor will render when the block is used.
 *
 * @see https://developer.wordpress.org/block-editor/reference-guides/block-api/block-edit-save/#edit
 *
 * @return {Element} Element to render.
 */

export default function Edit( {
	context: { postType, postId },
} ) {

    // Use blockProps for any necessary wrapper attributes (className, id, etc.)
    const blockProps = useBlockProps();

	// Get meta props
	const [ meta, updateMeta ] = useEntityProp(
		'postType',
		postType,
		'meta',
		postId
	);

	console.log('meta::', meta);

	// Get custom post meta
	const { d_general_subtitle } = meta;
	const { d_general_introduction } = meta;

	// Mirror update block from custom meta input in page
	// https://wordpress.stackexchange.com/questions/417626/force-update-the-meta-variable-first-set-using-var-meta-setmeta-useentityp
	// Single
	// useEffect(() => {
	// 	// Define an array of input IDs and their corresponding meta keys
	// 	const inputMetaPairs = [
	// 	  { inputId: 'd_general_subtitle', metaKey: 'd_general_subtitle' },
	// 	  { inputId: 'd_general_introduction', metaKey: 'd_general_introduction' }, // RTE are not working
	// 	  // Add more pairs here as needed
	// 	  // { inputId: 'another_input_id', metaKey: 'another_meta_key' },
	// 	];

	// 	// Function to handle input changes
	// 	const handleInputChange = (metaKey) => (event) => {
	// 	  const newContent = event.target.value;
	// 	  updateMeta({
	// 		...meta,
	// 		[metaKey]: newContent,
	// 	  });
	// 	};

	// 	// Iterate over each input-meta pair and attach event listeners
	// 	inputMetaPairs.forEach(({ inputId, metaKey }) => {
	// 	  const inputElement = document.getElementById(inputId);
	// 	  if (inputElement) {
	// 		inputElement.addEventListener('input', handleInputChange(metaKey));
	// 	  }
	// 	});

	// 	// Cleanup function to remove event listeners
	// 	return () => {
	// 	  inputMetaPairs.forEach(({ inputId, metaKey }) => {
	// 		const inputElement = document.getElementById(inputId);
	// 		if (inputElement) {
	// 		  inputElement.removeEventListener('input', handleInputChange(metaKey));
	// 		}
	// 	  });
	// 	};
	//   }, [meta, updateMeta]); // Dependencies array, re-run effect if these values change

	// Define an array of input IDs and their corresponding meta keys
	const inputMetaPairs = [
		{ inputId: 'd_general_subtitle', metaKey: 'd_general_subtitle' },
		{ inputId: 'd_general_introduction', metaKey: 'd_general_introduction' },
		// Add more pairs here as needed
		// { inputId: 'another_input_id', metaKey: 'another_meta_key' },
	];

	// Multiple
	useEffect(() => {

		// Function to handle input changes
		const handleInputChange = (metaKey) => (event) => {
		  const newContent = event.target.value;
		  updateMeta({
			...meta,
			[metaKey]: newContent,
		  });
		};

		// Iterate over each input-meta pair and attach event listeners
		inputMetaPairs.forEach(({ inputId, metaKey }) => {
		  const inputElement = document.getElementById(inputId);
		  if (inputElement) {
			inputElement.addEventListener('input', handleInputChange(metaKey));
		  }
		});

		// Cleanup function to remove event listeners
		return () => {
		  inputMetaPairs.forEach(({ inputId, metaKey }) => {
			const inputElement = document.getElementById(inputId);
			if (inputElement) {
			  inputElement.removeEventListener('input', handleInputChange(metaKey));
			}
		  });
		};
	  }, [updateMeta]); // Dependencies array, re-run effect if these values change



	// Define the allowed blocks and default template structure
	const ALLOWED_BLOCKS = ['core/image', 'core/heading', 'core/paragraph'];
	const TEMPLATE = [
		['core/paragraph', { placeholder: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' }], // Add a paragraph block
		['core/image', {}], // Add an image block
	];

	return (
		<div { ...blockProps }>
			<RichText
				placeholder={ __( 'Subtitle', 'wa-rsfp' ) }
				tagName="span"
				allowedFormats={ [] }
				disableLineBreaks
				value={ d_general_subtitle }
				onChange={ ( newContent ) => {
						// Regular way to update meta value id "d_general_subtitle"
						// updateMeta( { ...meta, d_general_subtitle: newContent });
						// Directly update the element's value of an input displayed in the same page with id "d_general_subtitle"
						const inputElement = document.getElementById('d_general_subtitle');
						if (inputElement) { inputElement.value = newContent; }
					}
				}
			/>
			<div class="lead">
				<RichText
					placeholder={ __( 'Introduction', 'wa-rsfp' ) }
					tagName="p"
					value={ d_general_introduction }
					onChange={ ( newContent ) => {
							const inputElement = document.getElementById('d_general_introduction');
							if (inputElement) { inputElement.value = newContent; }
						}
					}
				/>
			</div>
			<InnerBlocks
                allowedBlocks={ALLOWED_BLOCKS}
                template={TEMPLATE}
                templateLock={false} // Change to "all" to lock the template structure
            />
		</div>
	);

}
