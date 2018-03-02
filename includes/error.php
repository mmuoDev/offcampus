<?php
$action = isset($_GET['action'])?$_GET['action']: "";
$name = isset($_POST['name'])?$_POST['name'] : "";
$email = isset($_POST['email'])?$_POST['email'] : "";
$category = isset($_POST['category'])?$_POST['category'] : "";
$password = isset($_POST['password'])?$_POST['password'] : "";
$fields = [$name, $email, $password, $category];
$empty = $all_fields = $error1 = $error2 = $error3 = $error4 = $error5 = $output = $error6 = $error7 = $fail = null;




