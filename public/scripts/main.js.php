<?php 
defined('PS') ? NULL : define('PS', '/');
defined('WEB_PATH') ? NULL : define('WEB_PATH', 'http://'.$_SERVER['HTTP_HOST'].PS.'event_booking'.PS.'admin'.PS);
?>
$(document).ready(function(){
	$("#parentEvents").click(function(){
		location.href = "<?php echo WEB_PATH?>events/index/";									  
	});
	$("#subEvents").click(function(){
		location.href = "<?php echo WEB_PATH?>subevents/index/";									  
	});
	$("#seatMaps").click(function(){
		location.href = "<?php echo WEB_PATH?>seatmaps/view/";									  
	});
	$("#viewBookings").click(function(){
		location.href = "<?php echo WEB_PATH;?>bookings/index/";									  
	});
    $("#subEventView").click(function(){
    	location.href = "<?php echo WEB_PATH;?>subevents/view/";									  
    });
    $("#subEventsAdd").click(function(){
    	location.href = "<?php echo WEB_PATH;?>subevents/add/";									  
    });
    $("#seatMapView").click(function(){
    	location.href = "<?php echo WEB_PATH;?>seatmaps/view/";									  
    });
    $("#seatMapAdd").click(function(){
    	location.href = "<?php echo WEB_PATH;?>seatmaps/add/";									  
    });
    $("label").inFieldLabels();
});