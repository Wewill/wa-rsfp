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

import './css/bootstrap-grid.min.css'; // import boostrap to projet 
import './css/bootstrap-utilities.min.css'; // import boostrap to projet 
// import '../../../../../../themes/waffthree/dist/css/style-rsfp.css'; // import boostrap to projet 
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

	// Get identity meta
	const { d_identity_location, d_identity_area, d_identity_number_of_people, d_identity_livestock, d_identity_label, d_identity_commercialization} = meta;
	const d_identity_label_li = (d_identity_label || []).map((label, index) =>
		<li class="lead" key={index}>{label}</li>
	);
	const d_identity_commercialization_p = (d_identity_commercialization || []).map((label, index) =>
		<p class="mb-0" key={index}>{label}</p>
	);

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
	const ALLOWED_BLOCKS = [
		'core/image', 
		'core/heading', 
		'core/paragraph', 
		'core/list', 
		'core/quote', 
		'core/pullquote', 
		'core/block', 
		'core/button', 
		'core/buttons', 
		'core/column', 
		'core/columns', 
		'core/table', 
		'core/text-columns', 
		//
		'coblocks/accordion',
		'coblocks/accordion-item',
		'coblocks/alert',
		'coblocks/counter',
		'coblocks/column',
		'coblocks/row',
		'coblocks/dynamic-separator',
		'coblocks/logos',
		'coblocks/icon',
		'coblocks/buttons',
		// 
		'directory/wa-rsfp-directory-block',
		// Add metabox.io testimony block
		'meta-box/rsfp-readmore',
	];
	const TEMPLATE = [
		['core/paragraph', { placeholder: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.' }], // Add a paragraph block
		['core/image', {}], // Add an image block
	];

	return (
		<div { ...blockProps }>
			<RichText
				placeholder={ __( 'Sous-titre', 'wa-rsfp' ) }
				tagName="h4"
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

			<RichText
				placeholder={ __( 'Introduction', 'wa-rsfp' ) }
				tagName="p"
				className='lead'
				value={ d_general_introduction }
				onChange={ ( newContent ) => {
						const inputElement = document.getElementById('d_general_introduction');
						if (inputElement) { inputElement.value = newContent; }
					}
				}
			/>

			<section class="mb-2 d-none">
				<div class="container-fluid px-0">
					<div class="row g-0">

						<div class="col-lg-5 col-xl-5 bg-action-1 p-4 p-lg-5 rounded-bottom-4 rounded-bottom-right-0" data-aos="fade-down" data-aos-delay="300">
							<h6 class="subline text-action-1">Map</h6>
						</div>

						<div class="col-lg overflow-hidden bg-color-layout p-4 p-lg-5 rounded-bottom-4 rounded-bottom-left-0" data-aos="fade-left" data-aos-delay="100">

							<div class="w-100 d-flex align-items-center justify-content-between">
								<h6 class="subline text-action-1">Carte d'identité</h6>
							</div>

							<div class="row row-cols-1 row-cols-md-2 g-4 pt-3 py-2 py-md-5">

								{ d_identity_location && <div class="col d-flex align-items-center">
									<i class="bi bi-bootstrap flex-shrink-0 me-3 h4"></i>
									<div>
									<h6 class="fw-bold">{ __( 'Location', 'wa-rsfp' ) }</h6>
									<p class="lead mb-0 mb-md-4">{ d_identity_location }</p>
									</div>
								</div> }

								{ d_identity_area && <div class="col d-flex align-items-center">
									<i class="bi bi-bootstrap flex-shrink-0 me-3 h4"></i>
									<div>
									<h6 class="fw-bold">{ __( 'Area (in ha)', 'wa-rsfp' )}</h6>
									<p class="lead mb-0 mb-md-4">{ d_identity_area }</p>
									</div>
								</div> }

								{ d_identity_number_of_people && <div class="col d-flex align-items-center">
									<i class="bi bi-bootstrap flex-shrink-0 me-3 h4"></i>
									<div>
									<h6 class="fw-bold">{__( 'Number of people', 'wa-rsfp' )}</h6>
									<p class="lead mb-0 mb-md-4">{ d_identity_number_of_people }</p>
									</div>
								</div> }

								{ d_identity_livestock && <div class="col d-flex align-items-center">
									<i class="bi bi-bootstrap flex-shrink-0 me-3 h4"></i>
									<div>
									<h6 class="fw-bold">{ __( 'Livestock', 'wa-rsfp') }</h6>
									<p class="lead mb-0 mb-md-4">{ d_identity_livestock }</p>
									</div>
								</div> }

								{ d_identity_label && <div class="col d-flex align-items-center">
									<i class="bi bi-bootstrap flex-shrink-0 me-3 h4"></i>
									<div>
									<h6 class="fw-bold">{ __( 'Label', 'wa-rsfp') }</h6>
									<ul class="ps-4 list-group list-group-flush">{ d_identity_label_li }</ul>
									</div>
								</div> }

							</div>

							<div class="row row-cols-1 row-cols-md-1 g-4 py-2 py-md-5">

								{ d_identity_commercialization && <div class="col d-flex align-items-center">
									<i class="bi bi-bootstrap flex-shrink-0 me-3 h4"></i>
									<div>
									<h6 class="fw-bold">{ __( 'Commercialization', 'wa-rsfp') }</h6>
									{ d_identity_commercialization_p }
									</div>
								</div> }

							</div>

						</div>

					</div>
				</div>
			</section>

			<section class="content">
					<InnerBlocks
						allowedBlocks={ALLOWED_BLOCKS}
						template={TEMPLATE}
						templateLock={false} // Change to "all" to lock the template structure
					/>
			</section>

		</div>
	);

}
