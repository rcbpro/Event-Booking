<?php
ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
require $_SERVER['DOCUMENT_ROOT'].'event_booking/admin/library/database.php';
if ("POST" == $_SERVER['REQUEST_METHOD']){
	if ($adminDbFunc->updateParentEventName($_POST['id'], $_POST['value'])){
		echo $_POST['value'];
	}
}