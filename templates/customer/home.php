<?php
$title = 'Level Up - Premium Gaming Hardware';
require_once __DIR__ . '/../header.php';
?>

<style>
  .landing-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: white;
    padding: 2rem;
    background: url('assets/images/bg1.jpg') center/cover no-repeat;
  }
  
  .landing-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, transparent 0%, transparent 60%, var(--bg-primary) 100%);
    pointer-events: none;
  }
  
  .landing-hero-content {
    position: relative;
    z-index: 1;
  }
  
  .landing-hero-content h1 {
    font-size: 4rem;
    font-weight: 900;
    margin-bottom: 1rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    line-height: 1.2;
  }
  
  .landing-hero-content p {
    font-size: 1.5rem;
    margin-bottom: 2rem;
    opacity: 0.95;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
  }
  
  .cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 3rem;
  }
  
  .cta-button {
    padding: 1rem 2.5rem;
    font-size: 1.1rem;
    border: 2px solid white;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: background 0.3s;
    text-decoration: none;
    display: inline-block;
    background: transparent;
    color: white;
  }
  
  .cta-button:hover {
    background: rgba(255,255,255,0.2);
  }
  
  .trust-badges {
    display: flex;
    justify-content: center;
    gap: 2rem;
    margin-top: 3rem;
    flex-wrap: wrap;
    font-size: 0.9rem;
  }
  
  .trust-badge {
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
  
  .features-section {
    background: var(--bg-secondary);
    padding: 5rem 2rem;
  }
  
  .features-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    max-width: 1200px;
    margin: 0 auto;
  }
  
  .feature-card {
    background: var(--bg-primary);
    padding: 2rem;
    border-radius: 12px;
    text-align: center;
    box-shadow: var(--shadow);
    transition: transform 0.3s, box-shadow 0.3s;
  }
  
  .feature-card:hover {
    background: rgba(94, 53, 242, 0.2);
  }
  
  .feature-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    color: var(--highlight-color);
  }
  
  .feature-icon svg {
    width: 48px;
    height: 48px;
    stroke: currentColor;
    stroke-width: 2;
    fill: none;
  }
  
  .feature-card h3 {
    color: var(--highlight-color);
    margin-bottom: 0.5rem;
  }
  
  .feature-card p {
    color: var(--text-secondary);
    font-size: 0.95rem;
  }
  
  .section-title {
    font-size: 2.5rem;
    text-align: center;
    margin-bottom: 3rem;
    color: var(--text-primary);
  }
  
  @media (max-width: 768px) {
    .landing-hero-content h1 {
      font-size: 2.5rem;
    }
    .landing-hero-content p {
      font-size: 1.2rem;
    }
    .cta-buttons {
      flex-direction: column;
    }
    .cta-button {
      width: 100%;
      max-width: 300px;
      margin: 0 auto;
    }
  }
</style>

<!-- Hero Section -->
<section class="landing-hero">
  <div class="landing-hero-content">
    <h1>Level Up</h1>
    <p>Level up your gaming today!</p>
    <div class="cta-buttons">
      <a href="<?= BASE_URL ?>index.php?page=products" class="cta-button primary">Start Shopping</a>
    </div>
  </div>
</section>

<!-- Popular Products Section -->
<section class="features-section" id="features">
  <h2 class="section-title">Popular Products</h2>
  <?php
    $popularProducts = [
      [
        'name' => 'TECKNET RGB Gaming Keyboard',
        'desc' => 'Mechanical-feel keyboard with vibrant RGB lighting zones',
        'img' => 'products/keyboards/keyboard1/01.png',
        'price' => 32.99,
        'id' => 1
      ],
      [
        'name' => 'Logitech G305 LIGHTSPEED',
        'desc' => 'High-accuracy HERO sensor with up to 12,000 DPI',
        'img' => 'products/mice/mouse1/01.png',
        'price' => 59.99,
        'id' => 6
      ],
      [
        'name' => 'HyperX Cloud Alpha',
        'desc' => 'Dual-chamber drivers provide cleaner audio',
        'img' => 'products/headsets/head1/01.png',
        'price' => 34.99,
        'id' => 11
      ],
      [
        'name' => 'Philips 27E1N1100A 27"',
        'desc' => '27-inch Full HD IPS panel with wide viewing angles',
        'img' => 'products/monitors/monitor1/01.png',
        'price' => 94.99,
        'id' => 16
      ],
      [
        'name' => 'TONOR RGB USB Microphone',
        'desc' => 'High-clarity microphone with built-in noise reduction',
        'img' => 'products/microphones/mic1/01.png',
        'price' => 49.99,
        'id' => 21
      ],
      [
        'name' => 'Corsair K55 RGB Pro',
        'desc' => 'Dynamic RGB backlighting and six macro keys',
        'img' => 'products/keyboards/keyboard2/01.png',
        'price' => 44.99,
        'id' => 2
      ],
      [
        'name' => 'Razer DeathAdder V2',
        'desc' => 'Focus+ Optical Sensor, 20,000 DPI, Speedflex cable',
        'img' => 'products/mice/mouse2/01.png',
        'price' => 69.99,
        'id' => 7
      ],
      [
        'name' => 'SteelSeries Arctis 5',
        'desc' => 'RGB illuminated, DTS Headphone:X v2.0 surround sound',
        'img' => 'products/headsets/head2/01.png',
        'price' => 79.99,
        'id' => 12
      ],
    ];
  ?>
  <div class="product-grid" style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">
    <?php foreach ($popularProducts as $product): ?>
      <div class="product-card" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: var(--shadow);">
        <div class="product-image" style="width: 100%; height: 200px; background: white; display: flex; align-items: center; justify-content: center; overflow: hidden;">
          <img src="<?= BASE_URL ?>assets/images/<?= $product['img'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: 100%; object-fit: contain; padding: 10px;">
        </div>
        <div class="product-info" style="padding: 1.25rem;">
          <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem; color: #1a1a2e;"><?= htmlspecialchars($product['name']) ?></h3>
          <p style="color: #6b6b80; font-size: 0.9rem; margin-bottom: 1rem;"><?= htmlspecialchars($product['desc']) ?></p>
          <div style="display: flex; justify-content: space-between; align-items: center;">
            <span style="font-size: 1.5rem; font-weight: bold; color: var(--highlight-color);">£<?= number_format($product['price'], 2) ?></span>
            <a href="<?= BASE_URL ?>index.php?page=product&id=<?= $product['id'] ?>" style="padding: 0.6rem 1.25rem; background: var(--highlight-color); color: white; border-radius: 6px; text-decoration: none; font-weight: 600;">View</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  </div>
