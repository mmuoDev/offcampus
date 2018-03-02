<?php
session_start();
$admin_id = isset($_SESSION['admin_id'])?$_SESSION['admin_id']:"";
require_once "menu.php";
?>
        
        <nav class="navbar navbar-default navbar-static-top">
             
          <div class="container">
              <!--
              <p class="text-center" style='font-family: cursive; font-size: 15px; padding-top: 5px; '>We are building a community of farmers and investors in the Nigerian agricultural sector.  
              </BR>
              
              <span style='font-family: sans-serif;'>
                   <a class="" href="tel:+2348063321043">
                       <span class="text-primary"><strong> <i class='fa fa-phone'></i> +234 80 6332 1043</strong></span>
                  </a> 
              </span>
              </p>
             -->
            <div class="navbar-header">
              <button class="navbar-toggle" data-toggle="collapse" data-target="#collapse_menu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
                <a href="index.php" class="navbar-brand" style=""><strong><span class="" style="color: #2bc02f;">Offcampus</span><small style = "font-size:16px;">.com.ng</small></strong></a>
                
            </div>
            <div class="collapse navbar-collapse" id="collapse_menu">
              <ul class="nav navbar-nav">

              </ul>
              <ul class="nav navbar-nav navbar-right">
                <?php
                  echo "
                  <li><a href='dash.php' class='index_login'>Dash</a></li>
                  ";
                  if (isset($_SESSION['admin_id'])== false){
                    echo "<li><a href='admin_login.php' class='index_login'><i class='fa fa-sign-in'></i> Login</a></li>";
                  }else{
                    echo "<li><a href='admin_logout.php' class='index_login'>Logout</a></li>";
                  }
                ?>
              </ul>
            </div>
          </div>
        </nav>


