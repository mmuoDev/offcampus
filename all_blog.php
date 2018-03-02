<?php
require_once "includes/header.php";
//require_once "include/banner_3.php";
require_once "db/db_handle.php";
require_once "admin_check.php";

 $err = array(
    '01' => "Your post was submitted.",
    '02' => "Your post was not submitted, try again."
 );
 $err_code = isset($_GET['err']) ? $_GET['err'] : null;
if (isset($_POST['submit'])){

    $data = array(
                  'title' => $_POST['title'],
                  'description' => $_POST['description'],
                   'date' => date('Y-m-d H:i:s')

                  );

    $sql = "INSERT INTO blog (title, description, date)
            VALUES
            (:title, :description,  :date)";
    $query = $db->query($sql, $data);

    if ($query){
        header ("Location: all_blog.php?err=01");
    }else{
        header ("Location: all_blog.php?err=02");


    }

}



?>
<!DOCTYPE html>
    <html lang="en">
        <head>
            <title>Blog posts</title>
            <script>tinymce.init({ 
                selector:'textarea',
                plugins : 'image,autolink,link',
                toolbar: 'sizeselect | bold italic | fontselect |  fontsizeselect | image | link', 

                });</script>
        </head>
        <body>
            <div class="container">
                <!--Add a new event -->
                <div class="col-md-8">
                    <?php
                    echo ('01' == $err_code) ? "<span class='text-success'>{$err['01']}</span>" : '';
                    echo ('02' == $err_code) ? "<span class='text-danger'>{$err['02']}</span>" : '';
                    ?>
                    <?php echo isset($_GET['m']) ? "<span class='text-danger'>Fill the compulsory fields completely</span>" : null; ?>
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" name="title" id="title" value="">
                        </div>
                        <div class="form-group">
                            <label for="desc">Detail</label>
                            <textarea class="form-control" name="description" id="desc" class="form-control"></textarea>
                        </div>

                        <input type="submit" value="Post" class="btn btn-success btn-sm" name="submit">
                    </form>
                    <!-- Event addition ends -->
                </div>
                <div class="col-md-3 col-md-offset-1 login_form_2">
                    <h4><strong>All blog posts</strong></h4>
                    <?php
                    $select = "SELECT COUNT(*) AS num FROM blog ";
                    $count = $db->query($select)->fetch();
                    $num = $count['num'];
                    if ($num == ""){
                        echo "<span class='text-danger'>No blog posts have been added</span>";
                    }else{
                        $sql = "SELECT * FROM blog ORDER BY id DESC";
                        foreach($db->query($sql) AS $result){
                             $myDate = date('F j, Y g:i a', strtotime($result['date']));
                            echo "{$result['title']}.<br>
                            <em style='font-size: 13px;'>Added: $myDate</em></br>
                               <a href='edit_blog.php?id={$result['id']}'>Details</a></br></br>";


                        }
                    }

                    ?>
                </div>
            </div>

        </body>
    </html>
