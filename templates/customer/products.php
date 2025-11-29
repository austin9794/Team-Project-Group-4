<?php
require_once "../src/Controllers/ProductController.php";

$productController = new ProductController();

$filters = [
    'category' => $_GET['category'] ?? null,
    'search' => $_GET['search'] ?? null,
    'min_price' => $_GET['min_price'] ?? null,
    'max_price' => $_GET['max_price'] ?? null
];

$products = $productController->listProducts($filters);
$categories = $productController->getCategories();
?>

<?php include 'header.php'; ?>

<div class="container">
    <h1>Gaming Products</h1>

    <div class="filters">
        <form method="GET" action="products.php">
            <div class="filter-group">
                <input type="text" name="search" placeholder="Search gaming products..." 
                       value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>">
            </div>
            
            <div class="filter-group">
                <select name="category">
            <option value="">All Categories</option>
                    <?php foreach ($categories as $category): ?>
                     <option value="<?php echo $category['name']; ?>" 
                         <?php echo ($filters['category'] == $category['name']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="filter-group">
                <label>Price Range:</label>
                <input type="number" name="min_price" placeholder="Min price" 
                       value="<?php echo $filters['min_price'] ?? ''; ?>" min="0" step="0.01">
                <input type="number" name="max_price" placeholder="Max price" 
                       value="<?php echo $filters['max_price'] ?? ''; ?>" min="0" step="0.01">
            </div>

            <button type="submit" class="btn">Apply Filters</button>
            <a href="products.php" class="btn btn-secondary">Clear Filters</a>
        </form>
    </div>

    <div class="product-grid">
        <?php if (empty($products)): ?>
            <div class="no-products">
                <p>No gaming products found.</p>
                <a href="products.php" class="btn">View All Products</a>
            </div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card">
         <div class="product-image">
                     <img src="/public/assets/img/<?php echo htmlspecialchars($product['image']); ?>" 
                             alt="<?php echo htmlspecialchars($product['name']); ?>"
                       onerror="this.src='/public/assets/img/placeholder.jpg'">
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="category"><?php echo htmlspecialchars($product['category_name']); ?></p>
              <p class="description"><?php echo htmlspecialchars(substr($product['description'], 0, 100)); ?>...</p>
                        <p class="price">£<?php echo number_format($product['price'], 2); ?></p>
                        
                        <div class="stock-status">
                            <?php if ($product['stock'] > 10): ?>
                                <span class="in-stock">✓ In Stock</span>
                            <?php elseif ($product['stock'] > 0): ?>
                                <span class="low-stock"> Low Stock (<?php echo $product['stock']; ?> left)</span>
                            <?php else: ?>
                                <span class="out-of-stock"> Out of Stock</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="product-actions">
                            <a href="product_detail.php?id=<?php echo $product['product_id']; ?>" 
                               class="btn btn-primary">View Details</a>
                            <?php if ($product['stock'] > 0): ?>
                                <form method="POST" action="add_to_basket.php" class="add-to-basket-form">
                                    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-success">Add to Basket</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>