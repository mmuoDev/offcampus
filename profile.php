<?php
ob_start();
require_once 'db/db_handle.php';
require_once 'includes/layout2.php';
if ($_SESSION['id'] == false){
  header ("location: login.php");
}
$all_field = $all_field2= $error1 =  $error2 = $error3 = $error4 = $error5 = $error6 = $error7 = $output1 = null;
//Get name and phone number of user from db.
$select = "select name, phone_number, password from users where id = :id";
$db->query($select, array('id' => $_SESSION['id']));
$info = $db->fetch();
//$name = $_POST['name'];
//$phone_number = $_POST['phone_number'];
$name = isset($info['name'])?$info['name']:"";
$phone_number = isset($info['phone_number'])?$info['phone_number']:"";
//ends
//Old Password
$old_password_1 = isset($_POST['old_password'])?$_POST['old_password']:"";
$old_password = hash('sha256', $old_password_1 . "Some nonsense here just to be naughty");
//New Password
$new_password_1 = isset($_POST['new_password'])?$_POST['new_password']:"";
$new_password = hash('sha256', $new_password_1 . "Some nonsense here just to be naughty");
//Re-enter new password
$new_password2_1 = isset($_POST['new_password2'])?$_POST['new_password2']:"";
$new_password2 = hash('sha256', $new_password2_1 . "Some nonsense here just to be naughty");
//Confirm the entered the old password
$sql = "SELECT COUNT(*) AS num FROM users WHERE password = :old_password";
$db->query($sql, array('old_password' => $old_password));
$get_old_count = $db->fetch();
//Confirmation ends.
if (isset($_POST['submit'])){
  $name = $_POST['name'];
  $phone_number = $_POST['phone_number'];
  //Get the phone_number count
  $sql2 = "SELECT COUNT(*) AS num FROM users WHERE phone_number = :phone_number AND id != :id";
  $db->query($sql2, array ('phone_number' => $phone_number, 'id' => $_SESSION['id']));
  $info2 = $db->fetch();
  //count ends

  $fields = [$name, $phone_number]; //Array of name and phone_number
  $values = [$name, $phone_number, $old_password_1, $new_password_1, $new_password2_1]; //Array of all fields

  foreach ($fields as $field){
    if(empty($field)){
      $all_field = true;
    }
  }
  foreach ($values as $value){
    if(empty($value)){
      $all_field2 = true;
    }
  }
  if (empty($old_password_1)){
    if($all_field){
      $error1 = "Name or Phone number is needed";
    }elseif (!preg_match("/^[a-zA-Z ]*$/", $name)) {
      $error2 = "Please enter a valid name";
    }else if (!preg_match("/^[0-9]{11}$/",$phone_number)){
      $error3 = "Enter a valid phone number";
    }else if ($info2['num'] == 1){
      $error4 = "Phone number is already taken";
    }else{
      $update = "UPDATE users SET name = :name, phone_number = :phone_number WHERE id = :id";
      $db->query($update, array('name' => $_POST['name'], 'phone_number' => $_POST['phone_number'], 'id' => $_SESSION['id']));
      $output1 = "Profile updated";
    }
  }else if (!empty($old_password_1)){
    if($all_field2){
      $error5 = "Fill all password fields to alter password";
    }else if($get_old_count['num'] == 1){
      if ($new_password != $new_password2){
        $error6 = "Both passwords must match!";
      }else if ($new_password == $new_password2){
        $update2 = "UPDATE users SET name = :name, phone_number = :phone_number, password = :password WHERE id = :id";
        $db->query($update2, array('name' => $_POST['name'], 'phone_number' => $_POST['phone_number'], 'password' => $new_password, 'id' => $_SESSION['id']));
        $output1 = "Profile updated";
      }else{}
    }else if ($get_old_count['num'] != 1){
      $error7 = "Wrong old password";
    }
  }else{}
  /**
    if($empty){
      $error1 = "Name and Phone number are needed";
    }

  }else if (!empty($old_password_1)){
    if($empty2){
      $error2 = "Fill all password fields to alter password";
    }
  }else{

  }
  **/
}
?>

<title>Edit Profile</title>
<div class="container">
  <div class="row">
    <div class="col-md-5 col-md-offset-4">
      <div class="">
        
        <div class="">
          
          <span class="help-block custom_error col-md-offset-4"> <?php echo $output1; ?> </span>
          <span class="help-block custom_error col-md-offset-4"> <?php echo $error5; ?> </span>
          <form action="" method="post" class="form-horizontal form">
            
            <div class="form-group">
              <div class="col-md-12">
                <input type="text" id="name" name="name" class="" value="<?php echo htmlspecialchars($name); ?>" placeholder="Your Name">
                <span class="help-block custom_error"> <?php echo $error2; ?> </span>
                <span class="help-block custom_error"> <?php echo $error1; ?> </span>
              </div>
            </div>
            
            <div class="form-group">
              <div class="col-md-12">
                <input type="text" class="" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($phone_number); ?>" placeholder="Your Phone Number">
                <span class="help-block custom_error"> <?php echo $error3; ?> </span>
                <span class="help-block custom_error"> <?php echo $error4; ?> </span>
              </div>
            </div>
            <!--<input type='checkbox' class='update_pass' > <span class='home_text_2' style='font-weight: bold;'></span></br>-->
            <span id="helpBlock" style='color:black' class="help-block"><u>Fill fields below to alter your password else ignore</u></span>
            <div class="">
              
              <div class="form-group">
                <div class="col-md-12">
                  <input type="password" id="old_password" name="old_password" class="" value="" placeholder="Old Password">
                  <span class="help-block custom_error"> <?php echo $error7; ?> </span>
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-md-12">
                  <input type="password" class="" id="new_password" name="new_password" value="" placeholder="New Password">
                  <span class="help-block custom_error"> <?php echo $error6; ?> </span>
                </div>
              </div>
              
              <div class="form-group">
                <div class="col-md-12">
                  <input type="password" id="new_password2" name="new_password2" class="" value="" placeholder="Re-enter New Password">
                  <span class="help-block custom_error"> <?php echo $error6; ?> </span>
                </div>
              </div>
            </div>
            <div class="form-group">
                <div class="col-md-12">
                    <input type="submit" class="btn btn-success" name="submit" value="Update">
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
