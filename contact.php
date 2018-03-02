<?php
require_once 'includes/layout.php';
require_once 'db/db_handle.php';
$name = isset($_POST['name'])?$_POST['name']:"";
$email = isset($_POST['email'])?$_POST['email']:"";
$subject = isset($_POST['subject'])?$_POST['subject']:"";
$message = isset($_POST['message'])?$_POST['message']:"";
$action = isset($_GET['action'])?$_GET['action']:"";
$fields = [$name, $email, $message,$subject];
$empty = $all_fields = $error1 = $error2 = $error3 = $error4 = $fail = $output = null;

if(isset($_POST['send'])){
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
  }
  else{
      
  		$message = $_POST['message']. "Sent by". $_POST['fullname'];
		$content = $_POST['message'];
		$toEmail = "offcampus.com.ng@gmail.com";
		$email_from = $_POST['email'];
		$subject = $_POST['subject'];
                // Always set content-type when sending HTML email
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

                // More headers
                $headers = 'From: '.$email_from."\r\n". 'Reply-To: '.$email_from."\r\n" . 'X-Mailer: PHP/' . phpversion();

  		//$mailHeaders = "From: Admin no_reply@offcampus.com.ng\r\n";
  		if(mail($toEmail, $subject, $content, $headers)) {
                    header("location: contact.php?action=success");
  		}else{
        //  Unable to process request
                    header("location: contact.php?action=fail");
                }
    }
}else{
  //Not contacted
}
if ($action == "success"){
  $output = "Your message was sent!";
}else if ($action == "fail"){
  $fail = "Temporarily unable to process request, try again";
}
?>
<title>Contact Us</title>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="">
               
                <div class="">
                    <span class="help-block text-center custom_error"> <?php echo $all_fields; ?> </span>
                    <span class="help-block text-center col-md-offset-1 custom_error"> <?php echo $output; ?> </span>
                    <span class="help-block text-center col-md-offset-1 custom_error"> <?php echo $fail; ?> </span>
                    <form class="form-horizontal form" role="form" method="POST" action="contact.php">
                        <div class="form-group">

                            <div class="col-md-12">
                                <input type="text" placeholder="Your name" class="" name="name" value="<?php echo htmlspecialchars($name); ?>">
                                <span class="help-block custom_error"> <?php echo $error1; ?> </span>
                            </div>
                        </div>
                        <div class="form-group">
                           
                            <div class="col-md-12">
                                <input type="email" placeholder="Your email" class="" name="email" value="<?php echo htmlspecialchars($email); ?>">
                                <span class="help-block custom_error"> <?php echo $error2; ?> </span>
                                
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text"  placeholder="Your subject" class="" name="subject" value="<?php echo htmlspecialchars($subject); ?>">
                                
                            </div>
                        </div>
                       <div class='form-group'>
                            
                            <div class="col-md-12">
                              <textarea name="message" style=" resize:none;" placeholder="Type your message here"  class=""><?php echo htmlspecialchars($message); ?></textarea>
                              
                            </div>
                        </div>
                       
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="submit" name="send" value="Send" class="btn btn-success">
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


