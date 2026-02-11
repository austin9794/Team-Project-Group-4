<style>
  .footer-info { display: flex; align-items: center; gap: 0.5rem; justify-content: flex-end; }
  .footer-info svg { flex-shrink: 0; }
</style>

<hr>
<footer style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem 2rem;">
    <p>© Level Up Inc.</p>
    <div style="text-align: right;">
        <p class="footer-info" style="margin: 0;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span>Aston Triangle, Birmingham, B4 7ET, United Kingdom</span>
        </p>
        <p class="footer-info" style="margin: 0.5rem 0 0 0; font-size: 0.9rem;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                <circle cx="12" cy="10" r="3"></circle>
            </svg>
            <span>UK Shipping Only</span>
        </p>
    </div>
</footer>

<script src="<?= BASE_URL ?>assets/js/main.js" defer></script>
<script src="<?= BASE_URL ?>assets/js/theme-toggle.js" defer></script>
<script src="<?= BASE_URL ?>assets/js/validation.js" defer></script>

<script>
document.querySelectorAll('.clickable-row').forEach(row => {
    row.addEventListener('click', function () {
        window.location = this.dataset.href;
    });
});
</script>


</body>
</html>
