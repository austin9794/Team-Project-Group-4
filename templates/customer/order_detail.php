<?php include __DIR__ . '/../header.php'; ?>

<style>
.order-container {
    max-width: 900px;
    margin: 40px auto;
    background: #1a0b2e;
    padding: 25px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(132, 0, 255, 0.25);
    color: #eee;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.order-header h1 {
    margin: 0;
    color: #d9a7ff;
}

.order-status {
    padding: 6px 12px;
    border-radius: 8px;
    font-weight: bold;
}

.order-returned-notice {
    margin-top: 15px;
    padding: 10px;
    background: #5c1a1a;
    border-radius: 6px;
    color: #ffb3b3;
}

.order-tracker {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin: 40px 0;
}

.tracker-step {
    text-align: center;
    flex: 1;
    position: relative;
}

.tracker-step .circle {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #2a2a2a;
    border: 2px solid #444;
    color: #aaa;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 10px;
    font-weight: bold;
}

.tracker-step.active .circle {
    background: #7c3aed;
    border-color: #7c3aed;
    color: white;
}

.tracker-step span {
    font-size: 14px;
    color: #888;
}

.tracker-step.active span {
    color: white;
}

.tracker-line {
    height: 4px;
    background: #2a2a2a;
    flex: 1;
    margin: 0 5px;
}

.tracker-line.active {
    background: #7c3aed;
}

