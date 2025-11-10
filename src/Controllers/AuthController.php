<?php
function logoutUser() {
    // Temporary placeholder — to be replaced by Ayaan’s logic later
    session_unset();
    session_destroy();
    header("Location: index.php?page=login");
    exit;
}
?>
