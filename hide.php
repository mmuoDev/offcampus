<?php
require_once "db/db_handle.php";
//$location= urlencode($_SERVER['REQUEST_URI']);
if(isset($_GET['id']) && isset($_GET['action'])){
  if (isset($_GET['action'])  == "hide"){
    $sql = "UPDATE offers SET status = 'hide' WHERE id = :id";
    $db->query($sql, array('id' => $_GET['id']));
    header("location: properties.php");
  }
}else{
  header("location: properties.php");
}
?>
