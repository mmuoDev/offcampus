<?php
ob_start();
require_once "includes/layout3.php";
require_once "includes/header.html";
require_once "db/db_handle.php";
$location= urlencode($_SERVER['REQUEST_URI']);
if (isset($_SESSION['id']) == false){
  header ("Location: login.php?location=$location");
}
$school = isset($_POST['school'])?$_POST['school']:"";
$description = isset($_POST['description'])?$_POST['description']:"";
$action = isset($_GET['action'])?$_GET['action']:"";
$fields = [$school, $description];
$all_fields = $empty = $error1 = $output = $fail = null;
foreach ($fields as $field){
  if(empty($field)){
    $empty = true;
  }
}
if(isset($_POST['submit'])){
  if($empty){
    $all_fields = "All fields are required";
  }else if (!preg_match("/^[a-zA-Z0-9., ?]+$/",$_POST['description'])){
    $error1 = "Enter only letters, numbers, commas, question marks and full stops.";
  }else{
    $param = array(
        'school' => $_POST['school'],
        'description' => $_POST['description'],
        'member_id' => $_SESSION['id'],
        'date' => date('Y-m-d H:i:s')
    );
    $sql = "INSERT INTO post_request
            (school, description, member_id, date, status)
             VALUES
            (:school, :description, :member_id, :date, 'unresolved')";
    if ($db->query($sql, $param)){
      header("location: post_request.php?action=success");
    }else{
      header("location: post_request.php?action=fail");
    }
  }
}
if ($action == "success"){
  $output = "Request submitted";
}else if ($action == "fail"){
  $fail = "Temporarily unable to process request, try again";
}
?>
<title>Post a Request</title>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success">
                <div class="panel-heading"><strong> Post a request</strong> </div>
                <div class="panel-body">
                  <div class='row'>
                  <div class='col-md-6 col-md-offset-4'>
                    <span class="help-block custom_error"> <?php echo $all_fields; ?> </span>
                    <span class="help-block custom_error"> <?php echo $output; ?> </span>
                    <span class="help-block custom_error"> <?php echo $fail; ?> </span>
                  </div>
                </div>
                    <form class="form-horizontal" role="form" method="POST" action="post_request.php">
                        <div class="form-group">
                            <label class="col-md-4 control-label">Your School</label>
                            <div class="col-md-6">
                              <select name="school" id="school" class="form-control input-3x">
                                  <option value="">Select School...</option>
                                  <option value="Lagos State University" <?php if($school =="Lagos State University") print 'selected'; echo">Lagos State University</option>";?>
                                  
                                  <option value="Federal University of Technology, Owerri" <?php if($school =="Federal University of Technology, Owerri") print 'selected'; echo">Federal University of Technology, Owerri</option>";?>
                              </select>

                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Briefly describe your requested accommodation</label>
                            <div class="col-md-6">
                                <textarea  name="description" style=" resize:none;" placeholder="Describe your requested accommodation"  class="form-control"><?php echo htmlspecialchars($description); ?></textarea>
                                <p class="help-block">Please, be clear as possible</p>
                                <span class="help-block custom_error"> <?php echo $error1; ?> </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                              <input type="submit" value="Post" name="submit" class="btn btn-success submit_button" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
