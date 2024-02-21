/* 
   Adds editor scripts
*/

// Add text after .editor-post-featured-image
wp.domReady(() => {
    const observer = new MutationObserver((mutations, obs) => {
        const panel = document.querySelector('.editor-post-featured-image');
        if (panel) {
            // Element is now available
            addCustomText(panel);
            obs.disconnect(); // Stop observing once we've added our custom text
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});

function addCustomText(targetNode) {
    const featuredImageText = document.createElement('div');
    featuredImageText.innerHTML = '<p class="post-description"><span class="label">INFO</span> This image will be used as a logotype</p><p><span class="important">Provide at least 1000x1000px image in transparent * .png format.</span></p>';
    // featuredImageText.className = 'post-description';
    featuredImageText.style.marginTop = '10px';
    targetNode.parentNode.insertBefore(featuredImageText, targetNode.nextSibling);
}

// Display a notice
wp.data.dispatch('core/notices').createNotice(
    'success', // Type of notice
    'Directory › Knowledge › La fiche a été automatiquement mise en page.', // Notice message
    {
        isDismissible: true, // Whether the user can dismiss the notice
        // Any additional options
    }
);