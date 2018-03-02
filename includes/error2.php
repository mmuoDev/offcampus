<?php
$price = isset($_POST['price'])?$_POST['price']:"";
$newPrice = str_replace(",", "", $price);
$session_id = isset($_SESSION['id'])?$_SESSION['id']:"";
$accommodation =  isset($_POST['accommodation'])?$_POST['accommodation']:"";
$school = isset($_POST['school'])?$_POST['school']:"";
$description = isset($_POST['description'])?$_POST['description']:"";
$exact_location = isset($_POST['location'])?$_POST['location']:"";
$fields = [$price, $accommodation, $school, $description, $exact_location];
$all_fields = $empty = $error1 = $error2 = $error3 = $error4 = $output = $fail = null;
$action = isset($_GET['action'])?$_GET['action']: "";

 ?>
