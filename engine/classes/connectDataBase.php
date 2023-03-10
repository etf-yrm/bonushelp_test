<?php
	class connectDataBase{
		public $db;
		public function __construct($cfgDb=false){
			if(!$cfgDb){
				$cfgDb = $GLOBALS["cfgDb"];
			}
			if(!isset($this->db)){
				$this->db = new mysqli($cfgDb['host'],$cfgDb['user'],$cfgDb['pass'],$cfgDb['name']);
			}
			if(!$this->db->connect_error){
				mysqli_query($this->db, "SET NAMES utf8");
			}else{
				throw new \Exception ( 
					$this->connect_error, 
					$this->connect_errno 
				); 
			}
		}
	}
?>