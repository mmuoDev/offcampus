<?php
require_once "includes/header.php";
require_once "db/db_handle.php";
require_once "admin_check.php";

$select = "SELECT * FROM blog WHERE id = :id";
$stmt = $db->query($select, array('id' => $_GET['id']));
while ($result = $stmt->fetch()){
    $title = $result['title'];
    $description = $result['description'];

}

 $err = array(
    '01' => "Changes were saved.",
    '02' => "Changes were not saved, try again."
 );
 $err_code = isset($_GET['err']) ? $_GET['err'] : null;
//Updates event details
$id = $_GET['id'];

if (isset($_POST['delete'])){
    $delete = "DELETE FROM blog WHERE id = :id";
    $query = $db->query($delete, array('id' => $id));
    header("Location: all_blog.php");
}

if (isset($_POST['update'])){

    $data = array(
                  'title' => $_POST['title'],
                  'description' => $_POST['description'],
                  'id' => $_GET['id']

                  );

    $update = "UPDATE blog SET title = :title, description = :description WHERE id = :id";
    $result = $db->query($update, $data);

     if ($result){
        header ("Location: edit_blog.php?err=01&id=$id");
    }else{
        header ("Location: edit_blog.php?err=02&id=$id");

    }
}
//Event updating ends
?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <title>Edit blog</title>
            <script>tinymce.init({ 
                selector:'textarea',
                plugins : 'image,autolink,link',
                toolbar: 'sizeselect | bold italic | fontselect |  fontsizeselect | image | link', 

                });</script>
        </head>
        <body>
            <div class="container">

                <!--Add a new event -->
                <div class="col-md-6 col-md-offset-3">
                    <?php
                    echo ('01' == $err_code) ? "<span class='text-success'>{$err['01']}</span>" : '';
                    echo ('02' == $err_code) ? "<span class='text-danger'>{$err['02']}</span>" : '';
                    ?>
                    <?php echo isset($_GET['m']) ? "<span class='text-danger'>Fill the compulsory fields completely</span>" : null; ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">title</label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo $title; ?>">
                        </div>
                        <div class="form-group">
                            <label for="desc">Description</label>
                            <textarea class="form-control" name="description" id="desc" class="form-control"><?php echo $description; ?></textarea>
                        </div>


                        <input type="submit" value="Update post" class="btn btn-success btn-sm" name="update">
                        <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#<?php echo $id; ?>">Delete post</a>
                    </form>

                    <div class='modal fade' id='<?php echo $id; ?>' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <form action='' method='post'>
                                    <div class='modal-body'>
                                        <p>Are you sure you want to delete this post?</p>
                                        <!--<input type='hidden' value='<?php /*echo $id; */?>' name='event_id'>-->
                                    </div>
                                    <div class='modal-footer'>
                                        <input type='submit' class='btn btn-danger btn-sm'   name='delete' value='Delete'>
                                        <button type='button' class='btn btn-default btn-sm' data-dismiss='modal'>Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
                    <!-- Event addition ends -->
                </div>
