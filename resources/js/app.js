import './bootstrap';
import 'alpinejs'
import hljs from 'highlight.js';
import 'highlight.js/styles/intellij-light.min.css'; // You can choose another theme if you prefer

document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('pre').forEach((block) => {
        hljs.highlightElement(block);
    });
    // Hide the loading screen after the page loads
    const loadingScreen = document.getElementById('loading-screen');
    if (loadingScreen) {
        loadingScreen.style.display = 'none';
    }
});
setTimeout(function() {
    const loadingScreen = document.getElementById('loading-screen');
    if (loadingScreen) {
        loadingScreen.style.display = 'none';
    }
}, 2000); // 2 seconds fallback
