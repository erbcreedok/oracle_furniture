<?php 
//$dbArray = array();
$connect_error = "We are Experiencing Some Technical Difficulty";	
$conn=oci_connect('scott', 'admin', 'localhost/orcl') or die($connect_error);
$_POST = json_decode(file_get_contents('php://input'),true);
$id = $_POST['or_id'];
$query = 'delete from user_kama where id =:id';
$smtp = oci_parse($conn,$query);
oci_bind_by_name($smtp,':id',$id);
$ex = oci_execute($smtp);
echo 'ok';
oci_close($conn);

?>