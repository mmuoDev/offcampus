<?php
session_start();
session_unset($_SESSION['admin_id']);
header("Location: admin_login.php");
?>