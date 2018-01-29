<?php session_start();?>
<div id="eventListingDiv" style="overflow-hidden; float:left; width:400px;">
<?php if ((isset($_SESSION['error_message'])) && ($_SESSION['error_message'])):?>
<?php unset($_SESSION['error_message']);?>    
<span class="errorInSpan">Please fix errors !</span>
<?php endif;?>
<?php if ((isset($_SESSION['already_error_message'])) && ($_SESSION['already_error_message'])):?>
<?php unset($_SESSION['already_error_message']);?>    
<span class="errorInSpan">This name is already exists !</span>    
<?php endif;?>
<?php if ((isset($_SESSION['upload_error_message'])) && ($_SESSION['upload_error_message'])):?>
<?php unset($_SESSION['upload_error_message']);?>    
<span class="errorInSpan">Image Uploading error !</span>    
<?php endif;?>
<?php if ((isset($_SESSION['success_message'])) && ($_SESSION['success_message'])):?>
<span class="successInSpan">New Seatmap added successfully !</span>
<?php unset($_SESSION['success_message']);?>
<?php endif;?>
<?php if ((isset($_SESSION['update_success_message'])) && ($_SESSION['update_success_message'])):?>
<span class="successInSpan">Seatmap updated successfully !</span>
<?php unset($_SESSION['update_success_message']);?>
<?php endif;?>
<?php if ((isset($_SESSION['drop_message'])) && ($_SESSION['drop_message'])):?>
<span class="successInSpan">Seatmap deleted successfully !</span>
<?php unset($_SESSION['drop_message']);?>
<?php endif;?>
    <table id="seatmaps" style="width:70%;" border="1" cellpadding="0" cellspacing="0">
        <thead>
            <th style="width:20%;">Seat Map(Thumb)</th>
            <th style="width:40%;">Seat Map Name</th>
            <th style="width:5%;">Edit</th>
            <th style="width:5%;">Drop</th>        
        </thead>
        <tbody>
            <?php if (count($allSeatMaps) > 0):?>
                <?php foreach($allSeatMaps as $eachSeatMap):?>
                <tr>
                    <td style="width:20%;" align="left"><a class="seatMapImageLitebox" href="<?php echo IMAGE_UPLOADED_URL_PATH.$eachSeatMap['seatMapImge']?>"><img width="60" height="60" src="<?php echo IMAGE_UPLOADED_URL_PATH.$eachSeatMap['seatMapImge']?>"></a></td>
                    <td style="width:40%;" align="left"><?php echo $eachSeatMap['seatMapName']?></td>        
                    <td style="width:5%;" align="left"><a href="<?php echo WEB_PATH?>seatmaps/edit/<?php echo $eachSeatMap['id']?>/"><img src="<?php echo WEB_PATH?>public/images/b_edit.png"></a></td>
                    <td style="width:5%;" align="left"><a href="<?php echo WEB_PATH?>seatmaps/drop/<?php echo $eachSeatMap['id']?>/"><img src="<?php echo WEB_PATH?>public/images/b_drop.png"></a></td>
                </tr>
                <?php endforeach;?>
            <?php else:?>
                <tr>
                    <td colspan="3"><span class="successInSpan">No Seat maps !</span></td>
                </tr>
            <?php endif;?>
        </tbody>
    </table>
</div>
<div style="float:left; margin-left:20px;">    
    <form name="add_seat_map_form" action="" method="post" enctype="multipart/form-data">
        <label id="eventLabel" for="seatMapName">Seat Map Name</label><input id="seatMapName" style="<?php echo (((isset($errors)) && (in_array('name', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" type="text" name="seatMap[name]" /><br /><br />
        <div style="<?php echo ((isset($_POST['seatMap'])) && ($_FILES['add_seat_map_file']['name'] == "") ? 'width:218px; border:#FF0000 1px solid;' : '');?>"><input type="file" name="add_seat_map_file" style="width:25px;" /></div><br />
        <input type="submit" name="add_seat_map" value="Add Seat Map" style="width:200px;" class="buyButton AdminButtons" />
    </form>
</div>
<input class="buyButton backToHome" type="button" style="width:290px; margin-top:15px;" value="Back to Admin Panel" />