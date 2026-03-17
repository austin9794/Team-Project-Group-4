<style>
  .footer-info { display: flex; align-items: center; gap: 0.5rem; justify-content: flex-end; }
  .footer-info svg { flex-shrink: 0; }
</style>

<hr>
<hr>

<footer class="site-footer">

<div class="footer-grid">

<!-- BRAND -->
<div class="footer-col">
<h3>Level Up</h3>
<p class="footer-tagline">
Premium gaming gear for players who want to level up.
</p>

<div class="social-icons">
<svg width="20" height="20"><path d=""/></svg>
<svg width="20" height="20"><path d=""/></svg>
<svg width="20" height="20"><path d=""/></svg>
<svg width="20" height="20"><path d=""/></svg>
</div>
</div>


<!-- QUICK LINKS -->
<div class="footer-col">
<h4>Quick Links</h4>

<a href="<?= BASE_URL ?>index.php?page=products">Products</a>
<a href="<?= BASE_URL ?>index.php?page=about">About Us</a>
<a href="<?= BASE_URL ?>index.php?page=contact">Contact</a>
<a href="<?= BASE_URL ?>index.php?page=orders">Orders</a>
</div>


<!-- CONTACT -->
<div class="footer-col">

<h4>Contact</h4>

<p class="footer-info">
📍 Aston Triangle, Birmingham  
B4 7ET, United Kingdom
</p>

<p class="footer-info">
🚚 UK Shipping Only
</p>

<p class="footer-info">
✉ support@levelupgaming.co.uk
</p>

</div>

</div>


<div class="footer-bottom">
© <?= date("Y") ?> Level Up Inc.
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
