<?php
		if(!isset($_SESSION))
			session_start();
		if(!isset($_SESSION['users']))
			header("Location:../index.php");
?>

<script type="text/javascript" src="../js/searchbar.js"></script>
<div class="header_panel">
		<ul class="header_list">
			<li>
				<div class="site_name"><a href="home.php">GaintSchool</a></div>
			</li>
			<li>
				<div>
					<div class="ion-search ion-android-search "></div>
					<div class="header_srch_box">
						<input type="text" name="frnd_srch_box" placeholder="Search Friend..." spellcheck="false">
					</div>
				</div>
				<div class="head_srch_result">
					<i class="ion-close-round" id='head_search_pannel_close'></i>
					<div>
						<div id="srched_loader" style="height:20%;width:100%;background-color:silver;"><img src="../images/SVG-Loaders-master/svg-loaders/oval.svg" alt="" style="margin:20px 0px 0px 40%;height:40px;"></div>
						<ul class="search_bar_res"></ul>
					</div>
				</div>
			</li>
			<li>
				<div><a href="home.php">HOME</a></div>
				
			</li>
			<li>
				<div class="header_profile_div">
					<a href="Profile.php?id=<?php echo $_SESSION['users']['uid']?>"><div id=hpro_pic><img src=""></div>
					<div>
						<span><?php echo $_SESSION['users']['uname'];?></span>
					</div></a>
					<div class="profile_sub_menu">
						<div>YOUR ACCOUNT</div>
						<div>
							<ul class="profile_log_list">
								<li>
									<a href="Profile.php?id=<?php echo $_SESSION['users']['uid']?>">
										<i class="ion-ios-contact"></i>
										<span>Profile Setting</span>
									</a>
								</li>
								<li>
									<a href="GroupDetails.php">
										<i class="ion-android-menu"></i>
										<span>My Group</span>
									</a>
								</li>
								<li>
									<a href="#">
										<i class="ion-ios-cog"></i>
										<span>Setting</span>
									</a>
								</li>
								<li>
									<a href="" id='logout_btn'>
										<i class="ion-power"></i>
										<span>Logout</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</li>
		</ul>
</div>