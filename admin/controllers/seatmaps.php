<?php
$allSeatMaps = $adminDbFunc->loadAllSeatMaps();
if (($view != "edit") && (!isset($QPramas))){
	if ("POST" == $_SERVER['REQUEST_METHOD']){
		if (isset($_POST['seatMap'])){	
			$errors = errorCheckingFields($_POST['seatMap']);
		}
		if (
			($errors['errorStatus']) ||
			($_FILES['add_seat_map_file']['name'] == "")
		   )
			{
				$_SESSION['error_message'] = true;
		}else{
			if (move_uploaded_file($_FILES['add_seat_map_file']['tmp_name'], IMAGE_UPLOADED_PATH.DS.basename($_FILES['add_seat_map_file']['name']))){
				if ($adminDbFunc->addNewSeatMap($_POST['seatMap'], $_FILES['add_seat_map_file']['name'])){
					$_SESSION['success_message'] = true;
					header("Location: ". WEB_PATH.'seatmaps/view/');			
					exit();
				}else{
					$_SESSION['already_error_message'] = true;
				}
			}else{
				$_SESSION['upload_error_message'] = true;			
			}	
		}
	}
}	
if (($view == "drop") && (isset($QPramas))){
	if ($adminDbFunc->dropSeatMapByItsId($QPramas)){
		$_SESSION['drop_message'] = true;
		$current_path = IMAGE_UPLOADED_PATH.DS.$seatMapDetails['seatMapImge'];		
		if (file_exists($current_path)){
			unlink($current_path);
		}
		header("Location: ". WEB_PATH.'seatmaps/view/');			
		exit();
	}	
}
if (($view == "edit") && (isset($QPramas))){
	$seatMapDetails = $adminDbFunc->editSeatMapDetailsByItsId($QPramas);
	if ("POST" == $_SERVER['REQUEST_METHOD']){
		if (isset($_POST['editSeatMap'])){	
			$errors = errorCheckingFields($_POST['editSeatMap']);
		}
		if ($errors['errorStatus']){
				$_SESSION['error_message'] = true;
		}else{
			if ($_FILES['update_seat_map_file']['name'] != ""){
				$current_path = IMAGE_UPLOADED_PATH.DS.$seatMapDetails['seatMapImge'];
				if (file_exists($current_path)){
					unlink($current_path);
				}
				$new_path = IMAGE_UPLOADED_PATH.DS.basename($_FILES['update_seat_map_file']['name']);
				if (move_uploaded_file($_FILES['update_seat_map_file']['tmp_name'], $new_path)) {
					$seat_map = basename($_FILES['update_seat_map_file']['name']);
					if ($adminDbFunc->updateNewSeatMapDetails($_POST['editSeatMap']['name'], $seat_map, $seatMapDetails['id'])){
						$_SESSION['update_success_message'] = true;
						header("Location: ". WEB_PATH.'seatmaps/view/');			
						exit();
					}
				}else{
					$_SESSION['upload_error_message'] = true;			
				}
			}else{
				  if ($adminDbFunc->updateNewSeatMapDetails($_POST['editSeatMap']['name'], $seatMapDetails['seatMapImge'], $seatMapDetails['id'])){
						$_SESSION['update_success_message'] = true;
						header("Location: ". WEB_PATH.'seatmaps/view/');			
						exit();
				  }
			}
		}
	}
}