<?php

function errorCheckingFields($fieldsArray = array()) {

	$errorFieldsArray = array();
	$errorsFound = true;
	foreach($fieldsArray as $field => $value) {
		if ((isset($value)) && (!empty($value)) && ($value != '') && ($value != NULL)) $errorsFound = false;
		else $errorFieldsArray[] = $field;
	}
	return array('errorStatus' => $errorsFound, 'errorFields' => $errorFieldsArray);
}
