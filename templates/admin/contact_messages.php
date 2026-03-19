<?php
define('ACCESS_ALLOWED', true);
include __DIR__ . '/../header.php';
?>

<div class="dashboard-container">

    <div class="dashboard-header">
        <h1>📨 Contact Messages</h1>
        <p>Messages submitted by users</p>
    </div>

    <div class="table-container">

        <table class="admin-table">

            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>

            <?php if (empty($messages)): ?>
                <tr>
                    <td colspan="5" style="text-align:center;">No messages yet</td>
                </tr>
            <?php endif; ?>

            <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><?= htmlspecialchars($msg['name']) ?></td>
                    <td><?= htmlspecialchars($msg['email']) ?></td>
                    <td><?= htmlspecialchars($msg['subject']) ?></td>
                    <td style="max-width:300px;">
                        <?= nl2br(htmlspecialchars($msg['message'])) ?>
                    </td>
                    <td><?= date('d M Y, H:i', strtotime($msg['created_at'])) ?></td>
                </tr>
            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>