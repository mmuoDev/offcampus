<?php
ob_start();
//session_start();
if (isset($_SESSION['id'])==true){
 header("location: index.php");
}
require_once 'includes/layout.php';
require_once 'db/db_handle.php';
$empty = $all_fields = $error1 = $error2 = $error3 = null;
$email = isset($_POST['email'])?$_POST['email']:"";
$password = isset($_POST['npassword'])?$_POST['npassword']:"";
$password2 = isset($_POST['npassword2'])?$_POST['npassword2']:"";

$npassword = hash('sha256', $password . "Some nonsense here just to be naughty");
$npassword2 = hash('sha256', $password2 . "Some nonsense here just to be naughty");
$fields = array(
      'password' => $password,
      'npassword' => $password2
);
$token = isset($_GET['token'])?$_GET['token']:"";
$id = isset($_GET['id'])?$_GET['id']:"";
if(isset($token) && isset($id)){
  $select = "SELECT COUNT(*) AS num FROM users WHERE security_code = :token AND id = :id";
  $db->query($select, array('token' => $token, 'id' => $id));
  $info = $db->fetch();
  if(isset($_POST['submit'])){
    //Get user details from db
    $id = isset($_GET['id'])?$_GET['id']:"";
    foreach ($fields as $field){
      if(empty($field)){
        $empty = true;
      }
    }if($empty){
      $all_fields = "Error! All fields are required";
    }else if($npassword != $npassword2){
      $error1 = "Passwords must be the same";
    }else{
      $sql2 = "UPDATE users SET password = '$npassword' WHERE id = :id";
    	$update = $db->query ($sql2, array('id' => $id));
      $error2 = "Password has been changed";
    }

  }


?>
<title>Change Password</title>
<?php if ($info['num'] == 1){ ?>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="p">
                
                <div class="">
                    <span class="help-block text-center custom_error"> <?php echo $all_fields; ?> </span>

                    <span class="help-block text-center custom_error"> <?php echo $error2; ?> </span>
                    <span class="help-block text-center custom_error"> <?php echo $error3; ?> </span>
                    <form class="form-horizontal form" role="form" method="POST" action="">

                        <div class="form-group">
                            
                            <div class="col-md-12">
                                <input type="password" class="" name="npassword" placeholder="New Password here">
                                <span class="help-block custom_error"> <?php echo $error1; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            
                            <div class="col-md-12">
                                <input type="password" class="" name="npassword2" placeholder="Re-enter New Password">
                                <span class="help-block custom_error"> <?php echo $error1; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="col-md-12">
                            <input type="submit" name="submit" value="Update" class="btn btn-success">
                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } }
 ?>
