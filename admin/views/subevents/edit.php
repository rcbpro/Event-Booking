<div id="eventAddingDiv">
    <?php if ((isset($_SESSION['error_message'])) && ($_SESSION['error_message'])):?>
    <?php unset($_SESSION['error_message']);?>    
    <span class="errorInSpan">Please fix these errors !</span>
    <?php endif;?>
    <?php if ((isset($_SESSION['already_error_message_for_sub'])) && ($_SESSION['already_error_message_for_sub'])):?>
    <?php unset($_SESSION['already_error_message_for_sub']);?>    
    <span class="errorInSpan">This name is already exists !</span>    
    <?php endif;?>
    <?php if ((isset($_SESSION['new_ticket_success_message'])) && ($_SESSION['new_ticket_success_message'])):?>
    <?php unset($_SESSION['new_ticket_success_message']);?>    
    <span class="successInSpan">New Ticket type added !</span>    
    <?php endif;?>    
    	<div style="float:left; margin-left:-35px;">
		    <form name="update_form_events" action="" method="post">        
            <table border="0" cellpadding="0" cellspacing="0" >
                <tr>
                    <td><label>Sub Event Name</label></td>
                    <td><input value="<?php echo $subEventDetails['event_name']?>" style="<?php echo (((isset($errors)) && (in_array('subeventname', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="subeventsedit[subeventname]" /></td>
                </tr>
                <tr>
                    <td><label>Parent Name</label></td>
                    <td>
                    	<div style="width:165px; <?php echo (((isset($errors)) && (in_array('parentevents', $errors['errorFields']))) ? 'border:1px solid #FF0000;' : '');?>">
                        <select name="subeventsedit[parentevents]">
                            <option value="">Select the parent event</option>                    
                            <?php foreach($parentevents as $eachparentevent):?>
                            <option value="<?php echo $eachparentevent['event_id'];?>" <?php echo ($subEventDetails['event_parent_id'] == $eachparentevent['event_id']) ? "selected" : ""?>><?php echo $eachparentevent['event_name'];?></option>
                            <?php endforeach;?>
                        </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Date</label></td>
                    <td><input value="<?php echo $subEventDetails['date']?>" id="datepicker" onfocus="showCalendarControl(this);" style="<?php echo (((isset($errors)) && (in_array('date', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="subeventsedit[date]" /></td>
                </tr>
                <tr>
                    <td><label>Venue Name</label></td>
                    <td><input value="<?php echo $subEventDetails['venue']?>" style="<?php echo (((isset($errors)) && (in_array('venue', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="subeventsedit[venue]" /></td>
                </tr>
                <tr>
                    <td><label>City</label></td>
                    <td><input value="<?php echo $subEventDetails['city']?>" style="<?php echo (((isset($errors)) && (in_array('city', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="subeventsedit[city]" /></td>
                </tr>
                <tr>
                    <td><label>Seat Map</label></td>
                    <td>
                    	<div style="float:right; width:190px; <?php echo (((isset($errors)) && (in_array('seatmap', $errors['errorFields']))) ? 'border:1px solid #FF0000;' : '');?>">
                        <select name="subeventsedit[seatmap]">
                            <option value="">Please select the seat map</option>            
                            <?php foreach($seatMaps as $eachseatmap):?>
                            <option value="<?php echo $eachseatmap['id'];?>" <?php echo ($subEventDetails['seatMap'] == $eachseatmap['id']) ? "selected" : ""?>><?php echo $eachseatmap['seatMapName'];?></option>
                            <?php endforeach;?>
                        </select>              
			            </div>                                  
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="right">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="update_sub_event" value="Update Sub Event" style="width:265px;" class="buyButton AdminButtons" /></td>
                </tr>
            </table>
            </form>
        </div>
        <div style="float:left;">   
        	<table border="0" cellpadding="0" cellspacing="0"> 
            	<thead>
                	<th>Ticket Type</th>
                	<th>Ticket Price</th>                    
                </thead>
                <tbody>    
                	<?php if (count($ticketTypes) > 0):?>
                    <?php foreach($ticketTypes as $eachTicketType):?>	
                    <tr>
                        <td><?php echo $eachTicketType['ticket_type']?></td>
                        <td><?php echo $eachTicketType['ticket_price']?></td>
					</tr>
                    <?php endforeach;?>
                    <?php endif;?>
                </tbody>                        
			</table>
  		    <form name="add_more_ticket_types" action="" method="post">        
                <label>Ticket Type</label>&nbsp;&nbsp;<input style="<?php echo (((isset($errors)) && (in_array('tickettype', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="moretickettypes[tickettype]" /><br /><br />            
                <label>Ticket Price</label>&nbsp;&nbsp;<input style="<?php echo (((isset($errors)) && (in_array('ticketprice', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="moretickettypes[ticketprice]" /><br /><br />            
                <input type="submit" name="add_ticket_types" value="More Ticket Types" style="width:265px;" class="buyButton AdminButtons" />            
			</form>	
        </div>
</div>
<input class="buyButton backToHome" type="button" style="width:290px; margin-top:15px;" value="Back to Admin Panel" />