.order-status.pending { background: #ffc107; color: #000; }
.order-status.delivered { background: #28a745; color: #fff; }
.order-status.cancelled { background: #dc3545; color: #fff; }

.estimated-delivery {
    margin-top: 15px;
    padding: 12px;
    background: #1c1c1c;
    border-radius: 8px;
    font-size: 15px;
    color: #ddd;
}

.badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.8rem;
    font-weight: 600;
}

.badge-pending {
    background: #ffb86c;
    color: #000;
}

.badge-approved {
    background: #7cff9d;
    color: #000;
}

.badge-expired {
    background: #ff4f4f;
    color: #fff;
}


.item-card {
    display: flex;
    gap: 15px;
    background: #2a0f47;
    padding: 15px;
    border-radius: 10px;
    margin-top: 15px;
}

.item-card img {
    width: 90px;
    height: 90px;
    object-fit: contain;
    border-radius: 8px;
}

.summary-box {
    margin-top: 25px;
    padding: 15px;
    background: #2a0f47;
    border-radius: 10px;
}
</style>

<div class="order-container">

<?php
$statusSteps = [
    'pending'    => 1,
    'processing' => 2,
    'shipped'    => 3,
    'delivered'  => 4
];

$currentStatus = strtolower($order['status']);
$currentStep = $statusSteps[$currentStatus] ?? 1;
$isReturned = ($currentStatus === 'returned');

if ($isReturned) {
    $currentStep = 4;
}
?>

<?php
$estimatedDelivery = null;

switch ($currentStatus) {
    case 'pending':
        $estimatedDelivery = strtotime($order['created_at'] . ' +5 days');
        break;

    case 'processing':
        $estimatedDelivery = strtotime($order['created_at'] . ' +4 days');
        break;

    case 'shipped':
        if (!empty($order['shipped_at'])) {
            $estimatedDelivery = strtotime($order['shipped_at'] . ' +2 days');
        }
        break;

    case 'delivered':
    case 'returned':
        if (!empty($order['delivered_at'])) {
            $estimatedDelivery = strtotime($order['delivered_at']);
        }
        break;
}

$today = strtotime(date("Y-m-d"));
$deliveryMessage = null;

if ($estimatedDelivery) {

    $diffDays = floor(($estimatedDelivery - $today) / (60 * 60 * 24));

    if ($currentStatus === 'delivered' || $currentStatus === 'returned') {
        $pastDays = floor(($today - $estimatedDelivery) / (60 * 60 * 24));

        if ($pastDays === 0) {
            $deliveryMessage = "Delivered today";
        } elseif ($pastDays === 1) {
            $deliveryMessage = "Delivered yesterday";
        } elseif ($pastDays > 1) {
            $deliveryMessage = "Delivered {$pastDays} days ago";
        }

    } else {
        if ($diffDays > 1) {
            $deliveryMessage = "Arriving in {$diffDays} days";
        } elseif ($diffDays === 1) {
            $deliveryMessage = "Arriving tomorrow";
        } elseif ($diffDays === 0) {
            $deliveryMessage = "Out for delivery";
        } else {
            $deliveryMessage = "Delayed";
        }
    }
}
?>

    <!-- ORDER HEADER -->
    <div class="order-header">
        <h1>Order #<?= $order['order_id'] ?></h1>
        <span class="order-status <?= $currentStatus ?>">
            <?= ucfirst(htmlspecialchars($currentStatus)) ?>
        </span>
    </div>

    <p><strong>Date:</strong> <?= date("d M Y", strtotime($order['created_at'])) ?></p>

    <!-- ORDER TRACKER -->
    <div class="order-tracker">

        <div class="tracker-step <?= $currentStep >= 1 ? 'active' : '' ?>">
            <div class="circle">1</div>
            <span>Order Placed</span>
        </div>

        <div class="tracker-line <?= $currentStep >= 2 ? 'active' : '' ?>"></div>

        <div class="tracker-step <?= $currentStep >= 2 ? 'active' : '' ?>">
            <div class="circle">2</div>
            <span>Processing</span>
        </div>

        <div class="tracker-line <?= $currentStep >= 3 ? 'active' : '' ?>"></div>

        <div class="tracker-step <?= $currentStep >= 3 ? 'active' : '' ?>">
            <div class="circle">3</div>
            <span>Shipped</span>
        </div>

        <div class="tracker-line <?= $currentStep >= 4 ? 'active' : '' ?>"></div>

        <div class="tracker-step <?= $currentStep >= 4 ? 'active' : '' ?>">
            <div class="circle">4</div>
            <span>Delivered</span>
        </div>

    </div>

    <?php if ($isReturned): ?>
        <div class="order-returned-notice">
            This order has been returned.
        </div>
    <?php endif; ?>

    <h2>Items</h2>

<?php
$returnDeadline = strtotime($order['created_at'] . ' +7 days');
$canReturnOrder =
    $currentStatus === 'delivered'
    && time() <= $returnDeadline;
?>

<?php foreach ($items as $item): ?>

<div class="item-card">

    <img src="<?= BASE_URL ?>assets/images/<?= htmlspecialchars($item['image']) ?>" alt="">

    <div>
        <h3><?= htmlspecialchars($item['name']) ?></h3>

        <p>Purchased: <?= $item['quantity'] ?></p>

        <?php if ($item['returned_qty'] > 0): ?>
            <p style="color:#ffb86c;">
                Returned: <?= $item['returned_qty'] ?>
            </p>
        <?php endif; ?>

        <p>
            Price: £<?= number_format($item['price_at_purchase'], 2) ?>
        </p>

        <p>
            <strong>Line Total:</strong>
            £<?= number_format($item['price_at_purchase'] * $item['quantity'], 2) ?>
        </p>

    <?php if ($estimatedDelivery): ?>
    <div class="estimated-delivery">

        <strong>
            <?= ($currentStatus === 'delivered' || $currentStatus === 'returned')
                ? "Delivered on:"
                : "Estimated delivery:" ?>
        </strong>

        <?= date("l, d M Y", $estimatedDelivery) ?>

        <?php if ($deliveryMessage): ?>
            <div class="delivery-highlight">
                <?= $deliveryMessage ?>
            </div>
        <?php endif; ?>

    </div>
<?php endif; ?>

        <!-- RETURN STATUS / ACTION -->
        <div style="margin-top:10px;">

        <?php
         $returnStatus = $item['return_status'] ?? null;
         $remaining = $item['quantity'] - $item['returned_qty'];

         $isDelivered = $currentStatus === 'delivered';
         $withinWindow = time() <= $returnDeadline;
        ?>

       <?php if ($returnStatus === 'pending'): ?>
          <span class="badge badge-pending">Return pending</span>

        <?php elseif ($remaining <= 0): ?>
          <span class="badge badge-approved">Returned</span>

        <?php elseif (!$isDelivered): ?>
         <span class="badge badge-info">Return available after delivery</span>

        <?php elseif ($isDelivered && $withinWindow): ?>
          <a class="btn-purple"
             href="<?= BASE_URL ?>index.php?page=request-return&item=<?= $item['order_item_id'] ?>">
             Request return
          </a>

        <?php else: ?>
          <span class="badge badge-expired">Return window expired</span>
         <?php endif; ?>

        </div>
    </div>

</div>

<?php endforeach; ?>

<!-- SUMMARY -->
    <div class="summary-box">
        <h2>Order Summary</h2>

        <p><strong>Total:</strong> £<?= number_format($order['total_price'], 2) ?></p>

        <p><strong>Delivery Address:</strong><br>
            <?= nl2br(htmlspecialchars($order['shipping_address'])) ?>
        </p>

        <p><strong>Payment:</strong>
            <?= htmlspecialchars($order['payment_summary']) ?>
        </p>
    </div>

    <a href="<?= BASE_URL ?>index.php?page=orders" class="btn-secondary">
        ← Back to Orders
    </a>

</div>

<?php include __DIR__ . '/../footer.php'; ?>