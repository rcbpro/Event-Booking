<?php 
	session_start();
	require $_SERVER['DOCUMENT_ROOT'].'/www.coldplayconcerttickets.co.uk/wp_ex_functions.php';
	$splitted_url = explode("/", $_SERVER['REQUEST_URI']);			
	foreach($splitted_url as $eachSplit){
		if (!empty($eachSplit)) $newSplittedUrls[] = $eachSplit;
	}
	if (!$DBConn->checkTheSelectedEventSluigIsParentEventOrChildEvent(end($newSplittedUrls))){
		$events = $DBConn->getTheEventSubEventsBySlugName(end($newSplittedUrls));
		$parentId = 0;
		$event_title = $DBConn->getTheEventTitle(end($newSplittedUrls));
	}else{
		$events = $DBConn->getTheSubEventsDetailsByEventSlug(end($newSplittedUrls));	
		$parentId = $events[0]['event_parent_id'];	
		$event_title = $DBConn->getTheEventTitle($events[0]['event_slug']);
		$seatMapImage = $DBConn->getSeatMapImage($events[0]['seatMap']);
		$seatTypes = $DBConn->getSeatTypesForAParticullarEvent($events[0]['event_id']);	
	}	

	if ("POST" == $_SERVER['REQUEST_METHOD']){
		if (isset($_POST['seatTypeSubmitButton'])){		
			if (($_POST['seatType']['Qty'] != 0) && (!empty($_POST['seatType']['Qty'])) && ($_POST['seatType']['Qty'] != NULL)){
				$seatTypeDetails = $DBConn->getSeatTypeDetails($_POST['seatType']);
				$seatTypeDetails['selectedQty'] = $_POST['seatType']['Qty'];
				$_SESSION['seatsBuyForm'] = $seatTypeDetails;
				$events = $DBConn->getTheSubEventsDetailsByEventSlug(end($newSplittedUrls));	
			}
		}else if (isset($_POST['cutomer'])){

			$events_extra_details['event_slug'] = end($newSplittedUrls);
			$events_extra_details['event_name'] = $DBConn->getTheEventTitle(end($newSplittedUrls));			
			$events_extra_details['event_start_date'] = $events[0]['event_start_date'];
			$events_extra_details['event_start_time'] = $events[0]['event_start_time'];            
			$events_extra_details['location'] = (($events[0]['location_name'] == "") ? "--" : $events[0]['location_name']).(($events[0]['location_town'] != "") ? (", ".$events[0]['location_town']) : "");                   

			$DBConn->addBookingOrder($events_extra_details['event_name'], $_POST['cutomer'], $_SESSION['seatsBuyForm'], $events_extra_details);
			$DBConn->doMailForBooking($_POST['cutomer'], $_SESSION['seatsBuyForm'], $events_extra_details);
			$_SESSION['mail_sent'] = 'OK';
			echo "<script type='text/javascript' language='javascript'>window.location = '".WEB_PATH."/'</script>";
		}	
	}
