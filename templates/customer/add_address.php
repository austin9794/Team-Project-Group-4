<?php include __DIR__ . '/../header.php'; ?>

<div class="account-container" style="max-width:700px;margin:40px auto;">

    <div class="section-card">
        <h2>Add New Address</h2>

        <form method="POST" action="/Team-Project-Group-4/public/index.php?page=save-address">

            <label>Label (Home, Work, Uni...)</label>
            <input type="text" name="label" required>

            <label>Full Address</label>
            <textarea name="full_address" rows="4" required style="resize:none;"></textarea>

            <button class="btn-purple" type="submit">Save Address</button>
        </form>

        <br>
        <a class="btn-purple" href="/Team-Project-Group-4/public/index.php?page=account#addresses">Back</a>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>
