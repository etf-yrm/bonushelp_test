<?php
	header('Content-Type: application/json; charset=utf-8');
	$response = [
		"status" => false
	];
	if(array_key_exists("method",$_REQUEST)){
		$method = $_REQUEST["method"];
		if(is_file($rootDir.'/engine/apiMethods/'.$method.'.php')){
			require_once($rootDir.'/engine/apiMethods/'.$method.'.php');
		}else{
			$response["message"] = "Invalid input in the request";
		}
	}else{
		$response["message"] = "Bad Request";
	}
	if($response["status"] && !array_key_exists("code",$response)){
		$response["code"] = 200;
	}elseif(!$response["status"] && !array_key_exists("code",$response)){
		$response["code"] = 400;
	}
	echo json_encode($response,256,512);
?>