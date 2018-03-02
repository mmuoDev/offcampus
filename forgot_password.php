<?php
ob_start();
//session_start();
if (isset($_SESSION['id'])==true){
 header("location: index.php");
}
require_once 'includes/layout.php';
require_once 'db/db_handle.php';
$action = isset($_GET['action'])?$_GET['action']: "";
$error = $empty = $all_fields = $error1 = $error2 = $error3 = $success = $fail = null;
$email = isset($_POST['email'])?$_POST['email']:"";

if(isset($_POST['submit'])){

  //Get user details from db
  $sql =  "SELECT COUNT(*) AS num, id FROM users WHERE  email =:email";
  $db->query($sql, array('email' => $_POST['email']));
  $info = $db->fetch();


  if(empty($email)){
    $all_fields = "Email field is required";
  }else if ($info['num'] != 1){
    $error3 = "Email does not exist";
  }else if ($info['num'] == 1){
    $get_id = $info['id'];
    $encrypt = md5(1290*3+$get_id);
    $update = "UPDATE users SET security_code = :security_code";
    $db->query($update, array('security_code' => $encrypt));
    //$actual_link = "http://www.offcampus.com.ng/forgot_password.php?id=" . $get_id;
    $toEmail = $_POST['email'];
    $subject = "Recover your account details";
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // More headers
    $headers .= 'From: <no_reply@offcampus.com.ng>' . "\r\n";
    $content="
                <html>
                <head>

                </head>
                <body>
                <img src='http://www.offcampus.com.ng/img/logo.jpg' width='120' height='60' class='img img-responsive'>
                
                <p>Hi, <br>You recently requested for a change of password. <a href='http://www.offcampus.com.ng/change_password.php?token=$encrypt&id=$get_id'>Click here to change your password</a><br>
                  Ignore this mail if you never requested for a change of password.
                </p>
                The Support Team
                
                </body>
                </html>
        ";
    if(mail($toEmail, $subject, $content, $headers)) {
      $success = "Check your email to alter password";
    }
  }
  else{
      header("location: forgot_password.php?action=fail");
  }
}

if ($action == "fail"){
  $fail = "Temporarily unable to process request, try again";
}
?>
<title>Forgot Password</title>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="">
                
                <div class="">
                    <span class="help-block text-center custom_error"> <?php echo $all_fields; ?> </span>
                    <span class="help-block text-center custom_error"> <?php echo $success; ?> </span>
                    <span class="help-block text-center custom_error"> <?php echo $fail; ?> </span>

                    <form class="form-horizontal form" role="form" method="POST" action="">
                        <div class="form-group">
                            
                            <div class="col-md-12">
                                <input type="email" class="" placeholder="Your Email Address" name="email" value="<?php echo htmlspecialchars($email); ?>">
                                <span class="help-block custom_error"> <?php echo $error3; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="submit" name="submit" value="Submit" class="btn btn-success">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
