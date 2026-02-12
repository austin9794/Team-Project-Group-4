<?php include __DIR__ . '/../header.php'; ?>

<style>
.payment-container {
    max-width: 600px;
    margin: 40px auto;
    background: #1a0b2e;
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 0 25px rgba(132, 0, 255, 0.3);
}

.payment-container h2 {
    color: #d9a7ff;
    margin-bottom: 25px;
}

.form-group {
    margin-bottom: 18px;
}

.form-group label {
    display: block;
    margin-bottom: 6px;
    color: #c9a7ff;
    font-weight: 600;
}

.form-group input {
    width: 100%;
    padding: 12px;
    background: #2a0f47;
    border: 1px solid #5d3b8a;
    border-radius: 8px;
    color: white;
}

.inline-row {
    display: flex;
    gap: 12px;
}

.btn-purple {
    background: #8f3dff;
    padding: 12px 20px;
    border-radius: 8px;
    color: white;
    border: none;
    font-weight: bold;
    cursor: pointer;
    transition: 0.2s;
}

.btn-purple:hover {
    background: #b46cff;
}

.cancel-link {
    margin-left: 15px;
    color: #c9a7ff;
    text-decoration: none;
}
</style>
