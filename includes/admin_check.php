<?php
if(isset($_SESSION['admin_id']) == false){
    header("location: admin_login.php");
}
