<?php
require_once "includes/layout.php";
require_once "db/db_handle.php";

?>
        <title>Blog</title>
            <div class='container'>
                <div class="col-md-12">
            <?php
                //Display an error message when blog post is no longer available
                $stat = "SELECT COUNT(*) AS num from blog";
                $cout = $db->query($stat)->fetch();
                if ($cout['num'] == '0'){
                      echo"
                        <div class='col-md-6 col-md-offset-3'>
                                        <div class='alert alert-danger'>
                                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                            <strong>Sorry!</strong> No blog post yet.
                                        </div>
                        </div>";
                    exit;
                }
                //Error message stops
                $sql = "SELECT * FROM blog ORDER BY id DESC";
                foreach($db->query($sql) AS $result){
                    $rest = substr($result['description'], 0, 350);
                    echo "<strong><h4><u>{$result['title']}</u></h4></strong><br>
                    $rest
                    <a href='blog_details.php?id={$result['id']}'>...continue reading</a></br></br>";                                                                               
                }
                
            ?>
                </div>
            </div>
      