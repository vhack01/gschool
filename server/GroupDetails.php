<?php
	if(!isset($_SESSION))
	session_start();
?>
<html>
<head>
	<title>Group</title>
	<link rel="icon" href="../images/tab_logo.png" height=50px width=50px>
	<link rel="stylesheet" type="text/css" href="../style/index.css">
	<link rel="stylesheet" type="text/css" href="../style/profile.css">
	<link rel="stylesheet" type="text/css" href="../style/creategroup.css">
		<link rel="stylesheet" type="text/css" href="../style/groups.css">
	<link rel="stylesheet" type="text/css" href="../icons/css/ionicons.min.css">
	<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../js/creategroup.js"></script>
</head>
<body style="background:none">
<div class="Perror_pannel">
	<div><i class="ion-close-round"></i></div>
	<div></div>
</div>
<div class="Group_message_pannel">
	<div id='close_gmess_pannel'><i class="ion-close-round"></i></div>
	<div class="gmess_pannel">
		<div class="gmess_pannel_inner">
			<div><span>SEND MAIL</span></div>
			<div>
				<textarea spellcheck="false" placeholder="Send message to your groupmates... " class="gtext"></textarea>
			</div>
			<div>
				<div>Cancel</div>
				<div onclick="SendGroupMate()">Send</div>
			</div>
		</div>		
	</div>
</div>
<?php

	if(isset($_GET['err']))
	{
		echo '<div class="Perror_pannel" style="display:block;"><div><i class="ion-close-round"></i></div><div style="text-align:center;">You have alreay a group.</div></div>';
	}
	
	include("header.php");
	//include("QuickChat.php");
?>
<div class="create_container">
	<div class="create_banner">
		<div>
			<div class="banner_img1"></div>
			<div class="banner_text">
				<p>Manage your Group and Friends</p>	
				<p>Welcome to your group dashboard! Here you can create or manage your own group page.Here you’ll find everything you need to change your group information, settings, read notifications and requests. Have fun!</p>
				<img src="../images/img/group-member.png">
			</div>
		</div>
	</div>

	<div class="show_group_content">
		<div>
			<div class="group_menus">
				<ul>
					<li onclick="MyGroup(1)">
						<i class="ion-ios-home"></i>
						<span>My Group</span>
					</li>
					<li onclick="CreateGroup(2)">
						<i class="ion-compose"></i>
						<span>Create Group</span>
					</li>
					<li onclick="Groups(3)">
						<i class="ion-ios-people"></i>
						<span>Join Group</span>
					</li>
					<li onclick="FriendsRequest(4)">
						<i class="ion-android-happy"></i>
						<span>Friends</span>
					</li>
					<li onclick="groupInfo(5)">
						<i class="ion-android-notifications-none"></i>
						<span>Notification</span>
						<span style="background:red;color:#fff;padding:1px 5px 1px 5px;border-radius:2px;opacity:0" id="noti_number">0</span>
					</li>
				</ul>
			</div>
			
				<?php
					//include("createGroup.php");
					//include("MyGroup.php");
				?>
		</div><!-- div-->
	</div><!-- group information -->


</div><!-- container-->
</body>
</html>