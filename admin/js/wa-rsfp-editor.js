/* 
   Adds editor scripts
*/

// Add text after metabox
wp.domReady(() => {
    // Featured metabox
    const featuredObserver = new MutationObserver((mutations, obs) => {
        const featuredPanel = document.querySelector('.editor-post-featured-image');
        if (featuredPanel) {
            // Element is now available
            addCustomText(featuredPanel, '<p class="post-description"><span class="label">INFO</span> This image will be used as a logotype</p><p><span class="important">Provide at least 1000x1000px image in transparent * .png format.</span></p>');
            obs.disconnect(); // Stop observing once we've added our custom text
        }
    });

    // Taxonomies metabox
    const taxonomiesObserver = new MutationObserver((mutations, obs) => {
        const taxonomiesPanel = document.querySelector('.editor-post-taxonomies__hierarchical-terms-list');
        if (taxonomiesPanel) {
            // Element is now available
            addCustomText(taxonomiesPanel, '<p class="post-description"><span class="label">INFO</span> Both choose a geography & geolocation of attached farm. </p><p><span class="important">Only one geography is allowed.</span></p>');
            obs.disconnect(); // Stop observing once we've added our custom text
        }
    });
    
    // Start observing for both sections
    featuredObserver.observe(document.body, {
        childList: true,
        subtree: true
    });
    taxonomiesObserver.observe(document.body, {
        childList: true,
        subtree: true
    });
});

function addCustomText(targetNode, html) {
    const customText = document.createElement('div');
    customText.innerHTML = html;
    // customText.className = 'post-description';
    customText.style.marginTop = '10px';
    targetNode.parentNode.insertBefore(customText, targetNode.nextSibling);
}

/* 
   Adds editor notices
*/

// Display a notice
// wp.data.dispatch('core/notices').createNotice(
//     'success', // Type of notice
//     'Directory › Knowledge › La fiche a été automatiquement mise en page.', // Notice message
//     {
//         isDismissible: true, // Whether the user can dismiss the notice
//         // Any additional options
//     }
// );

// Display a notice if no featured image set 
( function( wp ) {
    var __ = wp.i18n.__;
    var useEffect = wp.element.useEffect;
    var useSelect = wp.data.useSelect;
    var dispatch = wp.data.dispatch;

    function MyFeaturedImageNotice() {
        // Unique identifier for the notice.
        const noticeId = 'my-featured-image-notice';

        var featuredImageId = useSelect( function( select ) {
            return select('core/editor').getEditedPostAttribute('featured_media');
        }, [] );

        useEffect(() => {
            // If there is no featured image, display the notice.
            if ( !featuredImageId ) {
                dispatch( 'core/notices' ).createNotice(
                    'warning', // Can be one of: success, info, warning, error.
                    __( 'This post has no featured image. Consider setting one.' ), // Text string to display.
                    {
                        id: noticeId, // Use the unique identifier for the notice.
                        isDismissible: true, // Whether the user can dismiss the notice.
                        // Any actions the user can perform.
                    }
                );
            } else {
                // If a featured image is set, remove the notice.
                dispatch( 'core/notices' ).removeNotice( noticeId );
            }
        }, [featuredImageId]); // Re-run this effect only if featuredImageId changes.

        // Return null because this component doesn't render anything itself.
        return null;
    }

    wp.plugins.registerPlugin( 'my-featured-image-notice', {
        render: MyFeaturedImageNotice
    } );
} )( window.wp );