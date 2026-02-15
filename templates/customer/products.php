<?php
$title = 'Products - Level Up Gaming';
require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/../../src/Database.php';

// Map category names to SVG icons
$category_icons = [
  'Keyboards' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2" ry="2"></rect><path d="M6 8h.01"></path><path d="M10 8h.01"></path><path d="M14 8h.01"></path><path d="M18 8h.01"></path><path d="M8 12h.01"></path><path d="M12 12h.01"></path><path d="M16 12h.01"></path><path d="M7 16h10"></path></svg>',
  'Mice' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1c-3.866 0-7 3.134-7 7v3H4c-1.657 0-3 1.343-3 3v2c0 1.657 1.343 3 3 3h3v3c0 3.866 3.134 7 7 7s7-3.134 7-7v-3h3c1.657 0 3-1.343 3-3v-2c0-1.657-1.343-3-3-3h-3V8c0-3.866-3.134-7-7-7zm0 2c2.761 0 5 2.239 5 5v3h-1c-2.209 0-4-1.791-4-4V3zm0 14c-2.761 0-5-2.239-5-5v-1h1c2.209 0 4 1.791 4 4v2z"></path></svg>',
  'Headsets' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 18v-6a9 9 0 0 1 18 0v6"></path><path d="M9 21c0 1.105-.895 2-2 2s-2-.895-2-2"></path><path d="M15 21c0 1.105-.895 2-2 2s-2-.895-2-2"></path></svg>',
  'Monitors' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><path d="M7 17h10"></path><path d="M9 21h6"></path></svg>',
  'Microphones' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>'
];

// Fetch products from database
$db = Database::getInstance()->getConnection();
$filtered_products = [];
$categories = [];

try {
  // Check if database connection is available
  if ($db === null) {
    throw new Exception("Database connection unavailable");
  } 
  
  // Get categories
  $catStmt = $db->query("SELECT name FROM categories ORDER BY name");
  $categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);

  // Build product query with filters
  $sql = "
    SELECT p.product_id AS id, p.name, c.name AS category, p.price, p.description, p.stock, p.image,
           COUNT(r.review_id) AS review_count, COALESCE(AVG(r.rating), 0) AS avg_rating
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    LEFT JOIN reviews r ON p.product_id = r.product_id
    WHERE 1=1
  ";
  $params = [];

  // Apply filters
  $selected_category = isset($_GET['category']) ? $_GET['category'] : null;
  if (!empty($selected_category)) {
    $sql .= " AND c.name = ? ";
    $params[] = $selected_category;  


  }

  if (!empty($_GET['search'])) {
    $sql .= " AND (p.name LIKE ? OR c.name LIKE ?) ";
    $params[] = "%" . $_GET['search'] . "%";
    $params[] = "%" . $_GET['search'] . "%";
  }

  if (!empty($_GET['min_price'])) {
    $sql .= " AND p.price >= ? ";
    $params[] = $_GET['min_price'];
  }

  if (!empty($_GET['max_price'])) {
    $sql .= " AND p.price <= ? ";
    $params[] = $_GET['max_price'];
  }

  $sql .= " GROUP BY p.product_id ORDER BY p.price ASC";

  $stmt = $db->prepare($sql);
  $stmt->execute($params);
  $db_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Format products with icons
  $filtered_products = array_map(function($product) use ($category_icons) {
    return array_merge($product, [
      'icon' => $category_icons[$product['category']] ?? '',
      'rating' => (int)$product['avg_rating'],
      'reviews' => (int)$product['review_count'],
      'original_price' => null,
      'badge' => $product['stock'] == 0 ? 'Out of Stock' : null
    ]);
  }, $db_products);

} catch (Exception $e) {
  error_log("Error fetching products: " . $e->getMessage());
  $filtered_products = [];
  $categories = ['Keyboards', 'Mice', 'Headsets', 'Monitors', 'Microphones'];
}
  $filtered_products = array_map(function($product) use ($category_icons) {
    return array_merge($product, [
        'icon' => $category_icons[$product['category_name']] ?? '',
        'original_price' => null
    ]);
}, $products);

  
  // Apply filters to fallback data
  $filtered_products = $fallback_products; foreach ($filtered_products as &$product) {
    $product['icon'] = $category_icons[$product['category_name']] ?? '';

  $selected_category = isset($_GET['category_name']) ? $_GET['category_name'] : null;
  $search_term = isset($_GET['search']) ? $_GET['search'] : null;
  $min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : null;
  $max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : null;
  
  if (!empty($selected_category)) {
    $filtered_products = array_filter($filtered_products, fn($p) => $p['category_name'] === $selected_category);
  }
  
  if (!empty($search_term)) {
    $filtered_products = array_filter($filtered_products, fn($p) => 
      stripos($p['name'], $search_term) !== false || 
      stripos($p['description'], $search_term) !== false ||
      stripos($p['category_name'], $search_term) !== false
    );
  }
  
  if ($min_price !== null) {
    $filtered_products = array_filter($filtered_products, fn($p) => $p['price'] >= $min_price);
  }
  
  if ($max_price !== null) {
    $filtered_products = array_filter($filtered_products, fn($p) => $p['price'] <= $max_price);
  }
}

// Initialize filters from GET parameters
$filters = [
  'search' => $_GET['search'] ?? '',
  'category' => $_GET['category'] ?? '',
  'min_price' => $_GET['min_price'] ?? '',
  'max_price' => $_GET['max_price'] ?? ''
];
?>

<style>
.filters {
    border: 2px solid var(--highlight-color);
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
    max-width: 70%;
}

.filters form {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    align-items: center;
}

