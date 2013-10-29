<?php 

require './common/userinfo.php';
if(isset($_POST["username"])=="1" && isset($_POST["pwd"])=="1" ){
	if(($_POST["username"]==$user_name && $_POST["pwd"]==$user_password ) || $_POST["username"]==$os_user_name && $_POST["pwd"]==$os_user_password){
		setcookie("username", $_POST["username"], time()+3600);
?>
	<frameset rows="70,*" cols="*" frameborder="no" border="0" framespacing="0">  
	<frame src="head.html" name="topFrame" scrolling="No" noresize="noresize" id="topFrame" />  
	<frameset cols="193,*" frameborder="yes" border="0" framespacing="0">    
	<frame src="common/loglist.php" scrolling="yes" noresize="noresize" id="leftFrame" />   
	<frame src="welcome.php" name="mainFrame" id="mainFrame" />  
	</frameset>
</frameset>
<?php 
	}else{
?>
		<script type="text/javascript" language="javascript">
		alert('”√ªß√‹¬Î¥ÌŒÛ£°');
		window.location='login.php';</script>
	<?php 
	}
}else{
?>
		<script type="text/javascript" language="javascript">
		window.location='login.php';</script>
	<?php 
}
?>