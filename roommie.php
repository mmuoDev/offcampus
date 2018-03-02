<?php
require_once "includes/header.php";
//require_once "include/banner_3.php";
require_once "db/db_handle.php";
require_once "admin_check.php";

?>
        <title>Roommate requests</title>
            <div class='container'>
                <div class="col-md-12">
            <?php
                //Display an error message when no agent has signed up
                $stat = "SELECT COUNT(*) AS num from roommate_request a JOIN roommate_links b ON a.id = b.request_id";
                $cout = $db->query($stat)->fetch();
                if ($cout['num'] == '0'){
                      echo"
                        <div class='col-md-6 col-md-offset-3'>
                                        <div class='alert alert-danger'>
                                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                            <strong>Sorry!</strong> No roommate request.
                                        </div>
                        </div>";
                    exit;
                }
                //Error message stops
                $sql = "SELECT a.*, b.*, c.* FROM roommate_request a JOIN roommate_links b ON a.id = b.request_id JOIN users c ON c.id = a.member_id ORDER BY a.id DESC";
                foreach($db->query($sql) AS $result){
                    $url = $result['share_link'];
                    $school = $result['school'];
                    $name = $result['name'];
                    echo "<!--Share property on social media- Facebook-->
                     
                        <div class=''>
                            <strong>$name</strong>: </br>
                            <a href='https://www.facebook.com/sharer/sharer.php?u=$url' target='_blank' style='color:white;'><i class='fa fa-facebook' style='background-color: #4060A5; padding: .5em .50em;'></i></a>
                            <a href='https://twitter.com/share?url=$url' target='_blank' style='color:white;'><i class='fa fa-twitter' style='background-color: #55acee; padding: .5em .50em;'></i></a>
                            <a href='whatsapp://send?text=A roommate is needed at $school. Click on the link for more details $url or call 08063321043' style='color:white;' data-action='share/whatsapp/share'><i class='fa fa-whatsapp' style='background-color: #25D366; padding: .5em .50em;'></i></a>
                        </div>
                        <!--Sharing ends-->
                    <br><br>
                    ";                                                                               
                }
                
            ?>
                </div>
            </div>
      