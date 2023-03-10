<?php
	#require setting
	@require_once("engine/setting.php");
	
	$moduleName=false;
	if(array_key_exists("module",$_REQUEST)){
		$moduleParts=explode('/',strval($_REQUEST["module"]));
		$moduleName=$moduleParts[0];
	}
	
	if(!$moduleName){
		$moduleFile=$rootDir."/engine/modules/default_index.php";
	}elseif(!is_file($rootDir."/engine/modules/".$moduleName.".php") || in_array($moduleName,["header","footer"])){
		$pageErrorCode=404;
		$moduleFile=$rootDir."/engine/modules/error.php";
	}else{
		$moduleFile=$rootDir."/engine/modules/".$moduleName.".php";
	}
	

	
	try {
		require_once($moduleFile);
	} catch (Exception $e) {
		var_dump($e->getMessage());
	}
	
?>