<?php 
$_POST = json_decode(file_get_contents('php://input'),true);
$p = $_POST['password'];
if($p=='qwerty'){
	echo 'ok';
}else{
	echo 'not';
}

 ?>