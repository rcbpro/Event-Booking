<?php session_start();?>
<div id="eventListingDiv">
<table id="eventTable" style="width:100%;" border="1" cellpadding="0" cellspacing="0">
	<thead>
        <th>Event Name</th>
        <th>Event Url</th>
        <th>Drop</th>        
	</thead>    
    <tbody>
    	<?php if (count($allParentEvents) > 0):?>
			<?php foreach($allParentEvents as $eachParent):?>
            <tr id="<?php echo $eachParent['event_id']?>">
                <td class="event_name" style="width:30%;" align="left"><?php echo $eachParent['event_name']?></td>
                <td style="width:30%;" align="left"><a href="<?php echo LOCAL_WEB_PATH.'tickets/'.$eachParent['event_slug']?>/"><?php echo $eachParent['event_slug']?></a></td>        
                <td style="width:40%;" align="left"><a href="<?php echo WEB_PATH.'events/drop/'.$eachParent['event_id']?>"><img src="<?php echo WEB_PATH;?>public/images/b_drop.png" /></a></td>        
            </tr>
            <?php endforeach;?>    
        <?php else:?>
            <tr>
                <td colspan="3"><span class="successInSpan">No Parent events !</span></td>
            </tr>
        <?php endif;?>
    </tbody>
</table>
</div>
<div id="eventAddingDiv">
    <form name="add_form_events" action="" method="post">
        <label id="eventLabel" for="eventName">Event Name</label><input id="eventName" style="<?php echo (((isset($errors)) && (in_array('name', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="events[name]" /><br /><br />
        <input type="submit" name="add_main_event" value="Add Event" style="width:200px;" class="buyButton AdminButtons" />
    </form>
    <?php if ((isset($_SESSION['error_message'])) && ($_SESSION['error_message'])):?>
    <?php unset($_SESSION['error_message']);?>    
    <span class="errorInSpan">Please fix errors !</span>
    <?php endif;?>
    <?php if ((isset($_SESSION['already_error_message'])) && ($_SESSION['already_error_message'])):?>
    <?php unset($_SESSION['already_error_message']);?>    
    <span class="errorInSpan">This name is already exists !</span>    
    <?php endif;?>
    <?php if ((isset($_SESSION['success_message'])) && ($_SESSION['success_message'])):?>
    <span class="successInSpan">New Parent Event added successfully !</span>
    <?php unset($_SESSION['success_message']);?>
    <?php endif;?>
    <?php if ((isset($_SESSION['drop_message'])) && ($_SESSION['drop_message'])):?>
    <span class="successInSpan">Parent Event deleted successfully !</span>
    <?php unset($_SESSION['drop_message']);?>
    <?php endif;?>
</div>
<input class="buyButton backToHome" type="button" style="width:290px; margin-top:15px;" value="Back to Admin Panel" />