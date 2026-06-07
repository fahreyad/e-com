require('./bootstrap');
import anchor from '@alpinejs/anchor'

import Alpine from 'alpinejs';
Alpine.plugin(anchor)
window.Alpine = Alpine;
Alpine.start();


document.addEventListener('DOMContentLoaded', () => {
    // Find all elements with the class 'only-number'
    const onlyNumberContainers = document.querySelectorAll('.only-number');

    // Add a listener to each container
    onlyNumberContainers.forEach(container => {
        container.addEventListener('input', (event) => {
            const input = event.target;
            // Check if the event target is an input of type "text"
            if (input.tagName === 'INPUT' && input.type === 'text') {
                // Remove all non-digit characters
                input.value = input.value.replace(/\D/g, '');
            }
        });
    });

    document.addEventListener('submit', function (event) {
        if (!event.defaultPrevented && event.target.tagName.toLowerCase() === 'form') {
            event.target.querySelectorAll('button:not([type="button"])').forEach(button => button.disabled = true)
            event.target.querySelectorAll('input[type="submit"]').forEach(button => button.disabled = true)
        }
    })
});
