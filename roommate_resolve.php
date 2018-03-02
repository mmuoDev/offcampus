<?php
ob_start();
//session_start();
require_once "includes/header.php";
require_once "includes/admin_check.php";
//require_once "includes/manager_check.php";
require_once "db/db_handle.php";

$id = isset($_GET['id'])?$_GET['id']:"";
$school = isset($_GET['school'])?$_GET['school']:"";
$sql = "UPDATE roommate_request SET status = 'resolved' WHERE id = :id";
$db->query($sql, ['id' => $id]);
header("location: admin_roommates.php?school=$school");