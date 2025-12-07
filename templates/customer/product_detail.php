<?php 
$title = isset($product) ? htmlspecialchars($product['name']) . ' - Level Up Gaming' : 'Product Details - Level Up Gaming';
include __DIR__ . '/../header.php'; 
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
  <div class="product-breadcrumb">
    <a href="/Team-Project-Group-4/public/index.php?page=home">Home</a>
    <span>/</span>
    <a href="/Team-Project-Group-4/public/index.php?page=products">Products</a>
    <span>/</span>
    <span><?= htmlspecialchars($product['category_name'] ?? 'Product') ?></span>
  </div>

  <div class="product-detail-grid">
    <!-- Product Image -->
    <div class="product-image-section">
      <img src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($product['image'] ?? 'placeholder.png') ?>"> alt="<?= htmlspecialchars($product['name']) ?>">

    </div>
  </div>

  <!-- Details and Reviews Grid -->
  <div class="details-reviews-grid">
    <!-- Product Information -->
    <div class="product-info-section">
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h1 class="product-title" style="margin-bottom: 0;"><?= htmlspecialchars($product['name']) ?></h1>
        <div class="product-price" style="margin-bottom: 0;">£<?= number_format($product['price'], 2) ?></div>
      </div>
      
      <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <div class="product-rating" style="margin-bottom: 0;">
          <span>☆☆☆☆☆</span>
          <span>(<?= isset($product['review_count']) ? $product['review_count'] : 0 ?> reviews)</span>
        </div>

        <!-- Stock Status -->
        <?php if ($product['stock'] > 10): ?>
          <span class="stock-status in-stock">✓ In Stock</span>
        <?php elseif ($product['stock'] > 0): ?>
          <span class="stock-status low-stock">⚠ Low Stock (<?= $product['stock'] ?> left)</span>
        <?php else: ?>
          <span class="stock-status out-of-stock">✗ Out of Stock</span>
        <?php endif; ?>
      </div>

      <p class="product-description">
        <?= nl2br(htmlspecialchars($product['description'])) ?>
      </p>

      <!-- Specs -->
      <div class="product-specs" style="display: none;">
        <div class="spec-item">
          <span class="spec-label">SKU</span>
          <span class="spec-value">PRD-<?= str_pad($product['product_id'], 4, '0', STR_PAD_LEFT) ?></span>
        </div>
        <div class="spec-item">
          <span class="spec-label">Category</span>
          <span class="spec-value"><?= htmlspecialchars($product['category_name']) ?></span>
        </div>
        <div class="spec-item">
          <span class="spec-label">Availability</span>
          <span class="spec-value"><?= $product['stock'] ?> in stock</span>
        </div>
      </div>

      <?php if ($product['stock'] > 0): ?>
      <form method="POST" action="/Team-Project-Group-4/public/index.php?page=add-to-basket">
        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
        
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem;">
          <div class="quantity-selector" style="margin-bottom: 0;">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="1" min="1" max="<?= $product['stock'] ?>">
          </div>
          <button type="submit" class="btn-add-cart">Add to Cart</button>
        </div>
      </form>
      <?php else: ?>
        <button class="btn-add-cart" disabled>Out of Stock</button>
      <?php endif; ?>
    </div>

    <!-- Reviews Section -->
    <section class="reviews-section">
      <h2 class="reviews-title">Customer Reviews</h2>
      <?php if (isset($reviews) && count($reviews) > 0): ?>
        <div class="review-list">
          <?php foreach ($reviews as $review): ?>
          <div class="review-item">
            <div class="review-header">
              <div>
                <div class="review-author"><?= htmlspecialchars($review['author']) ?></div>
                <div class="review-rating"></div>
              </div>
              <div class="review-date"><?= date('M d, Y', strtotime($review['date'])) ?></div>
            </div>
            <p class="review-text"><?= htmlspecialchars($review['text']) ?></p>
          </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="no-reviews">
          <p>No reviews yet, could you be the first?</p>
        </div>
      <?php endif; ?>
    </section>
  </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>