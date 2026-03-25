<?php
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'doctor') {
    header("Location: ../admin/login.php");
    exit;
}
?>
