<?php
require_once "db/db_handle.php";
require_once "includes/layout2.php";
$location= urlencode($_SERVER['REQUEST_URI']);
if (isset($_SESSION['id']) == false){
  header ("Location: login.php?location=$location");
}

?>
<title>My favourite</title>
<?php
if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
    $start_from = ($page-1) * 6;

$query3 = "SELECT i.*, m.*, f.*, count(*) AS num FROM offers i
            JOIN users m ON m.id = i.member_id JOIN favourite f ON i.id = f.offer_id
            WHERE f.member_id = :session_id";

              $db -> query($query3, array('session_id' => $_SESSION['id'] ));
              $info3 = $db -> fetch();

              if ($info3['num'] == '0'){
                  echo "
                  <div class='container'>
                    <div class='alert alert-danger'>
                        <a href='#' class='close' data-dismiss='alert'>&times;</a>
                        <strong>Sorry!</strong> No property has been added to your favourite list.
                    </div>
                  </div>";
              }

$sql = "SELECT i.*, m.*, f.*, i.id AS id_count, FORMAT(price, 0) AS price FROM offers i
            JOIN users m ON m.id = i.member_id JOIN favourite f ON i.id = f.offer_id
            WHERE f.member_id = :session_id ORDER BY f.offer_id ASC LIMIT $start_from, 6";


echo "<div class='row'>
<div class='container'>
<div class='col-xs-12 col-sm-12 col-md-12'>
";

foreach ($db->query($sql, array('session_id' => $_SESSION['id'])) AS $result)
    {
      $newPrice = str_replace(".", ",", $result['price']);
      $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";
      $myDate = date('F j, Y g:i a', strtotime($result['date']));
      $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 91));

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


        echo "
          <div class='col-xs-12 col-sm-6 col-md-6' >
                 <div class='myfav'>
                  <div class='row'>
                      <div class='col-md-4'>
                      ";
                      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
                          echo "     <img src='properties/{$result2['photo']}' class='img-responsive' width = '300px' height ='' style=' '/>";
                      }   echo"
                      </div>


                      <div class='col-md-8'>
                            <div class='user_class col-md-12'>
                                <span style=''>
                                <i class='fa fa-university icon_color home_pad' style=''></i> {$result['school']}</br>
                                <i class='fa fa-home icon_color home_pad_2' style=''></i> <span class='home_pad_3'>{$result['accommodation']}</span></br>

                                "; if ($result['location'] != ''){ echo "<i class='fa fa-map-marker icon_color home_pad_4 style=''></i> {$result['location']}</br>"; } echo "
                                <i class='fa fa-money icon_color home_pad_5' style=''></i> <strong>&#x20a6;$newPrice </strong></span>
                            </div>
                            <div class='user_class col-md-12'>
                            <div class='row'>
                            <div class='col-md-12'>";
                            if (isset($_SESSION['id']) != false){
                              echo $follow_btn;
                            }else{

                            $follow_btn_1 = "<span class='btn btn-success following_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to Fav</span>";
                            echo $follow_btn_1;
                            echo"
                            <div class='modal fade' id='{$result['id_count']}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                                <div class='modal-dialog'>
                                    <div class='modal-content'>

                                        <div class='modal-body'>
                                           <p class='text-center follow_btn_p'><a href='login.php?location=$location' class='follow_btn_a'>You must login to use this feature. Click to login</a></p>
                                        </div>
                                        <div class='modal-footer'>
                                            <button type='button' class='btn btn-danger' data-dismiss='modal'>Cancel</button>

                                        </div>

                                    </div>
                                </div>
                            </div>";
                            }
                            echo "
                            <div class='pull-right' ><a href='readmore.php?id={$result['id_count']}' class='btn btn-success btn-sm btn' style=''>Details </a></div>
                            <!--Share property on social media- Facebook-->
                            </br></br>
                            <div class=''>
                              <strong>Share this property on</strong>: </br>
                              <a href='https://www.facebook.com/sharer/sharer.php?u=www.offcampus.com/readmore.php?id={$result['id_count']}' target='_blank' style='color:white;'><i class='fa fa-facebook' style='background-color: #4060A5; padding: .5em .50em;'></i></a>
                              <a href='https://twitter.com/share?url=www.offcampus.com/readmore.php?id={$result['id_count']}' target='_blank' style='color:white;'><i class='fa fa-twitter' style='background-color: #55acee; padding: .5em .50em;'></i></a>
                              <a href='whatsapp://send?text={$result['accommodation']} offcampus apartment at {$result['school']}. Click on the link for more details www.offcampus.com/readmore.php?id={$result['id_count']}  or call 08063321043' style='color:white;' data-action='share/whatsapp/share'><i class='fa fa-whatsapp' style='background-color: #25D366; padding: .5em .50em;'></i></a>
                            </div>
                            <!--Sharing ends-->
                            </div></div>
                            </br>

                      </div>
                    </div>
                </div>

            </div>
          </div>

        ";
    }



echo " </div></div></div>";
  //Pagination continues
$sql2 = "SELECT COUNT(id) FROM favourite WHERE member_id = :id";
$rs_result =  $db-> query($sql2, array('id' => $_SESSION['id']));
$row = $rs_result->fetch();
$total_records = $row[0];
$total_pages = ceil($total_records / 6);

echo "
<div class='col-md-12 text-center'>
<ul class='pagination  pag'>";
if ($total_pages != 1){
for ($i=1; $i<=$total_pages; $i++) {

    if ($page == $i)
           echo "<li class='active' >";
    else
           echo "<li>";

    echo "<a href='myfav.php?page=$i' >$i</a></li>";
};
}
echo "</ul></div>";
//Pagination stops
?>
