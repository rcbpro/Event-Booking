<?php
if ("POST" == $_SERVER['REQUEST_METHOD']){
	if (isset($_POST['loginForm'])){	
		if (isset($_POST['loginForm'])){	
			$errors = errorCheckingFields($_POST['loginForm']);
		}
		if ($errors['errorStatus']){
			$_SESSION['error_message'] = true;
			header("Location: ". WEB_PATH);			
			exit();
		}else{
			$password = $adminDbFunc->loginProcess($_POST['loginForm']);
			if ($password != trim(md5($_POST['loginForm']['password']))){
				$_SESSION['login_error_message'] = true;
				header("Location: ". WEB_PATH);			
				exit();
			}else{
				$_SESSION['logged'] = true;
				$_SESSION['logged_success_message'] = true;
				header("Location: ". WEB_PATH);			
				exit();				
			}
		}
	}
}else{
	if ($view == "logout"){
		unset($_SESSION['logged']);
		$_SESSION['loggedout_success_message'] = true;
		header("Location: ". WEB_PATH);			
		exit();				
	}
}