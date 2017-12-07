<?php 
//$dbArray = array();
$connect_error = "We are Experiencing Some Technical Difficulty";	
$conn=oci_connect('scott', 'admin', 'localhost/orcl') or die($connect_error);
$_POST = json_decode(file_get_contents('php://input'),true);
$id = $_POST['id'];
$name = $_POST['name'];
$surname = $_POST['surname'];
$gender = $_POST['gender'];
$credit = $_POST['credit'];
$job = $_POST['job'];
$image = $_POST['image'];

$query = "UPDATE USER_KAMA SET ";
$query .="NAME = '".$name."' ";
$query .=",SURNAME = '".$surname."' ";
$query .=",GENDER = '".$gender."' ";
$query .=",CREDIT = '".$credit."' ";
$query .=",JOB = '".$job."' ";
$query .=",IMAGE  = '".$image."' ";
$query .="WHERE ID = '".$id."'";
$smtp = oci_parse($conn,$query);
$ex = oci_execute($smtp,OCI_NO_AUTO_COMMIT);
if (!$ex) {    
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}else{
	oci_commit($conn);
	echo 'ok';
}
oci_close($conn);

?>