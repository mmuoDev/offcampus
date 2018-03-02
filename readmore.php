<?php
ob_start();
require_once "db/db_handle.php";
//require_once "includes/header.html";
require_once "includes/layout.php";
//if (isset($_SESSION['id']) == false){
//  header ("Location: login.php?location=$location");
//}
$id = isset($_GET['id'])?$_GET['id']:"";
$location= urlencode($_SERVER['REQUEST_URI']);
$url = "http://www.offcampus.com.ng/readmore.php?id=".$id;
?>
<title>Property Details</title>

<?php


$name = isset($_POST['name'])?$_POST['name']:"";
$number = isset($_POST['number'])?$_POST['number']:"";
$fields = [$name, $number];
$empty = $all_fields = $error1  = $output = $fail = null;
$action = isset($_GET['action'])?$_GET['action']:"";
if (isset($_POST['request'])){
	foreach ($fields AS $field){
		if(empty($field)){
			$empty = true;
		}
	}
	if($empty){
		$all_fields = "All fields are required";
	}else if (!preg_match("/^[0-9]{11}$/", $number)){
		$error1 = "Phone number is not valid";
	}else{
		$sql = "SELECT i.*, m.*, i.id AS property_id, m.id AS member_id FROM offers i
					 JOIN users m ON m.id = i.member_id
					 WHERE i.id = :id";
					 $result = $db->query($sql, array('id' => $id))->fetch();
					 $agent_id = $result['member_id'];
					 $number = $result['phone_number'];
					 $help = '08063321043';
					 $property_id = $result['property_id'];
		 		 		$agent_name = $result['name'];
					 $student_name = $_POST['name'];
					 $student_number = $_POST['number'];
						$insert = "INSERT INTO contact_agent (property_id, student_name, student_number, agent_id, agent_number, date)
									 VALUES
									 (:property_id, :student_name, :student_number, :agent_id, :agent_number, :date)
									 ";
									 $db->query($insert,
															array('property_id' => $property_id,
																		'student_name' => $student_name,
																		'student_number' => $student_number,
																		'agent_id'     => $agent_id,
																		'agent_number'   => $number,
						'date' => date('Y-m-d h:i:s')
															 ));
					 //echo "inserted";
					 //
		$owneremail="offcampus.com.ng@gmail.com";
		$subacct="offcampus";
		$subacctpwd="offcampus2015";
		$sendto= $student_number; /* destination number */
		$sender="Offcampus"; /* sender id */
		$message="
/*Your requested information*/
Agent's name: $agent_name
Agent's number: $number
Helpline: $help
Get a roommate: http://goo.gl/MTwqHY
";



		/* message to be sent */
		/* create the required URL */
		$url = "http://www.smslive247.com/http/index.aspx?"
		. "cmd=sendquickmsg"
		. "&owneremail=" . UrlEncode($owneremail)
		. "&subacct=" . UrlEncode($subacct)
		. "&subacctpwd=" . UrlEncode($subacctpwd)
		. "&message=" . UrlEncode($message)
		. "&sendto=" . UrlEncode($sendto);
		/* call the URL */
		if ($f = @fopen($url, "r")){
		$answer = fgets($f, 255);
			 if (substr($answer, 0, 1) == "OK"){
				//echo "SMS to $dnr was successful.";
			 }
			 else{
				//echo "an error has occurred: [$answer].".$sendto;
			 }
			 //echo "url working";

		}else{
			 //header("Location: readmore.php?id=$id&err=04");
			 header("location: readmore.php?id=$id&action=fail");
		}
		 //echo "done";
		 header("location: readmore.php?id=$id&action=success");
	}

}
if ($action == "success"){
	$output = "SMS was sent";
}else if ($action == "fail"){
	$fail ="SMS was not sent. Try again";
}
//Display an error message when property is no longer available
$stat = "SELECT COUNT(*) AS num from offers WHERE id = :id";
$cout = $db->query($stat, array('id' => $id))->fetch();
if ($cout['num'] == '0'){
      echo"
        <div class='col-md-6 col-md-offset-3'>
                        <div class='alert alert-danger'>
                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                            <strong>Sorry!</strong> Property no longer exit.
                        </div>
        </div>";
	exit;
}
//Display error ends

//$agents = "SELECT * FROM members WHERE id = :session_id";
//$agent_query = $db-> query($agents, array ('session_id' => $_SESSION['id']))->fetch();
//$count_insert = "INSERT INTO visitors_count (count, idea_id) values(1, :id)";
//$count_query=$db->query($count_insert, array('id' => $_GET['id']));

