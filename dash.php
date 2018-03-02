<?php
ob_start();
require_once "includes/header.php";
$location= urlencode($_SERVER['REQUEST_URI']);
if (isset($_SESSION['admin_id']) == false){
  header ("Location: admin_login.php?location=$location");
}
//require_once "include/admin_check.php";
//require_once "include/manager_check.php";
require_once "db/db_handle.php";
//Check the number of farms created

?>
<title>Dashboard</title>
<div class="container">
    <div class="row"> 
        
        <div class="col-md-12 col-md-offset-2 ">
            
            <div class="custom_error">               
                    <div class="">
                        <div class="row">                           
                            <div class="col-sm-3">
                                <div class="">
                                    <div class="text-center icon_size">
                                        <i class="fa fa-user-plus home_icon"></i>
                                    </div>
                                    <div class="caption">
                                        <p class="text-center home_text">
                                            <a href="roommie.php" class="custom_icons">Roommates</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="">
                                    <div class="text-center icon_size">
                                        <i class="fa fa-home home_icon"></i>
                                    </div>
                                    <div class="caption">
                                        <p class="text-center home_text">
                                            <a href="agents.php" style="" class="custom_icons">Agents</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="">
                                    <div class="text-center icon_size">
                                        <i class="fa fa-book home_icon"></i>
                                    </div>
                                    <div class="caption">
                                        <p class="text-center home_text">
                                            <a href="all_blog.php" style="" class="custom_icons">Blog</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
            </div>
        </div>
    </div>
</div>
