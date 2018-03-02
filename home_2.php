<?php
ob_start();
require_once "includes/layout.php";

require_once "db/db_handle.php";
$location= urlencode($_SERVER['REQUEST_URI']);
?>
    <title>Search results</title>

  <?php

   echo "
    <div class=''>
     <div class='container'>
     <div class='col-xs-12 col-sm-12 col-md-12'>
    ";

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
              WHERE i.school = :school AND i.status = 'show'  AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business) ";

              $db -> query($query, array('school' => $_GET['school'], 'search' => '%'.$_GET['location'].'%', 'distance' => $_GET['distance'], 'water' => $_GET['water'], 'business' => $_GET['business']));
              $info = $db -> fetch();

              if ($info['num'] == '0'){
                  echo "<div class='alert alert-success'>

                      <a href='#' class='close' data-dismiss='alert'>&times;</a>

                      <strong>Sorry!</strong> No accommodation has been submitted under this category.

                  </div>";
              }
              $sql2 = "SELECT  i.*, m.*,  i.id AS id_count, FORMAT(price, 0) AS price, i.photo AS photos FROM offers i
                    JOIN users m ON m.id = i.member_id
                    WHERE i.school = :school AND i.status = 'show' AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business) ORDER BY i.id DESC LIMIT $start_from, 6 ";

              //AND (accommodation = 'one room' OR accommodation = 'one room self-contain' OR accommodation = 'room and parlor' OR accommodation = '2 bedroom flat' OR accommodation = '3 bedroom flat'

              foreach ($db->query($sql2, array('school' => $_GET['school'],  'search' => '%'.$_GET['location'].'%', 'distance' => $_GET['distance'], 'water' => $_GET['water'], 'business' => $_GET['business'])) AS $result)
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
                          $follow_btn = "<span class='btn btn-success btn-sm following'' data-clique_id='{$result['id_count']}' data-adder_id='{$_SESSION['id']}'>Drop from fav</span>";
                      }else {
                          // if the user is NOT following, show follow button
                          echo "<div class='hide' id='status'>Add to fav</div>";
                          $follow_btn = "<span class='btn btn-success btn-sm following'' id='{$result['id_count']}'>Add to fav</span>";
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
                                <span style='font-size: 30px'><strong>Price: &#x20a6;$newPrice </strong></span></br>
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

                            $follow_btn_1 = "<span class='btn btn-success btn-sm following'_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to fav</span>";
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
         $page_count2 = "SELECT COUNT(id) FROM offers WHERE school = :school AND status = 'show' AND price = :price AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business)";
         $rs_result =  $db-> query($page_count2, array('school' => $_GET['school'], 'price'=> $_GET['price'], 'search' => '%'.$_GET['location'].'%', 'distance' => $_GET['distance'], 'water' => $_GET['water'], 'business' => $_GET['business']) );
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

                   echo '<a href="home.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&distance='.$_GET['distance'].'&water='.$_GET['water'].'&business='.$_GET['business'].'&location='.'%'.$_GET['location'].'%'.'&page='.$i.'">'.$i.'</a></li>';
                };
            }
            echo "</ul></div>";
         //Pagination stops
  }
  else if ($_GET['accommodation']=="see all"){

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

              $query = "SELECT i.*, m.*, COUNT(*) AS num FROM offers i
              JOIN users m ON m.id = i.member_id
              WHERE i.school = :school AND i.status = 'show' AND (price >= :min_price AND price <= :max_price) AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business) ";

              $db -> query($query, array('school' => $_GET['school'], 'min_price' => $min_price, 'max_price' => $max_price, 'search' => '%'.$_GET['location'].'%', 'distance' => $_GET['distance'], 'water' => $_GET['water'], 'business' => $_GET['business']));
              $info = $db -> fetch();

              if ($info['num'] == '0'){
                  echo "<div class='alert alert-success'>

                      <a href='#' class='close' data-dismiss='alert'>&times;</a>

                      <strong>Sorry!</strong> No accommodation has been submitted under this category.

                  </div>";
              }
              $sql2 = "SELECT  i.*, m.*, i.id AS id_count, FORMAT(price, 0) AS price, i.photo AS photos FROM offers i
                    JOIN users m ON m.id = i.member_id
                    WHERE i.school = :school AND i.status = 'show' AND (price >= :min_price AND price <= :max_price) AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business) ORDER BY i.id DESC LIMIT $start_from, 6 ";

              //AND (accommodation = 'one room' OR accommodation = 'one room self-contain' OR accommodation = 'room and parlor' OR accommodation = '2 bedroom flat' OR accommodation = '3 bedroom flat'

              foreach ($db->query($sql2, array('school' => $_GET['school'], 'min_price' => $min_price,'max_price' => $max_price,  'search' => '%'.$_GET['location'].'%', 'distance' => $_GET['distance'], 'water' => $_GET['water'], 'business' => $_GET['business'])) AS $result)
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
                          $follow_btn = "<span class='btn btn-success btn-sm following'' data-clique_id='{$result['id_count']}' data-adder_id='{$_SESSION['id']}'>Drop from fav</span>";
                      }else {
                          // if the user is NOT following, show follow button
                          echo "<div class='hide' id='status'>Add to fav</div>";
                          $follow_btn = "<span class='btn btn-success btn-sm following'' id='{$result['id_count']}'>Add to fav</span>";
                      }
                }
                //Add Fav ends

                echo "
          <div >
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
                                <span style='font-size: 30px'><strong>Price: &#x20a6;$newPrice </strong></span></br>
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

                            $follow_btn_1 = "<span class='btn btn-success btn-sm following'_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to fav</span>";
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
         $page_count2 = "SELECT COUNT(id) FROM offers WHERE school = :school AND status = 'show' AND (price >= :min_price AND price <= :max_price) AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business)";
         $rs_result =  $db-> query($page_count2, array('school' => $_GET['school'], 'min_price'=> $min_price, 'max_price' => $max_price, 'search' => '%'.$_GET['location'].'%', 'distance' => $_GET['distance'], 'water' => $_GET['water'], 'business' => $_GET['business']) );
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

                   echo '<a href="home.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&distance='.$_GET['distance'].'&water='.$_GET['water'].'&business='.$_GET['business'].'&location='.'%'.$_GET['location'].'%'.'&page='.$i.'">'.$i.'</a></li>';
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
            WHERE i.school = :school AND i.status = 'hide' AND accommodation = :accommodation AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business)";

            $db -> query($query2, array('school' => $_GET['school'], 'accommodation' => $_GET['accommodation'], 'search' => '%'.$_GET['location'].'%', 'distance' => $_GET['distance'], 'water' => $_GET['water'], 'business' => $_GET['business']));
            $info2 = $db -> fetch();

            if ($info2['num'] == '0'){
                echo "<div class='alert alert-success'>

                    <a href='#' class='close' data-dismiss='alert'>&times;</a>

                    <strong>Sorry!</strong> No accommodation has been submitted under this category.

                </div>";
            }

            $sql3 = "SELECT i.*, m.*, i.id AS id_count, FORMAT(price, 0) AS price, i.photo AS photos FROM offers i
                    JOIN users m ON m.id = i.member_id
                    WHERE i.school = :school AND i.status = 'show' AND accommodation = :accommodation AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business) ORDER BY i.id DESC LIMIT $start_from, 6";

            foreach ($db->query($sql3, array('school' => $_GET['school'],  'accommodation' => $_GET['accommodation'], 'search' => '%'.$_GET['location'].'%', 'distance' => $_GET['distance'], 'water' => $_GET['water'], 'business' => $_GET['business'])) AS $result)
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
                              $follow_btn = "<span class='btn btn-success btn-sm following'' data-clique_id='{$result['id_count']}' data-adder_id='{$_SESSION['id']}'>Drop from fav</span>";
                          }else {
                              // if the user is NOT following, show follow button
                              echo "<div class='hide' id='status'>Add to fav</div>";
                              $follow_btn = "<span class='btn btn-success btn-sm following'' id='{$result['id_count']}'>Add to fav</span>";
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
                                <span style='font-size: 30px'><strong>Price: &#x20a6;$newPrice </strong></span></br>
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

                            $follow_btn_1 = "<span class='btn btn-success btn-sm following'_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to fav</span>";
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
         $page_count3 = "SELECT COUNT(id) FROM offers WHERE school = :school AND status = 'show' AND accommodation = :accommodation AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business)";
         $rs_result =  $db-> query($page_count3, array('school' => $_GET['school'], 'accommodation'=>$_GET['accommodation'], 'search' => '%'.$_GET['location'].'%', 'distance' => $_GET['distance'], 'water' => $_GET['water'], 'business' => $_GET['business']) );
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

                   echo '<a href="home.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&distance='.$_GET['distance'].'&water='.$_GET['water'].'&business='.$_GET['business'].'&location='.'%'.$_GET['location'].'%'.'&page='.$i.'">'.$i.'</a></li>';
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
                  'search' => '%'.$_GET['location'].'%',
                  'distance' => $_GET['distance'],
                  'water' => $_GET['water'],
                  'business' => $_GET['business'],
                  'min_price' => $min_price,
                  'max_price' => $max_price
              );
              if (isset($_GET['page'])) { $page  = $_GET['page']; } else { $page=1; };
              $start_from = ($page-1) * 6;

              $query = "SELECT i.*, m.*, COUNT(*) AS num FROM offers i
              JOIN users m ON m.id = i.member_id
              WHERE school = :school AND accommodation = :accommodation AND i.status = 'show'  AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business) AND (price >= :min_price AND price <= :max_price)";

              $db -> query($query, $param);
              $info = $db -> fetch();

              if ($info['num'] == '0'){
                  echo "<div class='alert alert-success'>

                      <a href='#' class='close' data-dismiss='alert'>&times;</a>

                      <strong>Sorry!</strong> No accommodation has been submitted under this category.

                  </div>";
              }

              $sql = "SELECT i.*, m.*, FORMAT(price, 0) AS price, i.id AS id_count FROM offers i
                  JOIN users m ON m.id = i.member_id
                  WHERE i.school = :school AND i.status = 'show' AND accommodation = :accommodation AND (price >= :min_price AND price <= :max_price) AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business) ORDER BY i.id DESC LIMIT $start_from, 6";



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
                                $follow_btn = "<span class='btn btn-success btn-sm following'' data-clique_id='{$result['id_count']}' data-adder_id='{$_SESSION['id']}'>Drop from fav</span>";
                            }else {
                                // if the user is NOT following, show follow button
                                echo "<div class='hide' id='status'>Add to fav</div>";
                                $follow_btn = "<span class='btn btn-success btn-sm following'' id='{$result['id_count']}'>Add to fav</span>";
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
                                <span style='font-size: 30px'><strong>Price: &#x20a6;$newPrice </strong></span></br>
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

                            $follow_btn_1 = "<span class='btn btn-success btn-sm following'_2' data-toggle='modal' data-target='#{$result['id_count']}'>Add to fav</span>";
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
         $page_count4 = "SELECT COUNT(id) FROM offers WHERE school = :school AND status = 'show' AND accommodation = :accommodation AND (price >= :min_price AND price <= :max_price) AND (location LIKE :search AND distance = :distance AND water = :water AND business = :business) ";
         $rs_result =  $db-> query($page_count4, array('school' => $_GET['school'], 'min_price' => $min_price, 'max_price' => $max_price, 'accommodation' => $_GET['accommodation'], 'search' => '%'.$_GET['location'].'%', 'distance' => $_GET['distance'], 'water' => $_GET['water'], 'business' => $_GET['business']) );
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

                   echo '<a href="home.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&distance='.$_GET['distance'].'&water='.$_GET['water'].'&business='.$_GET['business'].'&location='.'%'.$_GET['location'].'%'.'&page='.$i.'">'.$i.'</a></li>';
                };
            }
            echo "</ul></div>";
         //Pagination stops
      }
      echo "</div><div class='col-xs-12 col-md-3 col-sm-3 col-md-offset-2' >
      <form class='form-horizontal home_form' role='form' method='get' action=''>

          <div class='form-group'>
          <span class='home_text_2'>Your School</span><br class='clear'>
            <select name='school' class='form-control input-3x' id='school'>
                <option value='select' >select....</option>
                <option value='University of Lagos'"; if($_GET['school'] =='University of Lagos') print 'selected'; echo ">University of Lagos</option>
                <option value='Federal University of Technology, Owerri'"; if($_GET['school'] =='Federal University of Technology, Owerri') print 'selected'; echo ">Federal University of Technology, Owerri</option>
                 <option value='Lagos State University'"; if($_GET['school'] =='Lagos State University') print 'selected'; echo ">Lagos State University</option>
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
            <input type='text' name='location' placeholder='e.g. Dim Gate, Staff Quarters,' value='{$_GET['location']}'  class='home_select_box_2'>
          </div>

          <div class='form-group'>
            <span class='home_text_2'>Distance to School</span><br class='clear'>
            <input type='radio' name='distance' value='near' "; if($_GET['distance'] =='near') print 'checked'; echo">Near
            <input style='' type='radio' name='distance' value='far' "; if($_GET['distance'] =='far') print 'checked'; echo">Far
          </div>

          <div class='form-group'>
            <span class='home_text_2'>Water Source</span><br class='clear'>
            <input type='radio' name='water' value='tap' "; if($_GET['water'] =='tap') print 'checked'; echo">Borehole
            <input style='margin-left:5px;' type='radio' name='water' value='well' "; if($_GET['water'] =='well') print 'checked'; echo">Well
            <input style='margin-left:5px;' type='radio' name='water' value='both' "; if($_GET['water'] =='both') print 'checked'; echo">Both
          </div>
          <div class='form-group'>
            <span class='home_text_2'>Distance to a business  centre (Photocopy, Typing, Cybercafe, etc)</span><br class='clear'>
            <input type='radio' name='business' value='near' "; if($_GET['business'] =='near') print 'checked'; echo">Near
            <input style='margin-left:5px;' type='radio' name='business' value='far' "; if($_GET['business'] =='far') print 'checked'; echo">Far
          </div>
          <div class='form-group'>
            <input type='submit' name='submit' value='Refine search' class='btn btn-success btn-sm' style=''>
          </div>

          
        </form>




    </div>";
  }
?>

</div>
</div>
</div>
</body>
</html>
