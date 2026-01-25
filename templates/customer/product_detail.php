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

  <!-- Breadcrumb -->
  <div class="product-breadcrumb">
    <a href="<?= BASE_URL ?>index.php?page=home">Home</a>
    <span>/</span>
    <a href="<?= BASE_URL ?>index.php?page=products">Products</a>
    <span>/</span>
    <span><?= htmlspecialchars($product['category_name']) ?></span>
  </div>

  <!-- TOP SECTION: Gallery + Info -->
  <div class="product-main-grid">