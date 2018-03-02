<?php
ob_start();
require_once "includes/layout2.php";
$location= urlencode($_SERVER['REQUEST_URI']);
if (isset($_SESSION['id']) == false){
  header ("Location: login.php?location=$location");
}
//require_once "include/admin_check.php";
//require_once "include/manager_check.php";
require_once "db/db_handle.php";
//Check the number of farms created

?>
<title>Dashboard</title>
<div class="container">
    <div class="row"> 
        
        <div class="col-md-12 col-md-offset-0 ">
            
            <div class="custom_error">               
                    <div class="">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="">
                                    <div class="text-center icon_size">
                                        <i class="fa fa-user home_icon"></i>
                                    </div>
                                    <div class="caption">
                                        <p class="text-center home_text">
                                            <a href="profile.php" class="custom_icons">Edit Profile</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            
                           
                            <div class="col-sm-3">
                                <div class="">
                                    <div class="text-center icon_size">
                                        <i class="fa fa-user-plus home_icon"></i>
                                    </div>
                                    <div class="caption">
                                        <p class="text-center home_text">
                                            <a href="roommate.php" class="custom_icons">Find roommates</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="">
                                    <div class="text-center icon_size">
                                        <i class="fa fa-share-alt home_icon"></i>
                                    </div>
                                    <div class="caption">
                                        <p class="text-center home_text">
                                            <a href="share_links.php" style="" class="custom_icons">Share links</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="">
                                    <div class="text-center icon_size">
                                        <i class="fa fa-star home_icon"></i>
                                    </div>
                                    <div class="caption">
                                        <p class="text-center home_text">
                                            <a href="myfav.php" class="custom_icons">My Favs</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php if ($_SESSION['category'] == 'agent'){
                            echo"
                            <div class='col-sm-3'>
                                <div class=''>
                                    <div class='text-center icon_size'>
                                        <i class='fa fa-home home_icon'></i>
                                    </div>
                                    <div class='caption'>
                                        <p class='text-center home_text'>
                                            <a href='post_property.php' style='' class='custom_icons'>Post a Property</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            ";
                            } ?>
                            <?php if ($_SESSION['category'] == 'agent'){
                            echo"
                            <div class='col-sm-3'>
                                <div class=''>
                                    <div class='text-center icon_size'>
                                        <i class='fa fa-pencil-square-o home_icon'></i>
                                    </div>
                                    <div class='caption'>
                                        <p class='text-center home_text'>
                                            <a href='properties.php' style='' class='custom_icons'>My properties</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            ";
                            } ?>
                            

                            
                        </div>
                    </div>   
            </div>
        </div>
    </div>
</div>