.filter-group {
    display: flex;
    gap: 10px;
    align-items: center;
}

.filter-group label {
    color: var(--text-primary);
    font-size: 14px;
    font-weight: 500;
    white-space: nowrap;
}

.filters input[type="text"],
.filters input[type="number"],
.filters select {
    padding: 10px 14px;
    border: 2px solid var(--lavender);
    border-radius: 6px;
    background-color: #0a0a0a;
    color: var(--white);
    outline: none;
    font-size: 14px;
    min-width: 150px;
}

.filters input[type="text"]::placeholder,
.filters input[type="number"]::placeholder {
    color: #bca8e6;
}

.filters select {
    cursor: pointer;
    width: 330px;
}

.filters select option {
    background-color: #0a0a0a;
    color: var(--white);
}

.filters .btn {
    padding: 10px 20px;
    background-color: var(--highlight-color);
    border: 2px solid var(--lavender);
    border-radius: 6px;
    color: var(--white);
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    transition: 0.2s;
    text-decoration: none;
    display: inline-block;
}

.filters .btn:hover {
    background-color: var(--lavender);
    color: #0a0a0a;
    text-shadow: 0 0 10px white;
}

.filters .btn-secondary {
    background-color: transparent;
    border-color: var(--lavender);
    color: var(--text-primary);
}

.filters .btn-secondary:hover {
    background-color: var(--lavender);
    color: #0a0a0a;
}

/* Product card styles */
.product-card {
    position: relative;
}

.stock-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    z-index: 10;
    text-align: center;
    max-width: 90%;
}

.stock-badge.in-stock {
    background-color: rgba(50, 255, 120, 0.2);
    color: #6bff8f;
    border: 1px solid #6bff8f;
}

.stock-badge.low-stock {
    background-color: rgba(255, 193, 7, 0.2);
    color: #ffc107;
    border: 1px solid #ffc107;
}

.stock-badge.out-of-stock {
    background-color: rgba(255, 79, 79, 0.2);
    color: #ff4f4f;
    border: 1px solid #ff4f4f;
}

.product-stock-info {
    font-size: 12px;
    margin: 8px 0;
    min-height: 20px;
}

.stock-units {
    color: var(--text-secondary);
}
</style>

<div class="container">
    <h1>Gaming Products</h1>

    <form method="GET" action="index.php" style="position: relative;">
        <input type="hidden" name="page" value="products">

        <!-- Logo positioned behind filters -->
        <img src="<?= BASE_URL ?>assets/images/logo_no_text.png" alt="Level Up Gaming" style="position: absolute; right: 0;
         transform: translateX(50%); top: 45%; transform: translateY(-50%); height: 400px; width: auto; opacity: 0.7; z-index: -1;">


        <!-- Other Filters Section -->
        <div class="filters">
            <div style="display: flex; gap: 15px; align-items: center; margin-bottom: 15px;">
                <div class="filter-group">
                    <select name="category">
                <option value="">All Categories</option>
                        <?php foreach ($categories as $category): ?>
                         <?php $cat_name = is_array($category) ? $category['name'] : $category; ?>
                         <option value="<?php echo htmlspecialchars($cat_name); ?>" 
                             <?php echo ($filters['category'] == $cat_name) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($cat_name); ?>
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
            </div>

            <div style="display: flex; gap: 15px;">
                <button type="submit" class="btn">Apply Filters</button>
                <a href="index.php?page=products" class="btn btn-secondary">Clear Filters</a>
            </div>
        </div>
    </form>

    <div class="product-grid">

    <?php if (empty($filtered_products)): ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px 20px;">
            <p style="font-size: 1.2em; color: #666;">No products matching search available</p>
            <a href="index.php?page=products" class="btn" style="margin-top: 20px; display: inline-block;">View All Products</a>
        </div>
    <?php else: ?>
    
    <?php foreach ($filtered_products as $product): ?>
        <div class="product-card">

            <div class="product-img">
                <?php
               $imagePath = "products/"
              . strtolower($product['category_name']) . "/"
              . $product['slug'] . "/01.png";
             ?>

                <!-- Stock Badge -->
                <?php if ($product['stock'] > 10): ?>
                    <span class="stock-badge in-stock">✓ In Stock</span>
                <?php elseif ($product['stock'] > 0): ?>
                    <span class="stock-badge low-stock">⚠ Low Stock</span>
                <?php else: ?>
                    <span class="stock-badge out-of-stock">✗ Out of Stock</span>
                <?php endif; ?>

            <img 
                src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($imagePath) ?>" 
                alt="<?= htmlspecialchars($product['name']) ?>"
                >

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

                <!-- Stock Level Information -->
                <div class="product-stock-info">
                    <?php if ($product['stock'] > 10): ?>
                        <span class="stock-units">✓ In Stock (<?= $product['stock'] ?> available)</span>
                    <?php elseif ($product['stock'] > 0): ?>
                        <span class="stock-units">⚠ Low Stock (<?= $product['stock'] ?> left)</span>
                    <?php else: ?>
                        <span class="stock-units">✗ Out of Stock</span>
                    <?php endif; ?>
                </div>

                <div class="product-actions">
                    <a href="index.php?page=product&id=<?= $product['product_id'] ?>"
                        class="btn-view">View Details</a>


                    <?php if ($product['stock'] > 0): ?>
                        <form method="POST"
                              action="index.php?page=add-to-basket">
                            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                            <button type="submit" class="btn-basket">Add to Basket</button>
                        </form>
                    <?php else: ?>
                        <span class="out-of-stock-text">Out of Stock</span>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    <?php endforeach; ?>
    
    <?php endif; ?>

</div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>