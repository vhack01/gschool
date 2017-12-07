<?php
	if(!isset($_SESSION))
		session_start();
	if(isset($_SESSION['users']))
	{
		header("Location:server/home.php");
	}
?>
<html>
<head>
	<title>Gaintschool - Login or Signup </title>
	<link rel="icon" href="images/tab_logo.png" height=50px width=50px>
	<link rel="stylesheet" type="text/css" href="style/index.css">
	<link rel="stylesheet" type="text/css" href="icons/css/ionicons.min.css">
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="js/validation.js"></script>
</head>
<body>
<img src="images/location.png" style="position: absolute;top:16%;">
<div class="cover">
	
	<div class="logo_header">
		<div class="logo_nm">GiantSchool</div>
	</div>	
	<ul class="login-signup">
		<li style="float:right;margin-right:4%;">
			<span class="login_icon">Login</span>
			<div class="logo_border"></div>
			<div class="login_pannel">
				<div class="login_form">
					<span class="err12">
						<?php 
								if(isset($_GET['log'])&&$_GET['log']=="false")
								{
									echo "Invalid username and password";
								}
						?>
					</span>
					<form action="server/SignupServer.php" method="post">
						<table cellspacing="0" cellpadding=0 border=0>
							<tr>
								<td>
									<input type="text" name="log_eml" placeholder="Email or Phone Number" spellcheck="false" autocomplete="off">
								</td>
							</tr>
							<tr>
								<td><input type="password" name="log_psd" placeholder="Password" spellcheck="false" autocomplete="off"></td>
							</tr>
							<tr>
								<td>
									<label><input type="checkbox" name="log_psd"><span>Rember Me</span></label>
								</td>
							</tr>
							<tr>
								<td><input type="submit" name="login" value="Login"></td>
							</tr>
							<tr>
								<td><a href="#">Forget Password ?</a></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
			<a href="server/Signup.php"><div class="login_to_signup">Create an account</div></a>
		</li>
		
	</ul>





</div>
</body>
</html>