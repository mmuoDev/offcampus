<?php
require_once "db/db_handle.php";


?>
<!DOCTYPE Html>
<html lang = "en-us">
  <head>
    <title>Students' login </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="C:/xampp/htdocs/off-campus/css/login.css"/>
    <style> 
      input[type=email], input[type=password] {
        width: 100%;
        padding: 10px 20px;
        border: 1px solid #ccc;
        margin: 5px 0 20px 0;
        display: inline-block;
        box-sizing: border-box;
      }
/*
    input[type=email]:focus,input[type=password]:focus {
      border: 1px solid #44aa44;
      box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px rgba(126, 239, 104, 0.6);
    }
*/
    
    input[type=email]:hover,input[type=password]:hover {
        border: 1px solid #44aa44;
      }
      label {
        text-transform: uppercase;
        font: 14px lato;
      }
      span.close {
        position: absolute;
        cursor: pointer;
        color: purple;
        right: -12px;
        top: -30px;
        font-size: 25px;
        font-weight: 500;
      }
      span.close:hover {
        background-color: red;
        color: white;
        padding: 0 2px;
        border-radius: 1px;
      }
      .close-wrap {
        text-align: center;
        position: relative;
/*        border: 1px solid black;*/
      }
      .modal-pop {
        margin: 0% auto 12% auto;
        padding: 10px 20px;
        width: 60%;
        background-color: #fefefe;
      }
      .modal-01 {
        display: none;  /*Hidden by default*/ 
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(105, 105, 105, 0.19); /* Black w/ opacity */
        padding-top: 60px;
      }
      button.btn-show {
        float:right;
        position: relative;
        font-size: 16px;
        font-weight: 200;
        color:aliceblue;
        top: -52px;
        right: 10px;
        background-color: rgba(132, 139, 160, 0.16);
        border: none;
        border-radius: 4px;
        padding: 5px 14px;
      }
      button.btn-login {
        width: 100%;
        padding: 7px 0;
        background-color: #5cb85c
          ;
        border: none;
        color:white;
        font-size: 18px;
        text-transform: uppercase;
        border-radius: 4px;
      }
      .container p a {
        text-decoration: none;
        color:#4343d6;
      }
      div.separator {
        position: relative;
      }
      span.separator-text {
        background-color: white;
        position: absolute;
        top:-8px;
        right: 48%;
        padding: 0 8px;
        font-size: 14px;
        box-sizing: border-box;
      }
      @media screen and (max-width: 768px) and (min-width: 667px) {
        span.separator-text {
          right: 47%;
        }
      }
      div.alternate-login {
        margin: auto;
/*        border: 1px solid #3b0909;*/
      }
      .social-bottons {
        display: flex;
        justify-content: center;
      } 
      div.alternate-login button {
        border: none;
        width: 205px;
        padding: 14px 20px;
        display:inline-block;
        margin-top: 10px;
        color:white;
        text-transform: uppercase;
      }
        /*  Start media queries */
      
      @media screen and (max-width: 520px) and (min-width: 320px) {
        div.alternate-login button {
          width: 120px;
          padding: 10px 0px;
        }
        button.btn-show {
          font-size: 14px;
          padding: 5px 8px;
        }
        span.separator-text {
          right: 43%;
        }
      }
      
      @media screen and (max-width: 667px) and (min-width: 520px) {
        div.alternate-login button {
          width: 160px;
          padding: 10px 0px;
        }
        div.alternate-login button:before {
          content: "Login via ";
          color: :white;
        }
        button.btn-show {
          font-size: 14px;
          padding: 5px 10px;
          
        }
        span.separator-text {
          right: 43%;
        }
      }
      @media screen and (max-width: 768px) and (min-width: 667px), (min-width: 768px) {
        div.alternate-login button {
          width: 180px;
          padding: 10px 0px;
        }
        div.alternate-login button:before {
          content: "Login via ";
          color: white;
        }
      }
      div.social-bottons button.facebook  {
        background-color: #4060A5;
      }
      div.social-bottons button.gmail  {
        background-color: #aa2e2e;
        margin-left: 10px;
      }
      
      /*      modal animation */
    .animate {
    -webkit-animation: animatepopin 0.6s;
    animation: animatepopin 0.6s;
      }
        @-webkit-keyframes animatepopin {
        from {-webkit-transform: scale(0)}
        to {-webkit-transform: scale(1)}
      }
    
    @keyframes animatepopin {
      from {transform: scale(0)}
      to {transform: scale(1)}
      }
      div.signup {
        margin-top: 18px;
        text-align: center;
        letter-spacing: 1px;
      }
      div.signup span {
        padding-left: 5px;
/*        margin:10px auto;*/
      }
      @media screen and (max-width: 375px) and (min-width: 320px) {
        div.signup span {
          display: block;
        }
        div.alternate-login button {
          width: 100px;
          padding: 10px 0px;
      } 
    </style>
  </head>
  <body>
    <div>
    
    </div>
    <section>
      <div class="modal-01 container-wrap" id="md01">
          <form class="modal-pop animate" role="form">
            <div class= "close-wrap">
              <span onclick="document.getElementById('md01').style.display='none'" class="close" title="Close">&times;</span>
              <h1>Login to Offcampus</h1>
            </div>
            <div class="container">
              <label>Email address</label>
              <input type="email" placeholder="Enter Email address" required>

              <label>password</label>
              <input type="password" placeholder="Enter your Password" required>
              <span><button class="btn-show btn-sm">SHOW</button></span>

              <input type="checkbox" checked="checked"> Remember Me
              <button class="btn-login btn-lg">login</button>
              <p><a href="#">Forgot password?</a></p>
            </div>
            <div class="alternate-login">
              <div class="separator">
                <hr>
                <span class="separator-text">OR</span>
              </div>
              <div class="social-bottons">
                <a href="#"><button class="facebook"><i class="fa fa-facebok"></i>facebook</button></a>
                <a href="#"><button class="gmail"><i class="fa fa-gmail"></i>Google</button></a>
              </div>
            </div>
            <div class="signup">
              <P>Don't have an account?<span><a href="#">Sign up</a></span></P>
            </div>
        </form>
      </div>
    </section>
    <script>
// Get the modal
var modal = document.getElementById('md01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
  </body>
</html>
<div class="row">
            <div class="col-sm-12" style="margin-top: -50px;">
                <div class="features_items"><!--features_items-->
                    <!--<h2 class="title text-left" style="color: #5e5e5e">How it works</h2> -->
                    <div class="col-sm-4">
                        <div class="thumbnail thumb_col">
                            <div class="text-center icon_size">
                                <i class="fa fa-binoculars fa-lg home_icon"></i>
                            </div>
                            <div class="caption">
                                <p class="text-center home_text">
                                      Browse farms
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="thumbnail thumb_col">
                            <div class="text-center icon_size">
                                <i class="fa fa-users fa-lg home_icon"></i>
                            </div>
                            <div class="caption">
                                <p class="text-center home_text">
                                Assemble a team
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="thumbnail thumb_col">
                            <div class="text-center icon_size">
                                <i class="fa fa-thumbs-up home_icon"></i>
                            </div>
                            <div class="caption">
                                <p class="text-center home_text">
                                Start farming
                                </p>
                            </div>
                        </div>
                    </div>
                </div><!--features_items-->
            </div> <!-- Columns end -->
        </div> <!-- rows end -->
        $query = "SELECT COUNT(*) AS num FROM team_members WHERE member_id = :id";
$result = $db->query($query, ['id' => $_SESSION['id']])->fetch();
         <?php 
                  if($result['num'] == 0){
                      echo "No teams yet";
                  }else{
                      //List user's team
                      $teams = "SELECT a.*, b.*  FROM teams a JOIN team_members b ON a.id = b.team_id WHERE member_id = :id";
                      foreach($db->query($teams, ['id' => $_SESSION['id']]) AS $res){
                          $new_word = ucwords($res['team_name']); 
                          echo "<a href='team_info.php?id={$res['id']}' class='home_text'>$new_word</a></br>";
                      }
                  }
                  
                  ?>