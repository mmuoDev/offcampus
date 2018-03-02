<?php
require_once "includes/layout2.php";
require_once "db/db_handle.php";
$location= urlencode($_SERVER['REQUEST_URI']);
if (isset($_SESSION['id']) == false){
  header ("Location: login.php");
}
else if (isset($_SESSION['category']) != "agent"){
  header ("Location: index.php");
}else{}

?>
    <title>My Properties</title>
    <script>
     $('#confirm-delete').on('show.bs.modal', function(e) {
    $(this).find('.danger').attr('', $(e.relatedTarget).data('href'));
    });
    </script>
  <div class='row' >
   <div class='container'>

    <div class='col-xs-12 col-sm-9 col-md-9'>
  <?php
  //Pagination starts
    if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
    $start_from = ($page-1) * 6;
  //Pagination stops

    $query3 = "SELECT count(*) AS num FROM offers WHERE member_id = :session_id";
    $db -> query($query3, array('session_id' => $_SESSION['id'] ));
    $info3 = $db -> fetch();
    if ($info3['num'] == '0'){
      echo "<div class='alert alert-success'>
            <a href='#' class='close' data-dismiss='alert'>&times;</a>
            <strong>Sorry!</strong> You have not submitted any property.  
          </div>";
    }

  $sql = "SELECT i.*, m.*, FORMAT(price, 0) AS price, i.status AS status, i.id AS id_count FROM offers i
            JOIN users m ON m.id = i.member_id
            WHERE i.member_id = :id  ORDER BY i.id DESC LIMIT $start_from, 6";

foreach ($db->query($sql, array('id' => $_SESSION['id'])) AS $result)
{
  $newPrice = str_replace(".", ",", $result['price']);
  $view_photo = "SELECT i.*, p.* FROM offers i JOIN photos p ON i.id = p.photo_id WHERE i.id = :offer_id LIMIT 1 ";
  $myDate = date('F j, Y g:i a', strtotime($result['date']));
  $rest = preg_replace('/\s+?(\S+)?$/', '', substr($result['description'], 0, 50));


  echo "
            <div class='col-xs-12 col-sm-10 col-md-10'>
              <div class='submit_offer' >
                  <div class='row'>
                      <div class='col-md-4'>
                      ";
                      foreach ($db->query($view_photo, array( 'offer_id' => $result['id_count'])) AS $result2){
                          echo "     <img src='properties/{$result2['photo']}' class='img-responsive' width = '300px' style=' '/>";
                      }   echo"
                      </div>
                      <div class='col-md-6'>
                            <div class='user_class col-md-12'><span style='opacity:0.5;'><span style='text-transform: capitalize;'> {$result['accommodation']}</span> | {$result['location']} | {$result['school']}  | <strong> &#x20a6;$newPrice </strong> | Added: $myDate  </span> </div>
                            <div class='user_class col-md-12'>
                            <div class='row'>
                            <div class='col-md-12'>
                            <a href=''  data-toggle='modal' data-target='#{$result['id_count']}' class='btn btn-danger btn-sm pull-left'>Delete</a>
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

  ?>
<?php
  //Pagination continues
$sql2 = "SELECT COUNT(id) FROM offers WHERE member_id = :id";
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

    echo "<a href='properties.php?page=$i' >$i</a></li>";
};
}
echo "</ul></div>";
//Pagination stops
 ?>
