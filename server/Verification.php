<?PHP
	
	if(isset($_POST['resend_otp']))
	{
		include("VerificationCode.php");
	}
	if(!isset($_SESSION))
		session_start();
	if(!isset($_SESSION['verify']['OTP']))
		header("Location:Signup.php");
?>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../style/index.css">
	<link rel="stylesheet" type="text/css" href="../icons/css/ionicons.min.css">
	<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../js/validation.js"></script>
</head>
<body style="background:none;">

	<div class="logo_header_ver">
		<div class="logo_nm_ver">GiantSchool</div>
	</div>	
	
	<div class="verification_panel">
			<div class="ver_loader">
					 <img src="../images/SVG-Loaders-master/svg-loaders/ball-triangle.svg" alt="">
					<span id="resending_otp">
										<?php 
											if(isset($_GET['r'])&&$_GET['r']=="true")
											{
												echo "Resending...";
											}
											else
											{
												echo "Verifying...";	
											}

										?>
					</span>
			</div>
			<div class="verify_div">
				<!--<span class="verify_icon">OTP Serification Screen</span>-->
				<div class="ver_img">
					<i class="ion-chatbubble-working"></i>
					<i class="ion-android-phone-portrait"></i>
				</div>
			</div>
			<div class="verify_area">
			 <form action="SignupServer.php" method="post" onsubmit="loader('resend');">
				<ul class="verify_ul">
					<li>
						<span>VERIFY MOBILE NUMBER</span>
					</li>
					<li>
						<div><span>OTP has been send to you on your mobile number . Please enter it below.</span></div>
					</li>
					<li>
						<span class="err11 signup_err">
										<?php 
											if(isset($_GET['r'])&&$_GET['r']=="false")
											{
												echo "Please enter valid OTP";
											}
											else if(isset($_GET['r'])&&$_GET['r']=="f")
												echo "Invalid OTP . Please enter valid OTP";

										?>
						</span>
						<input type="text" name="ver_code" placeholder="">
					</li>
					<li>
						<input type="submit" name="resend_otp" value="Resend">
						<input type="submit" name="verify_otp" value="Verify">
					</li>
					<li>
						<a href="#">Didn't received otp ?</a>
					</li>
				</ul>
			 </form>
			</div>
		</div>

</body>
</html>