<?php

include '../define.inc';
global $DBConn;
$DBConn = new DatabaseConnection();

class DatabaseConnection{

	public $connection = NULL;
	
	function __construct() {
	
		if ($connection = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD)){
			mysql_select_db(DB_NAME);
			$this->connection = $connection;
		}else{
			return NULL;
		}
	}
	
	function execute_query($query) {
	
		if ($query != ""){
			return mysql_query($query, $this->connection);
		}
	}
	
	function return_mysql_fetched_results($results, $params) {
	
		$i = 0;
		$resulted_array = array();
		while($row = mysql_fetch_array($results)){
			foreach($params as $eachParam){
				$resulted_array[$i][$eachParam] = $row[$eachParam];
			}$i++;
		}
		return $resulted_array;
	}

	function return_mysql_fetched_results_to_single_array($results, $params) {
	
		$resulted_array = array();
		while($row = mysql_fetch_array($results)){
			foreach($params as $eachParam){
				$resulted_array[$eachParam] = $row[$eachParam];
			}
		}
		return $resulted_array;
	}
	
	function return_single_result($result, $pos) { return mysql_result($result, $pos); }
	
	function getEventNameBySlugName($event_slug) {
	
		$query = "SELECT wp_em_events.event_name FROM wp_em_events WHERE wp_em_events.event_slug = '{$event_slug}' AND wp_em_events.event_status = 1";
		$results = $this->execute_query($query);
		return $this->return_single_result($results, 0);
	}
	
	function checkTheSelectedEventSluigIsParentEventOrChildEvent($event_slug) {

		$query = "SELECT wp_em_events.event_parent_id FROM wp_em_events WHERE wp_em_events.event_slug = '{$event_slug}' AND wp_em_events.event_status = 1";
		$results = $this->execute_query($query);
		$event_parent_id = $this->return_single_result($results, 0);
		if ($event_parent_id != 0){
			return true;
		}else{
			return false;
		}
	}
	
	function getTheSubEventsDetailsByEventSlug($event_slug) {
	
		$query = "SELECT 
					wp_em_events.post_id, wp_em_events.event_parent_id, wp_em_events.event_name, wp_em_events.event_slug, wp_em_events.event_start_date, wp_em_events.event_start_time, wp_em_events.event_end_time, wp_em_events.event_end_date, 
					wp_em_locations.location_name, wp_em_locations.location_town
				  FROM wp_em_events 
				  LEFT JOIN wp_em_locations 
				  ON wp_em_events.location_id = wp_em_locations.location_id
				  WHERE wp_em_events.event_slug = '{$event_slug}' AND wp_em_events.event_parent_id != 0";
		$results = $this->execute_query($query);
		$params = array('post_id', 'event_name', 'event_parent_id', 'event_slug', 'event_start_date', 'event_start_time', 'event_end_time', 'event_end_date', 'location_name', 'location_town');
		$resulted_array = $this->return_mysql_fetched_results($results, $params);
		return $resulted_array;
	}
	
	function getTheEventSubEventsBySlugName($eventSlug) {

		$query = "SELECT wp_em_events.event_id FROM wp_em_events WHERE wp_em_events.event_slug = '{$eventSlug}' AND wp_em_events.event_status = 1";
		$results = $this->execute_query($query);
		$event_id = $this->return_single_result($results, 0);
		$query = "SELECT 
					wp_em_events.post_id, wp_em_events.event_name, wp_em_events.event_slug, wp_em_events.event_start_date, wp_em_events.event_start_time, wp_em_events.event_end_time, wp_em_events.event_end_date, 
					wp_em_locations.location_name, wp_em_locations.location_town
				  FROM wp_em_events 
				  LEFT JOIN wp_em_locations 
				  ON wp_em_events.location_id = wp_em_locations.location_id
				  WHERE wp_em_events.event_parent_id = '{$event_id}'";
		$results = $this->execute_query($query);
		$params = array('post_id', 'event_name', 'event_slug', 'event_start_date', 'event_start_time', 'event_end_time', 'event_end_date', 'location_name', 'location_town');
		$resulted_array = $this->return_mysql_fetched_results($results, $params);
		return $resulted_array;
	}
	
	function getSeatTypes() {
	
		$query = "SELECT * FROM wp_em_seat_map";
		$results = $this->execute_query($query);
		$params = array('id', 'seat_type', 'price', 'seat_map');
		$resulted_array = $this->return_mysql_fetched_results($results, $params);
		return $resulted_array;
	}
	
	function getSeatTypeDetails($postedValues) {

		$query = "SELECT * FROM wp_em_seat_map WHERE id = {$postedValues['Id']}";
		$results = $this->execute_query($query);
		$params = array('id', 'seat_type', 'price', 'seat_map');
		$resulted_array = $this->return_mysql_fetched_results_to_single_array($results, $params);
		return $resulted_array;
	}
	
	function getTheNewPostContent($event_slug) {
	
		$query = "SELECT 
					post_content  
				  FROM wp_em_events 
				  WHERE event_slug  = '{$event_slug}'";
		$results = $this->execute_query($query);
		return $this->return_single_result($results, 0);
	}
	
	function getAllEventsListed() {
	
		$query = "SELECT 
					wp_em_events.post_id, wp_em_events.event_name, wp_em_events.event_slug, wp_em_events.event_start_date, wp_em_events.event_end_date, 
					wp_em_locations.location_name, wp_em_locations.location_town
				  FROM wp_em_events 
				  LEFT JOIN wp_em_locations 
				  ON wp_em_events.location_id = wp_em_locations.location_id
				  WHERE event_status = 1 AND wp_em_events.event_parent_id = 0";
				  var_dump($this->connection);
		$results = $this->execute_query($query);
		$params = array('post_id', 'event_name', 'event_start_date', 'event_end_date', 'location_name', 'location_town', 'event_slug');
		$resulted_array = $this->return_mysql_fetched_results($results, $params);
		return $resulted_array;
	}
	
	function doMailForBooking($event_name, $postedResult, $seatedDetails, $eventDetails) {

		$to  = 'jeronmall2011@gmail.com' . ', ';
     	$to .= $postedResult['email'];
		$from = "contact@madonnatickets2012.com"; 
		$subject = "{$event_name} booking order"; 
	
		$content = " <h3>Booking order details</h3>\n";
		$content .= "<br /><table border='0' cellpadding='2' cellspacing='2' align='left'>
						<tr>
							<td><b>Event Date<b> </td>
							<td><div class='smallWidthDiv'><!-- --></div></td>							
							<td class='paddingLeft'>".$eventDetails['event_start_date']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Time<b> </td>
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".date('h:i',strtotime($eventDetails['event_start_time']))."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Location<b> </td>
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$eventDetails['location_name'].", ".$eventDetails['location_town']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Ticket Type<b> </td>
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$seatedDetails['name']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Ticket Quantity<b> </td>
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$seatedDetails['noOfTickets']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Ticket Price<b> </td>
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>&euro;".($seatedDetails['description'] * $seatedDetails['noOfTickets'])."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>First Name<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['fname']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Last Name<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['lname']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Email<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['email']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Billing Address<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['address']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Post Code<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['postcode']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Card Name<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['card_name']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Card Type<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['card_type']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Card Number<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['card_number']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Card Security Number<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['security_number']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Card Expiry Date<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['card_expiry_month']."-".$postedResult['card_expiry_year']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>";
						if (($postedResult['card_start_month'] != "") && ($postedResult['card_start_year'] != "")){
			$content .= "<tr>
							<td><b>Card Start Date<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['card_start_month']."-".$postedResult['card_start_year']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>";
						}
			$content .= "<tr>
							<td><b>Delivery Address<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['delievery_address']."</td>
						</tr>
						<tr>
							<td colspan='3'>&nbsp;</td>
						</tr>
						<tr>
							<td><b>Telephone Number<b> </td>							
							<td><div class='smallWidthDiv'><!-- --></div></td>														
							<td class='paddingLeft'>".$postedResult['telno']."</td>
						</tr>
					</table>";
		
		$message = "<html><head></head><body style=\"font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; background-image:".home_url( '/' )."/images/bodybg.jpg;\">{$content}</body></html>"; 
	
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
		$headers  .= "From: {$from}\r\n"; 
		mail($to, $subject, $message, $headers); 
	}
	
	function addBookingOrder($event_name, $postedDetails, $seatTypeDetails, $eventExtraDetails) {
	
		$query = "INSERT INTO wp_em_real_bookings (event_slug, event_name, event_start_date, event_start_time, location, email, first_name, last_name, billing_address, post_code, ticket_type,
													total_tickets_price, total_tickets, name_of_card, card_type, card_number, security_number, expiry_date, start_date, delivery_address, tel_no
												   ) VALUES (
												   			'".$eventExtraDetails['event_slug']."', '".$event_name."', '".$eventExtraDetails['event_start_date']."', 
															'".$eventExtraDetails['event_start_time']."', '".$eventExtraDetails['location']."', '".$postedDetails['email']."', 
															'".$postedDetails['fname']."', '".$postedDetails['lname']."', '".$postedDetails['address']."', '".$postedDetails['postcode']."', 
															'".$seatTypeDetails['seat_type']."', '".($seatTypeDetails['price'] * $seatTypeDetails['selectedQty'])."', ".$seatTypeDetails['selectedQty'].", 
															'".$postedDetails['card_name']."', '".$postedDetails['card_type']."', '".$postedDetails['card_number']."', '".$postedDetails['security_number']."', 
															'".$postedDetails['card_expiry_year']."-".$postedDetails['card_expiry_month']."-00', '".$postedDetails['card_start_year']."-".$postedDetails['card_start_month']."-00', 
															'".$postedDetails['delievery_address']."', '".$postedDetails['telno']."'		
												   			)";	
		$results = $this->execute_query($query);
		if ($results){
			return true;
		}													
	}
}