//if (isset($_POST['send'])){
//
//            $Mesparam = array(
//            'sender_id'=> $_SESSION['id'],
//            'receiver_id' => $_POST['receiver_id'],
//            'message'=> $_POST['message'],
//	    'date' => date('Y-m-d H:i:s')
//
//        );
//	    if (isset($_SESSION['id']) == false){
//	    header ("Location: readmore.php?id=$id&err=04");
//	    }
//	    else if ($Mesparam['message'] != null){
//
//		  $sum = $Mesparam['receiver_id'] + $Mesparam['sender_id'];
//
//		  $Messql= "INSERT INTO message (sender_id, receiver_id, message, message_id, date) VALUES (:sender_id, :receiver_id, :message, '$sum', :date)";
//
//		  $Mesresult=$db->query($Messql, $Mesparam);
//		  if($Mesresult){
//			header ("Location: readmore.php?id=$id&err=01");
//		  }else{
//			header ("Location: readmore.php?id=$id&err=02");
//		      }
//	    }else{
		  //echo "<script>alert('Sorry, Message can't be empty!');</script>";
//		  echo "<div class='error-general'>'Message can't be empty!</div>";
//
//		  header ("Location: readmore.php?id=$id&err=03");
//	    }
//}

$sql = "SELECT i.*, m.*, i.id AS id_count,FORMAT(price, 0) AS price, m.id AS receiver_id, i.photo AS photos FROM offers i
            JOIN users m ON m.id = i.member_id
            WHERE i.id = :id";

