<?php
	session_start();
	require $_SERVER['DOCUMENT_ROOT'].'/www.coldplayconcerttickets.co.uk/wp_ex_functions.php';
	$splitted_url = explode("/", $_SERVER['REQUEST_URI']);			
	foreach($splitted_url as $eachSplit){
		if (!empty($eachSplit)) $newSplittedUrls[] = $eachSplit;
	}
	if (isset($_SESSION['seatsBuyForm'])) unset($_SESSION['seatsBuyForm']);
	$events = $DBConn->getAllEventsListed(end($newSplittedUrls));
?>
<table border="0" cellpadding="0" cellspacing="0">
    <thead class="tableHeading">
        <th align="center">Event</th>
    </thead>
    <tbody>	
        <?php for($i=0; $i<count($events); $i++):?>
        <tr class="<?php echo ($i % 2 == 0) ? 'evenCssClass' : 'oddCssClass';?>">
            <td><a href="<?php echo WEB_PATH.$events[$i]['event_slug'];?>/"><?php echo $events[$i]['event_name'];?></a></td>	
        </tr>    
        <?php endfor;?>
    </tbody>
</table>
<?php if ($_SESSION['mail_sent'] == 'OK'):?>
<?php 
    unset($_SESSION['mail_sent']);
    unset($_SESSION['seatsBuyForm']);
?>
<div id="bookingMessage2" class="successMessageForBooking">Mail has been sent succesfully !</div>
<?php endif;?>
