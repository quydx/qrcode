<?php 


    $options = array(
		PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
	);


		$databaseName = $_GET['database']; 
		try {
	    	$connect = new PDO("mysql:host=localhost;dbname=$databaseName", "root", "" ,$options);
		}
		catch(PDOException $e) {
			die("false");
		}

		if (!isset($_GET['table'])) {
		$query = "SELECT TABLE_NAME FROM information_schema.tables WHERE TABLE_TYPE='BASE TABLE' AND TABLE_SCHEMA = '$databaseName'";
		}
		else{
			$tableName = $_GET['table'];
			$query = "SELECT COLUMN_NAME FROM information_schema.columns WHERE TABLE_SCHEMA = '$databaseName' AND TABLE_NAME = '$tableName'";
		}
		$results = $connect->prepare($query);
	    $results->setFetchMode(PDO::FETCH_ASSOC);
	    $results->execute();
	    while($row = $results->fetch()){
	    	$data[] = $row ;
	    }

	  	if (!$data) return false ; 
	  	else {
	 
	  		// echo "<option selected>Close this and choose one below</option>";
			foreach ($data as $dt) {
				foreach ($dt as $key => $value) {
					echo "<option value='$value'>$value</option>";
				}
			}
		}


?>