?>
<script type="text/javascript" language="javascript">
function gotToFunc(url) {
	location.href = '<?php echo WEB_PATH?>' + url+'/';
}	
$(document).ready(function(){
	$("#emailSubmit").click(function(){
		var errors = false;
   		var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;   
		if (
			($("#cutomer_email").val() == "") &&
			($("#cutomer_name").val() == "") &&
			($("#cutomer_address").val() == "") &&
			($("#customer_postcode").val() == "") &&
			($("#cutomer_delievery_address").val() == "") &&
			($("#customer_telno").val() == "") && 
			($("#card_type").val() == "Select your card type") && 
			($("#customer_card_name").val() == "") &&			
			($("#customer_card_number").val() == "") &&
			($("#customer_security_number").val() == "") &&
			($("#customer_card_expiry_month").val() == "") &&
			($("#customer_card_expiry_year").val() == "")
		   ){
				$("#cutomer_email").addClass('errorClass');
				$("#cutomer_name").addClass('errorClass');
				$("#cutomer_address").addClass('errorClass');
				$("#customer_postcode").addClass('errorClass');
				$("#cutomer_delievery_address").addClass('errorClass');
				$("#customer_telno").addClass('errorClass');
				$("#customer_card_name").addClass('errorClass');				
				$("#card_type").addClass('errorClass');
				$("#customer_card_number").addClass('errorClass');
				$("#customer_security_number").addClass('errorClass');
				$("#customer_card_expiry_month").addClass('errorClass');
				$("#customer_card_expiry_year").addClass('errorClass');
				
				errors = true;																				
		   }else{ 
		   		if ($("#cutomer_email").val() == ""){ 
					errors = true;																				
					$("#cutomer_email").addClass('errorClass');
				}else{
					if (!emailReg.test($("#cutomer_email").val())){
						errors = true;																				
						$("#cutomer_email").addClass('errorClass');
					}else{
						$("#cutomer_email").removeClass('errorClass');
					}	
				}				
				if ($("#cutomer_fname").val() == ""){ 
					errors = true;							
					$("#cutomer_fname").addClass('errorClass');
				}else{
					$("#cutomer_fname").removeClass('errorClass');				
				}
				if ($("#cutomer_lname").val() == ""){ 
					errors = true;							
					$("#cutomer_lname").addClass('errorClass');
				}else{
					$("#cutomer_lname").removeClass('errorClass');				
				}
				if ($("#cutomer_address").val() == ""){ 
					errors = true;							
					$("#cutomer_address").addClass('errorClass');
				}else{
					$("#cutomer_address").removeClass('errorClass');								
				}
				if ($("#customer_postcode").val() == ""){ 
					errors = true;							
					$("#customer_postcode").addClass('errorClass');
				}else{
					$("#customer_postcode").removeClass('errorClass');												
				}
				if ($("#customer_card_name").val() == ""){ 
					errors = true;							
					$("#customer_card_name").addClass('errorClass');
				}else{
					$("#customer_card_name").removeClass('errorClass');												
				}
				if ($("#card_type").val() == "Select your card type"){ 
					errors = true;							
					$("#card_type").addClass('errorClass');
				}else{
					$("#card_type").removeClass('errorClass');												
				}
				if ($("#customer_card_number").val() == ""){ 
					errors = true;							
					$("#customer_card_number").addClass('errorClass');
				}else{
					$("#customer_card_number").removeClass('errorClass');												
				}
				if ($("#customer_security_number").val() == ""){ 
					errors = true;							
					$("#customer_security_number").addClass('errorClass');
				}else{
					$("#customer_security_number").removeClass('errorClass');												
				}
				if ($("#customer_card_expiry_month").val() == ""){ 
					errors = true;							
					$("#customer_card_expiry_month").addClass('errorClass');
				}else{
					$("#customer_card_expiry_month").removeClass('errorClass');												
				}
				if ($("#customer_card_expiry_year").val() == ""){ 
					errors = true;							
					$("#customer_card_expiry_year").addClass('errorClass');
				}else{
					$("#customer_card_expiry_year").removeClass('errorClass');												
				}
				
				if ($("#customer_card_start_month").val() != ""){ 
					if ($("#customer_card_start_year").val() == ""){ 
						errors = true;							
						$("#customer_card_start_year").addClass('errorClass');
					}else{
						$("#customer_card_start_year").removeClass('errorClass');												
					}
				}else{
					$("#customer_card_start_month").removeClass('errorClass');												
				}
				
				if ($("#cutomer_delievery_address").val() == ""){ 
					errors = true;							
					$("#cutomer_delievery_address").addClass('errorClass');
				}else{
					$("#cutomer_delievery_address").removeClass('errorClass');																
				}
				if ($("#customer_telno").val() == ""){ 
					errors = true;							
					$("#customer_telno").addClass('errorClass');																				
				}else{
					$("#customer_telno").removeClass('errorClass');																				
				}					
		   }								
		   
		   if (errors){
		   		$("#bookingMessage").removeClass("hide");
				$("#bookingMessage").html("Validation errors occurred. Please confirm the fields and submit it again.");
				$("#bookingMessage").addClass("validationMessageForBooking");
		   }else{
		   		$("#custom_booking_notification_mail_form").submit();
		   }							
	});
});
</script>
<?php if (($parentId == 0) && (!isset($_SESSION['seatsBuyForm']))):?>
<h1 class="entry-title"><?php echo $event_title; ?></h1>
<table border="0" cellpadding="0" cellspacing="0">
	<?php if (!empty($events)):?>            
	<thead class="tableHeading">
		<th>Event</th>
		<th>Date</th>
		<th>Venue</th>
		<th>City</th>                                                            
		<th>Buy / Sell</th>                                                                                
	</thead>
	<?php endif;?>                
	<tbody>	
		<?php if (!empty($events)):?>
		<?php for($i=0; $i<count($events); $i++):?>
		<tr class="<?php echo ($i % 2 == 0) ? 'evenCssClass' : 'oddCssClass';?>">
			<td><?php echo $events[$i]['event_name'];?></td>	
			<td><?php echo $events[$i]['date'];?></td>	
			<td><?php echo $events[$i]['venue'];?></td>	
			<td><?php echo $events[$i]['city'];?></td>	
			<td>
				<input type="hidden" name="post_id" value="<?php //echo $events[$i]['post_id'];?>" />
				<input type="button" value="Buy" class="buyButton" onclick="javascript:gotToFunc('<?php echo $events[$i]['event_slug'];?>');" />
			</td>	
		</tr>    
		<?php endfor;?>
		<?php else:?>
		<tr class="evenCssClass">
			<td colspan="5">No Sub Events</td>	
		</tr>    
		<?php endif;?>
	</tbody>
