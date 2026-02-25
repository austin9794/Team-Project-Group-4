<?php 
$title = isset($product) ? htmlspecialchars($product['name']) . ' - Level Up Gaming' : 'Product Details - Level Up Gaming';
include __DIR__ . '/../header.php'; 
?>

<?php
$mainImage = 'placeholder.png';

if (!empty($images) && isset($images[0]['image_path'])) {
    $mainImage = $images[0]['image_path'];
}
?>

<style>
  .product-detail-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 3rem 2rem;
  }

  .product-breadcrumb {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 2rem;
    color: var(--text-secondary);
    font-size: 0.9rem;
  }

  .product-breadcrumb a {
    color: var(--highlight-color);
    text-decoration: none;
  }

  .product-detail-grid {
    display: block;
    margin-bottom: 3rem;
  }

  .product-main-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    align-items: start;
  }

  .product-info-panel {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }


  .product-image-section {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
  }

  .product-image-section img {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
  }

  .product-info-section {
    display: flex;
    flex-direction: column;
  }

  .product-category {
    color: var(--highlight-color);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
  }

  .product-title {
    font-size: 2rem;
    color: var(--text-primary);
    margin-bottom: 1rem;
    font-weight: 700;
  }

  .product-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    font-size: 0.95rem;
  }

  .product-rating span:first-child {
    font-size: 1.5rem;
  }

  .product-price {
    font-size: 1.8rem;
    font-weight: 700;
    color: var(--highlight-color);
    margin-bottom: 0.5rem;
  }

  .product-description {
    color: var(--text-secondary);
    line-height: 1.8;
    margin-bottom: 1.5rem;
    font-size: 1rem;
  }

  .stock-status {
    display: inline-block;
    padding: 0.5rem 1rem;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
  }

  .in-stock {
    background: #d4edda;
    color: #155724;
  }

  .low-stock {
    background: #fff3cd;
    color: #856404;
  }

  .out-of-stock {
    background: #f8d7da;
    color: #721c24;
  }

  .product-specs {
    background: var(--bg-secondary);
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 2rem;
  }

  .spec-item {
    display: flex;
    justify-content: space-between;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--bg-primary);
  }

  .spec-item:last-child {
    border-bottom: none;
  }

  .spec-label {
    color: var(--text-secondary);
    font-weight: 600;
  }

  .spec-value {
    color: var(--text-primary);
  }

  .quantity-selector {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
  }

  .quantity-selector label {
    font-weight: 600;
    color: var(--text-primary);
  }

  .quantity-selector input {
    width: 80px;
    padding: 0.5rem;
    border: 1px solid var(--highlight-color);
    border-radius: 6px;
    text-align: center;
  }

  .quantity-row {
    display: flex;
    align-items: center;
    gap: 1rem;
  }

  .product-actions {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
  }

  .btn-add-cart {
    padding: 0.75rem 2rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s;
    background: var(--highlight-color);
    color: var(--white);
  }

  .btn-add-cart:hover {
    background: var(--highlight-dark);
  }

  .btn-add-cart:disabled {
    background: #6c757d;
    cursor: not-allowed;
  }

  .reviews-section {
    background: var(--bg-secondary);
    padding: 2rem;
    border-radius: 12px;
  }

  .reviews-section.full-width {
    margin-top: 4rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255,255,255,0.1);
  }


  .details-reviews-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    margin-top: 2rem;
  }

  .reviews-title {
    font-size: 1.5rem;
    color: var(--text-primary);
    margin-bottom: 1.5rem;
    border-bottom: 2px solid var(--highlight-color);
    padding-bottom: 0.5rem;
  }

  .review-item {
    background: var(--bg-primary);
    padding: 1.5rem;
    border-radius: 8px;
    margin-bottom: 1rem;
  }

  .review-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
  }

  .review-author {
    font-weight: 600;
    color: var(--text-primary);
  }

  .review-rating {
    color: white;
  }

  .review-date {
    color: var(--text-secondary);
    font-size: 0.85rem;
  }

  .review-text {
    color: var(--text-secondary);
    line-height: 1.6;
  }

  .no-reviews {
    text-align: center;
    padding: 2rem;
    color: var(--text-secondary);
  }

  @media (max-width: 768px) {
    .product-detail-grid {
      grid-template-columns: 1fr;
      gap: 2rem;
    }

    .product-title {
      font-size: 1.5rem;
    }

    .product-price {
      font-size: 1.5rem;
    }

    .product-actions {
      flex-direction: column;
    }
  }
</style>

