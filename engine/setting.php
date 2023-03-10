<?php
	#Database connect setting
	$cfgDb = [
		"host"=>'localhost',
		"user"=>'',
		"pass"=>'',
		"name"=>''
	];
	
	#Path to root directory	
	$rootDir = $_SERVER['DOCUMENT_ROOT'];
	
	#Classes autoload
	spl_autoload_register(function($className){
		$classPath=$GLOBALS["rootDir"]."/engine/classes/".$className.".php";
		if(file_exists($classPath) && !class_exists($className)){
			if(is_file($classPath)){
				@require_once($classPath);
			}
		}
	});
?>