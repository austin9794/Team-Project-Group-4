<?php include __DIR__ . '/../header.php'; ?>

<div class="container">
    <h1>Gaming Products</h1>

    <div class="filters">
        <form method="GET" action="/Team-Project-Group-4/public/index.php">
        <input type="hidden" name="page" value="products">

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
            <a href="/Team-Project-Group-4/public/index.php?page=products" class="btn btn-secondary">Clear Filters</a>

        </form>
    </div>

    <div class="product-grid">

    <?php foreach ($products as $product): ?>
        <div class="product-card">

            <div class="product-img">
                <img src="/Team-Project-Group-4/public/assets/images/<?php echo htmlspecialchars($product['image']); ?>"
                alt="<?php echo htmlspecialchars($product['name']); ?>"
                onerror="this.src='/Team-Project-Group-4/public/assets/images/placeholder.png';">

            </div>

            <div class="product-info">
                <h3 class="product-title"><?php echo htmlspecialchars($product['name']); ?></h3>

                <p class="product-category">
                    <?php echo htmlspecialchars($product['category_name']); ?>
                </p>

                <p class="product-desc">
                    <?php echo htmlspecialchars(substr($product['description'], 0, 70)); ?>...
                </p>

                <p class="product-price">
                    £<?php echo number_format($product['price'], 2); ?>
                </p>

                <div class="product-actions">
                    <a href="/Team-Project-Group-4/public/index.php?page=product&id=<?php echo $product['product_id']; ?>"
                       class="btn-view">View Details</a>

                    <?php if ($product['stock'] > 0): ?>
                        <form method="POST"
                              action="/Team-Project-Group-4/public/index.php?page=add-to-basket">
                            <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                            <button type="submit" class="btn-basket">Add to Basket</button>
                        </form>
                    <?php else: ?>
                        <span class="out-of-stock-text">Out of Stock</span>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    <?php endforeach; ?>

</div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>