<?php
ob_start();
require_once "includes/layout.php";
require_once "db/db_handle.php";
$id = isset($_GET['id'])?$_GET['id']:"";
$location= urlencode($_SERVER['REQUEST_URI']);
$url = "http://www.offcampus.com.ng/blog_details.php?id=".$id;
?>
<html lang="en">
        <head>
            <title>Blog</title>
        </head>
        <body>
            <div class="container">
    <?php
        $id = isset($_GET['id'])?$_GET['id']:"";
                //Display an error message when blog post is no longer available
                $stat = "SELECT COUNT(*) AS num from blog WHERE id = :id";
                $cout = $db->query($stat, array('id' => $id))->fetch();
                if ($cout['num'] == '0'){
                      echo"
                        <div class='col-md-6 col-md-offset-3'>
                                        <div class='alert alert-danger'>
                                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                            <strong>Sorry!</strong> Blog post no longer exit.
                                        </div>
                        </div>";
                    exit;
                }
                //Error message stops
        $err = array(
        '01' => "Comment can not be empty.",
        '02' => "Only registered users can comment, <a href='login.php?location=blog_details.php?id=$id'>Login here</a>",
        '03' => "Comment posted",
        '04' => "Temporarily unable to comment, try again",
        //'05' => "Comment cant be empty",
        //'06' => "Comment updated"
         );
        $err_code = isset($_GET['err']) ? $_GET['err'] : null;
        
        if (isset($_POST['update'])){
                $param = array(
                               'comment' => trim($_POST['description']),
                               'post_id' => $_POST['comment_id']
                               );
                
                if (empty($param['comment'])){
                     //header("Location: blog_details.php?id=$id&err=05");   
                }else{
                        $update = "UPDATE comment SET comment = :comment WHERE id = :post_id";
                        $res = $db->query($update, $param);
                        //header("Location: blog_details.php?id=$id&err=06");
                }
        }
    if (isset($_POST['post'])){
        $data = array(
                      'comment' => trim($_POST['comment']),
                      'post_id' => $id,
                      'poster_id' => $_SESSION['id'],
                      'date' => date('Y-m-d H:i:s')
                     );
        
        if (isset($_SESSION['id']) == false){
                header("Location: blog_details.php?id=$id&err=02");
        }
        else if (empty($data['comment'])){
                header("Location: blog_details.php?id=$id&err=01");
        }else{
                $insert = "INSERT INTO comment (comment, post_id, poster_id, date)
                                VALUES
                                (:comment, :post_id, :poster_id, :date)";
                $query = $db->query($insert, $data);
                if ($query){
                        header("Location: blog_details.php?id=$id&err=03");     
                }else{
                       header("Location: blog_details.php?id=$id&err=04");
                       //echo "error";
                }
        }
    }
    
    $sql = "SELECT * FROM blog WHERE id = :id";
    
    //Counts the number of blog comments
    $comment = "SELECT COUNT(*) AS num FROM comment WHERE post_id = :id";
    $count = $db->query($comment, array('id' => $id))->fetch();
    //Count ends
    
    //Gets the details of comment and poster
    $poster = "SELECT m.*, c.*,  c.poster_id AS poster, c.id AS comment_id FROM users m JOIN comment c ON m.id = c.poster_id WHERE c.post_id = :id";
    //ends
    //Get details of blog post- title + full description
    foreach($db->query($sql, array('id' => $_GET['id'])) AS $result){
        $myDate = date('F j, Y g:i a', strtotime($result['date']));
        echo "<strong><h4>{$result['title']}</h4></strong>.<br>Posted: $myDate.<br>.
        {$result['description']}.</br>
        <!--Share property on social media- Facebook-->
                        </br></br>
                        <div class=''>
                            <strong>Share this post on</strong>: </br>
                            <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank' style='color:white;'><i class='fa fa-facebook' style='background-color: #4060A5; padding: .5em .50em;'></i></a>
                            <a href='https://twitter.com/share?url=$url' target='_blank' style='color:white;'><i class='fa fa-twitter' style='background-color: #55acee; padding: .5em .50em;'></i></a>
                            <a href='whatsapp://send?text={$result['title']}. Click on the link to readmore $url ' style='color:white;' data-action='share/whatsapp/share'><i class='fa fa-whatsapp' style='background-color: #25D366; padding: .5em .50em;'></i></a>
                        </div>
                        <!--Sharing ends-->
        <h3>Comments</h3>
        ";
        if ($count['num'] == '0'){ echo "
        <span class='text-danger'>No comments, be the first to comment!</span></br></br>";
        }else{
         foreach($db->query($poster, array('id' => $_GET['id'])) AS $result_2){
                $myDate = date('F j, Y g:i a', strtotime($result_2['date']));
                //echo    ('05' == $err_code) ? "<span class='text-info'>{$err['05']}</span></br>" : '';
                //echo    ('06' == $err_code) ? "<span class='text-info'>{$err['06']}</span></br>" : '';
                echo "
                {$result_2['comment']} </br><small>$myDate</small></br>
                
                ";
                if (isset($_SESSION['id']) == $result_2['poster']){
                        echo  "<a href=''  id='comment' data-toggle='modal' data-target='#{$result_2['comment_id']}'>Edit</a></br>";
                }
                echo"
                <em>{$result_2['name']}</em></br></br>
                
                
                <div class='modal fade' id='{$result_2['comment_id']}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <form action='' method='post'>
                                    <div class='modal-body'>                       
                                        <textarea style='border: none;' id='' class='form-control' name='description' placeholder='Type your message here'>{$result_2['comment']}</textarea>
                                        <input type='hidden' value='{$result_2['comment_id']}' name='comment_id'>
                                                                       
                                                                        
                                    </div>
                                    <div class='modal-footer'>
                                        <div id='length_status' class='pull-left'></div>
                                        <input type='submit' class='btn btn-success'   name='update' value='Update'>
                                        <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>  
                                    </div>
                                </form>
                            </div>
                        </div> 
                </div>
                
                
                
                ";
               
                //Comment + poster details     
         }
        }
        echo    ('01' == $err_code) ? "<span class='text-danger'>{$err['01']}</span>" : '';
        echo    ('02' == $err_code) ? "<span class='text-danger'>{$err['02']}</span>" : '';
        echo    ('03' == $err_code) ? "<span class='text-info'>{$err['03']}</span>" : '';
        echo    ('04' == $err_code) ? "<span class='text-danger'>{$err['04']}</span>" : '';
        
        echo"
        <form action='' class='form-horizontal' method='post'>
        <div class='form-group'>
            <div class='col-md-3'>
                <textarea name='comment' class='form-control'></textarea>
            </div>
        </div>
        <input type='submit' name='post' value='Post' class='btn btn-success btn-sm'>
        </form>
        ";
        
    }
    
?>

            </div>
        </body>
</html>