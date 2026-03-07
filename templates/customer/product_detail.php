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
    <form method="POST"
      action="<?= BASE_URL ?>index.php?page=add-to-basket"
      class="add-to-cart-form"
      id="addCartForm">

    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

    <div class="quantity-row">

        <span class="quantity-label">Quantity</span>

        <div class="qty-controls">

            <button type="button" class="qty-btn" onclick="decreaseQty()">−</button>

            <input
                type="number"
                id="quantity"
                name="quantity"
                value="1"
                min="1"
                max="<?= $product['stock'] ?>"
                class="qty-input"
            >

            <button type="button" class="qty-btn" onclick="increaseQty()">+</button>

        </div>

        <button type="submit" class="btn-add-cart" id="addCartBtn">
            Add to Cart
        </button>

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

        <h4 class="review-title">
            <?= htmlspecialchars($review['title']) ?>
        </h4>

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

<?php if (isset($_SESSION['user_id'])): ?>

    <?php if ($canReview): ?>
        <button class="btn-review" onclick="openReviewModal()">
            Write a customer review
        </button>
    <?php endif; ?>

    <?php if (!$canReview && !empty($reviews)): ?>
    <p class="review-note">You have already reviewed this item.</p>
    <?php endif; ?>

<?php else: ?>
    <p>Please log in to leave a review.</p>
<?php endif; ?>

<!-- REVIEW MODAL -->
<div id="reviewModal" class="review-modal">
  <div class="review-modal-content">

    <span class="review-close" onclick="closeReviewModal()">&times;</span>

    <h2>Review this product</h2>

    <form method="POST" action="<?= BASE_URL ?>index.php?page=add-review">

      <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">

      <div class="form-group">
        <label>Rating</label>
        <div class="star-input">
          <?php for ($i=5;$i>=1;$i--): ?>
            <input type="radio" name="rating" value="<?= $i ?>" id="star<?= $i ?>" required>
            <label for="star<?= $i ?>">★</label>
          <?php endfor; ?>
        </div>
      </div>

      <div class="form-group">
        <label>Review title (required)</label>
        <input type="text" name="title" required>
      </div>

      <div class="form-group">
        <label>Write your review</label>
        <textarea name="comment" required></textarea>
      </div>

      <button type="submit" class="submit-review-btn">
        Submit Review
      </button>

    </form>

  </div>
</div>

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

function openReviewModal() {
    document.getElementById("reviewModal").style.display = "flex";
}

function closeReviewModal() {
    document.getElementById("reviewModal").style.display = "none";
}

function increaseQty() {
    const input = document.getElementById("quantity");
    const max = parseInt(input.max);

    if (parseInt(input.value) < max) {
        input.value = parseInt(input.value) + 1;
    }
}

function decreaseQty() {
    const input = document.getElementById("quantity");

    if (parseInt(input.value) > 1) {
        input.value = parseInt(input.value) - 1;
    }
}

document.getElementById("addCartForm").addEventListener("submit", function(e){

    e.preventDefault();

    const form = this;
    const btn = document.getElementById("addCartBtn");

    const formData = new FormData(form);

    fetch(form.action, {
        method: "POST",
        body: formData
    })
    .then(data => {

    btn.innerHTML = "✓ Added";
    btn.style.background = "#22c55e";

    const basket = document.getElementById("basket-count");

if(basket){

    let current = parseInt(basket.textContent);

    basket.textContent = current + parseInt(formData.get("quantity"));

}else{

    const wrapper = document.querySelector(".basket-wrapper");

    const badge = document.createElement("span");

    badge.id = "basket-count";
    badge.className = "basket-badge";
    badge.textContent = formData.get("quantity");

    wrapper.appendChild(badge);

}

    setTimeout(() => {
        btn.innerHTML = "Add to Cart";
        btn.style.background = "";
    },1500);

})
    .catch(() => {
        btn.innerHTML = "Error";
    });

});
</script>


<?php include __DIR__ . '/../footer.php'; ?>