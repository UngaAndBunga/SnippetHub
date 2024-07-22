import './bootstrap';
import 'alpinejs'
import hljs from 'highlight.js';
import 'highlight.js/styles/intellij-light.min.css'; // You can choose another theme if you prefer

document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('pre').forEach((block) => {
        hljs.highlightElement(block);
    });
});
