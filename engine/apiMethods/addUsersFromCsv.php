<?php
	$users = new users();
	if(array_key_exists("fileCSV",$_FILES)){
		$files=$_FILES["fileCSV"];
		$responseAdd = $users->addFromCsv($files);
		$response["status"] = $responseAdd["status"];
		if($response["status"] == true){
			$response["message"] = $responseAdd["message"];
		}else{
			$response["message"] = $responseAdd["error"];
		}
	}else{
		$response["message"] = "File not transferred";
	}
?>