</section>

<?php if (!empty($recentProducts)): ?>
<section class="features-section">
  <h2 class="section-title">Recently Viewed</h2>

  <div class="product-grid"
  style=" max-width:1200px; margin:0 auto; display:grid; grid-template-columns:repeat(auto-fill, minmax(250px,250px)); gap:25px; justify-content:center;">
    <?php foreach ($recentProducts as $product): ?>

      <?php
        $imagePath = "products/"
          . strtolower($product['category_name']) . "/"
          . $product['slug'] . "/01.png";
      ?>

     <div class="product-card">
       <div class="product-image">
           <img src="<?= BASE_URL ?>assets/images/<?= $imagePath ?>"
                alt="<?= htmlspecialchars($product['name']) ?>">
        </div>

    <div class="product-info">
        <h3><?= htmlspecialchars($product['name']) ?></h3>

        <div style="display:flex; justify-content:space-between; align-items:center;">
            <span class="product-price">
                £<?= number_format($product['price'], 2) ?>
            </span>

            <a href="<?= BASE_URL ?>index.php?page=product&id=<?= $product['product_id'] ?>"
               class="product-button">
               View
            </a>
        </div>
    </div>

</div>

    <?php endforeach; ?>

  </div>
</section>
<?php endif; ?>

<?php if (!empty($reorderProducts)): ?>
<section class="features-section">
  <h2 class="section-title">Reorder</h2>

  <div class="product-grid"
    style="max-width:1200px;margin:0 auto;display:grid;
    grid-template-columns:repeat(auto-fill,minmax(250px,250px));
    gap:25px;justify-content:center;">

  <?php foreach ($reorderProducts as $product): ?>

  <?php
    $imagePath = "products/"
   . strtolower($product['category_name']) . "/"
   . $product['slug'] . "/01.png";
  ?>

  <div class="product-card">

     <div class="product-image">
      <img src="<?= BASE_URL ?>assets/images/<?= $imagePath ?>"
      alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <div class="product-info">

      <h3><?= htmlspecialchars($product['name']) ?></h3>

    <div style="display:flex;justify-content:space-between;align-items:center;">

     <span class="product-price">
        £<?= number_format($product['price'], 2) ?>
     </span>

    <form method="POST"
          action="<?= BASE_URL ?>index.php?page=add-to-basket">

        <input type="hidden"
         name="product_id"
         value="<?= $product['product_id'] ?>">

       <button class="product-button">
        Reorder
       </button>
     </form>
   </div>
 </div>
</div>

<?php endforeach; ?>

</div>
</section>
<?php endif; ?>

<?php if (!empty($recommendedProducts)): ?>
<section class="features-section">
  <h2 class="section-title">Recommended For You</h2>

  <div class="product-grid" style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px;">

    <?php foreach ($recommendedProducts as $product): ?>

      <?php
        $imagePath = "products/"
          . strtolower($product['category_name']) . "/"
          . $product['slug'] . "/01.png";
      ?>

    <div class="product-card">
    <div class="product-image">
        <img src="<?= BASE_URL ?>assets/images/<?= $imagePath ?>"
             alt="<?= htmlspecialchars($product['name']) ?>">
    </div>

    <div class="product-info">
        <h3><?= htmlspecialchars($product['name']) ?></h3>

        <div style="display:flex; justify-content:space-between; align-items:center;">
            <span style="font-weight:bold; color:var(--highlight-color);">
                £<?= number_format($product['price'], 2) ?>
            </span>

            <a href="<?= BASE_URL ?>index.php?page=product&id=<?= $product['product_id'] ?>"
               class="product-button">
               View
            </a>
        </div>
    </div>
</div>

    <?php endforeach; ?>

  </div>
</section>
<?php endif; ?>

<!-- CTA Section -->
<section style="position: relative; overflow: hidden; color: white; padding: 4rem 2rem; text-align: center;">
  <video autoplay loop muted playsinline style="position: absolute; top: 50%; left: 50%; min-width: 100%; min-height: 100%; width: auto; height: auto; transform: translate(-50%, -50%); z-index: 0; object-fit: cover;">
    <source src="<?= BASE_URL ?>assets/images/bg_video.mp4" type="video/mp4">
  </video>
  <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(94, 53, 242, 0.6); z-index: 1;"></div>
  <div class="container" style="position: relative; z-index: 2;">
    <h2 style="font-size: 2rem; margin-bottom: 2rem;">Ready to level up your gaming today?</h2>
    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
      <a href="<?= BASE_URL ?>index.php?page=products" class="cta-button primary">Shop Now!</a>
      <a href="<?= BASE_URL ?>index.php?page=about" class="cta-button secondary">Learn More</a>
    </div>
  </div>
</section>

<?php require_once __DIR__ . '/../footer.php'; ?>
