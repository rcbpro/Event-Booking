<?php

$splittedUrls = explode("/", $_SERVER['REQUEST_URI']);
foreach($splittedUrls as $eachUri){
	if ((isset($eachUri)) && (!empty($eachUri))) $newSplittedUrls[] = $eachUri;
}
if ((($newSplittedUrls[0] == 'event_booking') || ($newSplittedUrls[0] == 'tickets')) && (!isset($newSplittedUrls[1]))){
	$viewToBeLoad = 'page';
}else if (isset($newSplittedUrls[1])){
	$viewToBeLoad = 'single';
}
include LAYOUT_PATH.'index.html';