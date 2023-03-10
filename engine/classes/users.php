<?php
class users extends connectDataBase{
	private function isValidCsv($file = []){
		if(is_array($file)){
			if(in_array($file['type'],['text/csv','application/csv','text/comma-separated-values'])){
				return true;
			}
		}
		return false;
	}
	public function getList(){
		$result = [
			"status" => false
		];
		$selectUserData =  $this->db->query("SELECT * FROM users ORDER by id ASC");
		if($selectUserData && $selectUserData->num_rows > 0){
			$userList = [];
			while($userData = $selectUserData->fetch_assoc()){
				$userList[$userData["id"]] = $userData;
			}
			$result["status"] = true;
			$result["list"] = $userList;
		}else{
			$result["error"] = "Database select error";
		}
		return $result;
	}
	public function addFromCsv($file = [], $separator = "\r"){
		$result = [
			"status" => false
		];
		if($this->isValidCsv($file)){
			if(($openFile = fopen($file["tmp_name"],"r")) !== false){
				$oldNumbersSelect =  $this->db->query("SELECT number FROM users");
				if($oldNumbersSelect && $oldNumbersSelect->num_rows > 0){
					$prevAdded = [];
					#create an array of old values as keys to use the isset function
					while($oldRow = $oldNumbersSelect->fetch_array()){
						$prevAdded[$oldRow[0]] = 1;
					}
				}
				#If an array of old numbers is not formed, then we do not resort to using an array search for greater performance
				$issetTest = isset($prevAdded) && count($prevAdded) > 0;
				$userDataFromCsv = []; $countAllUserInFile = 0;
				while(($rowUser = fgetcsv($openFile, null,  $separator)) !== false){
					$rowUserData = explode(",",$rowUser[0]);
					if(count($rowUserData)==2){
						if(!$issetTest || ($issetTest && !isset($prevAdded[(int) $rowUserData[0]]))){
							$userDataFromCsv[] = "(".intval($rowUserData[0]).",'".trim(strval($rowUserData[1]))."')";
						}
						$countAllUserInFile++;
					}
				}
				if(count($userDataFromCsv) > 0){
					if($this->db->query("INSERT INTO `users`(`number`, `name`) VALUES ".implode(",",$userDataFromCsv))){
						$result["status"] = true;
						$result["message"] = "Add [".count($userDataFromCsv)."] new users from CSV";
					}else{
						$result["error"] = "An error occurred while adding new data to the database";
					};
				}elseif(count($userDataFromCsv) == 0 && $countAllUserInFile > 0){
					$result["status"] = true;
					$result["message"] = "Is not find new user data to add from CSV file";
				}else{
					$result["error"] = "The transferred file CSV does not contain data for adding new users";
				}
			}else{
				$result["error"] = "Is not opened CSV file";
			}
		}else{
			$result["error"] = "Is not valid CSV file";
		}
		return $result;
	}
}
?>