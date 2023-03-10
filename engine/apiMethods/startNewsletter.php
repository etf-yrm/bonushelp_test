<?php
	if(array_key_exists("startId",$_REQUEST)){
		$newsletter = new newsletter();
		$responseStart = $newsletter->start(intval($_REQUEST["startId"]));
		$response["status"] = $responseStart["status"];
		if($response["status"] == true){
			$response["message"] = $responseStart["message"];
		}else{
			$response["message"] = $responseStart["error"];
		}
	}else{
		$response["message"] = "Newsletter id not transferred";
	}
?>