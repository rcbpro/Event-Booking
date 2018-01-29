<div id="eventAddingDiv">
    <?php if ((isset($_SESSION['error_message'])) && ($_SESSION['error_message'])):?>
    <?php unset($_SESSION['error_message']);?>    
    <span class="errorInSpan">Please fix errors !</span>
    <?php endif;?>
    <?php if ((isset($_SESSION['already_error_message'])) && ($_SESSION['already_error_message'])):?>
    <?php unset($_SESSION['already_error_message']);?>    
    <span class="errorInSpan">This name is already exists !</span>    
    <?php endif;?>
    <form name="add_form_events" action="" method="post">
    	<div style="float:left; margin-left:-30px;">
            <table border="0" cellpadding="0" cellspacing="0" >
                <tr>
                    <td><label>Sub Event Name</label>&nbsp;&nbsp;</td>
                    <td><input style="<?php echo (((isset($errors)) && (in_array('subeventname', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="subevents[subeventname]" /></td>
                </tr>
                <tr>
                    <td><label>Parent Name</label>&nbsp;&nbsp;</td>
                    <td>
                    	<div style="width:165px; <?php echo (((isset($errors)) && (in_array('parentevents', $errors['errorFields']))) ? 'border:1px solid #FF0000;' : '');?>">
                        <select name="subevents[parentevents]">
                            <option value="">Select the parent event</option>                    
                            <?php foreach($parentevents as $eachparentevent):?>
                            <option value="<?php echo $eachparentevent['event_id'];?>"><?php echo $eachparentevent['event_name'];?></option>
                            <?php endforeach;?>
                        </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><label>Date</label>&nbsp;&nbsp;</td>
                    <td><input id="datepicker" onfocus="showCalendarControl(this);" style="<?php echo (((isset($errors)) && (in_array('date', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="subevents[date]" /></td>
                </tr>
                <tr>
                    <td><label>Venue Name</label>&nbsp;&nbsp;</td>
                    <td><input style="<?php echo (((isset($errors)) && (in_array('venue', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="subevents[venue]" /></td>
                </tr>
                <tr>
                    <td><label>City</label>&nbsp;&nbsp;</td>
                    <td><input style="<?php echo (((isset($errors)) && (in_array('city', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="subevents[city]" /></td>
                </tr>
                <tr>
                    <td colspan="2" align="right">&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="add_sub_event" value="Add Sub Event" style="width:225px;" class="buyButton AdminButtons" /></td>
                </tr>
            </table>
        </div>
        <div style="float:left;">    
			<label>Ticket Type</label>&nbsp;&nbsp;<input style="<?php echo (((isset($errors)) && (in_array('tickettype', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="subevents[tickettype]" /><br /><br />        
			<label>Ticket Price</label>&nbsp;&nbsp;<input style="<?php echo (((isset($errors)) && (in_array('ticketprice', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="subevents[ticketprice]" /><br /><br />
        	<label>Seat Map</label>&nbsp;&nbsp;&nbsp;&nbsp;
          	<div style="float:right; width:190px; <?php echo (((isset($errors)) && (in_array('seatmap', $errors['errorFields']))) ? 'border:1px solid #FF0000;' : '');?>">            
            <select name="subevents[seatmap]">
            	<option value="">Please select the seat map</option>            
            	<?php foreach($seatMaps as $eachseatmap):?>
            	<option value="<?php echo $eachseatmap['id'];?>"><?php echo $eachseatmap['seatMapName'];?></option>
                <?php endforeach;?>
            </select>              
            </div>          
        </div>
    </form>
</div>
<input class="buyButton backToHome" type="button" style="width:290px; margin-top:15px;" value="Back to Admin Panel" />