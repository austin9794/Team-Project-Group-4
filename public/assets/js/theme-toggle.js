// Theme Toggle Script
document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('theme-toggle');
    const html = document.documentElement;
    const sunIcon = document.querySelector('.theme-toggle-icon.sun');
    const moonIcon = document.querySelector('.theme-toggle-icon.moon');
    
    // Check localStorage for saved theme preference
    const savedTheme = localStorage.getItem('theme') || 'light';
    
    // Set initial theme
    if (savedTheme === 'dark') {
        html.setAttribute('data-theme', 'dark');
        updateIcons(true);
    } else {
        html.removeAttribute('data-theme');
        updateIcons(false);
    }
    
    // Toggle theme on click
    if (themeToggle) {
        themeToggle.addEventListener('click', function(e) {
            e.preventDefault();
            
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            if (newTheme === 'dark') {
                html.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
                updateIcons(true);
            } else {
                html.removeAttribute('data-theme');
                localStorage.setItem('theme', 'light');
                updateIcons(false);
            }
        });
    }
    
    function updateIcons(isDark) {
        if (sunIcon && moonIcon) {
            if (isDark) {
                sunIcon.style.opacity = '0.4';
                moonIcon.style.opacity = '1';
            } else {
                sunIcon.style.opacity = '1';
                moonIcon.style.opacity = '0.4';
            }
        }
    }
});
