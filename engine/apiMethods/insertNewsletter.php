<?php
	if(array_key_exists("name",$_REQUEST) && array_key_exists("text",$_REQUEST)){
		$newsletter = new newsletter();
		$responseInsert = $newsletter->insert(strval($_REQUEST["name"]),strval($_REQUEST["text"]));
		$response["status"] = $responseInsert["status"];
		if($response["status"] == true){
			$response["message"] = $responseInsert["message"];
		}else{
			$response["message"] = $responseInsert["error"];
		}
	}else{
		$response["message"] = "The necessary parameters for adding a mailing list were not passed";
	}
?>