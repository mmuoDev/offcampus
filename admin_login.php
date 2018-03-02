<?php
ob_start();
require_once 'includes/header.php';
require_once 'db/db_handle.php';
//session_start();
if (isset($_SESSION['admin_id']) != false){
 header("location: admin_login.php");
}



$empty = $all_fields = $error1 = $error2 = $error3 = null;
$email = isset($_POST['email'])?$_POST['email']:"";
$action = isset($_GET['action'])?$_GET['action']:"";
$password = isset($_POST['password'])?$_POST['password']:"";
$password = hash('sha256', $password . "Some nonsense here just to be naughty");
$param = array(
      'email' => $email,
      'password' => $password
);
if(isset($_POST['login'])){
  $location = isset($_GET['location'])?$_GET['location']:"";
  /**Get user details from db
  $sql =  "SELECT COUNT(*) AS num, category, email,id, name, status  FROM users WHERE  email =:email AND password = :password";
  $db->query($sql, $param);
  $info = $db->fetch();
  **/
  foreach ($param as $field){
    if(empty($field)){
      $empty = true;
    }
  }if($empty){
    /** $all_fields = "Error! All fields are required"; **/
    header ("Location: admin_login.php?action=msg1&location=$location");
  }
  /**else if ($info['num'] == 1 && $info['_status']=='inactive'){
    $error1 = "Please check your email and activate your account";
  }
  **/
  else if ($_POST['email'] == "admin" && $_POST['password'] == "offcampus2015") {
    $_SESSION['admin_id'] = "admin";
    //header("location: submitoffer.php");
    $redirect = NULL;
    if($_GET['location'] != '') {
        $redirect = $_GET['location'];
        header("Location:". $redirect);
    }else {
        header("Location: dash.php");
    }
  }
  else{
    $error3 = "Temporarily unable to login";
  }
}
if($action == "msg1"){
  header ("Location: login.php?action=msg3&location=$location");
  $all_fields = "Error! All fields are required";  
}else if($action == "msg2"){
  $error1 = "Please check your email and activate your account";
}else if($action == "msg3"){
   $error2 = "Login details are incorrect";
}
?>
<title>Login</title>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="">
               
                <div class="">
                    <span class="help-block text-center custom_error"> <?php echo $all_fields; ?> </span>
                    <span class="help-block text-center custom_error"> <?php echo $error1; ?> </span>
                    <span class="help-block text-center custom_error"> <?php echo $error2; ?> </span>
                    <span class="help-block text-center custom_error"> <?php echo $error3; ?> </span>
                    <form class="form-horizontal form" role="form" method="POST" action="">
                        <div class="form-group">
                           

                            <div class="col-md-12">
                                <input type="text" placeholder="Email Address" class="" name="email" value="<?php echo htmlspecialchars($email); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                          
                            <div class="col-md-12">
                                <input type="password" placeholder="Password" class="" name="password">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="submit" name="login" value="Login" class="btn btn-success">
                                

                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