<div class="product-detail-container">

  <!-- Breadcrumb -->
  <div class="product-breadcrumb">
    <a href="<?= BASE_URL ?>index.php?page=home">Home</a>
    <span>/</span>
    <a href="<?= BASE_URL ?>index.php?page=products">Products</a>
    <span>/</span>
    <span><?= htmlspecialchars($product['category_name']) ?></span>
  </div>

  <!-- MAIN SECTION -->
  <div class="product-main-grid">

    <!-- LEFT: IMAGE + ZOOM -->
    <div class="product-gallery">

  <div class="image-zoom-wrapper">

    <!-- IMAGE PREVIEW -->
    <div class="image-preview">
      <img
        id="mainProductImage"
        src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($mainImage) ?>"
        alt="<?= htmlspecialchars($product['name']) ?>"
      >

      <button type="button" class="view-full-btn">
        View full image
      </button>
    </div>

    <!-- ZOOM PANEL -->
    <div id="zoomResult"></div>

  </div>

  <!-- THUMBNAILS -->
  <?php if (!empty($images)): ?>
    <div class="thumbnail-row">
      <?php foreach ($images as $index => $img): ?>
        <img
          src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($img['image_path']) ?>"
          class="thumbnail <?= $index === 0 ? 'active' : '' ?>"
          data-image="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($img['image_path']) ?>"
          alt="Thumbnail <?= $index + 1 ?>"
        >
      <?php endforeach; ?>
    </div>
  <?php endif; ?>

</div>


    <!-- RIGHT: PRODUCT INFO -->
    <div class="product-info-panel">

      <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>

      <div class="product-price">£<?= number_format($product['price'], 2) ?></div>

      <?php
       $avg = round($averageData['avg_rating'] ?? 0);
      ?>

      <div class="product-rating">
        <?= str_repeat('★', $avg) ?>
        <?= str_repeat('☆', 5 - $avg) ?>
        <span>(<?= $averageData['count'] ?? 0 ?> reviews)</span>
      </div>

      <?php if ($product['stock'] > 10): ?>
        <span class="stock-status in-stock">✓ In Stock</span>
      <?php elseif ($product['stock'] > 0): ?>
        <span class="stock-status low-stock">⚠ Low Stock (<?= $product['stock'] ?> left)</span>
      <?php else: ?>
        <span class="stock-status out-of-stock">✗ Out of Stock</span>
      <?php endif; ?>

      <div class="product-about">
        <h3 class="about-title">About this item</h3>
        <?php
          $features = array_filter(
          array_map('trim', explode('|', $product['description']))
          );
        ?>

      <ul class="product-features">
       <?php foreach ($features as $feature): ?>
           <li><?= htmlspecialchars($feature) ?></li>
        <?php endforeach; ?>
      </ul>

      </div>

      <?php if ($product['stock'] > 0): ?>
        <form method="POST" action="<?= BASE_URL ?>index.php?page=add-to-basket" class="add-to-cart-form">
          <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

          <div class="quantity-row">
            <label for="quantity">Quantity</label>
            <input
              type="number"
              id="quantity"
              name="quantity"
              value="1"
              min="1"
              max="<?= $product['stock'] ?>"
            >
            <button type="submit" class="btn-add-cart">Add to Cart</button>
          </div>
        </form>
      <?php else: ?>
        <button class="btn-add-cart" disabled>Out of Stock</button>
      <?php endif; ?>

    </div>
  </div>

  <!-- REVIEWS -->
   <section class="reviews-section full-width">
  <h2 class="reviews-title">Customer Reviews</h2>

  <?php if (!empty($reviews)): ?>
    <div class="review-list">
      <?php foreach ($reviews as $review): ?>
        <div class="review-item">
          <div class="review-header">
            <strong><?= htmlspecialchars($review['name']) ?></strong>
            <span class="review-date">
              <?= date('M d, Y', strtotime($review['created_at'])) ?>
            </span>
          </div>

          <div class="review-rating">
            <?= str_repeat('★', $review['rating']) ?>
            <?= str_repeat('☆', 5 - $review['rating']) ?>
          </div>

          <p><?= htmlspecialchars($review['comment']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="no-reviews">No reviews yet — be the first!</p>
  <?php endif; ?>
</section>

<?php if (!empty($_SESSION['review_success'][$product['product_id']])): ?>
    <p class="review-success">
        <?= $_SESSION['review_success'][$product['product_id']] ?>
    </p>
    <?php unset($_SESSION['review_success'][$product['product_id']]); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['review_error'][$product['product_id']])): ?>
    <p class="review-error">
        <?= $_SESSION['review_error'][$product['product_id']] ?>
    </p>
    <?php unset($_SESSION['review_error'][$product['product_id']]); ?>
<?php endif; ?>

<?php if (isset($_SESSION['user_id']) && $canReview): ?>
    <button class="btn-review" onclick="openReviewModal()">
        Write a customer review
    </button>
<?php elseif (isset($_SESSION['user_id'])): ?>
    <p>You can only review products after they have been delivered.</p>
<?php else: ?>
    <p>Please log in to leave a review.</p>
<?php endif; ?>

<!-- FULLSCREEN MODAL -->
  <div id="imageModal" class="image-modal" aria-hidden="true">
    <span class="modal-close">&times;</span>
    <button class="modal-nav prev">&#10094;</button>
    <img id="modalImage" src="" alt="Product image fullscreen">
    <button class="modal-nav next">&#10095;</button>
  </div>

</div>

<script>
  const images = <?= json_encode(
    array_map(
      fn($img) => BASE_URL . 'assets/images/' . $img['image_path'],
      $images ?? []
    )
  ) ?>;
</script>


<?php include __DIR__ . '/../footer.php'; ?>