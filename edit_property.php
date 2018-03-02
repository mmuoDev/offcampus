<?php
ob_start();
//session_start();
require_once "includes/header2.php";
require_once "includes/admin_check.php";
//require_once "includes/manager_check.php";
require_once "db/db_handle.php";
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Admin | Edit Properties</title>
  </head>
</html>
<?php
$id = isset($_GET['id'])?$_GET['id']:"";
//Display an error message when property is no longer available
$stat = "SELECT COUNT(*) AS num, member_id AS member_id from offers WHERE id = :id";
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
if (isset($_POST['update'])){
    
    if ($_POST['desc'] == ''){
        echo"
        <div class='col-md-3 col-md-offset-4'>
                        <div class='alert alert-danger'>  
                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                            <strong>Error!</strong> Description can't be empty.          
                        </div>
        </div>";        
    }else{
        $update = "UPDATE offers SET description = :desc WHERE id = :id";
        $query = $db->query($update, array('desc' => $_POST['desc'], 'id' => $_POST['offer_id']));
        echo"
        <div class='col-md-3 col-md-offset-4'>
                        <div class='alert alert-success'>  
                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                            <strong>Success!</strong> Changes were saved.          
                        </div>
        </div>";
    }
    
}
if (isset($_POST['delete'])){
    $delete = "DELETE FROM photos WHERE id = :id";
    $query = $db->query($delete, array('id' => $_POST['photo_id']));
    //$sql = "SELECT photo FROM photos WHERE id = :id";
    //$res = $db->query($query, array('id' => $_POST['photo_id']))->fetch();
    unlink("properties/".$_POST['photo']);
    
     echo"
    <div class='col-md-3 col-md-offset-4'>
                    <div class='alert alert-success'>  
                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
                        <strong>Success!</strong> Photo was deleted.          
                    </div>
                </div>";
}
if (isset($_POST['delete_offer'])){
    $delete = "DELETE FROM offers WHERE id = :id";
    $query = $db->query($delete, array('id' => $_POST['offer_id']));
    
    $select = "SELECT * FROM photos WHERE photo_id = :id";
    foreach ($db->query($select, array('id' => $_POST['offer_id'])) AS $select_2){
    //foreach ($db->query($delete_2, array('id' => $_POST['offer_id'])) AS $select_2){
    $delete_2 = "DELETE FROM photos WHERE photo_id = :id";
    $query = $db->query($delete_2, array('id' => $select_2['photo_id']));
    unlink("properties/".$select_2['photo']);
   
    }
    //$delete_2 = "DELETE FROM photos WHERE photo_id = :id";
    //foreach ($db->query($delete_2, array('id' => $_POST['offer_id'])) AS $query_2){
    //unlink("profile_pix/".$_POST['offer_id']);
    //}
    echo"
    <div class='col-md-6 col-md-offset-3'>
                    <div class='alert alert-success'>  
                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
                        <strong>Success!</strong> Property was deleted.          
                    </div>
    </div>";
                //header ("Location: agent_properties.php");
                
}

//Updates profile photo
if(isset($_POST['upload'])){ 
    $upload_folder = "./properties/";
	if(!empty($_FILES['profile_photo']['name'])) {
	  if (($_FILES['profile_photo']['type'] == 'image/jpeg') OR ($_FILES['profile_photo']['type'] == 'image/png') OR ($_FILES['profile_photo']['type'] =='image/gif')) {
			      $type = $_FILES['profile_photo']['type'];
			      if ($type == "image/png"){
			      $pic_name = time() . ".png";
			      }else if ($type == "image/jpeg"){
			      $pic_name = time() . ".jpg";
			      }else if ($type == "image/gif"){
			      $pic_name = time() . ".gif";
			      }else{}
			      $pic_path = $upload_folder . $pic_name;
				  
			      require_once "includes/resize.php";
			      if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $pic_path)) {
				    $image = new Resize($pic_path);
				    $image->resizeImage(220, 220, 'crop');
				    $image->saveImage($pic_path);
					  
			      }
			      $sql9 = "UPDATE photos SET photo = '$pic_name' WHERE id = :id";
			      $db -> query($sql9, array('id' => $_POST['id']));
                              //("properties/".$_POST['photo']);
                              if ($_POST['photo'] != "no image.jpg"){
                                 unlink("properties/".$_POST['photo']);
                              }
			    echo "<div class='col-md-3 col-md-offset-4'>
                                <div class='alert alert-success'>  
                                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                    <strong>Success!</strong> Photo was changed.          
                                </div>
                            </div>";
                            
			
			     
	  }else {
		  echo"
                <div class='col-md-3 col-md-offset-4'>
                    <div class='alert alert-danger'>  
                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
                        <strong>Error!</strong> File format must be .jpg, .gif and .png.          
                    </div>
                </div>";
		}
	}else{
                   
	 //
	}
	
}
//Upload photo ends

