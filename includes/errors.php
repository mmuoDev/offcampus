<?php
$action = isset($_GET['action'])?$_GET['action']: "";
$name = isset($_POST['name'])?$_POST['name'] : "";
$school = isset($_POST['school'])?$_POST['school'] : "";
$email = isset($_POST['email'])?$_POST['email'] : "";
$phone_number = isset($_POST['phone_number'])?$_POST['phone_number'] : "";
$password = isset($_POST['password'])?$_POST['password'] : "";
$security_code = isset($_POST['security_code'])?$_POST['security_code']:"";
$category = isset($_POST['category'])?$_POST['category']:"";
$fields = [$name, $email, $phone_number, $password, $category, $school];
$empty = $all_fields = $error1 = $error2 = $error3 = $error4 = $error5 = $output = $error6 = $error7 = $fail = null;



 ?>
