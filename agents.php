<?php
require_once "includes/header.php";
//require_once "include/banner_3.php";
require_once "db/db_handle.php";
require_once "admin_check.php";

?>
        <title>Agents</title>
            <div class='container'>
                <div class="col-md-12">
            <?php
                //Display an error message when no agent has signed up
                $stat = "SELECT COUNT(*) AS num from users WHERE category = :category";
                $cout = $db->query($stat, array('category' => 'agent'))->fetch();
                if ($cout['num'] == '0'){
                      echo"
                        <div class='col-md-6 col-md-offset-3'>
                                        <div class='alert alert-danger'>
                                            <a href='#' class='close' data-dismiss='alert'>&times;</a>
                                            <strong>Sorry!</strong> No agent has signed up.
                                        </div>
                        </div>";
                    exit;
                }
                //Error message stops
                $sql = "SELECT * FROM users ORDER BY id DESC";
                foreach($db->query($sql) AS $result){
                    echo "<strong>{$result['name']}</strong><br>
                    {$result['school']}<br><br>
                    ";                                                                               
                }
                
            ?>
                </div>
            </div>
      