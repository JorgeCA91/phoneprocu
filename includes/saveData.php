<?php
include 'BindParam.php';

function SaveData($data,$fields,$host,$username,$password,$dbname,$table){

	$columns = array_keys($data);

	$mysqli = new mysqli($host, $username, $password, $dbname);
	$bindParam = new BindParam(); 


	if (mysqli_connect_errno()) {
	    printf("Connect failed: %s\n", mysqli_connect_error());
	    exit();
	}

	$sql = "INSERT INTO $table SET ";

	if(!empty($data)){
		$sql .= implode(' = ? , ',$columns)." = ? ";
	}

	if ($stmt = $mysqli->prepare($sql)) {

	    foreach ($data as $field => $value) {
	    	$val = is_array($value) ? implode(',',$value) : $value;
	    	$val = $bindParam->SanitizeDateTime($field,$val,$fields);
	    	$bindParam->add($val);
	    }

	    call_user_func_array( array($stmt, 'bind_param'), $bindParam->get());

	    $stmt->execute();

	    $stmt->close();
	}

	$mysqli->close();
}
?>