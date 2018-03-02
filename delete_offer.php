<?php
ob_start();
session_start();
require_once "db/db_handle.php";
//$location= urlencode($_SERVER['REQUEST_URI']);
if (isset($_SESSION['id']) == false){
  //header ("Location: login.php?location=$location");
  header("location: login.php");
}
if (isset($_GET['id'])){

    //$redirect = $_GET['location'];
    //$query = "DELETE a.*, b.* FROM offers AS a INNER JOIN offer_count AS b ON a.member_id = b.offer_id  WHERE
    //  b.offer_id =  :id";
    $query="DELETE  FROM offers WHERE id= :id";
    $result = $db->query($query, array ('id' => $_GET['id']));
    if ($result){
        $sql2="DELETE  FROM favourite WHERE offer_id = :id";
        $db->query($sql2, array ('id' => $_GET['id']));
        //delete all them photos of this offer
        $select = "SELECT * FROM photos WHERE photo_id = :id";
        foreach ($db->query($select, array('id' => $_GET['id'])) AS $select_2){
            $delete_2 = "DELETE FROM photos WHERE photo_id = :id";
            $query = $db->query($delete_2, array('id' => $select_2['photo_id']));

            if ($select_2['photo'] != "no image.jpg"){
            unlink("properties/".$select_2['photo']);
            }
        }
        //deleting photos ends
        header("Location: properties.php");
    }else{
        //echo mysql_error();
    }
}else{
  header("location: properties.php");
}

?>
