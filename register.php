<?php

include_once ('includes/config.php');
include_once ('templates/fcm.php');
header( 'Content-Type: application/json; charset=utf-8' );
if(isset($_GET['token'])) {
	
	date_default_timezone_set('Asia/Kolkata');

	$query = "SELECT * FROM tbl_tokens where token='".$_GET['token']."'" ;
	$sel = mysqli_query($connect, $query);
	
	if(mysqli_num_rows($sel) > 0) {
		$set['data'][]=array('message' => 'Token already added','status'=>'0');
		echo $val= str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE));
		die();
	} else {
		$currentDate = date('Y-m-d H:i:s', time());
	
		$data = array(            
	        'token'  =>  $_GET['token'],
			'createdAt' => $currentDate
	    );  
	      
	    $qry = Insert('tbl_tokens', $data);
    	
        $set['data'][]=array('message' => 'Successfully added!','status'=>'1', 'result'=>$data);
		echo $val= str_replace('\\/', '/', json_encode($set, JSON_UNESCAPED_UNICODE));
		die();
	}
} else {
	echo "Paramert token is missing";
}

?>