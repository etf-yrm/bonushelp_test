<?php
class newsletter extends connectDataBase{
	private function sending($userList = [], $nid = 0, $name = "", $text = ""){
		$result = [
			"status" => false
		];
		if(is_array($userList) && !empty($name) && !empty($text)){
			
			#Pseudo state that the send to the user was successful
			$sendingResult = true; 
			
			$usersRecivedCount = 0;
			foreach($userList as $userData){
				if($sendingResult){
					$this->db->query("INSERT INTO `users_received`(`nid`, `uid`) VALUES (".$nid.",".$userData["id"].")");
					$usersRecivedCount++;
				}
			}
			if($usersRecivedCount == count($userList)){
				$result["status"] = true;
				$result["message"] = "Newsletter full sended complete";
			}elseif($usersRecivedCount > 0 && $usersRecivedCount !== count($userList)){
				$result["status"] = true;
				$result["message"] = "Newsletter sended partially";
			}else{
				$result["error"] = "Sending failed";
			}
		}else{
			$errorList = [];
			!is_array($userList) ? $errorList[] = "userList argument is not array" : true ;
			empty($name) ? $errorList[] = "newsletter name is empty" : true ;
			empty($text) ? $errorList[] = "newsletter text is empty" : true ;
			$result["error"] = "Error list: " . implode(", ",$errorList);
		}
		return $result;
	}
	public function start($id = false){
		$result = [
			"status" => false
		];
		if(is_int($id)){
			$newsletterData = $this->db->query("SELECT * FROM newsletters WHERE id = ".$id);
			if($newsletterData){
				if($newsletterData->num_rows > 0){
					$newsletter = $newsletterData->fetch_assoc();
					$users = new users();
					$userList = $users->getList();
					
					#Select uid of users to whom this newsletter list was previously sent
					$usersReceived = $this->db->query("SELECT uid FROM users_received WHERE nid = ".$newsletter["id"]);
					if($usersReceived && $usersReceived->num_rows > 0){
						while($userReceived = $usersReceived->fetch_assoc()){
							if(isset($userList[$userReceived["uid"]])){
								unset($userList[$userReceived["uid"]]);
							}
						}
					}
					if(count($userList["list"]) > 0){
						$responseSending = $this->sending(
							$userList["list"], 
							intval($newsletter["id"]), 
							$newsletter["name"], 
							$newsletter["text"]
						);
						if($responseSending["status"] == true){
							$result["status"] = true;
							$result["message"] = "Newsletter has been completed";
						}else{
							$result["error"] = $responseSending["error"];
						}
					}elseif(array_key_exists("list",$userList) && count($userList["list"]) == 0){
						$result["status"] = true;
						$result["message"] = "Newsletter to all users was carried out earlier, to continue mailing you can add new users";
					}else{
						$result["error"] = $userList["error"];
					}
				}else{
					$result["error"] = "Not find newsletter with id [" . $id . "]";
				}
			}else{
				$result["error"] = "Error occurred while selecting from the database";
			}
		}else{
			$result["error"] = "Id is uncorrect";
		}
		return $result;
	}
	public function insert($name = "", $text = ""){
		$result = [
			"status" => false
		];
		$name = trim($name); 
		$text = trim($text);
		if(!empty($name) && !empty($text)){
			if($this->db->query("INSERT INTO `newsletters`(`name`, `text`) VALUES ('".$name."','".$text."')")){
				$result["status"] = true;
				$result["message"] = "Newsletter is add complete, id number [" . $this->db->insert_id . "]";
			}else{
				$result["error"] = "An error occurred while adding newsletter data to the database";
			}
		}else{
			$errorList = [];
			empty($name) ? $errorList[] = "newsletter name is empty" : true ;
			empty($text) ? $errorList[] = "newsletter text is empty" : true ;
			$result["error"] = "Error: " . implode(", ",$errorList);
		}
		return $result;
	}
}
?>