<?php include __DIR__ . '/../header.php'; ?>

<style>
.success-container{
max-width:700px;
margin:60px auto;
background:#140a26;
padding:40px;
border-radius:14px;
text-align:center;
box-shadow:0 0 20px rgba(132,0,255,0.25);
color:white;
}

.success-icon{
font-size:50px;
color:#6bff8f;
margin-bottom:15px;
}

.success-container h2{
color:#c9a7ff;
margin-bottom:10px;
}

.success-container p{
color:#bbb;
margin-bottom:25px;
}

.btn-purple{
display:inline-block;
padding:12px 20px;
background:#8f3dff;
border-radius:8px;
color:white;
text-decoration:none;
font-weight:bold;
transition:0.2s;
}

.btn-purple:hover{
background:#b46cff;
}
</style>

<div class="success-container">

<div class="success-icon">✓</div>

<h2>Return Request Submitted</h2>

<p>
Your return request has been sent to our team.
We will review it and notify you once it has been approved.
</p>

<a class="btn-purple" href="<?= BASE_URL ?>index.php?page=orders">
View Your Orders
</a>

</div>

<?php include __DIR__ . '/../footer.php'; ?>