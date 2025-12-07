<?php include __DIR__ . '/../header.php'; ?>

<style>
.basket-container {
    max-width: 900px;
    margin: 40px auto;
    background: #140a26;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 0 20px rgba(132, 0, 255, 0.25);
    color: white;
}

.cart-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px;
    background: #1d1133;
    border-radius: 10px;
    margin-bottom: 20px;
}

.item-left {
    display: flex;
    gap: 18px;
    align-items: center;
}

.item-left img {
    width: 110px;
    height: 110px;
    object-fit: contain;
    background: #0f081c;
    border-radius: 8px;
}

.item-info h3 {
    margin: 0;
    color: #d9a7ff;
}

.item-info p {
    margin: 4px 0;
}

.quantity-box {
    display: flex;
    align-items: center;
    gap: 10px;
}

.qty-btn {
    background: #5A3FA3;
    color: white;
    width: 32px;
    height: 32px;
    border-radius: 6px;
    border: none;
    font-size: 20px;
    cursor: pointer;
    transition: 0.2s;
}

.qty-btn:hover {
    background: #7E5AF5;
}

.quantity-display {
    padding: 6px 12px;
    background: #2a0f47;
    border-radius: 6px;
    color: #d9a7ff;
    font-weight: bold;
}

.remove-btn {
    background: #b30000;
    padding: 10px 18px;
    border-radius: 6px;
    color: white;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transition: 0.2s;
}

.remove-btn:hover {
    background: #ff4444;
}

.total-price {
    font-size: 20px;
    font-weight: bold;
    color: #c097ff;
}
.checkout-btn {
    background: #8f3dff;
    padding: 14px 22px;
    border-radius: 8px;
    font-weight: bold;
    color: white;
    border: none;
    cursor: pointer;
    font-size: 18px;
    transition: 0.2s;
}

.checkout-btn:hover {
    background: #b46cff;
}
</style>


<div class="basket-container">

    <h1>Shopping Basket</h1>

    <?php if (empty($basketItems)): ?>

    <div class="basket-container">
        <h1>Your Basket is Empty</h1>
        <p>Looks like you haven’t added anything yet.</p>

        <a href="/Team-Project-Group-4/public/index.php?page=products" 
           class="checkout-btn">
           Browse Products
        </a>
    </div>

    <?php include __DIR__ . '/../footer.php'; ?>
    <?php return; ?>

<?php endif; ?>


    <?php foreach ($basketItems as $item): ?>
        <div class="cart-item">

            <div class="item-left">
                <img src="/Team-Project-Group-4/public/assets/images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">


                <div class="item-info">
                    <h3><?= htmlspecialchars($item['name']) ?></h3>
                    <p>£<?= number_format($item['price'], 2) ?></p>

                    <!-- Quantity Controls -->
                    <div class="quantity-box">

                        <!-- Minus -->
                        <form method="POST" action="/Team-Project-Group-4/public/index.php?page=basket-update">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="quantity" value="<?= $item['quantity'] - 1 ?>">
                            <button class="qty-btn minus" data-id="<?= $item['id'] ?>">−</button>
                        </form>

                        <!-- Quantity Display -->
                        <div class="quantity-display" id="qty-<?= $item['id'] ?>"><?= $item['quantity'] ?></div>

                        <!-- Plus -->
                        <form method="POST" action="/Team-Project-Group-4/public/index.php?page=basket-update">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="quantity" value="<?= $item['quantity'] + 1 ?>">
                            <button class="qty-btn plus" data-id="<?= $item['id'] ?>">+</button>
                        </form>

                    </div>

                    <!-- Remove -->
                    <form method="POST" action="/Team-Project-Group-4/public/index.php?page=basket-remove">
                        <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                        <button class="remove-btn" data-id="<?= $item['id'] ?>">Remove Item</button>

                    </form>
                </div>
            </div>

            <div class="total-price">
                £<?= number_format($item['total'], 2) ?>
            </div>

        </div>
    <?php endforeach; ?>


    <h2>Total: £<?= number_format($basketTotal, 2) ?></h2>

    <a href="/Team-Project-Group-4/public/index.php?page=checkout" class="checkout-btn">
    Proceed to Checkout
    </a>


</div>

<script>
document.addEventListener("DOMContentLoaded", () => {

    function updateQuantity(productId, newQty) {
        fetch("/Team-Project-Group-4/public/index.php?page=basket-update-ajax", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `product_id=${productId}&quantity=${newQty}`
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {

                // If removed from basket
                if (data.remove) {
                    document.getElementById(`item-${productId}`).remove();
                } else {
                    // Update quantity display
                    document.getElementById(`qty-${productId}`).innerText = newQty;

                    // Update line total
                    document.getElementById(`line-${productId}`).innerText = "£" + data.lineTotal;
                }

                // Update basket total
                document.getElementById("basket-total").innerText = "£" + data.total;
            }
        });
    }

    // Handle plus buttons
    document.querySelectorAll(".qty-btn.plus").forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.id;
            const qtyBox = document.getElementById(`qty-${id}`);
            const newQty = parseInt(qtyBox.innerText) + 1;
            updateQuantity(id, newQty);
        };
    });

    // Handle minus buttons
    document.querySelectorAll(".qty-btn.minus").forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.id;
            const qtyBox = document.getElementById(`qty-${id}`);
            const newQty = parseInt(qtyBox.innerText) - 1;
            updateQuantity(id, newQty);
        };
    });

    // Handle remove button
    document.querySelectorAll(".remove-btn").forEach(btn => {
        btn.onclick = () => {
            const id = btn.dataset.id;
            updateQuantity(id, 0);
        };
    });
});
</script>

<?php include __DIR__ . '/../footer.php'; ?>
