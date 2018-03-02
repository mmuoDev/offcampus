<?php
require_once "db/db_handle.php";
//$location= urlencode($_SERVER['REQUEST_URI']);
if(isset($_GET['id']) && isset($_GET['action'])){
  if(isset($_GET['action'])  == "show"){
    $query = "UPDATE offers SET status = 'show' WHERE id = :id";
    $db->query($query, array('id' => $_GET['id']));
    header("location: properties.php");
  }
}else{
  header("location: properties.php");
}
?>
