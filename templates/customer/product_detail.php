<?php
require_once "../src/Controllers/ProductController.php";

$productController = new ProductController();

$productId = $_GET['id'] ?? null;
if (!$productId) {
    header("Location: products.php");
    exit;
}

$product = $productController->showProduct($productId);
if (!$product) {
    header("Location: products.php");
    exit;
}
?>

<?php include 'header.php'; ?>

<div class="container">
    <div class="product-detail">
        <div class="product-image">
            <img src="/public/assets/img/<?php echo htmlspecialchars($product['image']); ?>" 
                 alt="<?php echo htmlspecialchars($product['name']); ?>"
                 onerror="this.src='/public/assets/img/placeholder.jpg'">
        </div>
        
        <div class="product-info">
            <h1><?php echo htmlspecialchars($product['name']); ?></h1>
            <p class="category">Category: <?php echo htmlspecialchars($product['category_name']); ?></p>
            <p class="description"><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
            <p class="price">Price: £<?php echo number_format($product['price'], 2); ?></p>
            
            <p class="stock">
                Availability: 
                <?php if ($product['stock'] > 10): ?>
                    <span class="in-stock"> In Stock</span>
                <?php elseif ($product['stock'] > 0): ?>
                    <span class="low-stock"> Low Stock (<?php echo $product['stock']; ?> left)</span>
                <?php else: ?>
                    <span class="out-of-stock">✗ Out of Stock</span>
                <?php endif; ?>
            </p>

            <?php if ($product['stock'] > 0): ?>
            <form method="POST" action="add_to_basket.php" class="add-to-basket">
                 <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
                <div class="quantity-selector"> 

                    <label for="quantity">Quantity:</label>
                      <input type="number" id="quantity" name="quantity" value="1" min="1" 
                           max="<?php echo $product['stock']; ?>">
                </div>
                <button type="submit" class="btn btn-primary btn-large">Add to Basket</button>
      </form>
            <?php else: ?>
            <button class="btn btn-disabled" disabled>Out of Stock</button>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>