<?php
	if(!isset($_SESSION))
		session_start();
?>
<html>
<head>
	<title>Profile</title>
	<link rel="icon" href="../images/tab_logo.png" height=50px width=50px>
	<link rel="stylesheet" type="text/css" href="../style/index.css">
	<link rel="stylesheet" type="text/css" href="../style/profile.css">
	<link rel="stylesheet" type="text/css" href="../icons/css/ionicons.min.css">
	<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>	
	<script type="text/javascript" src="../js/profile.js"></script>
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
	//include("QuickChat.php");

	//echo $_SESSION['global_maxid']."-------";
?>
<div class="profile_upper">	
	<div class="profile_cover_pannel">
		<div class="profile_cover">
			<div class="profile_cover_loader">
				<div class="prof_loader">
					<div>
						<span>Are you sure you want to change your cover photo.</span>
					</div>
					<div>
						<div onclick="saveCover(1)" id='save_cpic'>save changes</div>
						<div onclick="saveCover(0)">Cancel</div>
					</div>
				</div>
				<div class="p_loading">
					<img src="../images/SVG-Loaders-master/svg-loaders/oval.svg" width="50" alt="">
					<div>Uploading</div>
				</div>

			</div>
			<img src="../images/cover1.jpg" id='cover_pic'>
		</div>
		<div class="profile_pic">
			<div>
				<img src="" id='profile_pic_img'>
				<div class="profileP_loader">
					<img src="../images/SVG-Loaders-master/svg-loaders/rings.svg" width="60" alt="">
				</div>
			</div>
			<ul id='relation_setting_action'>
				<li class="p_li1">
					<div>
						<div id='profrndStat'></div>
					</div>
				</li>
				<li class="p_li3">
					<i class="ion-ios-cog"></i>
					<div class="profile_tooltip">
						<div class="profile_pointer"></div>
						<form method="post" enctype="multipart/form-data">
							<input type="file" name="cover_pic" id=profile_upload style="display: none;" onchange="cover_uploading()">
							<input type="file" name="profile_pic" id=profileP_upload style="display: none;" onchange="profile_uploading()">
						</form>
						<ul class="profile_tooltip_item">
							<a href="#"><label for=profile_upload><li>Change Cover Photo</li></label></a>
							<a href="#"><label for=profileP_upload><li>Change Profile Photo</li></label></a>
							<a href="#"><li>Account Setting</li></a>
						</ul>
					</div>
				</li>
			</ul>
		</div>
		<div class="profile_list">
			<ul>
				<li><a href="?id=<?php echo $_GET['id']?>&v=1">Timeline</a></li>
				<li><a href="?id=<?php echo $_GET['id']?>&v=2">About</a></li>
				<li><a href="#">Friends</a></li>
				<li><a style="color: rgb(82, 82, 82);" onclick="return false">
						<?php echo $_SESSION['users']['uname']; ?>
					</a></li>
				<li><a href="#">Photos</a></li>
				<li><a href="#">Video</a></li>
			</ul>
		</div>
	</div>
</div>
<?php
		if(isset($_GET['v'])&&$_GET['v']==2)
			include("About.php");
		else if(isset($_GET['v'])&&$_GET['v']==3)
			include("Friends.php");
		else if(isset($_GET['v'])&&$_GET['v']==4)
			include("Photos.php");
		else if(isset($_GET['v'])&&$_GET['v']==5)
			include("Video.php");
		else
			include("Timeline.php");
?>
</body>
</html>