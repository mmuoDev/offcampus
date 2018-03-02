<?php
ob_start();
require_once "includes/layout.php";

require_once "db/db_handle.php";


?>
    <title>Search results</title>
    <?php
   echo "

    <div class='container'>
    <div class = ''>

   ";
  $location= urlencode($_SERVER['REQUEST_URI']);
  if (isset ($_GET['submit'])){

  echo "

    <div class='col-xs-12 col-md-7 col-sm-7 '>
    <div class='row'>
      <div class='col-md-6'>
          <div class='alert alert-danger'>
            <a href='#' class='close' data-dismiss='alert'>&times;</a>
              <strong>Can't find what you are looking for? Call or WhatsApp us on 080 6332 1043</strong> 
          </div>
      </div>
    </div>
    ";
  if ($_GET['accommodation'] == "see all" AND $_GET['price']=="see all"){
              if (isset($_GET['page'])) { $page  = $_GET['page']; } else { $page=1; };
              $start_from = ($page-1) * 6;

              $query = "SELECT i.*, m.*, COUNT(*) AS num FROM offers i
              JOIN users m ON m.id = i.member_id
              WHERE i.school = :school AND i.status = 'show'";

              $db -> query($query, array('school' => $_GET['school']));
              $info = $db -> fetch();

              if ($info['num'] == '0'){
                  echo "<div class='alert alert-success'>

                      <a href='#' class='close' data-dismiss='alert'>&times;</a>

                      <strong>Sorry!</strong> No accommodation has been submitted under this category.

                  </div>";
              }
              $sql2 = "SELECT  i.*, m.*, FORMAT(price, 0) AS price, i.id AS id_count FROM offers i
                    JOIN users m ON m.id = i.member_id
                    WHERE i.school = :school AND i.status = 'show' ORDER BY i.id DESC LIMIT $start_from, 6 ";

              //AND (accommodation = 'one room' OR accommodation = 'one room self-contain' OR accommodation = 'room and parlor' OR accommodation = '2 bedroom flat' OR accommodation = '3 bedroom flat'

              foreach ($db->query($sql2, array('school' => $_GET['school'])) AS $result)
              {
                $newPrice = str_replace(".", ",", $result['price']);
                $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";
                $myDate = date('F j, Y g:i a', strtotime($result['date']));
                $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 91));

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
          <div>
                 <div class='user_sec_fav'>
                  <div class='row'>
                      <div class='col-md-4'>
                      ";
                      //Displays property Image
                      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){

                          echo "<img src='properties/{$result2['photo']}' class='img-responsive' width = '300px' height ='' style=' '/>";
                      }   echo"
                      </div>

                      <!-- Property details -->
                      <div class='col-md-6' style=''>
                            <div class='user_class col-md-12'>
                                <span style='font-size: 30px'><strong> &#x20a6;$newPrice </strong></span></br>
                                <i class='fa fa-university icon_color home_pad' style=''></i> {$result['school']}</br>
                                <i class='fa fa-home icon_color home_pad_2' style=''></i> <span class='home_pad_3'>{$result['accommodation']}</span></br>

                                "; if ($result['location'] != ''){ echo "<i class='fa fa-map-marker icon_color home_pad_4 style=''></i> {$result['location']}</br>"; } echo "

                            </div>
                            <div class='user_class col-md-12'>
                              <div class='row'>
                                <div class='col-md-12'>";
                                  if (isset($_SESSION['id']) != false){
                                    echo $follow_btn;
                                  }else{

                                  $follow_btn_1 = "<span class='btn btn-success btn-sm following_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to fav</span>";
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
                                  <div class='pull-right' ><a href='readmore.php?id={$result['id_count']}' class='btn btn-success btn-sm' style=''>Details </a></div>
                                </div>
                              </div>
                            </div>
                    </div>
                </div>

            </div>
          </div>

        ";
              }
     //echo " </div>";
      //Pagination continues
