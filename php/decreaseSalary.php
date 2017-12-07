<?php 
$connect_error = "We are Experiencing Some Technical Difficulty";	
$conn=oci_connect('scott', 'admin', 'localhost/orcl') or die($connect_error);
$_POST = json_decode(file_get_contents('php://input'),true);
$query = "CALL decreaseSalary(:param)";
$smtp = oci_parse($conn,$query);
$sal = 200;
oci_bind_by_name($smtp, ':param', $sal) ;
$ex = oci_execute($smtp,OCI_NO_AUTO_COMMIT);
if (!$ex) {    
    $e = oci_error($smtp);
    trigger_error(htmlentities($e['message']), E_USER_ERROR);
}else{
	oci_commit($conn);
	echo 'ok';
}
oci_close($conn);
 ?>