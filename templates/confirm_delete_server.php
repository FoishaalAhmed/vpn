<?php 

	if (isset($_GET['id'])) {
		$ID = $_GET['id'];
	} else {
		$ID = "";
	}
		
	
	//Is it Free Server?
	$sql_query = "SELECT * FROM tbl_servers where isPaid='0' and id = '$ID'";
	$total_free = mysqli_query($connect, $sql_query);
	$isFree =  mysqli_num_rows($total_free);
	

	// delete data from menu table
	$sql_query = "DELETE FROM tbl_servers WHERE id = ?";
			
	$stmt = $connect->stmt_init();
	if ($stmt->prepare($sql_query)) {	
		// Bind your variables to replace the ?s
		$stmt->bind_param('s', $ID);
		// Execute query
		$stmt->execute();
		// store result 
		$delete_result = $stmt->store_result();
		$stmt->close();
	}
				
	// if delete data success back to reservation page
	if($delete_result) {
		if($isFree > 0){
			header("location: freeservers.php");
		}else {
			header("location: paidservers.php");
		}
	}

?>