</table>
<?php elseif (($parentId != 0) && (!isset($_SESSION['seatsBuyForm']))):?>
<h1 class="entry-title"><?php echo $event_title; ?></h1>
<h3 align="right">Date : <?php echo $events[0]['date'];?></h3>
<h3 align="right">Location : <?php echo ($events[0]['venue'] == "") . $events[0]['city'];?></h3><br />
<div id="SeatMap"><img src="<?php echo WEB_PATH.'admin'.PS.'public'.PS.'uploaded'.PS.$seatMapImage; ?>" /></div>
<div class="clearH"></div>
<table border="0" cellpadding="0" cellspacing="0">
	<thead class="tableHeading">
		<th>Seat Type</th>
		<th>Price</th>
		<th>Qunatity</th>
		<th>Buy</th>
	</thead>
	<tbody>	
		<?php for($i=0; $i<count($seatTypes); $i++):?>
		<form name="seatsBuyForm" id="seatsBuyForm" method="post">
		<tr class="<?php echo ($i % 2 == 0) ? 'evenCssClass' : 'oddCssClass';?>">
			<td><?php echo ucwords($seatTypes[$i]['ticket_type']);?></td>	
			<td>$<?php echo $seatTypes[$i]['ticket_price'];?></td>	
			<td>
            	<input class="smallTextBox" type="text" name="seatType[Qty]" value="1" /><input class="smallTextBox" type="hidden" name="seatType[Id]" value="<?php echo $seatTypes[$i]['id'];?>" />
            </td>	
			<td><input type="submit" value="Buy" class="seatBuyButton" name="seatTypeSubmitButton" /></td>	
		</tr>    
		</form>                    
		<?php endfor;?>
	</tbody>