$page_count2 = "SELECT COUNT(id) FROM offers WHERE school = :school AND status = 'show'";
$rs_result =  $db-> query($page_count2, array('school' => $_GET['school']));
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

   echo '<a href="home.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&page='.$i.'">'.$i.'</a></li>';
};
}
echo "</ul></div>";
//Pagination stops


  }
  else if ($_GET['accommodation']=="see all"){
              if ($_GET['price'] == "0-50,000"){
                $min_price = 0;
                $max_price = 50000;
              }
              else if ($_GET['price'] == "50,000-100,000"){
                $min_price = 50000;
                $max_price = 100000;
               }else if ($_GET['price'] == "100,000-150,000"){
                $min_price = 100000;
                $max_price = 150000;

               }
               else if($_GET['price'] == "150,000-200,000"){
                $min_price = 150000;
                $max_price = 200000;
               }
               else if ($_GET['price'] == "200,000 and above"){
                $min_price = 200000;
                $max_price = 1000000;

               }else{}

              if (isset($_GET['page'])) { $page  = $_GET['page']; } else { $page=1; };
              $start_from = ($page-1) * 6;

              $query = "SELECT i.*, m.*, COUNT(*) AS num FROM offers i
              JOIN users m ON m.id = i.member_id
              WHERE i.school = :school AND i.status = 'show' AND (price >= :min_price AND price <= :max_price)";

              $db -> query($query, array('school' => $_GET['school'], 'min_price' => $min_price, 'max_price' => $max_price));
              $info = $db -> fetch();

              if ($info['num'] == '0'){
                  echo "<div class='alert alert-success'>

                      <a href='#' class='close' data-dismiss='alert'>&times;</a>

                      <strong>Sorry!</strong> No accommodation has been submitted under this category.

                  </div>";
              }
              $sql2 = "SELECT  i.*, m.*, i.id AS id_count, FORMAT(price, 0) AS price FROM offers i
                    JOIN users m ON m.id = i.member_id
                    WHERE i.school = :school AND i.status = 'show' AND (price >= :min_price AND price <= :max_price) ORDER BY i.id DESC LIMIT $start_from, 6 ";

              //AND (accommodation = 'one room' OR accommodation = 'one room self-contain' OR accommodation = 'room and parlor' OR accommodation = '2 bedroom flat' OR accommodation = '3 bedroom flat'

              foreach ($db->query($sql2, array('school' => $_GET['school'],  'min_price' => $min_price, 'max_price' => $max_price)) AS $result)
              {
                $newPrice = str_replace(".", ",", $result['price']);
                $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";

                $myDate = date('F j, Y g:i a', strtotime($result['date']));
                $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 91));

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
          <div>
                 <div class='user_sec_fav'>
                  <div class='row'>
                      <div class='col-md-4'>
                      ";
                      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
                          echo "     <img src='properties/{$result2['photo']}' class='img-responsive' width = '300px' height ='' style=' '/>";
                      }   echo"
                      </div>


                      <div class='col-md-6'>
                            <div class='user_class col-md-12'>
                                <span style=''>

                                <span style='font-size: 30px'><strong> &#x20a6;$newPrice </strong></span></br>
                                <i class='fa fa-university icon_color home_pad' style=''></i> {$result['school']}</br>
                                <i class='fa fa-home icon_color home_pad_2' style=''></i> <span class='home_pad_3'>{$result['accommodation']}</span></br>

                                "; if ($result['location'] != ''){ echo "<i class='fa fa-map-marker icon_color home_pad_4 style=''></i> {$result['location']}</br>"; } echo "

                            </div>
                            <div class='user_class col-md-12'>
                            <div class='row'>
                            <div class='col-md-12'>";
                            if (isset($_SESSION['id']) != false){
                              echo $follow_btn;
                            }else{

                            $follow_btn_1 = "<span class='btn btn-success btn-sm following_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to fav</span>";
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
                            <div class='pull-right' ><a href='readmore.php?id={$result['id_count']}' class='btn btn-success btn-sm' style=''>Details </a></div>
                            </div></div>
                            </br>

                      </div>
                    </div>
                </div>

            </div>
          </div>

        ";
              }
     //echo " </div>";
      //Pagination continues
