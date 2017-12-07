<?php
	if(!isset($_SESSION))
	session_start();
?>
<html>
<head>
	<title>Gaintschool</title>
	<link rel="icon" href="../images/tab_logo.png" height=15 width=15>
	<link rel="stylesheet" type="text/css" href="../style/index.css">
	<link rel="stylesheet" type="text/css" href="../style/profile.css">
	<link rel="stylesheet" type="text/css" href="../icons/css/ionicons.min.css">
	<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../js/home.js"></script>	
</head>
<body style="background:none;">
<div class="Perror_pannel" style="">
	<div><i class="ion-close-round"></i></div>
	<div></div>
</div>
<?php 
	include('addPhotosPannel.php');
?>
<?php
	include("header.php");
	include("QuickChat.php");
	include("Home_content.php");

	//echo $_SESSION['users']['uid']."-------";
?>

</body>
</html>