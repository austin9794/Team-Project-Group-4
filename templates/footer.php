<style>
.site-footer{
padding:40px 60px;
background:#0c0c14;
color:#bbb;
}

.footer-grid{
display:grid;
grid-template-columns:1fr 1fr 1fr;
gap:40px;
margin-bottom:25px;
}

.footer-col h3{
color:#c9a7ff;
margin-bottom:10px;
}

.footer-col h4{
color:#c9a7ff;
margin-bottom:12px;
}

.footer-col a{
display:block;
margin-bottom:8px;
color:#bbb;
text-decoration:none;
}

.footer-col a:hover{
color:#fff;
}

.footer-tagline{
font-size:14px;
color:#888;
margin-bottom:15px;
}

.social-icons{
display:flex;
gap:15px;
}

.social-icons svg{
opacity:0.6;
cursor:pointer;
transition:0.2s;
}

.social-icons svg:hover{
opacity:1;
transform:scale(1.1);
}

.footer-bottom{
border-top:1px solid #2a2a3a;
padding-top:15px;
font-size:13px;
text-align:center;
color:#777;
}

.footer-info { display: flex; align-items: center; gap: 0.5rem; justify-content: flex-end; }
.footer-info svg { flex-shrink: 0; }
</style>

<hr>
<hr>

<footer class="site-footer">

<div class="support-widget">

  <div class="support-tooltip">
    Got questions? Check our FAQ
  </div>

  <button class="support-btn" onclick="toggleSupport()">
    ?
  </button>

  <div class="support-panel" id="support-panel">

    <h4>Quick Help</h4>

    <ul>
      <li><strong>Delivery time?</strong><br>2–4 working days.</li>
      <li><strong>Returns?</strong><br>Within 7 days.</li>
      <li><strong>Payment methods?</strong><br>Only Visa and Mastercard supported.</li>
    </ul>

    <a href="index.php?page=faq" class="btn">View Full FAQ</a>

  </div>

</div>

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
<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"> <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path> <circle cx="12" cy="10" r="3"></circle> </svg>
Aston Triangle, Birmingham  
B4 7ET, United Kingdom
</p>

<p class="footer-info">
⛟ UK Shipping Only
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
