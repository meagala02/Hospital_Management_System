<?php
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'patient') {
    header("Location: ../admin/login.php");
    exit;
}
?>