</div><div class='col-xs-12 col-sm-3 col-md-3 contact_fraud' >
  <form class="form-horizontal" role="form" method="get" action="search.php" >
    <div class="form-group">
            <!-- <span class='home_text_2'>Select School</span><br class='clear'> -->
            <select name="school" id="school" class='form-control input-3x '>
                <option value="">Select School...</option>
                <option value="Abdul Gusau Polytechnic">Abdul Gusau Polytechnic</option>
                <option value="Abia State University">Abia State University</option>
                <option value="Adamawa State Polytechnic">Adamawa State Polytechnic</option>
                <option value="Adeniran Ogunsanya College of Education">Adeniran Ogunsanya College of Education</option>
                <option value="Adekunle Ajasin University">Adekunle Ajasin University</option>
                <option value="Adeyemi College of Education">Adeyemi College of Education</option>
                <option value="Ahmadu Bello University Zaria">Ahmadu Bello University Zaria</option>
                <option value="Ambrose Alli University">Ambrose Alli University</option>
                <option value="Akanu Ibiam Federal Polytechnic">Akanu Ibiam Federal Polytechnic</option>
                <option value="Akwa Ibom State University of Science and Technology">Akwa Ibom State University of Science and Technology</option>
                <option value="Akwa Ibom State Polytechnic">Akwa Ibom State Polytechnic</option>
                <option value="Auchi Polytechnic">Auchi Polytechnic</option>
                <option value="Benue State Polytechnic">Benue State Polytechnic</option>
                <option value="Benue State University">Benue State University</option>
                <option value="College of Agriculture, Kabba">College of Agriculture, Kabba</option>
                <option value="College of Education, Akwanga">College of Education, Akwanga</option>
                <option value="College of Education, Katsina Ala">College of Education, Katsina Ala</option>
                <option value="College of Education, Warri">College of Education, Warri</option>
                <option value="College of Education, Zuba">College of Education, Zuba</option>
                <option value="Delta State College of Agriculture">Delta State College of Agriculture</option>
                <option value="Delta State Polytechnic">Delta State Polytechnic</option>
                <option value="Delta State University, Abraka">Delta State University, Abraka</option>
                <option value="Ebonyi State University">Ebonyi State University</option>
                <option value="Enugu State University of Science and Technology">Enugu State University of Science and Technology</option>
                <option value="Ekiti State University">Ekiti State University</option>
                <option value="Federal College of Education (Technical), Akoka">Federal College of Education (Technical), Akoka</option>
                <option value="Federal College of Education (Technical), Bichi">Federal College of Education (Technical), Bichi</option>
                <option value="Federal College of Education (Technical), Gombe">Federal College of Education (Technical), Gombe</option>
                <option value="Federal College of Education (Technical), Gusau">Federal College of Education (Technical), Gusau</option>
                <option value="Federal College of Education, Kastina">Federal College of Education, Kastina</option>
                <option value="Federal College of Education, Kontagora">Federal College of Education, Kontagora</option>
                <option value="Federal College of Education Okene">Federal College of Education Okene</option>
                <option value="Federal College of Education, Osiele">Federal College of Education, Osiele</option>

                <option value="Federal College of Education, Umunze">Federal College of Education, Umunze</option>
                <option value="Federal College of Education Yola">Federal College of Education Yola</option>
                <option value="Federal College of Education, Zaria">Federal College of Education, Zaria</option>
                <option value="Federal Polytechnic, Ado-Ekiti">Federal Polytechnic, Ado-Ekiti</option>
                <option value="Federal Polytechnic, Bida">Federal Polytechnic, Bida</option>
                <option value="Federal Polytechnic, Birnin-Kebbi">Federal Polytechnic, Birnin-Kebbi</option>
                <option value="Federal Polytechnic, Damaturu">Federal Polytechnic, Damaturu</option>
                <option value="Federal Polytechnic, Ede">Federal Polytechnic, Ede</option>
                <option value="Federal Polytechnic, Idah">Federal Polytechnic, Idah</option>
                <option value="Federal Polytechnic, Ilaro">Federal Polytechnic, Ilaro</option>
                <option value="Federal Polytechnic, Mubi">Federal Polytechnic, Mubi</option>
                <option value="Federal Polytechnic, Namoda">Federal Polytechnic, Namoda</option>
                <option value="Federal Polytechnic, Nassarawa">Federal Polytechnic, Nassarawa</option>
                <option value="Federal Polytechnic, Nekede">Federal Polytechnic, Nekede</option>
                <option value="Federal Polytechnic, Offa">Federal Polytechnic, Offa</option>
                <option value="Federal Polytechnic, Oko">Federal Polytechnic, Oko</option>
                <option value="Federal University of Petroleum Resource Effurun">Federal University of Petroleum Resource Effurun</option>
                <option value="Federal University of Technology Akure">Federal University of Technology Akure</option>
                <option value="Federal University of Technology Owerri">Federal University of Technology Owerri</option>
                <option value="Federal University of Technology Minna">Federal University of Technology Minna</option>
                <option value="Federal University of Agriculture, Abeokuta">Federal University of Agriculture, Abeokuta</option>
                <option value="Ibrahim Babangida College of Agriculture">Ibrahim Babangida College of Agriculture</option>
                <option value="Imo State Polytechnic">Imo State Polytechnic</option>
                <option value="Imo State University">Imo State University</option>
                <option value="Institute of Management Technology, Enugu">Institute of Management Technology, Enugu</option>
                <option value="Ladoke Akintola University of Technology">Ladoke Akintola University of Technology</option>
                <option value="Lagos State Polytechnic">Lagos State Polytechnic</option>
                <option value="Lagos State University">Lagos State University</option>
                <option value="Lead City University">Lead City University</option>
                <option value="Michael Okpara Federal University of Agriculture">Michael Okpara Federal University of Agriculture</option>
                <option value="Moshood Abiola Polytechnic">Moshood Abiola Polytechnic</option>
                <option value="Nasarawa State University">Nasarawa State University</option>
                <option value="Nasarawa State Polytechnic">Nasarawa State Polytechnic</option>
                <option value="Niger Delta University">Niger Delta University</option>
                <option value="Nnamdi Azikiwe University">Nnamdi Azikiwe University</option>
                <option value="Institute of Management and Technology">Institute of Management and Technology</option>
                <option value="Kaduna Polytechnic">Kaduna Polytechnic</option>
                <option value="Kano State Polytechnic">Kano State Polytechnic</option>
                <option value="Kebbi State Polytechnic">Kebbi State Polytechnic</option>
                <option value="Kogi State Polytechnic">Kogi State Polytechnic</option>
                <option value="Kogi State University">Kogi State University</option>
                <option value="Kwara State Polytechnic">Kwara State Polytechnic</option>
                <option value="Kwara State University">Kwara State University</option>
                <option value="Obafemi Awolowo University">Obafemi Awolowo University</option>
                <option value="Olabisi Onabanjo University">Olabisi Onabanjo University</option>
                <option value="Osun State College of Technology, Ilesa">Osun State College of Technology, Ilesa</option>
                <option value="Osun State Polytechnic">Osun State Polytechnic</option>
                <option value="Osun State University">Osun State University</option>
                <option value="Rivers State College of Arts and Science">Rivers State College of Arts and Science</option>
                <option value="Rivers State College of Education">Rivers State College of Education</option>
                <option value="Rivers State Polytechnic">Rivers State Polytechnic</option>
                <option value="Rivers State University of Science and Technology">Rivers State University of Science and Technology</option>
                <option value="Rufus Giwa Polytechnic">Rufus Giwa Polytechnic</option>
                <option value="St. Paul University College">St. Paul University College</option>
                <option value="Tai Solarin University of Education">Tai Solarin University of Education</option>
                <option value="The Polytechnic, Calabar">The Polytechnic, Calabar</option>
                <option value="The Polytechnic, Ibadan">The Polytechnic, Ibadan</option>
                <option value="University of Abuja">University of Abuja</option>

                <option value="University of Agriculture, Makurdi">University of Agriculture, Makurdi</option>
                <option value="University of Benin">University of Benin</option>
                <option value="University of Calabar">University of Calabar</option>
                <option value="University of Ibadan">University of Ibadan</option>
                <option value="University of Ilorin">University of Ilorin</option>
                <option value="University of Jos">University of Jos</option>
                <option value="University of Lagos">University of Lagos</option>
                <option value="University of Nigeria, Nsukka">University of Nigeria, Nsukka</option>
                <option value="University of Port Harcourt">University of Port Harcourt</option>
                <option value="University of Uyo">University of Uyo</option>

                <option value="Yaba College of Technology">Yaba College of Technology</option>
                <!--<option value="see all">See All</option>-->
            </select>
    </div>
    <div class="form-group">
            <!--<span class='home_text_2'>Select Accommodation</span><br class='clear'> -->
            <select name="accommodation" id="accommodation" class='form-control input-3x '>
                <option value="">Select Accommodation</option>
                <option value="one room">One Room</option>
                <option value="one room self-contain">One Room Self-Contain</option>
                <option value="room and parlor">Room and Parlour</option>
                <option value="2 bedroom flat">2 Bedroom Flat</option>
                <option value="3 bedroom flat">3 Bedroom Flat</option>
                <option value="see all">See All</option>
            </select>
    </div>
    <div class="form-group">
            <!--<span class='home_text_2'>Select Price</span><br class='clear'>-->
            <select name="price" id="price" class='form-control input-3x '>
                <option value="">Price Range</option>
                <option value="0-50,000">0 - 50,000</option>
                <option value="50,000-100,000">50,000 - 100,000</option>
                <option value="100,000-150,000">100,000 - 150,000</option>
                <option value="150,000-200,000">150,000 - 200,000</option>
                <option value="200,000 and above">200,000 and above</option>
                <option value="see all">See All</option>

            </select>
    </div>
    <div class="form-group  text-center">
            <input type="submit" name="submit" value="Search" class='btn btn-success form-control' style="">
    </div>
  </form>

      </div>

  </div>
  </div>





  </body>

</html>