$page_count2 = "SELECT COUNT(id) FROM offers WHERE school = :school AND (price >= :min_price AND price <= :max_price) AND status = 'show'";
$rs_result =  $db-> query($page_count2, array('school' => $_GET['school'], 'min_price' => $min_price, 'max_price' => $max_price));
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

   echo '<a href="home.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&page='.$i.'">'.$i.'</a></li>';
};
}
echo "</ul></div>";
//Pagination stops
  }
  else if ($_GET['price']=="see all"){


            if (isset($_GET['page'])) { $page  = $_GET['page']; } else { $page=1; };
              $start_from = ($page-1) * 6;

            $query2 = "SELECT i.*, m.*, COUNT(*) AS num FROM offers i
            JOIN users m ON m.id = i.member_id
            WHERE i.school = :school AND i.status = 'show' AND accommodation = :accommodation";

            $db -> query($query2, array('school' => $_GET['school'], 'accommodation' => $_GET['accommodation']));
            $info2 = $db -> fetch();

            if ($info2['num'] == '0'){
                echo "<div class='alert alert-success'>

                    <a href='#' class='close' data-dismiss='alert'>&times;</a>

                    <strong>Sorry!</strong> No accommodation has been submitted under this category.

                </div>";
            }

            $sql3 = "SELECT i.*, m.*, i.id AS id_count, FORMAT(price, 0) AS price FROM offers i
                    JOIN users m ON m.id = i.member_id
                    WHERE i.school = :school  AND accommodation = :accommodation AND i.status = 'show' ORDER BY i.id DESC LIMIT $start_from, 6";

            foreach ($db->query($sql3, array('school' => $_GET['school'],  'accommodation' => $_GET['accommodation'])) AS $result)
            {
              $newPrice = str_replace(".", ",", $result['price']);
              $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";
              $myDate = date('F j, Y g:i a', strtotime($result['date']));
              $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 91));

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
          <div>
                 <div class='user_sec_fav'>
                  <div class='row'>
                      <div class='col-md-4'>
                      ";
                      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
                          echo "     <img src='properties/{$result2['photo']}' class='img-responsive' width = '300px' height ='' style=' '/>";
                      }   echo"
                      </div>


                      <div class='col-md-6'>
                            <div class='user_class col-md-12'>
                                <span style=''>
                                <span style='font-size: 30px'><strong> &#x20a6;$newPrice </strong></span></br>
                                <i class='fa fa-university icon_color home_pad' style=''></i> {$result['school']}</br>
                                <i class='fa fa-home icon_color home_pad_2' style=''></i> <span class='home_pad_3'>{$result['accommodation']}</span></br>

                                "; if ($result['location'] != ''){ echo "<i class='fa fa-map-marker icon_color home_pad_4 style=''></i> {$result['location']}</br>"; } echo "

                            </div>
                            <div class='user_class col-md-12'>
                            <div class='row'>
                            <div class='col-md-12'>";
                            if (isset($_SESSION['id']) != false){
                              echo $follow_btn;
                            }else{

                            $follow_btn_1 = "<span class='btn btn-success btn-sm following_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to fav</span>";
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
                            <div class='pull-right' ><a href='readmore.php?id={$result['id_count']}' class='btn btn-success btn-sm' style=''>Details </a></div>
                            </div></div>
                            </br>

                      </div>
                    </div>
                </div>

            </div>
          </div>

        ";
      }
                //echo " </div>";
            //Pagination continues
      $page_count3 = "SELECT COUNT(id) FROM offers WHERE school = :school AND accommodation = :accommodation AND status = 'show'";
      $rs_result =  $db-> query($page_count3, array('school' => $_GET['school'], 'accommodation' => $_GET['accommodation']));
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

           echo '<a href="home.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&page='.$i.'">'.$i.'</a></li>';
        };
        }
        echo "</ul></div>";
      //Pagination stops

  }
  else if ($_GET['accommodation'] == "" OR $_GET['price']=="" OR $_GET['school']==""){

          echo "<div class='alert alert-success'>

                      <a href='#' class='close' data-dismiss='alert'>&times;</a>

                      <strong>Sorry!</strong> You must select an option!

                </div>";
  }
  else {

              if (isset($_GET['page'])) { $page  = $_GET['page']; } else { $page=1; };
              $start_from = ($page-1) * 6;
              if ($_GET['price'] == "0-50,000"){
                $min_price = 0;
                $max_price = 50000;
              }
              else if ($_GET['price'] == "50,000-100,000"){
                $min_price = 50000;
                $max_price = 100000;
               }else if ($_GET['price'] == "100,000-150,000"){
                $min_price = 100000;
                $max_price = 150000;

               }
               else if($_GET['price'] == "150,000-200,000"){
                $min_price = 150000;
                $max_price = 200000;
               }
               else if ($_GET['price'] == "200,000 and above"){
                $min_price = 200000;
                $max_price = 1000000;

               }else{}
              $param= array(
                  'school' => $_GET['school'],
                  'accommodation' => $_GET['accommodation'],
                  'min_price' => $min_price,
                  'max_price' => $max_price

              );

              $query = "SELECT i.*, m.*, COUNT(*) AS num FROM offers i
              JOIN users m ON m.id = i.member_id
              WHERE i.school = :school AND i.status = 'show' AND accommodation = :accommodation AND (price >= :min_price AND price <= :max_price) ";

              $db -> query($query, $param);
              $info = $db -> fetch();

              if ($info['num'] == '0'){
                  echo "<div class='alert alert-success'>

                      <a href='#' class='close' data-dismiss='alert'>&times;</a>

                      <strong>Sorry!</strong> No accommodation has been submitted under this category.

                  </div>";
              }

              $sql = "SELECT i.*, m.*, i.id AS id_count, FORMAT(price, 0) AS price FROM offers i
                  JOIN users m ON m.id = i.member_id
                  WHERE i.school = :school AND accommodation = :accommodation AND i.status = 'show' AND (price >= :min_price AND price <= :max_price) ORDER BY i.id DESC LIMIT $start_from, 6";



              foreach ($db->query($sql, $param) AS $result)
              {
                $newPrice = str_replace(".", ",", $result['price']);
                $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";

                $myDate = date('F j, Y g:i a', strtotime($result['date']));
                $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 91));

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
          <div>
                 <div class='user_sec_fav'>
                  <div class='row'>
                      <div class='col-md-4'>
                      ";
                      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
                          echo "     <img src='properties/{$result2['photo']}' class='img-responsive' width = '300px' height ='' style=' '/>";
                      }   echo"
                      </div>


                      <div class='col-md-6'>
                            <div class='user_class col-md-12'>
                                <span style=''>
                                <span style='font-size: 30px'><strong> &#x20a6;$newPrice </strong></span></br>
                                <i class='fa fa-university icon_color home_pad' style=''></i> {$result['school']}</br>
                                <i class='fa fa-home icon_color home_pad_2' style=''></i> <span class='home_pad_3'>{$result['accommodation']}</span></br>

                                "; if ($result['location'] != ''){ echo "<i class='fa fa-map-marker icon_color home_pad_4 style=''></i> {$result['location']}</br>"; } echo "

                            </div>
                            <div class='user_class col-md-12'>
                            <div class='row'>
                            <div class='col-md-12'>";
                            if (isset($_SESSION['id']) != false){
                              echo $follow_btn;
                            }else{

                            $follow_btn_1 = "<span class='btn btn-success btn-sm following_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to fav</span>";
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
                            <div class='pull-right' ><a href='readmore.php?id={$result['id_count']}' class='btn btn-success btn-sm' style=''>Details </a></div>
                            </div></div>
                            </br>

                      </div>
                    </div>
                </div>

            </div>
          </div>

        ";
            }
            //echo " </div>";
            //Pagination continues
            $page_count4 = "SELECT COUNT(id) FROM offers WHERE school = :school AND status = 'show' AND accommodation = :accommodation AND (price >= :min_price AND price <= :max_price)";
            $rs_result =  $db-> query($page_count4, array('school' => $_GET['school'], 'accommodation' => $_GET['accommodation'], 'min_price' => $min_price, 'max_price' => $max_price));
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

               echo '<a href="home.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&page='.$i.'">'.$i.'</a></li>';
            };
            }
            echo "</ul></div>";
            //Pagination stops
      }

    echo "</div>

    <div class='col-xs-12 col-md-3 col-sm-3 col-md-offset-2' style=''>

      <form class='form-horizontal' role='form' method='get' action='home_2.php'>

          <div class='form-group'>
          <span class='home_text_2'>Your School</span><br class='clear'>
            <select name='school' class='form-control input-3x ' id=''>
                <option value='select' >select....</option>



                <option value='Lagos State University'"; if($_GET['school'] =='Lagos State University') print 'selected'; echo ">Lagos State University</option>
                 <option value='Federal University of Technology, Akure'"; if($_GET['school'] =='Federal University of Technology, Akure') print 'selected'; echo ">Federal University of Technology, Akure</option>
                <option value='University of Lagos'"; if($_GET['school'] =='University of Lagos') print 'selected'; echo ">University of Lagos</option>
                <option value='University of Ibadan'"; if($_GET['school'] =='University of Ibadan') print 'selected'; echo ">University of Ibadan</option>

                <option value='Ladoke Akintola University of Technology'"; if($_GET['school'] =='Ladoke Akintola University of Technology') print 'selected'; echo ">Ladoke Akintola University of Technology</option>
            </select>
            </div>

             <div class='form-group'>
            <span class='home_text_2'>Accommodation</span><br class='clear'>
            <select name='accommodation' id='accommodation' class='form-control input-3x'>
                <option value='' >Accommodation Type</option>
                <option value='one room'"; if($_GET['accommodation'] =='one room') print 'selected'; echo ">One Room</option>
                <option value='one room self-contain' "; if($_GET['accommodation'] =='one room self-contain') print 'selected'; echo ">One Room Self-Contain</option>
                <option value='room and parlor' "; if($_GET['accommodation'] =='room and parlor') print 'selected'; echo ">Room and Parlour</option>
                <option value='2 bedroom flat'"; if($_GET['accommodation'] =='2 bedroom flat') print 'selected'; echo ">2 Bedroom Flat</option>
                <option value='3 bedroom flat'"; if($_GET['accommodation'] =='3 bedroom flat') print 'selected'; echo ">3 Bedroom Flat</option>
                <option value='see all' "; if($_GET['accommodation'] =='see all') print 'selected'; echo ">See All</option>
            </select>
            </div>


            <div class='form-group'>
                <span class='home_text_2'>Budget</span><br class='clear'>
                <select name='price' id='price' class='form-control input-3x'>
                    <option value='' >Price Range.</option>
                    <option value='0-50,000' "; if($_GET['price'] =='0-50,000') print 'selected'; echo">0 - 50,000</option>
                    <option value='50,000-100,000' "; if($_GET['price'] =='50,000-100,000') print 'selected'; echo">50,000 - 100,000</option>
                    <option value='100,000-150,000' "; if($_GET['price'] =='100,000-150,000') print 'selected'; echo">100,000 - 150,000</option>
                    <option value='150,000-200,000' "; if($_GET['price'] =='150,000-200,000') print 'selected'; echo">150,000 - 200,000</option>
                    <option value='200,000 and above' "; if($_GET['price'] =='200,000 and above') print 'selected'; echo">200,000 and above</option>
                    <option value='see all' "; if($_GET['price'] =='see all') print 'selected'; echo">See All</option>

                </select>

              </div>


          <div class='form-group'>
            <span class='home_text_2'>Exact Location</span><br class='clear'>
            <input type='text' name='location' placeholder='e.g. Dim Gate, Staff Quarters,'  class='home_select_box_2'>
          </div>

          <div class='form-group'>
            <span class='home_text_2'>Distance to School</span><br class='clear'>
            <input type='radio' name='distance' value='near' checked>Near
            <input style='' type='radio' name='distance' value='far'>Far
          </div>

          <div class='form-group'>
            <span class='home_text_2'>Water Source</span><br class='clear'>
            <input type='radio' name='water' value='tap'>Borehole
            <input style='margin-left:5px;' type='radio' name='water' value='well'>Well
            <input style='margin-left:5px;' type='radio' name='water' value='both' checked>Both
          </div>
          <div class='form-group'>
            <span class='home_text_2'>Distance to a business  centre (Photocopy, Typing, Cybercafe, etc)</span><br class='clear'>
            <input type='radio' name='business' value='near' checked>Near
            <input style='margin-left:5px;' type='radio' name='business' value='far'>Far
          </div>
          <div class='form-group'>
            <input type='submit' name='submit' value='Refine search' class='btn btn-success btn-sm' style=' '>
          </div>

          
        </form>
    </div>";
    }



    //When the user is not seraching, display the 6 newest posts
    else{
      //Pagination starts
      if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
      $start_from = ($page-1) * 6;
      //Pagination stops
      echo"<div class=''>
            <div class='container'>
                <div class='col-xs-12 col-sm-12 col-md-12'>
                   ";

              $new_sql = "SELECT i.*, m.*, i.id AS id_count, FORMAT(price, 0) AS price FROM offers i
                  JOIN users m ON m.id = i.member_id WHERE i.status = 'show' ORDER BY i.id DESC LIMIT $start_from, 6
                  ";

              foreach ($db->query($new_sql) AS $result)
              {
                $newPrice = str_replace(".", ",", $result['price']);
                $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";

                $myDate = date('F j, Y g:i a', strtotime($result['date']));
                $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 50));

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
          <div class='col-xs-12 col-sm-6 col-md-6' >
                 <div class='user_sec_fav'>
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
                                <span style='font-size: 30px'><strong> &#x20a6;$newPrice </strong></span></br>
                                <i class='fa fa-university icon_color home_pad' style=''></i> {$result['school']}</br>
                                <i class='fa fa-home icon_color home_pad_2' style=''></i> <span class='home_pad_3'>{$result['accommodation']}</span></br>

                                "; if ($result['location'] != ''){ echo "<i class='fa fa-map-marker icon_color home_pad_4 style=''></i> {$result['location']}</br>"; } echo "

                            </div>
                            <div class='user_class col-md-12'>
                            <div class='row'>
                            <div class='col-md-12'>";
                            if (isset($_SESSION['id']) != false){
                              echo $follow_btn;
                            }else{

                            $follow_btn_1 = "<span class='btn btn-success btn-sm following_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to fav</span>";
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
                            <span class='' style='' ><a href='readmore.php?id={$result['id_count']}' class='btn btn-success btn-sm' style=''>Details </a></span>
                            </div></div>
                            </br>

                      </div>
                    </div>
                </div>

            </div>
          </div>

        ";
  }
  echo "</div></div></div>";

  //Pagination continues

$sql2 = "SELECT COUNT(id) FROM offers WHERE status = 'show' ORDER BY id DESC";
$rs_result =  $db-> query($sql2);
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

    echo "<a href='home.php?page=$i' >$i</a></li>";
};
}
echo "</ul></div>";
//Pagination stops


  }
?>
</div>
</div>


</body>
</html>
