	<?php 
    $dbArray = array();
    $connect_error = "We are Experiencing Some Technical Difficulty";	
    $conn=oci_connect('scott', 'admin', 'localhost/orcl') or die($connect_error);
    $stid = oci_parse($conn, 'select * from user_kama
join user_kama_relate on user_kama_relate.job=user_kama.job');
    oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
    
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
        $tempArray = array();
        foreach($row as $item){
            array_push($tempArray,$item); 
        }
        array_push($dbArray,$tempArray); 
    }
    echo json_encode($dbArray);
    oci_close($conn);
?>