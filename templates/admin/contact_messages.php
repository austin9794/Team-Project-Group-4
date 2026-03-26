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
        <td colspan="6" style="text-align:center;">No messages yet</td>
    </tr>
<?php endif; ?>

<?php foreach ($messages as $msg): ?>
    <tr onclick="window.location='<?= BASE_URL ?>index.php?page=admin-message-view&id=<?= $msg['id'] ?>'"
        style="cursor:pointer;">

        <td><?= htmlspecialchars($msg['name']) ?></td>
        <td><?= htmlspecialchars($msg['email']) ?></td>
        <td><?= htmlspecialchars($msg['subject']) ?></td>

        <td style="max-width:300px;">
            <?= substr(htmlspecialchars($msg['message']), 0, 80) ?>...
        </td>

        <td><?= date('d M Y, H:i', strtotime($msg['created_at'])) ?></td>

        <td>
            <?php if ($msg['status'] === 'unread'): ?>
                <span class="badge">Unread</span>
            <?php else: ?>
                <span style="color:#4caf50;">Read</span>
            <?php endif; ?>
        </td>

    </tr>
<?php endforeach; ?>

</tbody>

            <td>
           <?php if ($msg['status'] === 'unread'): ?>
              <a href="<?= BASE_URL ?>index.php?page=admin-message-view&id=<?= $msg['id'] ?>"
                  class="btn-small">
                   Mark as Read
              </a>
           <?php else: ?>
               <span style="color: #4caf50;">Read</span>
           <?php endif; ?>
       </td>

        </table>

    </div>

</div>

<?php include __DIR__ . '/../footer.php'; ?>