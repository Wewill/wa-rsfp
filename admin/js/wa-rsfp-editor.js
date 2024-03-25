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
wp.data.dispatch('core/notices').createNotice(
    'success', // Type of notice
    'Directory › Knowledge › La fiche a été automatiquement mise en page.', // Notice message
    {
        isDismissible: true, // Whether the user can dismiss the notice
        // Any additional options
    }
);