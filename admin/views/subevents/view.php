<?php session_start();?>
<div id="eventListingDiv" style="overflow-hidden; width:650px; margin-left:-20px;">
<?php if ((isset($_SESSION['success_message'])) && ($_SESSION['success_message'])):?>
<span class="successInSpan">New Parent Event added successfully !</span>
<?php unset($_SESSION['success_message']);?>
<?php endif;?>
<?php if ((isset($_SESSION['update_success_message'])) && ($_SESSION['update_success_message'])):?>
<span class="successInSpan">Sub Event updated successfully !</span>
<?php unset($_SESSION['update_success_message']);?>
<?php endif;?>
<?php if ((isset($_SESSION['drop_message'])) && ($_SESSION['drop_message'])):?>
<span class="successInSpan">&nbsp;&nbsp;Sub Event deleted successfully !</span>
<?php unset($_SESSION['drop_message']);?>
<?php endif;?>
<table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
	<thead>
    	<th>Event Name</th>
    	<th>Parent Event</th>
    	<th>Date</th>
    	<th>Venue</th>
    	<th>City</th>  
    	<th>Edit</th>  
    	<th>Drop</th>                                                        
    </thead>
    <tbody>
    	<?php if (count($subevents) > 0):?>
			<?php foreach($subevents as $eachSubEvent):?>
            <tr>
                <td style="width:30%;" align="left"><a href="<?php echo LOCAL_WEB_PATH.'tickets'.PS.$eachSubEvent['event_slug']?>/"><?php echo $eachSubEvent['event_name']?></a></td>
                <td style="width:30%;" align="left"><?php echo $adminDbFunc->getParentEventNameByPArentEventId($eachSubEvent['event_parent_id'])?></td>        
                <td style="width:10%;" align="left"><?php echo $eachSubEvent['date']?></td>        
                <td style="width:10%;" align="left"><?php echo $eachSubEvent['venue']?></td>
                <td style="width:10%;" align="left"><?php echo $eachSubEvent['city']?></td>        
                <td style="width:5%;" align="left"><a href="<?php echo WEB_PATH.'subevents/edit/'.$eachSubEvent['event_id']?>/"><img src="<?php echo WEB_PATH."public".PS.'images'.PS;?>b_edit.png" /></a></td>
                <td style="width:5%;" align="left"><a href="<?php echo WEB_PATH.'subevents/drop/'.$eachSubEvent['event_id']?>/"><img src="<?php echo WEB_PATH."public".PS.'images'.PS;?>b_drop.png" /></a></td>
            </tr>
            <?php endforeach;?>
        <?php else:?>
            <tr>
                <td colspan="3"><span class="successInSpan">No sub events !</span></td>
            </tr>
        <?php endif;?>
    </tbody>
</table>
</div>
<input class="buyButton backToHome" type="button" style="width:290px; margin-top:15px;" value="Back to Admin Panel" />