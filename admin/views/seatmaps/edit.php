<div id="eventListingDiv" style="overflow-hidden; float:left; width:400px; margin-left:100px;">
    <form name="add_seat_map_form" action="" method="post" enctype="multipart/form-data">
        <label id="eventLabel" for="seatMapName">Seat Map Name</label><input value="<?php echo $seatMapDetails['seatMapName']?>" id="seatMapName" style="<?php echo (((isset($errors)) && (in_array('name', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="editSeatMap[name]" /><br /><br />
        <div style="<?php echo ((isset($_POST['seatMap'])) && ($_FILES['add_seat_map_file']['name'] == "") ? 'width:218px; border:#FF0000 1px solid;' : '');?>"><input type="file" name="update_seat_map_file" /></div><br />
        <input type="submit" name="update_seat_map" value="Update Seat Map" style="width:250px;" class="buyButton AdminButtons" />
    </form>
</div>
<div style="float:left; margin-left:20px;">    
	<a id="viewcurrentImage" href="<?php echo IMAGE_UPLOADED_URL_PATH.$seatMapDetails['seatMapImge']?>"><img width="60" height="60" src="<?php echo IMAGE_UPLOADED_URL_PATH.$seatMapDetails['seatMapImge']?>" /></a>        
</div>    
<input class="buyButton backToHome" type="button" style="width:290px; margin-top:15px;" value="Back to Admin Panel" />