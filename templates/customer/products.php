<?php
$title = 'Products - Level Up Gaming';

require_once __DIR__ . '/../header.php';
require_once __DIR__ . '/../../src/Database.php';

// Ensure BASE_URL exists (defined in Config.php)
if (!defined('BASE_URL')) {
    define('BASE_URL', '/Team-Project-Group-4/public/');
}

/* ----------------------------------------------------------
   CATEGORY ICONS
---------------------------------------------------------- */
$category_icons = [
    'Keyboards' => '<svg ...></svg>',
    'Mice' => '<svg ...></svg>',
    'Headsets' => '<svg ...></svg>',
    'Monitors' => '<svg ...></svg>',
    'Microphones' => '<svg ...></svg>',
];

/* ----------------------------------------------------------
   DATABASE CONNECTION
---------------------------------------------------------- */
$db = Database::getInstance()->getConnection();

/* ----------------------------------------------------------
   FETCH CATEGORIES
---------------------------------------------------------- */
$categories = $db->query("SELECT name FROM categories ORDER BY name")->fetchAll(PDO::FETCH_COLUMN);

/* ----------------------------------------------------------
   BUILD FILTER QUERY
---------------------------------------------------------- */
$sql = "
    SELECT 
        p.product_id AS id,
        p.name,
        c.name AS category,
        p.price,
        p.description,
        p.stock,
        p.image,
        COUNT(r.review_id) AS review_count,
        COALESCE(AVG(r.rating), 0) AS avg_rating
    FROM products p
    JOIN categories c ON p.category_id = c.category_id
    LEFT JOIN reviews r ON p.product_id = r.product_id
    WHERE 1=1
";

$params = [];

// --- SEARCH FILTER ---
if (!empty($_GET['search'])) {
    $sql .= " AND (p.name LIKE ? OR c.name LIKE ?) ";
    $params[] = "%" . $_GET['search'] . "%";
    $params[] = "%" . $_GET['search'] . "%";
}

// --- CATEGORY FILTER ---
if (!empty($_GET['category'])) {
    $sql .= " AND c.name = ? ";
    $params[] = $_GET['category'];
}

// --- PRICE FILTERS ---
if (!empty($_GET['min_price'])) {
    $sql .= " AND p.price >= ? ";
    $params[] = $_GET['min_price'];
}

if (!empty($_GET['max_price'])) {
    $sql .= " AND p.price <= ? ";
    $params[] = $_GET['max_price'];
}

$sql .= " GROUP BY p.product_id ORDER BY p.price ASC";

/* ----------------------------------------------------------
   EXECUTE QUERY
---------------------------------------------------------- */
$stmt = $db->prepare($sql);
$stmt->execute($params);

$db_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

/* ----------------------------------------------------------
   FORMAT PRODUCTS
---------------------------------------------------------- */
$filtered_products = array_map(function($p) use ($category_icons) {
    return [
        'id' => $p['id'],
        'name' => $p['name'],
        'category' => $p['category'],
        'price' => $p['price'],
        'description' => $p['description'],
        'stock' => $p['stock'],
        'image' => $p['image'] ?? 'placeholder.png',
        'icon' => $category_icons[$p['category']] ?? '',
        'rating' => (int) $p['avg_rating'],
        'reviews' => (int) $p['review_count'],
        'badge' => $p['stock'] == 0 ? 'Out of Stock' : null,
    ];
}, $db_products);

/* ----------------------------------------------------------
    GET FILTER VALUES FOR UI
---------------------------------------------------------- */
$filters = [
    'search' => $_GET['search'] ?? '',
    'category' => $_GET['category'] ?? '',
    'min_price' => $_GET['min_price'] ?? '',
    'max_price' => $_GET['max_price'] ?? ''
];
?>

<style>
/* FILTER STYLES */
.filters {
    border: 2px solid var(--highlight-color);
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.filters form {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
}

/* PRODUCT GRID */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 25px;
    padding: 20px 0;
}

.product-card {
    background: #1a1a1a;
    border-radius: 12px;
    padding: 15px;
    color: white;
    text-align: left;
    box-shadow: 0 0 12px rgba(120, 50, 255, 0.2);
    transition: transform .2s;
}
.product-card:hover {
    transform: scale(1.03);
}

.product-img {
    height: 170px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #0d0d0d;
    border-radius: 8px;
    overflow: hidden;
}

.product-img img {
    height: 100%;
    width: auto;
    object-fit: contain;
}

.product-title {
    color: #C9A7FF;
    font-size: 1.15rem;
    margin-top: 12px;
}

.product-category {
    opacity: 0.7;
    font-size: 0.9rem;
}

.product-price {
    color: #8F68FF;
    font-size: 1.4rem;
    font-weight: bold;
    margin: 12px 0;
}

.out-of-stock-text {
    color: #ff4f4f;
}
</style>

<div class="container">
    <h1>Gaming Products</h1>

    <!-- FILTER FORM -->
    <form method="GET" action="index.php">
        <input type="hidden" name="page" value="products">

        <div class="filters">

            <!-- Search -->
            <div>
                <input type="text" name="search" placeholder="Search products..." 
                value="<?= htmlspecialchars($filters['search']) ?>">
            </div>

            <!-- Category -->
            <div>
                <select name="category">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat) ?>"
                            <?= $filters['category'] == $cat ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Price Range -->
            <div>
                <input type="number" name="min_price" placeholder="Min £"
                       value="<?= htmlspecialchars($filters['min_price']) ?>" min="0" step="0.01">
                <input type="number" name="max_price" placeholder="Max £"
                       value="<?= htmlspecialchars($filters['max_price']) ?>" min="0" step="0.01">
            </div>

            <!-- Buttons -->
            <button class="btn" type="submit">Apply Filters</button>
            <a class="btn btn-secondary" href="index.php?page=products">Clear</a>
        </div>
    </form>

    <!-- PRODUCT GRID -->
    <div class="product-grid">

        <?php if (empty($filtered_products)): ?>
            <p>No products found.</p>
        <?php else: ?>

            <?php foreach ($filtered_products as $p): ?>
            <div class="product-card">

                <div class="product-img">
                    <img src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($p['image']) ?>"
                        alt="<?= htmlspecialchars($p['name']) ?>">
                </div>

                <h3 class="product-title"><?= htmlspecialchars($p['name']) ?></h3>
                <p class="product-category"><?= htmlspecialchars($p['category']) ?></p>
                <p class="product-price">£<?= number_format($p['price'], 2) ?></p>

                <?php if ($p['badge'] === 'Out of Stock'): ?>
                    <p class="out-of-stock-text">Out of Stock</p>
                <?php else: ?>
                    <form method="POST" action="index.php?page=add-to-basket">
                        <input type="hidden" name="product_id" value="<?= $p['id'] ?>">
                        <button class="btn-basket">Add to Basket</button>
                    </form>
                <?php endif; ?>

                <a class="btn-view" href="index.php?page=product&id=<?= $p['id'] ?>">View Details</a>

            </div>
            <?php endforeach; ?>

        <?php endif; ?>

    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