</table>
<?php elseif (isset($_SESSION['seatsBuyForm'])):?>
<h1 class="entry-title"><?php echo $event_title; ?></h1>
<h3 align="right">Date : <?php echo $events[0]['date'];?></h3>
<h3 align="right">Location : <?php echo ($events[0]['venue'] == "") . $events[0]['city'];?></h3>
<form id="custom_booking_notification_mail_form" name="custom_booking_notification_mail_form" method="post" action="">
<table id="custom_booking_notification_mail_table" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td><h3>Ticket Type : </td>
		<td><h3><?php echo ucwords($_SESSION['seatsBuyForm']['ticket_type']);?></h3></td>
	</tr>
	<tr>
		<td><h3>Ticket Price : </td>
		<td><h3>&euro;<?php printf("%01.2f", ($_SESSION['seatsBuyForm']['ticket_price'] * $_SESSION['seatsBuyForm']['selectedQty']));?></h3></td>
	</tr>
	<tr>
		<td><h3>Number of Tickets : </td>
		<td><h3><?php echo $_SESSION['seatsBuyForm']['selectedQty'];?></h3></td>
	</tr>
	<tr>
		<td>Email * </td>
		<td><input type="text" name="cutomer[email]" id="cutomer_email" /></td>
	</tr>
	<tr>
		<td>First Name * </td>
		<td><input type="text" name="cutomer[fname]" id="cutomer_fname" /></td>
	</tr>
	<tr>
		<td>Last Name * </td>
		<td><input type="text" name="cutomer[lname]" id="cutomer_lname" /></td>
	</tr>
	<tr>
		<td>Billing Address * </td>
		<td><textarea name="cutomer[address]" rows="3" cols="30" id="cutomer_address"></textarea></td>
	</tr>
	<tr>
		<td>Post code * </td>
		<td><input type="text" name="cutomer[postcode]" id="customer_postcode" /></td>
	</tr>
	<tr>
		<td>Name of The Card * </td>
		<td><input type="text" name="cutomer[card_name]" id="customer_card_name" /></td>
	</tr>
	<tr>
		<td>Credit/debit card type * </td>
		<td>
			<select name="cutomer[card_type]" id="card_type">
				<option name="">Select your card type</option>                        
				<option name="visa">Visa</option>
				<option name="visa_debit">Visa debit</option>
				<option name="credit">Credit</option>
				<option name="visa_electron">Visa electron</option>
				<option name="master_card(credit)">Master card(credit)</option>           
				<option name="mastercard(debit)">Master card(debit)</option>           
				<option name="maestro">Maestro</option>                                                                   
			</select>
		</td>
	</tr>
	<tr>
		<td>Credit/debit card number * </td>
		<td><input type="text" name="cutomer[card_number]" id="customer_card_number" /></td>
	</tr>
	<tr>
		<td>Security number * </td>
		<td><input type="text" name="cutomer[security_number]" id="customer_security_number" /></td>
	</tr>
	<tr>
		<td>Expiry date * </td>
		<td>
			<select id="customer_card_expiry_month" name="cutomer[card_expiry_month]" class="smallWithInDate">
				<option value="">MM</option>
				<?php for ($i = 1; $i <= 12; $i++):?>
					<option value="<?php echo $i;?>"><?php echo date("F", mktime(0, 0, 0, $i+1, 0, 0));?></option>
				<?php endfor;?>
			</select>
		&nbsp;
			<select id="customer_card_expiry_year" name="cutomer[card_expiry_year]" class="smallWithInDate">
				<option value="">YY</option>
				<?php for ($i = date("Y") ; $i <= date("Y")+25; $i++):?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php endfor;?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Start date </td>
		<td>
			<select id="customer_card_start_month" name="cutomer[card_start_month]" class="smallWithInDate">
				<option value="">MM</option>
				<?php for ($i = 1; $i <= 12; $i++):?>
					<option value="<?php echo $i;?>"><?php echo date("F", mktime(0, 0, 0, $i+1, 0, 0));?></option>
				<?php endfor;?>
			</select>
		&nbsp;
			<select id="customer_card_start_year" name="cutomer[card_start_year]" class="smallWithInDate">
				<option value="">YY</option>
				<?php for ($i = date("Y") ; $i <= date("Y")+25; $i++):?>
					<option value="<?php echo $i;?>"><?php echo $i;?></option>
				<?php endfor;?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Delivery Address * </td>
		<td><textarea name="cutomer[delievery_address]" rows="3" cols="30" id="cutomer_delievery_address"></textarea></td>
	</tr>
	<tr>
		<td>Telephone Number * </td>
		<td><input type="text" name="cutomer[telno]" id="customer_telno" /></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><input id="emailSubmit" class="buyButton" type="button" name="emailSubmit" style="width:175px;" value="Submit"  /></td>
	</tr>
	<tr>
		<td colspan="2" align="center">
			<div id="bookingMessage" class="validationMessageForBooking hide"></div>
		</td>
	</tr>
</table> 
</form>        

<?php endif;?>
