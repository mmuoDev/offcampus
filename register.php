<?php
ob_start();
require_once 'includes/layout.php';
require_once 'includes/errors.php';
require_once 'db/db_handle.php';
if (isset($_SESSION['id']) != false){
 header("location: index.php");
}
//Get the email count
$sql1 = "SELECT COUNT(*) AS num FROM users WHERE email = :email";
$db->query($sql1, array ('email' => $email));
$info = $db->fetch();
//Get the phone_number count
$sql2 = "SELECT COUNT(*) AS num FROM users WHERE phone_number = :phone_number";
$db->query($sql2, array ('phone_number' => $phone_number));
$info2 = $db->fetch();

if(isset($_POST['register'])){
  
  //$security_code = hash('sha256', $_POST['security_code'] . "Some nonsense here just to be naughty");
  $password = hash('sha256', $_POST['password'] . "Some nonsense here just to be naughty");
  $password_confirmation = hash('sha256', $_POST['password_confirmation'] . "Some nonsense here just to be naughty");
  $inactive = 'inactive';
  $param = [
    'name' =>$_POST['name'],
    'email' => $_POST['email'],
    'phone_number' => $_POST['phone_number'],
    'password' => $password,
    'inactive' => $inactive,
    'category' => $category,
    'school' => $_POST['school']
  ];
  foreach ($fields as $field){
    if(empty($field)){
      $empty = true;
    }
  }if($empty){
    $all_fields = "Error! All fields are required";
  }elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
    $error1 = "Please enter a valid name";
  }else if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email)){
    $error2 = "Please enter a valid email address";
  }else if ($info['num'] == 1){
    $error3 = "Email is already taken";
  }else if (!preg_match("/^[0-9]{11}$/",$phone_number)){
    $error4 = "Enter a valid phone number";
  }else if ($info2['num'] == 1){
    $error6 = "Phone number is already taken";
  }else if ($password != $password_confirmation){
    $error5 = "Both passwords must match!";
  }else{
    //unset($_POST['name'], $_POST['email'], $_POST['phone_number']);
    //insert into db and  send activation email.
    $insert = "INSERT INTO users (name, email, phone_number, password, status, category, school) VALUES (:name, :email, :phone_number, :password, :inactive, :category, :school)";
    $current_id = $db->query($insert, $param);
    $get_id = $db ->getLastInsertId();
    if ($current_id){
      /** Generate security code **/
      $encrypt = md5(1290*3+$get_id);
      $update = "UPDATE users SET security_code = :security_code";
      $db->query($update, array('security_code' => $encrypt));

      $actual_link = "http://www.offcampus.com.ng/activate.php?id=" . $get_id."&token=".$encrypt;
  		$toEmail = $_POST["email"];
      $name = $_POST['name'];
  		$subject = "Offcampus.com.ng: Activate your email";
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
      <h3>Welcome to Offcampus.com.ng</h3>
      <img src='http://www.offcampus.com.ng/img/logo.jpg' width='120' height='60' class='img img-responsive'>
      <p>Hi $name, <br> 
      I would like to welcome you to the offcampus community. I hope you will have a nice time finding accommodations and roommates. Please activate your account <a href='http://www.offcampus.com.ng/activate.php?id=$get_id&token=$encrypt'>by clicking here</a> or copy
      and paste this link on your browser: http://www.offcampus.com.ng/activate.php?id=$get_id&token=$encrypt</p></br>
      Thank you. <br>
      Obioha Uche<br>
      (Founder)
      </br>

      </body>
      </html>
  		";

  		//$mailHeaders = "From: Admin no_reply@offcampus.com.ng\r\n";
  		if(mail($toEmail, $subject, $content, $headers)) {
        header("location: register.php?action=success");

  		}else{
        //  Unable to process request
        header("location: register.php?action=fail");


      }
    }else{
      //Unable to process request
      header("location: register.php?action=fail");


    }

  }
}else{
  //
}
if ($action == "success"){
  $output = "You can now login <a href='login.php'>here</a>! Check your email to activate your account";
}else if ($action == "fail"){
  $fail = "Temporarily unable to process request, try again";
}
?>
<title>Sign Up</title>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="">
                
                <div class="">
                    <span class="help-block text-center custom_error"> <?php echo $all_fields; ?> </span>
                    <span class="help-block text-center col-md-offset-1 custom_error"> <?php echo $output; ?> </span>
                    <span class="help-block text-center col-md-offset-1 custom_error"> <?php echo $fail; ?> </span>
                    <form class="form-horizontal form" role="form" method="POST" action="register.php">
                        <div class="form-group">

                            <div class="col-md-12">
                                <input type="text" class="" placeholder="Your name" name="name" value="<?php echo htmlspecialchars($name); ?>">
                                <span class="help-block custom_error"> <?php echo $error1; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-md-12">
                                <input type="email" class="" placeholder="Email address" name="email" value="<?php echo htmlspecialchars($email); ?>">
                                <span class="help-block custom_error"> <?php echo $error2; ?> </span>
                                <span class="help-block custom_error"> <?php echo $error3; ?> </span>
                            </div>
                        </div>

                        <div class="form-group">
                           
                            <div class="col-md-12">
                                <input type="password" placeholder="Enter Password" class="" name="password">
                                <span class="help-block custom_error"> <?php echo $error5; ?> </span>
                            </div>
                        </div>

                        <div class="form-group">
                           
                            <div class="col-md-12">
                                <input type="password" placeholder="Confirm Password" class="" name="password_confirmation">
                                <span class="help-block custom_error"> <?php echo $error5; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                           
                            <div class="col-md-12">
                                <input type="text" class="" placeholder="Your phone number, For e.g. 0809xxxxxxx" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>">
                                <span class="help-block custom_error"> <?php echo $error4; ?> </span>
                                <span class="help-block custom_error"> <?php echo $error6; ?> </span>
                            </div>
                        </div>
                        
                        <div class='form-group'>
                          <div class="col-md-12">
                            <select name="category" id="school" class="">
                              <option value="">Choose status...</option>
                              <option value="student" <?php if($category =="student") print 'selected'; echo">Student</option>";?>
                              <option value="agent" <?php if($category =="agent") print 'selected'; echo">Agent</option>";?>
                            </select>
                          </div>
                        </div>
                        <div class='form-group'>
                              
                              <div class="col-md-12">
                                  <select name="school" id="school" class="">
                                    <option value="">Select School...</option>
                                    <option value="Federal University of Technology, Akure" <?php if($school =="Federal University of Technology, Akure") print 'selected'; echo">Federal University of Technology, Akure</option>";?>
                                    <option value="Ladoke Akintola University of Technology" <?php if($school =="Ladoke Akintola University of Technology") print 'selected'; echo">Ladoke Akintola University of Technology</option>";?>
                                    <option value="Lagos State University" <?php if($school =="Lagos State University") print 'selected'; echo">Lagos State University</option>";?>
                                    <option value="University of Ibadan" <?php if($school =="University of Ibadan") print 'selected'; echo">University of Ibadan</option>";?>
                                    <option value="University of Lagos" <?php if($school =="University of Lagos") print 'selected'; echo">University of Lagos</option>";?>
                                      
                                </select>
                                  <span class="help-block" style='color:black;'><strong>
                                      For students, select where you school.</br>
                                      For agents, select school where your business is based around.
                                      </strong></span>
                              </div>
                          </div>
                        <!--
                        <div class="form-group">
                            <label class="col-md-4 control-label">Security Code</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="security_code" value="">
                                <span class="help-block custom_error"> <?php /** echo $error7; **/?> </span>
                                <span class="help-block"><small>This code will be needed if you wish to change your password.
                                This code can be numbers, letters or a combination of both. Just choose something you can easily
                                remember</small></span>
                            </div>
                        </div>
                      -->
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="submit" name="register" value="Register" class="btn btn-success">
                                <span style='margin-left: 20px;' class="">Already a user? <a href="login.php">Login</a></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
