    <?php 
    $dbArray = array();
    $connect_error = "We are Experiencing Some Technical Difficulty";   
    $conn=oci_connect('scott', 'admin', 'localhost/orcl') or die($connect_error);

    $_POST = json_decode(file_get_contents('php://input'),true);
    $id = $_POST['id'];
    $query =  "select GetNewSalary('".$id."') as totalSalary from user_kama_relate where rownum=1";
    $stid = oci_parse($conn,$query);
    oci_execute($stid,OCI_COMMIT_ON_SUCCESS);
    
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)){
        $tempArray = array();
        foreach($row as $item){
            array_push($tempArray,$item); 
        }
        array_push($dbArray,$tempArray); 
    }

    $query =  "select GetEmployees('".$id."') as totalSalary from user_kama where rownum=1";
    $stid = oci_parse($conn,$query);
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