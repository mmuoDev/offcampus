<?php
ob_start();
//$location= urlencode($_SERVER['REQUEST_URI']);
require_once "db/db_handle.php";
require_once "includes/layout2.php";
?>
<title>Search results</title>
<div class="row">
<div class='container'>

      <div class='col-xs-12 col-sm-12 col-md-12'>

<?php

  if (isset($_GET['submit'])){

      if ($_GET['accommodation'] == "see all" AND $_GET['price']=="see all"){

            if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
            $start_from = ($page-1) * 6;

              $query3 = "SELECT i.*, m.*, COUNT(*) AS num FROM offers i
              JOIN users m ON m.id = i.member_id
              WHERE i.member_id = :id AND i.status = 'show' AND i.school = :school";

              $db -> query($query3, array('id' => $_SESSION['id'], 'school' => $_GET['school']));
              $info3 = $db -> fetch();

              if ($info3['num'] == '0'){
                  echo "<div class='alert alert-success'>

                      <a href='#' class='close' data-dismiss='alert'>&times;</a>

                      <strong>Sorry!</strong> You have not submitted any property under this category.

                  </div>";
              }


              $sql4 = "SELECT i.*, m.*, i.id AS id_count, i.status AS status FROM offers i
                  JOIN users m ON m.id = i.member_id
                  WHERE i.school = :school AND i.member_id = :id  ORDER BY i.id ASC LIMIT $start_from, 6";

              foreach ($db->query($sql4, array('school' => $_GET['school'], 'id' => $_SESSION['id'])) AS $result)
              {
                  $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";

                  $myDate = date('F j, Y g:i a', strtotime($result['date']));
                  $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 91));




             echo "
            <div class='col-xs-12 col-sm-6 col-md-6'>
              <div class='user_sec_fav' >
                  <div class='row'>
                      <div class='col-md-4'>
                      ";
                      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
                          echo "     <img src='properties/{$result2['photo']}' class='img-responsive' width = '300px' style=' '/>";
                      }   echo"
                      </div>

                      <div class='col-md-8'>
                            <div class='user_class col-md-12'><span style='opacity:0.5;'><span style='text-transform: capitalize;'> {$result['accommodation']}</span> | {$result['school']} | Added: $myDate  <span class='user_4'> </span></span> </div>
                            <div class='user_class col-md-12'>
                            <div class='row'>
                            <div class='col-md-12'>

                            <a href=''   data-toggle='modal' data-target='#{$result['id_count']}' class='btn btn-danger btn-sm pull-left'>Delete</a>
                            "; if ($result['status'] == "show"){ echo"
                            <a href='hide.php?id={$result['id_count']}&action=hide' class='btn btn-success btn-sm pull-right'>Hide this </a>
                            "; } else if ($result['status'] == "hide"){ echo"
                            <a href='show.php?id={$result['id_count']}&action=show' class='btn btn-success btn-sm pull-right'>Show this</a>
                            ";}echo"
                            </div></div>
                            </br>

                      </div>
                  </div>
                </div>

            </div>
          </div>

      <div class='modal fade' id='{$result['id_count']}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>

                                </div>
                                <div class='modal-body'>

                                   <p style=''> Are you sure you want to delete this property?</p>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                                    <a href='delete_offer.php?id={$result['id_count']}' class='btn btn-danger danger'>Delete</a>
                                </div>

                            </div>
                        </div>
                    </div>
    ";
            }
                  echo " </div>";
                 //Pagination continues
               $page_count = "SELECT COUNT(id) FROM offers WHERE school = :school AND member_id = :id ";
               $rs_result =  $db-> query($page_count, array('school' => $_GET['school'], 'id' => $_SESSION['id']));
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

                    echo '<a href="search.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&page='.$i.'">'.$i.'</a></li>';
                };
                }
                echo "</ul></div>";
         //Pagination stops
  }
  else if ($_GET['accommodation']=="see all"){

                  if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
                  $start_from = ($page-1) * 6;

              $query = "SELECT i.*, m.*, COUNT(*) AS num FROM offers i
              JOIN users m ON m.id = i.member_id
              WHERE i.member_id = :id AND i.school = :school AND price = :price";

              $db -> query($query, array('id' => $_SESSION['id'], 'school' => $_GET['school'], 'price' => $_GET['price']));
              $info = $db -> fetch();

              if ($info['num'] == '0'){
                  echo "<div class='alert alert-success'>

                      <a href='#' class='close' data-dismiss='alert'>&times;</a>

                      <strong>Sorry!</strong> You have not submitted any property under this category.

                  </div>";
              }
              $sql2 = "SELECT  i.*, m.*, i.status AS status, i.id AS id_count FROM offers i
                    JOIN users m ON m.id = i.member_id
                    WHERE i.member_id = :id AND i.school = :school AND price = :price ORDER BY i.id ASC LIMIT $start_from, 6";

              //AND (accommodation = 'one room' OR accommodation = 'one room self-contain' OR accommodation = 'room and parlor' OR accommodation = '2 bedroom flat' OR accommodation = '3 bedroom flat'

              foreach ($db->query($sql2, array('id' => $_SESSION['id'], 'school' => $_GET['school'],  'price' => $_GET['price'])) AS $result)
              {
                  $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";

                  $myDate = date('F j, Y g:i a', strtotime($result['date']));
                  $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 91));



                echo "
            <div class='col-xs-12 col-sm-6 col-md-6'>
              <div class='user_sec_fav' >
                  <div class='row'>
                      <div class='col-md-4'>
                      ";
                      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
                          echo "     <img src='properties/{$result2['photo']}' class='img-responsive' width = '300px' style=' '/>";
                      }   echo"
                      </div>

                      <div class='col-md-8'>
                            <div class='user_class col-md-12'><span style='opacity:0.5;'><span style='text-transform: capitalize;'> {$result['accommodation']}</span> | {$result['school']} | Added: $myDate  <span class='user_4'> </span></span> </div>
                            <div class='user_class col-md-12'>
                            <div class='row'>
                            <div class='col-md-12'>

                            <a href=''   data-toggle='modal' data-target='#{$result['id_count']}' class='btn btn-danger btn-sm pull-left'>Delete</a>
                            "; if ($result['status'] == "show"){ echo"
                            <a href='hide.php?id={$result['id_count']}&action=hide' class='btn btn-success btn-sm pull-right'>Hide this </a>
                            "; } else if ($result['status'] == "hide"){ echo"
                            <a href='show.php?id={$result['id_count']}&action=show' class='btn btn-success btn-sm pull-right'>Show this</a>
                            ";}echo"
                            </div></div>
                            </br>

                      </div>
                  </div>
                </div>

            </div>
          </div>

      <div class='modal fade' id='{$result['id_count']}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>

                                </div>
                                <div class='modal-body'>

                                   <p style=''> Are you sure you want to delete this property?</p>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                                    <a href='delete_offer.php?id={$result['id_count']}&location=$location' class='btn btn-danger danger'>Delete</a>
                                </div>

                            </div>
                        </div>
                    </div>
    ";
              }
            echo " </div>";
                 //Pagination continues
               $page_count2 = "SELECT COUNT(id) FROM offers WHERE school = :school AND price = :price AND member_id = :id ";
               $rs_result =  $db-> query($page_count2, array('school' => $_GET['school'], 'price' => $_GET['price'], 'id' => $_SESSION['id']));
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

                        echo '<a href="search.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&page='.$i.'">'.$i.'</a></li>';
                    };
                }
                echo "</ul></div>";
         //Pagination stops
  }
      else if ($_GET['price']=="see all"){

            if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
            $start_from = ($page-1) * 6;

            $query2 = "SELECT i.*, m.*, COUNT(*) AS num FROM offers i
            JOIN users m ON m.id = i.member_id
            WHERE i.school = :school AND accommodation = :accommodation AND i.member_id = :id";

            $db -> query($query2, array('id' => $_SESSION['id'], 'school' => $_GET['school'], 'accommodation' => $_GET['accommodation']));
            $info2 = $db -> fetch();

            if ($info2['num'] == '0'){
                echo "<div class='alert alert-success'>

                    <a href='#' class='close' data-dismiss='alert'>&times;</a>

                    <strong>Sorry!</strong> You have not submitted any property under this category.

                </div>";
            }

            $sql3 = "SELECT i.*, m.*, i.id AS id_count, i.status = status, FROM offers i
                    JOIN users m ON m.id = i.member_id
                    WHERE i.school = :school  AND accommodation = :accommodation AND i.member_id = :id ORDER BY i.id ASC LIMIT $start_from, 6";

            foreach ($db->query($sql3, array('id' => $_SESSION['id'], 'school' => $_GET['school'],  'accommodation' => $_GET['accommodation'])) AS $result)
            {
                  $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";

                  $myDate = date('F j, Y g:i a', strtotime($result['date']));
                  $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 91));

              echo "
            <div class='col-xs-12 col-sm-6 col-md-6'>
              <div class='user_sec_fav' >
                  <div class='row'>
                      <div class='col-md-4'>
                      ";
                      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
                          echo "     <img src='properties/{$result2['photo']}' class='img-responsive' width = '300px' style=' '/>";
                      }   echo"
                      </div>

                      <div class='col-md-8'>
                            <div class='user_class col-md-12'><span style='opacity:0.5;'><span style='text-transform: capitalize;'> {$result['accommodation']}</span> | {$result['school']} | Added: $myDate  <span class='user_4'> </span></span> </div>
                            <div class='user_class col-md-12'>
                            <div class='row'>
                            <div class='col-md-12'>

                            <a href=''   data-toggle='modal' data-target='#{$result['id_count']}' class='btn btn-danger btn-sm pull-left'>Delete</a>
                            "; if ($result['status'] == "show"){ echo"
                            <a href='hide.php?id={$result['id_count']}&action=hide' class='btn btn-success btn-sm pull-right'>Hide this </a>
                            "; } else if ($result['status'] == "hide"){ echo"
                            <a href='show.php?id={$result['id_count']}&action=show' class='btn btn-success btn-sm pull-right'>Show this</a>
                            ";}echo"
                            </div></div>
                            </br>

                      </div>
                  </div>
                </div>

            </div>
          </div>

      <div class='modal fade' id='{$result['id_count']}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>

                                </div>
                                <div class='modal-body'>

                                   <p style=''> Are you sure you want to delete this property?</p>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                                    <a href='delete_offer.php?id={$result['id_count']}&location=$location' class='btn btn-danger danger'>Delete</a>
                                </div>

                            </div>
                        </div>
                    </div>
    ";
      }
            echo " </div>";
            //Pagination continues
               $page_count3 = "SELECT COUNT(id) FROM offers WHERE school = :school AND accommodation = :accommodation AND member_id = :id ";
               $rs_result =  $db-> query($page_count3, array('school' => $_GET['school'], 'accommodation' => $_GET['accommodation'], 'id' => $_SESSION['id']));
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

                        echo '<a href="search.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&page='.$i.'">'.$i.'</a></li>';
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

            if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
            $start_from = ($page-1) * 6;

              $param= array(
                  'school' => $_GET['school'],
                  'accommodation' => $_GET['accommodation'],
                  'price' => $_GET['price']

              );

              $query = "SELECT i.*, m.*, COUNT(*) AS num FROM offers i
              JOIN users m ON m.id = i.member_id
              WHERE i.school = :school AND accommodation = :accommodation AND price = :price";

              $db -> query($query, $param);
              $info = $db -> fetch();

              if ($info['num'] == '0'){
                  echo "<div class='alert alert-success'>

                      <a href='#' class='close' data-dismiss='alert'>&times;</a>

                      <strong>Sorry!</strong> You have not submitted any property under this category.

                  </div>";
              }

              $sql = "SELECT i.*, m.*, i.status AS status, i.id AS id_count, i.photo AS photos FROM offers i
                  JOIN users m ON m.id = i.member_id
                  WHERE i.school = :school AND accommodation = :accommodation AND price = :price ORDER BY i.id ASC LIMIT $start_from, 6";



              foreach ($db->query($sql, $param) AS $result)
              {
                  $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";

                  $myDate = date('F j, Y g:i a', strtotime($result['date']));
                  $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 91));



                  echo "
            <div class='col-xs-12 col-sm-6 col-md-6'>
              <div class='user_sec_fav' >
                  <div class='row'>
                      <div class='col-md-4'>
                      ";
                      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
                          echo "     <img src='properties/{$result2['photo']}' class='img-responsive' width = '300px' style=' '/>";
                      }   echo"
                      </div>

                      <div class='col-md-8'>
                            <div class='user_class col-md-12'><span style='opacity:0.5;'><span style='text-transform: capitalize;'> {$result['accommodation']}</span> | {$result['school']} | Added: $myDate  <span class='user_4'> </span></span> </div>
                            <div class='user_class col-md-12'>
                            <div class='row'>
                            <div class='col-md-12'>

                            <a href=''   data-toggle='modal' data-target='#{$result['id_count']}' class='btn btn-danger btn-sm pull-left'>Delete</a>
                            "; if ($result['status'] == "show"){ echo"
                            <a href='hide.php?id={$result['id_count']}&action=hide' class='btn btn-success btn-sm pull-right'>Hide this </a>
                            "; } else if ($result['status'] == "hide"){ echo"
                            <a href='show.php?id={$result['id_count']}&action=show' class='btn btn-success btn-sm pull-right'>Show this</a>
                            ";}echo"
                            </div></div>
                            </br>

                      </div>
                  </div>
                </div>

            </div>
          </div>

      <div class='modal fade' id='{$result['id_count']}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>
                        <div class='modal-dialog'>
                            <div class='modal-content'>
                                <div class='modal-header'>

                                </div>
                                <div class='modal-body'>

                                   <p style=''> Are you sure you want to delete this property?</p>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
                                    <a href='delete_offer.php?id={$result['id_count']}&location=$location' class='btn btn-danger danger'>Delete</a>
                                </div>

                            </div>
                        </div>
                    </div>
    ";
            }
      echo " </div>";
            //Pagination continues
               $page_count4 = "SELECT COUNT(id) FROM offers WHERE school = :school AND price = :price AND accommodation = :accommodation AND member_id = :id ";
               $rs_result =  $db-> query($page_count4, array('school' => $_GET['school'], 'price' => $_GET['price'], 'accommodation' => $_GET['accommodation'], 'id' => $_SESSION['id']));
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

                        echo '<a href="search.php?school='.$_GET['school'].'&accommodation='.$_GET['accommodation'].'&price='.$_GET['price'].'&submit='.$_GET['submit'].'&page='.$i.'">'.$i.'</a></li>';
                    };
                }
                echo "</ul></div>";
      //Pagination stops
      }
  }

?>
      </div>
</div>
</div>
