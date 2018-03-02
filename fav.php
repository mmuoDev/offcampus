<?php
session_start();
require_once "db/db_handle.php";


if ($_REQUEST['op'] == "add_clique") {
	$param = array(
          'session_id' => $_SESSION['id'],
          'offer_id' => $_POST['id']

          );
     $sql = "INSERT into favourite (member_id, offer_id) VALUES (:session_id, :offer_id)";
     
     $db->query($sql, $param);


}

elseif ($_REQUEST['op'] == 'del_clique') {
     $sql1 = "DELETE FROM favourite WHERE offer_id = :offer_id AND member_id = :member_id";
     $result1 = $db->query ($sql1, array('offer_id' => $_POST['clique_id'], 'member_id' => $_POST['adder_id']));

}
else{}
?>
