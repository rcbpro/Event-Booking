<?php
global $adminDbFunc;
$adminDbFunc = new AdminDbExtraFunctions();

class AdminDbExtraFunctions{
	
	public $dbAdminConnection = NULL;
	public $query = "";
	
	function __construct(){
	
		$this->dbAdminConnection = mysql_connect("localhost", "root", "");
		if ($this->dbAdminConnection != NULL){
			mysql_select_db("coldplay_db") or die(mysql_error());
		}
	}
	
	function execute_query() { return mysql_query($this->query, $this->dbAdminConnection); }
	
	function return_single_filed_value($result) { return mysql_result($result, 0); }
	
	function fetchSomeDataToSingleArray($results, $params) {
	
		$fetchedArray = array();
		while($row = mysql_fetch_array($results)){
			foreach($params as $eachParam){
				$fetchedArray[$eachParam] = $row[$eachParam];
			}
		}
		return $fetchedArray;
	}
	
	function fetchSomeDataToAssArray($results, $params) {
	
		$i = 0;
		$fetchedArray = array();
		while($row = mysql_fetch_array($results)){
			foreach($params as $eachParam){
				$fetchedArray[$i][$eachParam] = $row[$eachParam];
			}$i++;
		}
		return $fetchedArray;
	}
	
	function addNewParentEvent($postedDetails) {
	
		if ($this->checkThisNameIsAlreadyExists($postedDetails['name'])){	
			$this->query = "INSERT INTO wp_events (event_name, event_slug) VALUES('".$postedDetails['name']."', '".(strtolower(implode("-", explode(" ", $postedDetails['name']))))."')";
			$results = $this->execute_query();
			if ($results) return true; else return NULL;
		}			
	}
	
	function addNewSubEvent($postedData) {

		if ($this->checkThisNameIsAlreadyExists($postedData['subeventname'])){	
			$date = explode("-", $postedData['date']);
			$dd = $date[1];
			$mm = $date[0];
			$yy = $date[2];
			$rev_date = $yy."-".$mm."-".$dd;
			$this->query = "INSERT INTO wp_events (event_name, event_slug, event_parent_id , date, venue, city, seatMap) 
							VALUES('".$postedData['subeventname']."', '".(strtolower(implode("-", explode(" ", $postedData['subeventname']))))."', ".$postedData['parentevents'].", '".$rev_date."',
							'".$postedData['venue']."', '".$postedData['city']."', ".$postedData['seatmap'].")";
			$results = $this->execute_query();
			if ($results){ 
				return mysql_insert_id();
			}else{	
				return NULL;
			}	
		}			
	}
	
	function addTicketTypes($postedData, $sub_event_id) {
	
		$this->query = "INSERT INTO wp_em_ticket_types (event_id, ticket_type, ticket_price) 
						VALUES(".$sub_event_id.", '".$postedData['tickettype']."', '".$postedData['ticketprice']."')";
		$this->execute_query();
	}
	
	function loadAllParentEvents($current_val = "") {
		
		$this->query = "SELECT event_id, event_slug, event_name FROM wp_events WHERE event_parent_id = 0";
		$parent_events = $this->fetchSomeDataToAssArray($this->execute_query(), array('event_id', 'event_slug', 'event_name'));
		foreach($parent_events as $eachEvent){
			if ($eachEvent['event_id'] == $current_val){
				$eachEvent['selected'] = "selected";
			}else{
				$eachEvent['selected'] = "";
			}
			$modified_events[] = $eachEvent;
		}	
		return $modified_events;
	}

	function loadAllSubEvents() {
		
		$this->query = "SELECT * FROM wp_events WHERE event_parent_id != 0";
		return $this->fetchSomeDataToAssArray($this->execute_query(), array('event_id', 'event_slug', 'event_name', 'event_parent_id', 'date', 'venue', 'city'));
	}
	
	function getSubEventDetailsByItsId($event_id) {
	
		$this->query = "SELECT * FROM wp_events WHERE event_parent_id != 0 AND event_id = {$event_id}";
		return $this->fetchSomeDataToSingleArray($this->execute_query(), array('event_id', 'event_name', 'event_slug', 'event_parent_id', 'date', 'venue', 'city', 'seatMap'));
	}
	
	function loadTicketTypesRelatedToThisSubEvent($event_id) {
	
		$this->query = "SELECT * FROM wp_em_ticket_types WHERE event_id = {$event_id}";
		return $this->fetchSomeDataToAssArray($this->execute_query(), array('event_id', 'ticket_type', 'ticket_price'));
	}
	
	function getParentEventNameByPArentEventId($eventId) {
	
		$this->query = "SELECT event_name FROM wp_events WHERE event_parent_id = 0 && event_id = {$eventId}";
		return $this->return_single_filed_value($this->execute_query());					
	}
	
