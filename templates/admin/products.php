<!-- Admin product management -->
<?php include __DIR__ . '/../header.php'; ?>

<div class="admin-products-container">
    <div class="admin-header">
        <h1>🛍️ Product Management</h1>
        <p>Search, filter, and manage all products</p>
        <button onclick="document.getElementById('addProductModal').style.display='block'" class="btn-add-product">
            ➕ Add New Product
        </button>
    </div>

    <?php if (isset($_GET['updated'])): ?>
        <div class="success-message">✅ Product updated successfully!</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['added'])): ?>
        <div class="success-message">✅ Product added successfully!</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['deleted'])): ?>
        <div class="success-message">✅ Product deleted successfully!</div>
    <?php endif; ?>

    <!-- Search and Filter Section -->
    <div class="filter-section">
        <form method="GET" action="index.php" class="filter-form">
            <input type="hidden" name="page" value="admin-products">
            
            <div class="filter-row">
                <div class="filter-group">
                    <label>🔍 Search Product</label>
                    <input type="text" name="search" placeholder="Product name..." 
                           value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                </div>

                <div class="filter-group">
                    <label>📁 Category</label>
                    <select name="category">
                        <option value="">All Categories</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat) ?>" 
                                        <?= (($_GET['category'] ?? '') === $cat) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($cat) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label>📊 Stock Status</label>
                    <select name="stock_status">
                        <option value="">All Products</option>
                        <option value="out" <?= (($_GET['stock_status'] ?? '') === 'out') ? 'selected' : '' ?>>Out of Stock</option>
                        <option value="low" <?= (($_GET['stock_status'] ?? '') === 'low') ? 'selected' : '' ?>>Low Stock</option>
                        <option value="in_stock" <?= (($_GET['stock_status'] ?? '') === 'in_stock') ? 'selected' : '' ?>>In Stock</option>
                    </select>
                </div>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-filter">Apply Filters</button>
                <a href="index.php?page=admin-products" class="btn-clear">Clear All</a>
            </div>
        </form>
    </div>

    <!-- Results Summary -->
    <div class="results-summary">
        <p>Showing <strong><?= isset($products) ? count($products) : 0 ?></strong> product(s)</p>
    </div>

    <!-- Products Table -->
    <div class="table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Threshold</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="8" class="no-results">No products found matching your criteria</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr class="product-row <?= $product['stock'] == 0 ? 'out-of-stock' : ($product['stock'] <= $product['low_stock_threshold'] ? 'low-stock' : '') ?>">
                            <td><strong>#<?= $product['product_id'] ?></strong></td>
                            <td class="product-name-cell">
                                <strong><?= htmlspecialchars($product['name']) ?></strong>
                            </td>
                            <td><?= htmlspecialchars($product['category_name']) ?></td>
                            <td class="price-cell">
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" 
                                           class="inline-input price-input">
                                </form>
                            </td>
                            <td class="stock-cell">
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <input type="number" name="stock" value="<?= $product['stock'] ?>" 
                                           class="inline-input stock-input <?= $product['stock'] == 0 ? 'critical' : ($product['stock'] <= $product['low_stock_threshold'] ? 'warning' : '') ?>">
                                </form>
                            </td>
                            <td>
                                <?php if ($product['stock'] == 0): ?>
                                    <span class="status-badge critical">❌ Out of Stock</span>
                                <?php elseif ($product['stock'] <= $product['low_stock_threshold']): ?>
                                    <span class="status-badge warning">⚠️ Low Stock</span>
                                <?php else: ?>
                                    <span class="status-badge success">✅ In Stock</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <input type="number" name="low_stock_threshold" value="<?= $product['low_stock_threshold'] ?>" 
                                           class="inline-input threshold-input">
                                </form>
                            </td>
                            <td class="actions-cell">
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <input type="hidden" name="price" value="<?= $product['price'] ?>">
                                    <input type="hidden" name="stock" value="<?= $product['stock'] ?>">
                                    <input type="hidden" name="low_stock_threshold" value="<?= $product['low_stock_threshold'] ?>">
                                    <button type="submit" name="update_product" class="btn-update">💾 Update</button>
                                </form>
                                <form method="POST" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                                    <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                                    <button type="submit" name="delete_product" class="btn-delete">🗑️ Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>➕ Add New Product</h2>
            <span class="close" onclick="document.getElementById('addProductModal').style.display='none'">&times;</span>
        </div>
        <form method="POST" class="add-product-form">
            <div class="form-row">
                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="name" required placeholder="Enter product name">
                </div>
                
                <div class="form-group">
                    <label>Category *</label>
                    <select name="category_id" required>
                        <option value="">Select Category</option>
                        <?php 
                        $db = Database::getInstance()->getConnection();
                        $catStmt = $db->query("SELECT category_id, name FROM categories ORDER BY name");
                        $allCategories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($allCategories as $cat): 
                        ?>
                            <option value="<?= $cat['category_id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" required rows="4" placeholder="Enter product description"></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Price (£) *</label>
                    <input type="number" step="0.01" name="price" required min="0" placeholder="0.00">
                </div>

                <div class="form-group">
                    <label>Initial Stock *</label>
                    <input type="number" name="stock" required min="0" value="0">
                </div>

                <div class="form-group">
                    <label>Low Stock Threshold *</label>
                    <input type="number" name="low_stock_threshold" required min="1" value="10">
                </div>
            </div>

            <div class="modal-actions">
                <button type="submit" name="add_product" class="btn-submit">Add Product</button>
                <button type="button" onclick="document.getElementById('addProductModal').style.display='none'" class="btn-cancel">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
// Modal functionality
const modal = document.getElementById('addProductModal');
const addBtn = document.querySelector('.btn-add-product');
const closeBtn = document.querySelector('.close');

addBtn.onclick = function() {
    modal.style.display = 'block';
}

closeBtn.onclick = function() {
    modal.style.display = 'none';
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}

// Auto-submit forms when inline inputs change
document.querySelectorAll('.inline-input').forEach(input => {
    input.addEventListener('change', function() {
        const form = this.closest('form');
        const productId = form.querySelector('input[name="product_id"]').value;
        
        // Get all values from the row
        const row = this.closest('tr');
        const priceInput = row.querySelector('input[name="price"]');
        const stockInput = row.querySelector('input[name="stock"]');
        const thresholdInput = row.querySelector('input[name="low_stock_threshold"]');
        
        // Update hidden fields in the update button form
        const updateForm = row.querySelector('form:has(button[name="update_product"])');
        updateForm.querySelector('input[name="price"]').value = priceInput.value;
        updateForm.querySelector('input[name="stock"]').value = stockInput.value;
        updateForm.querySelector('input[name="low_stock_threshold"]').value = thresholdInput.value;
    });
});
</script>

<a href="index.php?page=dashboard" class="btn-secondary">
   ← Back to Dashboard
</a>

<?php include __DIR__ . '/../footer.php'; ?>
