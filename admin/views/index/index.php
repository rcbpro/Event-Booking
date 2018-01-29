<?php if (isset($_SESSION['logged'])):?>
<?php if ((isset($_SESSION['logged_success_message'])) && ($_SESSION['logged_success_message'])):?>
<span class="successInSpan">Successfully logged in.</span>
<?php unset($_SESSION['logged_success_message']);?>
<?php endif;?>
<table border="0" cellpadding="0" cellspacing="0" id="mainPanel">
    <tr>
        <td><input id="parentEvents" type="button" style="width:250px;" class="buyButton" value="Main Events" /></td><td><input id="subEvents" type="button" style="width:250px;" class="buyButton" value="Sub Events" /></td>
    </tr>
    <tr>
        <td><input id="seatMaps" type="button" style="width:250px;" class="buyButton" value="Seat Maps" /></td><td><input id="viewBookings" type="button" style="width:250px;" class="buyButton" value="View Bookings" /></td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input id="logoutButton" type="button" style="width:250px;" class="buyButton" value="Logout" /></td>
    </tr>
</table>
<?php else:?>
<div id="eventListingDiv" align="center" style="margin-left:125px;">
<?php if ((isset($_SESSION['error_message'])) && ($_SESSION['error_message'])):?>
<?php unset($_SESSION['error_message']);?>    
<span class="errorInSpan">Please fix errors !</span>
<?php endif;?>
<?php if ((isset($_SESSION['login_error_message'])) && ($_SESSION['login_error_message'])):?>
<?php unset($_SESSION['login_error_message']);?>    
<span class="errorInSpan">Login Faild !</span>    
<?php endif;?>
<?php if ((isset($_SESSION['loggedout_success_message'])) && ($_SESSION['loggedout_success_message'])):?>
<span class="successInSpan">Successfully logged out.</span>
<?php unset($_SESSION['loggedout_success_message']);?>
<?php endif;?>
<table border="0" cellpadding="0" cellspacing="0" id="mainPanel">
	<form name="loginToAdminFomr" method="post" action="">
    <tr>
        <td>Username</td><td><input type="text" name="loginForm[username]" style="<?php echo (((isset($errors)) && (in_array('username', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" /></td>
    </tr>
    <tr>
        <td>Password</td><td><input type="password" name="loginForm[password]" style="<?php echo (((isset($errors)) && (in_array('password', $errors['errorFields']))) ? 'background-color:#FF0000; color:#FFFFFF;' : '');?>" /></td>        
    </tr>
    <tr>
        <td colspan="2" align="center">&nbsp;&nbsp;<input type="submit" name="loginToAdmin" style="width:100px;" class="buyButton" value="Login" /></td>
    </tr>
    </form>
</table>
</div>
<?php endif;?>