<?php
ob_start();
require_once "includes/layout2.php";
require_once "db/db_handle.php";
$location= urlencode($_SERVER['REQUEST_URI']);
if (isset($_SESSION['id']) == false){
  header ("Location: login.php?location=$location");
}
$member_id = isset($_SESSION['id'])?$_SESSION['id']:"";
$school = isset($_POST['school'])?$_POST['school']:"";
$sex = isset($_POST['sex'])?$_POST['sex']:"";
$price = isset($_POST['price'])?$_POST['price']:"";
$accommodation = isset($_POST['accommodation'])?$_POST['accommodation']:"";
$newPrice = str_replace(",", "", $price);
$action = isset($_GET['action'])?$_GET['action']:"";
$fields = [$school, $sex, $price, $accommodation];
$all_fields = $empty = $output = $fail =$error2 = null;
foreach ($fields as $field){
  if(empty($field)){
    $empty = true;
  }
}
if(isset($_POST['submit'])){
  if($empty){
    $all_fields = "All fields are required";
  }else if (!preg_match("/^[1-9][0-9]*$/",$_POST['price'])  AND !preg_match("/^[1-9, ][0-9, ]+$/",$_POST['price'])) {
    $error2 =  "Enter only numbers";
  }else{
    $param = array(
        'price' => $newPrice,
        'school' => $_POST['school'],
        'sex' => $_POST['sex'],
        'member_id' => $_SESSION['id'],
        'accommodation' => $_POST['accommodation'],
        'date' => date('Y-m-d H:i:s')
    );
    $sql = "INSERT INTO roommate_request
            (school, sex, accommodation, member_id, price, date, status)
             VALUES
            (:school, :sex, :accommodation, :member_id, :price, :date, 'unresolved')";
    if ($db->query($sql, $param)){
            $get_id = $db ->getLastInsertId();        
            $link = "www.offcampus.com.ng/request_details.php?id=$get_id";
            //Insert social media share link into database
            $ins = "INSERT INTO roommate_links (request_id, member_id, share_link) VALUES ("
                    . ":request_id, :member_id, :share_link)";
            $db->query($ins, ['request_id' => $get_id, 'member_id' => $member_id, 'share_link' => $link]);
            
            //header("location: find_member.php?action=success");
            //Show link for user to share on social media and with his inner circle i.e. if he has.
            echo"<div class='alert alert-success col-md-6 col-md-offset-3'>
                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                    <strong>Success!</strong> While we assit you in finding a roommate, share this link: <a href='$link'>$link</a> <br> 
                    with your friends and other people on social media and offline for them
                    to respond to your request. This link will always be avaiable on your dashboard for you to copy until request has been fulfilled. <br>
                    <div class=''>
                        <strong>Start sharing</strong>: </br>
                        <a href='https://www.facebook.com/sharer/sharer.php?u=$link' target='_blank' style='color:white;'><i class='fa fa-facebook' style='background-color: #4060A5; padding: .5em .50em;'></i></a>
      <a href='https://twitter.com/share?url=$link' target='_blank' style='color:white;'><i class='fa fa-twitter' style='background-color: #55acee; padding: .5em .50em;'></i></a>
      <a href='whatsapp://send?text=I need a roommate who schools at $school. Click on the link for more details: $link or call 08063321043' style='color:white;' data-action='share/whatsapp/share'><i class='fa fa-whatsapp' style='background-color: #25D366; padding: .5em .50em;'></i></a>        
                    </div>
                </div>";
    }else{
      header("location: roommate.php?action=fail");
      
    }
  }
}
if ($action == "success"){
  //$output = "Request submitted. We will contact you shortly";
}else if ($action == "fail"){
  $fail = "Temporarily unable to process request, try again";
}
?>
<title>Find a roommate</title>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="">
                <div class="">
                  <div class='row'>
                  <div class='col-md-6 col-md-offset-3'>
                    <span class="help-block custom_error"> <?php echo $all_fields; ?> </span>
                    <span class="help-block custom_error"> <?php echo $output; ?> </span>
                    <span class="help-block custom_error"> <?php echo $fail; ?> </span>
                  </div>
                </div>
                    <form class="form-horizontal form" role="form" method="POST" action="roommate.php">
                      <div class="form-group">
                            <label class="col-md-12">I stay in a: </label>
                            <div class="col-md-12">
                              <select  class="form-size" name="accommodation" placeholder="Choose Accomodation type">
                                <option value="">Choose accomodation type</option>
                                <option value="one room">One Room Apartment</option>
                                <option value="one room self-contain">One Room Self-Contain Apartment</option>
                                <option value="room and parlour">Room and Parlour Apartment</option>
                                <option value="2 bedroom flat">2 Bedroom Flat Apartment</option>
                                <option value="3 bedroom flat">3 Bedroom Flat Apartment</option>
                                
                              </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">I need a: </label>
                            <div class="col-md-12">
                              <select name="sex" id="sex" class="input-3x">
                                  <option value="">Choose Sex...</option>
                                  <option value="Male" <?php if($sex =="Male") print 'selected'; echo">Male</option>";?>
                                  <option value="Female" <?php if($sex =="Female") print 'selected'; echo">Female</option>";?>
                                  <option value="Male or Female" <?php if($sex =="either") print 'selected'; echo">Male or Female</option>";?>

                              </select>
                             
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">roommate who schools at: </label>
                            <div class="col-md-12">
                              <select name="school" id="school" class="input-3x">
                                  <option value="">Select School...</option>
                                  <option value="Federal University of Technology, Akure" <?php if($school =="Federal University of Technology, Akure") print 'selected'; echo">Federal University of Technology, Akure</option>";?>
                                    <option value="Ladoke Akintola University of Technology" <?php if($school =="Ladoke Akintola University of Technology") print 'selected'; echo">Ladoke Akintola University of Technology</option>";?>
                                    <option value="Lagos State University" <?php if($school =="Lagos State University") print 'selected'; echo">Lagos State University</option>";?>
                                    <option value="University of Ibadan" <?php if($school =="University of Ibadan") print 'selected'; echo">University of Ibadan</option>";?>
                                    <option value="University of Lagos" <?php if($school =="University of Lagos") print 'selected'; echo">University of Lagos</option>";?>
                              </select>

                            </div>
                        </div>
                       
                          <div class='form-group'>
                              <label class="col-md-12">and willing to pay this amount per year: </label>
                              <div class="col-md-12">    
                                    <input type="text" class="input-3x" value="<?php echo htmlspecialchars($price); ?>" name="price" placeholder="E.g. 5,000"> 
                                    <span class="help-block custom_error"> <?php echo $error2; ?> </span>                     
                              </div>
                              
                          </div>
                        <p class='help-block'>Offcampus.com.ng collects 2% of whatever the roommate is going to pay on successful transaction. </p>
                        <div class="form-group">
                            <div class="col-md-12">
                              <input type="submit" value="Find" name="submit" class="btn btn-success submit_button" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
