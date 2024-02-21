/* 
   Adds Markdown capabilities to Input & textareas that have a class "enable-markdown"
*/
document.addEventListener('keydown', function(e) {
    if (!e.metaKey && !e.ctrlKey) return;

    const activeElement = document.activeElement;
    // Check if the active element is an input or textarea
    const isInputOrTextarea = activeElement.tagName === 'INPUT' || activeElement.tagName === 'TEXTAREA';
    // Function to navigate up the DOM to get the grandparent element and check for a class
    function hasParentWithClass(element, className, levelsUp) {
        let currentElement = element;
        for (let i = 0; i < levelsUp; i++) {
            if (!currentElement.parentElement) return false; // Reached the top of the DOM tree without finding the class
            currentElement = currentElement.parentElement;
            if (currentElement.classList.contains(className)) return true;
        }
        return false;
    }

    // Check if the active element's grandparent or great-grandparent has the 'enable-markdown' class
    const hasMarkdownClass = hasParentWithClass(activeElement, 'enable-markdown', 3);

    // Only proceed if the active element is an input or textarea and its grandparent has the 'enable-markdown' class
    if (!(isInputOrTextarea && hasMarkdownClass)) return;

    let markdownSymbol;
    // Check for Shift key in combination with others
    if (e.shiftKey) {
        switch (e.key) {
            case 'L': // Now using Command + Shift + L
                markdownSymbol = '***'; // Label
                break;
            case 'S': // Now using Command + Shift + S
                markdownSymbol = '#'; // Small
                break;
            case 'H': // Now using Command + Shift + H
                markdownSymbol = '##'; // Huge
                break;
        }
    } else {
        switch (e.key) {
            case 'b': // Command + b
                markdownSymbol = '**'; // Bold 
                break;
            case 'i': // Command + i
                markdownSymbol = '*'; // Italic
                break;
        }
    }

    if (!markdownSymbol) return; // Exit if no markdownSymbol has been set

    e.preventDefault(); // Prevent the default action

    wrapOrUnwrapText(activeElement, markdownSymbol);
});

function wrapOrUnwrapText(input, symbol) {
    const start = input.selectionStart;
    const end = input.selectionEnd;
    const selectedText = input.value.substring(start, end);
    const symbolLength = symbol.length;
    const wrappedText = `${symbol}${selectedText}${symbol}`;

    // Check if the selected text is already wrapped with the symbol
    if (selectedText.startsWith(symbol) && selectedText.endsWith(symbol)) {
        // Unwrap the text
        const unwrappedText = selectedText.slice(symbolLength, -symbolLength);
        input.value = input.value.substring(0, start) + unwrappedText + input.value.substring(end);
        input.setSelectionRange(start, start + unwrappedText.length);
		displayGutenbergNotice("Markdown has been removed");
    } else {
        // Wrap the text
        input.value = input.value.substring(0, start) + wrappedText + input.value.substring(end);
        input.setSelectionRange(start, start + wrappedText.length);
		displayGutenbergNotice("Markdown has been applied");
    }
}

function displayGutenbergNotice(message) {
    // Create the notice container if it doesn't already exist
    let noticeContainer = document.getElementById('custom-fixed-notice-container');
    if (!noticeContainer) {
        noticeContainer = document.createElement('div');
        noticeContainer.id = 'custom-fixed-notice-container';
        document.body.appendChild(noticeContainer);

        // Style the container
        noticeContainer.style.position = 'fixed';
        noticeContainer.style.bottom = '20px';
        noticeContainer.style.right = '20px';
        noticeContainer.style.zIndex = '10000';
        noticeContainer.style.maxWidth = '300px';
    }

    // Create the notice element
    const notice = document.createElement('div');
    notice.textContent = message;
    notice.style.background = 'rgba(0, 0, 0, 0.7)';
    notice.style.color = 'white';
    notice.style.padding = '10px';
    notice.style.marginTop = '10px';
    notice.style.borderRadius = '5px';
    notice.style.boxShadow = '0 2px 4px rgba(0,0,0,0.2)';

    // Add the notice to the container
    noticeContainer.appendChild(notice);

    // Remove the notice after 3 seconds
    setTimeout(() => {
        noticeContainer.removeChild(notice);
        // If no more notices, remove the container
        if (!noticeContainer.hasChildNodes()) {
            document.body.removeChild(noticeContainer);
        }
    }, 3000);
}