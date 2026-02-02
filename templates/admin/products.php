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

<style>
    .admin-products-container {
        max-width: 1600px;
        margin: 0 auto;
        padding: 30px;
    }

    .admin-header {
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .admin-header div {
        flex: 1;
    }

    .admin-header h1 {
        color: var(--text-primary);
        margin-bottom: 5px;
    }

    .admin-header p {
        color: var(--text-secondary);
    }

    .btn-add-product {
        padding: 12px 24px;
        background: #4caf50;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-add-product:hover {
        background: #388E3C;
        transform: translateY(-2px);
    }

    .success-message {
        padding: 15px 20px;
        background: rgba(76, 175, 80, 0.2);
        border: 2px solid #4caf50;
        border-radius: 8px;
        color: #4caf50;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .filter-section {
        background: rgba(188, 168, 230, 0.05);
        border: 2px solid var(--lavender);
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .filter-form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .filter-group label {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.9rem;
    }

    .filter-group input,
    .filter-group select {
        padding: 10px 12px;
        border: 2px solid rgba(188, 168, 230, 0.3);
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
        font-size: 0.95rem;
    }

    .filter-group input:focus,
    .filter-group select:focus {
        outline: none;
        border-color: var(--highlight);
    }

    .filter-actions {
        display: flex;
        gap: 10px;
    }

    .btn-filter,
    .btn-clear {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        border: none;
    }

    .btn-filter {
        background: var(--highlight);
        color: white;
    }

    .btn-filter:hover {
        background: var(--highlight-dark);
    }

    .btn-clear {
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-primary);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .btn-clear:hover {
        background: rgba(255, 255, 255, 0.2);
    }

    .results-summary {
        margin-bottom: 15px;
        padding: 12px;
        background: rgba(76, 175, 80, 0.1);
        border-left: 4px solid #4caf50;
        border-radius: 6px;
    }

    .results-summary p {
        margin: 0;
        color: var(--text-primary);
    }

    .table-container {
        overflow-x: auto;
        background: rgba(255, 255, 255, 0.02);
        border-radius: 12px;
        padding: 20px;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table thead {
        background: rgba(188, 168, 230, 0.2);
    }

    .admin-table th {
        padding: 15px 10px;
        text-align: left;
        color: var(--text-primary);
        font-weight: 600;
        border-bottom: 2px solid var(--lavender);
        white-space: nowrap;
    }

    .admin-table td {
        padding: 12px 10px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--text-primary);
    }

    .admin-table tbody tr:hover {
        background: rgba(188, 168, 230, 0.1);
    }

    .product-row.out-of-stock {
        background: rgba(220, 53, 69, 0.1);
    }

    .product-row.low-stock {
        background: rgba(255, 193, 7, 0.05);
    }

    .product-name-cell strong {
        color: var(--highlight);
    }

    .price-cell {
        font-weight: 600;
    }

    .stock-cell {
        text-align: center;
    }

    .inline-input {
        width: 80px;
        padding: 6px 8px;
        border: 2px solid rgba(188, 168, 230, 0.3);
        border-radius: 4px;
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
        font-weight: 600;
        text-align: center;
    }

    .inline-input:focus {
        outline: none;
        border-color: var(--highlight);
    }

    .price-input {
        width: 90px;
    }

    .stock-input.critical {
        border-color: #ff4444;
        color: #ff4444;
    }

    .stock-input.warning {
        border-color: #ffc107;
        color: #ffc107;
    }

    .threshold-input {
        width: 70px;
    }

    .status-badge {
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 0.85rem;
        font-weight: 600;
        white-space: nowrap;
        display: inline-block;
    }

    .status-badge.critical {
        background: rgba(220, 53, 69, 0.2);
        color: #ff6b6b;
        border: 1px solid #ff4444;
    }

    .status-badge.warning {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
        border: 1px solid #ffc107;
    }

    .status-badge.success {
        background: rgba(76, 175, 80, 0.2);
        color: #4caf50;
        border: 1px solid #4caf50;
    }

    .actions-cell {
        white-space: nowrap;
    }

    .btn-update {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        background: var(--highlight);
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        margin-right: 5px;
    }

    .btn-update:hover {
        background: var(--highlight-dark);
        transform: translateY(-1px);
    }

    .btn-delete {
        padding: 8px 16px;
        border: none;
        border-radius: 6px;
        background: #dc3545;
        color: white;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 0.9rem;
    }

    .btn-delete:hover {
        background: #c82333;
        transform: translateY(-1px);
    }

    .no-results {
        text-align: center;
        padding: 40px !important;
        color: var(--text-secondary);
        font-style: italic;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-content {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        margin: 5% auto;
        padding: 0;
        border: 2px solid var(--lavender);
        border-radius: 12px;
        width: 90%;
        max-width: 700px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
    }

    .modal-header {
        padding: 20px 30px;
        background: rgba(188, 168, 230, 0.1);
        border-bottom: 2px solid var(--lavender);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        margin: 0;
        color: var(--text-primary);
    }

    .close {
        color: var(--text-secondary);
        font-size: 35px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .close:hover {
        color: var(--highlight);
    }

    .add-product-form {
        padding: 30px;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group label {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.95rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 12px;
        border: 2px solid rgba(188, 168, 230, 0.3);
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.05);
        color: var(--text-primary);
        font-size: 1rem;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: var(--highlight);
    }

    .modal-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
    }

    .btn-submit {
        padding: 12px 30px;
        background: #4caf50;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-submit:hover {
        background: #388E3C;
    }

    .btn-cancel {
        padding: 12px 30px;
        background: rgba(255, 255, 255, 0.1);
        color: var(--text-primary);
        border: 2px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1rem;
    }

    .btn-cancel:hover {
        background: rgba(255, 255, 255, 0.2);
    }
</style>

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

<?php include __DIR__ . '/../footer.php'; ?>
