<?php include __DIR__ . '/../header.php'; ?>

<style>
/* Container */
.auth-box {
    width: 420px;
    margin: 70px auto;
    padding: 30px;
    border-radius: 14px;
    background: #1a0b2e;
    box-shadow: 0 0 25px rgba(132, 0, 255, 0.3);
    color: #eee;
    font-family: Arial, sans-serif;
}

/* Title */
.auth-box h2 {
    text-align: left;
    margin-bottom: 25px;
    font-size: 22px;
    color: #d9a7ff;
    font-weight: bold;
}

/* Inputs */
.auth-box input {
    width: 100%;
    padding: 14px;
    margin: 10px 0 18px;
    border-radius: 8px;
    border: 1px solid #5b2b8f;
    background: #2a0f47;
    color: white;
    font-size: 15px;
}

.auth-box input::placeholder {
    color: #c09dfc;
}

/* Button */
.auth-box button {
    width: 100%;
    padding: 12px;
    background: #8f3dff;
    border: none;
    border-radius: 20px;
    color: white;
    font-size: 16px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.auth-box button:hover {
    background: #b46cff;
}

/* Error + Success */
.error {
    background: rgba(255, 0, 0, 0.15);
    padding: 10px;
    border-left: 4px solid #ff5555;
    color: #ff7777;
    margin-bottom: 15px;
}

.success {
    background: rgba(50, 255, 120, 0.15);
    padding: 10px;
    border-left: 4px solid #24ff75;
    color: #6bff8f;
    margin-bottom: 15px;
}

/* Links */
.auth-box a {
    display: block;
    margin-top: 15px;
    color: #c9a7ff;
    text-decoration: none;
    text-align: left;
}

.auth-box a:hover {
    color: white;
}
</style>
