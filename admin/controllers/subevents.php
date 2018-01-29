<?php
$parentevents = $adminDbFunc->loadAllParentEvents();
$subevents = $adminDbFunc->loadAllSubEvents();
$seatMaps = $adminDbFunc->loadAllSeatMaps();
$ticketTypes = $adminDbFunc->loadTicketTypesRelatedToThisSubEvent($QPramas);

if ("POST" == $_SERVER['REQUEST_METHOD']){
	if ((isset($_POST['subevents'])) && ($view != "edit")){		
		$errors = errorCheckingFields($_POST['subevents']);
	}
	if ($errors['errorStatus']){
		$_SESSION['error_message'] = true;
	}else{
		$sub_event_id = $adminDbFunc->addNewSubEvent($_POST['subevents']);
		if ($sub_event_id != NULL){
			$adminDbFunc->addTicketTypes($_POST['subevents'], $sub_event_id);
			$_SESSION['success_message'] = true;
			header("Location: ". WEB_PATH.'subevents/edit/'.$sub_event_id.'/');			
			exit();
		}else{
			$_SESSION['already_error_message'] = true;
		}
	}
}
if (($view == "edit") && (isset($QPramas))){
	$subEventDetails = $adminDbFunc->getSubEventDetailsByItsId($QPramas);
	if ("POST" == $_SERVER['REQUEST_METHOD']){
		if (isset($_POST['subeventsedit'])){
			$errors = errorCheckingFields($_POST['subeventsedit']);
		}
		if (isset($_POST['moretickettypes'])){	
			$errors = errorCheckingFields($_POST['moretickettypes']);
		}
		if ($errors['errorStatus']){
			$_SESSION['error_message'] = true;
		}else{
			if (isset($_POST['subeventsedit'])){
				if ($adminDbFunc->updateCurrentSubEvent($subEventDetails['event_id'], $_POST['subeventsedit']) != NULL){
					$_SESSION['update_success_message'] = true;
					header("Location: ". WEB_PATH.'subevents/view/');			
					exit();
				}else{
					$_SESSION['already_error_message_for_sub'] = true;
				}
			}	
			if (isset($_POST['moretickettypes'])){	
				$adminDbFunc->addTicketTypes($_POST['moretickettypes'], $subEventDetails['event_id']);
				$_SESSION['new_ticket_success_message'] = true;
				header("Location: ". WEB_PATH.'subevents/edit/'.$QPramas.'/');			
				exit();
			}				
		}
	}
}
if (($view == "drop") && (isset($QPramas))){
	$adminDbFunc->dropSubEventById($QPramas);
	$_SESSION['drop_message'] = true;
	header("Location: ". WEB_PATH.'subevents/view/');			
	exit();
}