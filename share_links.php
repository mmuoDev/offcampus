<?php
ob_start();
require_once "includes/layout2.php";
require_once "db/db_handle.php";


?>
<title>Share links</title>
<div class="container">
    <div class="row">    
        <div class="col-md-12"> 
            <form class="form-horizontal form"  role="form" method="POST" action="">
              <?php
              $count = "SELECT COUNT(*) AS num FROM roommate_request WHERE status = :status";
              $res = $db->query($count, ['status' => 'unresolved'])->fetch();
              if ($res['num'] == 0){
                  echo"<div class='alert alert-danger'>
                    <a href='#' class='close' data-dismiss='alert'>&times;</a>
                    <strong>Oooops. No links!</strong> You have no pending request for roommates                      
                </div>";
              }
              $select = 'SELECT a.*, b.*,a.id AS id, b.member_id AS member_id FROM roommate_links a JOIN roommate_request b ON b.id = a.request_id WHERE status = :status AND a.member_id = :member_id';
              foreach ($db->query($select, ['status' => 'unresolved', 'member_id' => $_SESSION['id']]) AS $items){
                  //$newPrice = str_replace(".", ",", $items['price']);
                  echo '<br>'."Link {$items['id']}:  <a href='{$items['share_link']}'>{$items['share_link']}</a>".'<br>'.
                        "<div class=''>
                        <a href='https://www.facebook.com/sharer/sharer.php?u={$items['share_link']}' target='_blank' style='color:white;'><i class='fa fa-facebook' style='background-color: #4060A5; padding: .5em .50em;'></i></a>
			<a href='https://twitter.com/share?url={$items['share_link']}' target='_blank' style='color:white;'><i class='fa fa-twitter' style='background-color: #55acee; padding: .5em .50em;'></i></a>
			<a href='whatsapp://send?text=I need a roommate who schools at {$items['school']}. Click on the link for more details: {$items['share_link']} or call 08063321043' style='color:white;' data-action='share/whatsapp/share'><i class='fa fa-whatsapp' style='background-color: #25D366; padding: .5em .50em;'></i></a>				
                    </div>";
              }
              ?>
                           
            </form>
        </div>
    </div>
</div>
