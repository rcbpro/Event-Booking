<?php
$allParentEvents = $adminDbFunc->loadAllParentEvents();
if ("POST" == $_SERVER['REQUEST_METHOD']){
	if (isset($_POST['events'])){	
		$errors = errorCheckingFields($_POST['events']);
	}
	if ($errors['errorStatus']){
		$_SESSION['error_message'] = true;
		header("Location: ". WEB_PATH.'events/index/');			
		exit();
	}else{
		if ($adminDbFunc->addNewParentEvent($_POST['events']) != NULL){
			$_SESSION['success_message'] = true;
			header("Location: ". WEB_PATH.'events/index/');			
			exit();
		}else{
			$_SESSION['already_error_message'] = true;
			header("Location: ". WEB_PATH.'events/index/');			
			exit();
		}
	}
}
if (($view == "drop") && (isset($QPramas))){
	$adminDbFunc->dropMainEventById($QPramas);
	$_SESSION['drop_message'] = true;
	header("Location: ". WEB_PATH.'events/index/');			
	exit();
}