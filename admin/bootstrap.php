<?php

$requestedUri = $_SERVER['REQUEST_URI'];
$splittedUrls = explode('/', $requestedUri);
foreach($splittedUrls as $eachUri){
	if ((isset($eachUri)) && (!empty($eachUri))) $newSplittedUrls[] = $eachUri;
}
if (($newSplittedUrls[2] == '') || (!isset($_SESSION['logged']))){
	$controller = 'index';
	$view = 'index';
}else{
	$controller = $newSplittedUrls[2];
	$view = $newSplittedUrls[3];
	$QPramas = $newSplittedUrls[4];	
}
if (
	(file_exists(CONTROLLER_PATH.$controller.EXT)) && 
	(file_exists(VIEW_PATH.$controller.DS.$view.EXT))
	){
	require CONTROLLER_PATH.$controller.EXT;
}else{
	header("Location: ". WEB_PATH);			
	exit();
}	
include LAYOUT_PATH.'index.html';