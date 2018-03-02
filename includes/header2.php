<?php
session_start();
require_once "header.html";
$id = isset($_SESSION['admin_id'])?$_SESSION['admin_id']:"";
?>
<!DOCTYPE html>
<html lang="en">
    
<!DOCTYPE Html>
<html lang = "en-us">
<head>

  <!--
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <link type="text/css" rel="stylesheet" href="css/index.css"/>
-->
  <nav class="navbar navbar-default">
   <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mynavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Offcampus.com.ng
          <sup><span class="badge">beta</span></sup>
        </a>
        <!--
        <a class="navbar-text size" href="tel:+2348999-456-19">
          <span class="glyphicon glyphicon-phone"></span>
          <span class="hidden-xs">+234(9)99-456-19</span>
        </a>
      -->
      </div>
        <div class="collapse navbar-collapse" id="mynavbar">
          <ul class="nav navbar-nav navbar-right size">

            <li><a href='admins.php' class=''>Admins</a></li>
            <li><a href='agents.php' class=''>Agents</a></li>
            <?php
              if ($id== false){
                echo "<li><a href='login.php' class=''>Login</a></li>";
              }else{
                echo "<li><a href='logout.php' class=''>Logout</a></li>";
              }
            ?>
            <!--
            <li>
              <form action="">
                 <a class="btn btn-primary btn-sm navbar-btn" href="signup_agent.php"><strong>Offcampus Market</strong></a>
              </form>
            </li>
          -->
          </ul>
        </div>
     </div>
  </nav>
  </head>
<body>

</body>
</html>
