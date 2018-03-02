<?php
ob_start();
require_once 'includes/layout2.php';
require_once 'db/db_handle.php';
require_once 'includes/error2.php';
$location= urlencode($_SERVER['REQUEST_URI']);
if (isset($_SESSION['id']) == false){
  header ("Location: login.php?location=$location");
}
else if (isset($_SESSION['category']) != "agent"){
  header ("Location: dashboard.php");
}else{}

$upload_folder = "./properties/";
if (isset($_POST['submit'])) {

  $param = array(
      'accommodation' => $_POST['accommodation'],
      'school' => $_POST['school'],
      'description' => $_POST['description'],
      'member_id' => $session_id,
      'date' => date('Y-m-d H:i:s'),
      'price' => $newPrice,
      'location' => $_POST['location'],
      'distance' => $_POST['distance'],
      'water'  => $_POST['water'],
      'business' => $_POST['business']
  );
  foreach ($fields as $field){
    if(empty($field)){
      $empty = true;
    }
  }
  if ($empty){
    $all_fields = "All fields with * are compulsory";
  }else if (!preg_match("/^[a-zA-Z0-9., ?]+$/",$_POST['description'])){
    $error1 = "Enter only letters, numbers, commas, question marks and full stops.";
  }else if (!preg_match("/^[1-9][0-9]*$/",$_POST['price'])  AND !preg_match("/^[1-9, ][0-9, ]+$/",$_POST['price'])) {
    $error2 =  "Enter only numbers";
  }else if (!preg_match("/^[a-zA-Z ]+$/",$_POST['location'])){
    $error3 = "Enter only letters";
  }else{
    $sql = "INSERT INTO offers
            (accommodation, school, date,  available, member_id,  description, price, location, distance, water, business, status)
             VALUES
            (:accommodation, :school, :date, 'yes', :member_id,  :description, :price, :location, :distance, :water, :business, 'show')";
    if ($db->query($sql, $param)) {
      $offer_count = $db ->getLastInsertId();
      for ($i = 0; $i < count($_FILES["_photo"]["name"]); $i++) {
        if (!empty($_FILES['_photo']['name'][$i])) {
          if (($_FILES['_photo']['type'][$i] == 'image/jpeg') OR ($_FILES['_photo']['type'][$i] == 'image/png') OR ($_FILES['_photo']['type'][$i] =='image/gif')) {

            $type = $_FILES['_photo']['type'][$i];
            if ($type == "image/png"){
                $pic_name = $i . '_'. time() . ".png";
            }else if ($type == "image/jpeg"){
                $pic_name = $i . '_'. time() . ".jpg";
            }else if ($type == "image/gif"){
                $pic_name = $i . '_'. time() . ".gif";;
            }else{}
            //$pic_name = $i . '_'. time() . ".jpg";
            $pic_path = $upload_folder . $pic_name;

            require_once "includes/resize.php";
            //if (
              move_uploaded_file($_FILES['_photo']['tmp_name'][$i], $pic_path);
              //) {
              $image = new Resize($pic_path);
              $image->resizeImage(220, 220, 'crop');
              $image->saveImage($pic_path);
            //}
            $sql2 = "INSERT INTO photos
              (photo, member_id, photo_id)
            VALUES
            ('$pic_name', :session_id, :offer_count)";
            $db -> query($sql2, array('session_id' => $_SESSION['id'], 'offer_count' => $offer_count));
          }else{
            //Image format not supported
            $error4 = "Image format not supported";
          }
          //No photo uploaded
        }else {
            $pic_name_2="no image.jpg";
            $pic_path_2 = $upload_folder . $pic_name_2;
            require_once "includes/resize.php";
            if (move_uploaded_file($_FILES['_photo']['tmp_name'][$i], $pic_path_2)) {
              $image = new Resize($pic_path_2);
              $image->resizeImage(220, 220, 'crop');
              //$image->resizeImage(180, 180, 'crop');
              $image->saveImage($pic_path_2);
            }
            $sql2 = "INSERT INTO photos
            (photo, member_id, photo_id)
            VALUES
            ('$pic_name_2', :session_id, :offer_count)";
            $db -> query($sql2, array('session_id' => $_SESSION['id'], 'offer_count' => $offer_count));
        }
      }
      header("location: post_property.php?action=success");
    }else{
      header("location: post_property.php?action=fail");
    }
  }
}
if ($action == "success"){
  $output = "Your property has been added";
}else if ($action == "fail"){
  $fail = "Temporarily unable to process request, try again";
}
?>
<title>Post a property</title>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="">
                
                <div class="">
                  <div class='col-md-8 col-md-offset-2 submit_offer'>
                    <!-- Display error -->
                    <span class="help-block custom_error"> <?php echo $all_fields; ?> </span>
                    <span class="help-block custom_error"> <?php echo $output; ?> </span>
                    <span class="help-block custom_error"> <?php echo $fail; ?> </span>
                    <!-- error messages end -->
                    <div class="" >
                      <div class='form-group home_text_2' style="font-weight: bold;">Fields with * are compulsory</div>
                      <form action="post_property.php" class="" role="form" id="idea" method="post" enctype="multipart/form-data">
                          <div class='form-group'>
                              <span class='home_text_2'>Accommodation Type*</span><br class='clear'>
                              <select name="accommodation" id="accommodation" class="form-control input-3x">
                                              <option value="">Select....</option>
                                              <option value="one room" <?php if($accommodation =="one room") print 'selected'; echo">One Room</option>";?>
                                              <option value="one room self-contain" <?php if($accommodation =="one room self-contain") print 'selected'; echo">One Room Self-Contain</option>";?>
                                              <option value="room and parlour" <?php if($accommodation =="room and parlour") print 'selected'; echo">Room and Parlour</option>";?>
                                              <option value="2 bedroom flat" <?php if($accommodation =="2 bedroom flat") print 'selected'; echo">2 Bedroom Flat</option>";?>
                                              <option value="3 bedroom flat" <?php if($accommodation =="3 bedroom flat") print 'selected'; echo">3 Bedroom Flat</option>";?>

                              </select>
                          </div>

                          <div class='form-group'>
                              <span class='home_text_2'>Select School*</span><br class='clear'>
                              <select name="school" id="school" class="form-control input-3x">
                                  <option value="">Select School...</option>
                                  <option value="Federal University of Technology, Akure" <?php if($school =="Federal University of Technology, Akure") print 'selected'; echo">Federal University of Technology, Akure</option>";?>
                                  <option value="Lagos State University" <?php if($school =="Lagos State University") print 'selected'; echo">Lagos State University</option>";?>
                                  <option value="University of Lagos" <?php if($school =="University of Lagos") print 'selected'; echo">University of Lagos</option>";?>
                                    
                                    <option value="University of Ibadan" <?php if($school =="University of Ibadan") print 'selected'; echo">University of Ibadan</option>";?>
                              </select>
                          </div>

                          <div class='form-group'>
                              <span class='home_text_2'>Briefly describe this accommodation*</span><br class='clear'>

                              <textarea name="description" style=" resize:none;" placeholder="Location of accommodation, Proximity to school, Availability of water and electricity, etc. ."  class="form-control"><?php echo htmlspecialchars($description); ?></textarea>
                              <span class="help-block custom_error"> <?php echo $error1; ?> </span>
                          </div>


                          <div class='form-group'>
                              <span class='home_text_2'>Price*</span><br class='clear'>

                              <div class='input-group'>
                                  <span class="input-group-addon">&#x20a6;</span>
                                  <input type="text" class="form-control input-3x" value="<?php echo htmlspecialchars($price); ?>" name="price" placeholder="E.g. 5,000">

                              </div>
                              <span class="help-block custom_error"> <?php echo $error2; ?> </span>
                          </div>

                          <div class='form-group'>
                              <span class='home_text_2'>Exact Location*</span><br class='clear'>
                              <input type='text' name='location' value="<?php echo htmlspecialchars($exact_location); ?>" placeholder='e.g. Dim Gate, Staff Quarters,'  class=''>
                              <span class="help-block custom_error"> <?php echo $error3; ?> </span>
                          </div>

                          <div class='form-group'>
                              <span class='home_text_2'>Distance to School</span><br class='clear'>
                              <input type='radio' name='distance' value='near' checked>Near
                              <input style='margin-left:5px;' type='radio' name='distance' value='far'>Far
                          </div>

                          <div class='form-group'>
                              <span class='home_text_2'>Water Source</span><br class='clear'>
                              <input type='radio' name='water' value='tap'>Borehole
                              <input style='margin-left:5px;' type='radio' name='water' value='well'>Well
                              <input style='margin-left:5px;' type='radio' name='water' value='both' checked>Both
                          </div>

                          <div class='form-group'>
                              <span class='home_text_2'>Distance to a business  centre (Photocopy, Typing, Cybercafe, etc)</span><br class='clear'>
                              <input type='radio' name='business' value='near' checked>Near
                              <input style='margin-left:5px;' type='radio' name='business' value='far'>Far
                          </div>

                          <div class='form-group'>
                              <span class='home_text_2'>Upload Photo</span><br class='clear'>
                              <!--<div id="none">--><div style="width:100px;float:left;"><input type="file" id="_photo"  name="_photo[]" multiple="multiple"></div><!--</div>-->
                              <!--<input type="button" id="add_more" class="" value="Add More Files"/>-->
                              <br class='clear'>
                              <span class="help-block custom_error"> <?php echo $error4; ?> </span>
                          </div>
                          <p class='help-block'>Adding a photo(s) makes your property look more credible. Acceptable formats: jpg, png and gif</p>
                              <p class='help-block'>You can add as many photos (of the interior and exterior of the property) as possible.</p>
                          <br class='clear'>
                          <br class='clear'>
                          <div class='form-group'>
                              <input type="submit" value="Submit" name="submit" class="btn btn-success submit_button" />
                          </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>
