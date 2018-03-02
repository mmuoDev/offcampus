<?php
ob_start();
require_once 'includes/layout.php';
require_once 'includes/errors.php';
require_once 'db/db_handle.php';

$id = isset($_GET['id'])?$_GET['id'] : "";
$token = isset($_GET['token'])?$_GET['token']:"";

$select = "SELECT COUNT(*) AS num FROM users WHERE security_code = :token AND id = :id";
$db->query($select, array('token' => $token, 'id' => $id));
$info = $db->fetch();

$sql = "SELECT * FROM users WHERE id = :id";
$record = $db-> query($sql, array('id' => $id));
while($get_record = $record-> fetch()){
  $status = $get_record['status'];
}



if(isset($token) && isset($id)){
  if ($info['num'] != 1){
    echo"<div class='alert alert-danger col-md-6 col-md-offset-3'>
        <a href='#' class='close' data-dismiss='alert'>&times;</a>
        <strong>Ooops!</strong> Temporarily unable to activate account. Try again.                       
    </div>";
  }
  else if ($info['num'] == 1 && $status == 'inactive'){
    $query = "UPDATE users set status = 'active' WHERE id= :id";
    $result = $db->query($query, array('id' => $id));
    echo"<div class='alert alert-success col-md-6 col-md-offset-3'>
        <a href='#' class='close' data-dismiss='alert'>&times;</a>
        <strong>Hey!</strong>Your account is now activated. You can now login                      
    </div>";
  }else if($info['num'] == 1 && $status == 'active') { 
    echo"<div class='alert alert-danger col-md-6 col-md-offset-3'>
        <a href='#' class='close' data-dismiss='alert'>&times;</a>
        <strong>Ooops!</strong> Your account is already activated                      
    </div>";  
  }
  else {
    echo"<div class='alert alert-danger col-md-6 col-md-offset-3'>
        <a href='#' class='close' data-dismiss='alert'>&times;</a>
        <strong>Ooops!</strong> Temporarily unable to activate account. Try again.                       
    </div>";
  }
}else{
  echo"<div class='alert alert-danger col-md-6 col-md-offset-3'>
        <a href='#' class='close' data-dismiss='alert'>&times;</a>
        <strong>Ooops!</strong> Temporarily unable to activate account. Try again.                       
    </div>";
}

?>
<title>Activate account</title>
<div class="container">
    <div class="row">
<?php

?>
    </div>
</div>