foreach ($db->query($sql, array('id' => $id)) AS $result)
{
      $newPrice = str_replace(".", ",", $result['price']);
      $myDate = date('F j, Y g:i a', strtotime($result['date']));

      //AddFav only shows when you are logged In.
		  if (isset($_SESSION['id']) != false){
                        $param_fav = array(
                                       'session_id' => $_SESSION['id'],
                                        'offer_id'  => $result['id_count']
                                       );
                        $sql_fav= "SELECT COUNT(*) AS num FROM favourite WHERE member_id= :session_id AND offer_id = :offer_id";
                        $db->query($sql_fav, $param_fav);
                        $info_fav = $db->fetch();


                      if ($info_fav['num'] == '1') {
                          // if the user is already a friend
                          echo "<div class='hide' id='status'>Drop from fav</div>";
                          $follow_btn = "<span class='btn btn-success btn-sm following' data-clique_id='{$result['id_count']}' data-adder_id='{$_SESSION['id']}'>Drop from fav</span>";
                      }else {
                          // if the user is NOT following, show follow button
                          echo "<div class='hide' id='status'>Add to fav</div>";
                          $follow_btn = "<span class='btn btn-success btn-sm following' id='{$result['id_count']}'>Add to fav</span>";
                      }

                }
      //Add Fav ends

  echo "
    <div class=''>
    <div class='container'>
    <div class='col-xs-12 col-sm-12 col-md-12'>

     <div class='col-xs-12 col-sm-4 col-md-4'>

              <div class='user_sec_fav_2>
	       <div class='col-md-12'>
				  
				  <div class='alert alert-danger home_pad_6 home_pad_3'>
                            
                            <strong>{$result['accommodation']}!</strong> .
                        </div>
                      ";
                      //foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
		      //<img src='profile_pix/{$result2['photo']}' width = '150' height ='180px' style='padding:10px 0px 10px 10px;'/>
			$count_photo = 'SELECT i.*, p.*, COUNT(*) AS num FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id';
			$count = $db->query($count_photo, array( 'offer_id' => $result['id_count']))->fetch();
			if  ($count['num'] == 1){
			     echo "<img src='properties/{$count['photo']}' class='img-responsive' width = '400px' height ='' style=''/>";
			}else{

			$active_photo = 'SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1';
                          echo "

			  <div id='myCarousel' class='carousel slide' data-ride='carousel'>
			      <!-- Indicators -->


			      <!-- Wrapper for slides -->
			      <div class='carousel-inner' role='listbox'>

			      <div class='item active'>";
				    foreach ($db->query($active_photo, array( 'offer_id' => $result['id_count'])) AS $active_photo){
			       echo "     <img src='properties/{$active_photo['photo']}' class='img-responsive' width = '400px' height ='' style=' '/>";
			      }echo "
			      </div>
			      ";
			      $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id AND p.photo != '$active_photo[photo]'";
			      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
			      echo "
			      <div class='item'>
				  <img src='properties/{$result2['photo']}' class='img-responsive' width = '400px' height ='' style=''/>
			      </div>
			       ";}echo "

			      </div>

			      <!-- Left and right controls -->
			      <a class='left carousel-control' href='#myCarousel' role='button' data-slide='prev'>
						<span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>
						<span class='sr-only'>Previous</span>
			      </a>
			      <a class='right carousel-control' href='#myCarousel' role='button' data-slide='next'>
						<span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span>
						<span class='sr-only'>Next</span>
			      </a>
			    </div>";
			    }
                     // }
		     echo"
              </div>
	     </div>



	    <div class='col-xs-12 col-sm-4 col-md-4'>
              <div class='myfav' >
                  <div class='row'>
                      <div class='col-md-12'>
			<div class='user_class col-md-12'>
			      <i class='fa fa-university icon_color home_pad' style=''></i> {$result['school']}</br>

			      "; if ($result['location'] != ''){ echo "<i class='fa fa-map-marker icon_color home_pad_4 style=''></i> {$result['location']}</br>"; } echo "
                                <i class='fa fa-money icon_color home_pad_5' style=''></i> <strong>&#x20a6;$newPrice </strong></br>
			      Added: $myDate</br></br>
			      {$result['description']}
			</div>

                            <div class='user_class col-md-12'> </div>
                          <div class='user_class col-md-12'>
                            <div class='row'>
                             <div class='col-md-12'>
			      ";
                               if (isset($_SESSION['id']) != false){
                               echo $follow_btn;
                               }
			       else{

				    $follow_btn_1 = "<span class='btn btn-success btn-sm following_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to fav</span>";
				    echo $follow_btn_1;
				    echo"
				    <div class='modal fade' id='{$result['id_count']}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
					<div class='modal-dialog'>
					    <div class='modal-content'>

						<div class='modal-body'>
						   <p class='text-center' style='margin-top: 20px;'><a href='login.php?location=$location' style='margin-top: 20px; font-size:15px;'>You must login to use this feature</a></p>
						</div>
						<div class='modal-footer'>
						    <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>

						</div>

					    </div>
					</div>

				    </div>";
				    }
                               echo "
						<!--Share property on social media- Facebook-->
						</br></br>
						<div class=''>
							<strong>Share this property on</strong>: </br>
							<a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank' style='color:white;'><i class='fa fa-facebook' style='background-color: #4060A5; padding: .5em .50em;'></i></a>
							<a href='https://twitter.com/share?url=$url' target='_blank' style='color:white;'><i class='fa fa-twitter' style='background-color: #55acee; padding: .5em .50em;'></i></a>
							<a href='whatsapp://send?text={$result['accommodation']} offcampus apartment at {$result['school']}. Click on the link for more details $url or call 08063321043' style='color:white;' data-action='share/whatsapp/share'><i class='fa fa-whatsapp' style='background-color: #25D366; padding: .5em .50em;'></i></a>
						</div>
						<!--Sharing ends-->

                             </div>
			   </div></br>
                         </div>
                      </div>
                  </div>
             </div>
          </div>

	    <div class='col-xs-12 col-sm-4 col-md-4'>
		  <div class='myfav' >
			<span>
			<strong><u>Book an inspection</u></strong></br></br>
			<strong>Property ID: $id</strong></br></br>
			Call 
                            <a class='' href='tel:+2348063321043'>
                                <span class='text-primary'><strong> +234 80 6332 1043</strong></span>
                           </a> (click on the number)
                        to reach out to the agent and inspect this property. Note the Property ID while calling. </span></br></br>
			<span class='text-center'>

				Weekdays: 8am-6pm</br>
				Saturdays: 10am-6pm</br>
			</span><br>
			<p class='text-danger'><strong>Attention! Win recharge cards when you refer someone to use offcampus.com.ng to find accommodations or roommates. Call us or WhatsApp us on 080 6332 1043 (when you referred someone) to claim your prize.</strong></p>
			<!--
			Lets remove this and try the above model-it eliminates the need for SMS.
			<form action='readmore.php?id=$id' method='post'>
			      <div class='row'>

				   <div class='col-md-12'>

					  <div class='col-md-8 col-md-offset-4'>
							<span style=''><strong>You like this property? Fill the fields below to contact the agent.</strong></span></br></br>
							<span class='help-block custom_error'> $all_fields </span>
							<span class='help-block custom_error'> $output </span>
							<span class='help-block custom_error'> $fail </span>
					   </div>

					   <div class='col-md-4'>
						 	<span class='home_text_2'>Your name</span>
					   </div>
					   <div class='col-md-8'>
						 <input type='text' name='name' value='$name' class=''></br></br>
					   </div>

					   <div class='col-md-4'>
						 <span class='home_text_2'>Your phone number</span></br>

					   </div>

					   <div class='col-md-8'>
						 <input type='text' name='number' value='$number'>
						 <span class='help-block custom_error'> $error1 </span>

						 <input type='hidden' value='$id' name='id'>
					   </div>
					   <div class='col-md-8 col-md-offset-4'>
						 <input type='submit' name='request' value='Send' class='btn btn-success'></br>
					   </div>
					   <div class='col-md-8 col-md-offset-4'>
						 <p class='help_a'>An sms containing the contact details of the agent will be sent to your phone</p>
					   </div>
				    </div>
			      </div>
			</form>
			-->
		  </div>
	    </div>

 	</div>
    </div>
   </div>
    ";
}
// For accommodation type: <i class='fa fa-home icon_color home_pad_2' style=''></i> <span class='home_pad_3'>{$result['accommodation']}</span></br>
?>
