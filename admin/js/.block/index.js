// ( function( blocks, element, blockEditor, data ) {
//     var el = element.createElement;
//     var useSelect = data.useSelect;
//     var RichText = blockEditor.RichText;
//     var useBlockProps = blockEditor.useBlockProps;

//     blocks.registerBlockType( 'custom-meta-block/meta-block', {
//         title: 'Custom Meta Block',
//         icon: 'admin-post',
//         category: 'common',
//         attributes: {
//             content: {
//                 type: 'string',
//                 source: 'meta',
//                 meta: 'd_general_subtitle',
//             },
//         },

//         edit: function( props ) {
//             return el(
//                 'div',
//                 {},
//                 'Simple Block Content'
//             );
//         },

//         save: function() {
//             return null; // Content saved to meta, so save function is null
//         },
//     } );
// } )( window.wp.blocks, window.wp.element, window.wp.blockEditor, window.wp.data );


// ( function( blocks, element ) {
//     var el = element.createElement;
//     var registerBlockType = blocks.registerBlockType;

//     registerBlockType( 'custom-meta-block/meta-block', {
//         title: 'Custom Meta Block',
//         icon: 'admin-post',
//         category: 'common',

//         edit: function() {
//             return el(
//                 'div',
//                 {},
//                 'Simple Block Content'
//             );
//         },

//         save: function() {
//             return el(
//                 'div',
//                 {},
//                 'Simple Block Content'
//             );
//         },
//     } );
// } )( window.wp.blocks, window.wp.element );

wp.blocks.registerBlockType('custom-meta-block/meta-block', {
    title: 'Custom Meta Block',
    icon: 'admin-post',
    category: 'text',
    attributes: {
        content: {
            type: 'string',
            default: '',
        },
    },
    edit: function(props) {
        var metaValue = wp.data.useSelect(function(select) {
            return select('core/editor').getEditedPostAttribute('meta')['d_general_subtitle'];
        }, []);

        function onChangeContent(newValue) {
            wp.data.useDispatch('core/editor').editPost({
                meta: { 'd_general_subtitle': newValue }
            });
        }

        return wp.element.createElement(wp.blockEditor.RichText, {
            tagName: 'p',
            value: metaValue,
            onChange: onChangeContent,
        });
    },
    save: function() {
        return null; // Content is saved to post meta, rendering is handled server-side
    },
});