	function dropMainEventById($eventId) {
	
		$this->query = "DELETE FROM wp_events WHERE event_parent_id = 0 AND event_id = {$eventId}";	
		$results = $this->execute_query();	
		if ($results) return true; 
	}	

	function dropSubEventById($eventId) {
	
		$this->query = "DELETE FROM wp_events WHERE event_parent_id != 0 AND event_id = {$eventId}";	
		$results = $this->execute_query();	
		if ($results) return true; 
	}

	function updateParentEventName($id, $value) {
	
		if ($this->checkThisNameIsAlreadyExists($value)){
			$event_slug = (strtolower(implode("-", explode(" ", $value))));		
			$this->query = "UPDATE wp_events SET event_name = '{$value}', event_slug = '{$event_slug}' WHERE event_id = {$id} AND event_parent_id = 0";	
			$results = $this->execute_query();	
			if ($results) return true; else return false;
		}	
	}
	
	function updateCurrentSubEvent($event_id, $postedDate) {

		if ($this->checkThisNameIsAlreadyExists($postedDate['subeventname'])){
			$event_slug = (strtolower(implode("-", explode(" ", $postedDate['subeventname']))));		
			$this->query = "UPDATE wp_events SET 
									event_name = '".$postedDate['subeventname']."', 
									event_slug = '".$event_slug."',
									event_parent_id = ".$postedDate['parentevents'].",
									date = '".$postedDate['date']."',
									venue = '".$postedDate['venue']."',																											
									city = '".$postedDate['city']."',
									seatMap = ".$postedDate['seatmap']."																																													
							WHERE event_id = ".$event_id;	
			$results = $this->execute_query();	
			if ($results) return true; else return false;
		}	
	}
	
	function checkThisNameIsAlreadyExists($value) {
	
		if ($value != ""){
			$this->query = "SELECT event_name FROM wp_events WHERE event_name = '{$value}'";
			$results = $this->return_single_filed_value($this->execute_query());			
			if ($results == ""){
				return true;
			}
		}	
	}
	
	function returnParentEventIdByPostId($post_id = "") {

		if (($post_id != "") && ($_GET['action'] == "edit")){
			$this->query = "SELECT event_parent_id FROM wp_em_events WHERE post_id = {$post_id}";
			return $this->return_single_filed_value($this->execute_query());
		}else{
			return "";
		}	
	}
	
   function addNewSeatMap($postedValues, $seat_map) {
   
   		$this->query = "INSERT INTO wp_em_seat_map (seatMapName, seatMapImge) VALUES('".$postedValues['name']."', '".$seat_map."')";	
		if ($this->execute_query()){
			return true;
		}
   }
   
   function loadAllSeatMaps() {
   
   		$this->query = "SELECT * FROM wp_em_seat_map";
		return $this->fetchSomeDataToAssArray($this->execute_query(), array('id', 'seatMapName', 'seatMapImge'));
   }
   
   function dropSeatMapByItsId($id) {
   	
		$this->query = "DELETE FROM wp_em_seat_map WHERE id = {$id}";
		$result = $this->execute_query();
		if ($result) return true;
   }
   
   function editSeatMapDetailsByItsId($id) {
   
		$this->query = "SELECT * FROM wp_em_seat_map WHERE id = {$id}";
		return $this->fetchSomeDataToSingleArray($this->execute_query(), array('id', 'seatMapName', 'seatMapImge'));
   }
   
   function updateNewSeatMapDetails($name, $seat_map, $id) {
   
		$this->query = "UPDATE wp_em_seat_map SET seatMapName = '".$name."', seatMapImge = '".$seat_map."' WHERE id = {$id}";
   		$results = $this->execute_query();
		if ($results){
			return true;
		}   	
   }
   
   function listAllBookings() {
   
		$this->query = "SELECT * FROM wp_em_real_bookings";
		return $this->fetchSomeDataToAssArray($this->execute_query(), array('booking_id', 'event_name', 'post_code', 'event_slug', 'event_start_date','email', 'first_name', 'last_name', 'billing_address', 'post_code', 'ticket_type',
													'total_tickets_price', 'total_tickets', 'name_of_card', 'card_type', 'card_number', 'security_number', 'expiry_date', 'delivery_address', 'tel_no'));
   }
   
   function dropSelectedSeatMap($seatMapId) {
   
 		$this->query = "DELETE FROM wp_em_seat_map WHERE id = {$seatMapId}";
		$results = $this->execute_query();  		
		if ($results) return true;
   }
   
   function loginProcess($loginDetails) {

		$this->query = "SELECT password FROM wp_tickets_admin_users WHERE username = '".$loginDetails['username']."'";
		return $this->return_single_filed_value($this->execute_query());   		
   }
}