<?php
$title = 'Products - Level Up Gaming';
require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/../../src/Database.php';

$db = Database::getInstance()->getConnection();

$filtered_products = [];
$categories = [];

try {
  if ($db === null) {
    throw new Exception("Database connection unavailable");
  }

  // Categories
  $catStmt = $db->query("SELECT name FROM categories ORDER BY name");
  $categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);

  // Base query
  $sql = "SELECT 
            p.product_id,
            p.name,
            p.slug,
            c.name AS category_name,
            p.price,
            p.description,
            p.stock,
            COUNT(r.review_id) AS review_count,
            COALESCE(AVG(r.rating), 0) AS avg_rating
          FROM products p
          JOIN categories c ON p.category_id = c.category_id
          LEFT JOIN reviews r ON p.product_id = r.product_id
          WHERE 1=1";

  $params = [];

  // CATEGORY
  if (!empty($_GET['category'])) {
    $sql .= " AND c.name = ?";
    $params[] = $_GET['category'];
  }

  // SEARCH
  if (!empty($_GET['search'])) {
    $sql .= " AND (p.name LIKE ? OR c.name LIKE ?)";
    $params[] = "%" . $_GET['search'] . "%";
    $params[] = "%" . $_GET['search'] . "%";
  }

  // PRICE RANGE
  if (!empty($_GET['price_range'])) {
    $range = $_GET['price_range'];

    if ($range === '225+') {
      $sql .= " AND p.price >= ?";
      $params[] = 225;
    } else {
      list($min, $max) = explode('-', $range);
      $sql .= " AND p.price BETWEEN ? AND ?";
      $params[] = (float)$min;
      $params[] = (float)$max;
    }
  }

  // IN STOCK ONLY
  if (!empty($_GET['in_stock'])) {
    $sql .= " AND p.stock > 0";
  }

  $sql .= " GROUP BY p.product_id";

  // SORTING
  $sort = $_GET['sort'] ?? '';

  switch ($sort) {
    case 'price_desc':
      $sql .= " ORDER BY p.price DESC";
      break;
    case 'rating_desc':
      $sql .= " ORDER BY avg_rating DESC";
      break;
    case 'stock_desc':
      $sql .= " ORDER BY p.stock > 0 DESC";
      break;
    default:
      $sql .= " ORDER BY p.price ASC";
  }

  $stmt = $db->prepare($sql);
  $stmt->execute($params);
  $filtered_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (Exception $e) {
  error_log($e->getMessage());
}

// Persist filters
$filters = [
  'category' => $_GET['category'] ?? '',
  'price_range' => $_GET['price_range'] ?? '',
  'sort' => $_GET['sort'] ?? '',
  'in_stock' => $_GET['in_stock'] ?? ''
];
?>

<div class="container">
<h1>Gaming Products</h1>

<form method="GET" action="index.php">
<input type="hidden" name="page" value="products">

<div class="filters">

<div style="display:flex; gap:15px; flex-wrap:wrap;">

<!-- CATEGORY -->
<select name="category">
<option value="">All Categories</option>
<?php foreach ($categories as $cat): ?>
<option value="<?= htmlspecialchars($cat) ?>" <?= $filters['category']==$cat?'selected':'' ?>>
<?= htmlspecialchars($cat) ?>
</option>
<?php endforeach; ?>
</select>

<!-- PRICE RANGE -->
<select name="price_range">
<option value="">All Prices</option>
<option value="0-25" <?= $filters['price_range']=='0-25'?'selected':'' ?>>Up to £25</option>
<option value="25-50" <?= $filters['price_range']=='25-50'?'selected':'' ?>>£25 - £50</option>
<option value="50-75" <?= $filters['price_range']=='50-75'?'selected':'' ?>>£50 - £75</option>
<option value="75-100" <?= $filters['price_range']=='75-100'?'selected':'' ?>>£75 - £100</option>
<option value="100-150" <?= $filters['price_range']=='100-150'?'selected':'' ?>>£100 - £150</option>
<option value="150-225" <?= $filters['price_range']=='150-225'?'selected':'' ?>>£150 - £225</option>
<option value="225+" <?= $filters['price_range']=='225+'?'selected':'' ?>>£225+</option>
</select>

<!-- SORT -->
<select name="sort">
<option value="">Sort By</option>
<option value="price_asc" <?= $filters['sort']=='price_asc'?'selected':'' ?>>Price: Low → High</option>
<option value="price_desc" <?= $filters['sort']=='price_desc'?'selected':'' ?>>Price: High → Low</option>
<option value="rating_desc" <?= $filters['sort']=='rating_desc'?'selected':'' ?>>Top Rated</option>
<option value="stock_desc" <?= $filters['sort']=='stock_desc'?'selected':'' ?>>In Stock First</option>
</select>

<!-- STOCK -->
<label>
<input type="checkbox" name="in_stock" value="1" <?= $filters['in_stock']?'checked':'' ?>>
In Stock
</label>

</div>

<div style="margin-top:10px;">
<button class="btn">Apply Filters</button>
<a href="index.php?page=products" class="btn btn-secondary">Clear</a>
</div>

</div>
</form>

<div class="product-grid">

<?php if (empty($filtered_products)): ?>
<p>No products found.</p>
<?php else: ?>

<?php foreach ($filtered_products as $product): ?>

<div class="product-card skeleton">

<div class="product-image">

<?php
$imagePath = "products/"
. strtolower($product['category_name']) . "/"
. $product['slug'] . "/01.png";
?>


<!-- Stock Badge --> <?php if ($product['stock'] > 10): ?> <span class="stock-badge in-stock">✓ In Stock</span> <?php elseif ($product['stock'] > 0): ?> <span class="stock-badge low-stock">⚠ Low Stock</span> <?php else: ?> <span class="stock-badge out-of-stock">✗ Out of Stock</span> <?php endif; ?> <img src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($imagePath) ?>" alt="<?= htmlspecialchars($product['name']) ?>" >
</div>

<div class="product-info">

<h3 class="product-title skeleton-text"><?= htmlspecialchars($product['name']) ?></h3>

<p class="product-desc skeleton-text"> <?php echo htmlspecialchars(substr($product['description'], 0, 70)); ?>... </p>

<p class="product-price">£<?= number_format($product['price'],2) ?></p>

<div class="product-actions">
<a href="index.php?page=product&id=<?= $product['product_id'] ?>"class="btn-view">View</a>

<?php if ($product['stock'] > 0): ?>
<form class="add-to-cart-form">
<input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
<button type="submit" class="btn-basket">Add to Basket</button>
</form>
<?php else: ?>
<span>Out of stock</span>
<?php endif; ?>

</div>

</div>
</div>
<?php endforeach; ?>

<?php endif; ?>

</div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
