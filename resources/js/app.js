import './bootstrap';
import 'alpinejs'
import hljs from 'highlight.js';
import 'highlight.js/styles/github-dark-dimmed.min.css';

document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('pre').forEach((block) => {

        hljs.highlightElement(block);
    });
    var loadingScreen = document.getElementById('loading-screen');
    if (loadingScreen) {
        setTimeout(function() {
            loadingScreen.style.display = 'none';
        }, 1000); // 1000 milliseconds = 1 second
    }
});
