<?php
ob_start();
require_once "includes/layout.php";
require_once "db/db_handle.php";
$id = isset($_GET['id'])?$_GET['id']:"";
$session_id = isset($_SESSION['id'])?$_SESSION['id']:"";
$sql= "SELECT COUNT(*) AS num FROM roommate_request WHERE id = :id";
$res = $db->query($sql, ['id' => $id])->fetch();
$request_num = $res['num'];
$action = isset($_GET['action'])?$_GET['action']:"";
$output = $fail = $not_logged =  null;
if($res['num'] == 0){
    echo"<div class='alert alert-danger col-md-6 col-md-offset-3'>
        <a href='#' class='close' data-dismiss='alert'>&times;</a>
        <strong>Oooops!</strong> This link does not exist                      
    </div>";
}
if(isset($_POST['accept'])){
    $location= urlencode($_SERVER['REQUEST_URI']);
    if ($session_id == false){
        $not_logged = "Ooops! You must <a href='login.php?location=$location'>login here</a>";
    }else{
       //Insert into responses table and send a mail to admin
      
       $insert = "INSERT INTO responses (request_id, member_id, status) VALUES (:request_id, :member_id, :status)";
       $res = $db->query($insert, ['request_id' => $id, 'member_id' => $_SESSION['id'], 'status' => 'unresolved']);
       if($res){
            $toEmail = "offcampus.com.ng@gmail.com";
            $subject = "Roommate request: New response recorded";
            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            // More headers
            $headers .= 'From: <no_reply@offcampus.com.ng>' . "\r\n";
            $content="
            <html>
            <body>
            <h3>New roommate request has been recorded</h3></br></br>
            </body>
            </html>
            ";
            mail($toEmail, $subject, $content, $headers);
            //Mail sent. 
                header("location: request_details.php?id=$id&action=success");
        }else{
            header("location: request_details.php?id=$id&action=fail");
        }
    }   
} 
if ($action == "success"){
  $output = "Success! We will contact you shortly";
}else if ($action == "fail"){
  $fail = "Temporarily unable to process request, try again";
}else{}
?>
<title>Roommate Request Details</title>
<div class="container">
    <div class="row">    
        <div class="col-md-12"> 
            <span class="help-block custom_error text-center" style="font-family: cursive;"> <?php echo $not_logged; ?> </span>
            <span class="help-block custom_error text-center" style="font-family: cursive;"> <?php echo $output; ?> </span>
            <span class="help-block custom_error text-center" style="font-family: cursive;"> <?php echo $fail; ?> </span>
            <form class="form-horizontal form"  role="form" method="POST" action="">
              <?php
              if ($request_num != 0){
              $select = 'SELECT a.*,b.*, a.sex AS sex, a.school AS school, FORMAT(price, 0) AS price FROM roommate_request a JOIN users b ON b.id = a.member_id WHERE a.id = :id';
              foreach ($db->query($select, ['id' => $id]) AS $stmt){
              $newPrice = str_replace(".", ",", $stmt['price']);
              echo"<p style=''> ".'Hello,'.'</br>'."My name is {$stmt['name']} and I stay in a <strong>{$stmt['accommodation']} apartment </strong>. I want a <strong>{$stmt['sex']} roommate </strong> who schools at <strong>{$stmt['school']}</strong> and can pay <strong>&#x20a6;{$newPrice} </strong> per year in addition to my own quota."
                      . ""."</p>";
                   
              }?> 
              <div class="form-group">
                            <div class="col-md-12">
                              <input type="submit" value="Accept" name="accept" class="btn btn-success submit_button" />
                            </div>
              </div> 
               <a href="index.php" class="btn btn-danger decline">DECLINE</a>
              
            </form>
              <?php } ?>
        </div>
    </div>
</div>
