<div id="eventListingDiv" style="overflow-x:scroll; width:650px;">
<table style="width:200%;" border="1" cellpadding="0" cellspacing="0">
	<thead>
    	<th>Event Name</th>
    	<th>Event Start Date</th>
    	<th>Location</th>
    	<th>Email</th>
    	<th>Name</th>  
    	<th>Billing Address</th>  
    	<th>Post code</th>
    	<th>Total Ticket Price</th>                                                        
    	<th>No Of Tickets</th>
    	<th>Name of Card</th>
    	<th>Card Type</th>
    	<th>Card No:</th>
    	<th>Security No:</th>
    	<th>Expiry Date</th>  
    	<th>Delivery Address</th>  
    	<th>Telephone No:</th>                                                        

    </thead>
    <tbody>
    	<?php if (count($allBookings) > 0):?>
			<?php foreach($allBookings as $eachBooking):?>
            <tr>
                <td style="width:20%;" align="left"><a href="<?php echo LOCAL_WEB_PATH.'tickets'.PS.$eachBooking['event_slug']?>"><?php echo $eachBooking['event_name']?></a></td>
                <td style="width:20%;" align="left"><?php echo $eachBooking['event_start_date']?></td>                
                <td style="width:20%;" align="left"><?php echo $eachBooking['location']?></td>                
                <td style="width:20%;" align="left"><?php echo $eachBooking['email']?></td>                
                <td style="width:20%;" align="left"><?php echo $eachBooking['first_name'].' '.$eachBooking['last_name']?></td>                
                <td style="width:15%;" align="left"><?php echo $eachBooking['billing_address']?></td>         
                <td style="width:5%;" align="left"><?php echo $eachBooking['post_code']?></td>
                <td style="width:10%;" align="left"><?php echo $eachBooking['total_tickets_price']?></td>                                                                                                
                <td style="width:10%;" align="left"><?php echo $eachBooking['total_tickets']?></td>                
                <td style="width:10%;" align="left"><?php echo $eachBooking['name_of_card']?></td>                
                <td style="width:10%;" align="left"><?php echo $eachBooking['card_type']?></td>                
                <td style="width:5%;" align="left"><?php echo $eachBooking['card_number']?></td>                
                <td style="width:5%;" align="left"><?php echo $eachBooking['security_number']?></td>                
                <td style="width:10%;" align="left"><?php echo $eachBooking['expiry_date']?></td>                
                <td style="width:15%;" align="left"><?php echo $eachBooking['delivery_address']?></td>                
                <td style="width:5%;" align="left"><?php echo $eachBooking['tel_no']?></td>                
            </tr>
            <?php endforeach;?>
        <?php else:?>
            <tr>
                <td colspan="3"><span class="successInSpan">No bookings !</span></td>
            </tr>
        <?php endif;?>
    </tbody>
</table>
</div>
<input class="buyButton backToHome" type="button" style="width:290px; margin-top:15px;" value="Back to Admin Panel" />