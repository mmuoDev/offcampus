<?php
$location= urlencode($_SERVER['REQUEST_URI']);
if ($_SESSION['admin_id'] != "admin"){
  header("Location: admin_login.php?location=$location");  
}


?>