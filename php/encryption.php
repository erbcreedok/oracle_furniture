<?php 
//$dbArray = array();
$connect_error = "We are Experiencing Some Technical Difficulty";	
$conn=oci_connect('scott', 'admin', 'localhost/orcl') or die($connect_error);
$_POST = json_decode(file_get_contents('php://input'),true);
$param = $_POST['parameter'];
echo $param;
if($param=='enc'){
	$query='UPDATE user_kama SET name = p_encrypt.encrypt_ssn(name),surname = p_encrypt.encrypt_ssn(surname)';
}else{
	$query='UPDATE user_kama SET name = p_encrypt.decrypt_ssn(name),surname = p_encrypt.decrypt_ssn(surname)';
}
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