//Add new photo
if(isset($_POST['add'])){ 
    $upload_folder = "./properties/";
	if(!empty($_FILES['profile_photo']['name'])) {
	  if (($_FILES['profile_photo']['type'] == 'image/jpeg') OR ($_FILES['profile_photo']['type'] == 'image/png') OR ($_FILES['profile_photo']['type'] =='image/gif')) {
			      $type = $_FILES['profile_photo']['type'];
			      if ($type == "image/png"){
			      $pic_name = time() . ".png";
			      }else if ($type == "image/jpeg"){
			      $pic_name = time() . ".jpg";
			      }else if ($type == "image/gif"){
			      $pic_name = time() . ".gif";
			      }else{}
			      $pic_path = $upload_folder . $pic_name;
				  
			      require_once "includes/resize.php";
			      if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $pic_path)) {
				    $image = new Resize($pic_path);
				    $image->resizeImage(220, 220, 'crop');
				    $image->saveImage($pic_path);
					  
			      }
			      //$sql9 = "UPDATE photos SET photo = '$pic_name' WHERE id = :id";
                              $sql9 = "INSERT INTO photos (photo_id, photo, member_id) VALUES (:photo_id, :photo, :member_id)";
			      $db -> query($sql9, array('photo_id' => $id, 'photo' => $pic_name, 'member_id' => $cout['member_id']));
                              //("properties/".$_POST['photo']);
                             
			    echo "<div class='col-md-3 col-md-offset-4'>
                                <div class='alert alert-success'>  
                                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                    <strong>Success!</strong> Photo was added.          
                                </div>
                            </div>";
                            
			
			     
	  }else {
		  echo"
                <div class='col-md-3 col-md-offset-4'>
                    <div class='alert alert-danger'>  
                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
                        <strong>Error!</strong> File format must be .jpg, .gif and .png.          
                    </div>
                </div>";
		}
	}else{
                   
	 //
	}
	
}
//Add photo ends
//Get number of photos
$count = "SELECT COUNT(*) AS num FROM photos WHERE photo_id = :id";
$query = $db->query($count, ['id' => $id])->fetch();
$res = $query['num'];

//statistics ends
$select = "SELECT * FROM offers WHERE id = :id";
$view_photo = "SELECT *, id AS _id FROM photos  WHERE photo_id = :photo_id";

echo "
<div class='container'>

    ";
foreach($db->query($select, array('id' => $id)) AS $result){
 
  
  
    echo "
   
    <div class='col-md-8 col-md-offset-3'>
        
        <span class='col-md-12'>
        
        <a href='' style='color:red;' class=''  data-toggle='modal'  data-target='#{$result['id']}'><i class='fa fa-trash'></i> Delete this property</a></br></br>
        <!-- Add a new photo-->
        <form action='' class='form-inline' form role='form' method='post' enctype='multipart/form-data'>
        <div class='form-group'>
        <input type='hidden' value='{$id}' name='id' class='form-control'>
        <input type='file' name='profile_photo' class='form-control'>
        </div>
        <input type='submit' name='add' value='Add Photo' class='btn btn-primary btn-sm'>
        </form>
        <!-- Add a photo ends-->
        <form action='' method='post' class='form-inline'>
            <input type='hidden' value='{$result['id']}' name='offer_id'>
            <textarea class='form-control input-lg' style='resize:none;' cols='40' rows='8'  name='desc'>{$result['description']}</textarea></br></br>
            <input type='submit' value='Update desc' name='update' class='btn btn-success btn-sm text-center'>
        </form>
        </span>
        <div class='modal fade' id='{$result['id']}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <form action='' method='post'>
                        <div class='modal-body'>
                            <p>Are you sure you want to delete this property?</p>
                            <input type='hidden' value='{$result['id']}' name='offer_id'>                               
                        </div>
                        <div class='modal-footer'>
                            <input type='submit' class='btn btn-success'   name='delete_offer' value='Delete'>
                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>  
                        </div>
                    </form>
                </div>
            </div> 
        </div>
    
   
    
   
     
    ";
}

foreach($db->query($view_photo, array('photo_id' => $id)) AS $result2){
   
    echo
    "
        <div class='col-md-6' style=''>
        
        <a href= 'properties/{$result2['photo']}' class=''>{$result2['photo']}</a>"; if(($result2['photo'] != "no image.jpg") && ($res > 1)){ echo" <a href='' style='color:red;' class=''  data-toggle='modal'  data-target='#_{$result2['id']}'><i class='fa fa-trash'></i></a> ";}echo"</br>
       
        <form action='' class='form-inline' method='post' enctype='multipart/form-data'>
        <input type='hidden' value='{$result2['id']}' name='id'>
        <input type='hidden' value='{$result2['photo']}' name='photo'> 
        <input type='file' name='profile_photo'>
        <input type='submit' name='upload' value='Update' class='btn btn-primary btn-sm'>
        </form>
        </div>
        
        
        <div class='modal fade' id='_{$result2['id']}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
        <div class='modal-dialog'>
            <div class='modal-content'>
                <form action='' method='post'>
                    <div class='modal-body'>
                        <p>Are you sure you want to delete this photo?</p>
                        <input type='hidden' value='{$result2['id']}' name='photo_id'>
                        <input type='hidden' value='{$result2['photo']}' name='photo'>
                                                       
                                                        
                    </div>
                    <div class='modal-footer'>
                        <input type='submit' class='btn btn-success'   name='delete' value='Delete'>
                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>  
                    </div>
                </form>
            </div>
        </div> 
    </div>
  
    ";
    
}

echo "

    </div>
</div>

";

?>