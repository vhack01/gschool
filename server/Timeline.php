<script>
	$(document).ready(function(){
		$(".profile_list>ul>li:nth-child(2)>a").css("color","#999a9a");
		$(".profile_list>ul>li:nth-child(3)>a").css("color","#999a9a");
		$(".profile_list>ul>li:nth-child(4)>a").css("color","#999a9a");
		$(".profile_list>ul>li:nth-child(5)>a").css("color","#999a9a");	
		$(".profile_list>ul>li:nth-child(1)>a").css("color","#ff694f");
	});
</script>
<div class="timeline_pannel">
	<div class="">
		<div class="Tquick_view">
			<div class="t_intro">
				<div>
					<i class="ion-android-globe"></i>
					<span>Introduction</span>
					
				</div>
				<div>
					<h4 style="font-family:Ancillary;color:#4e4d4d;font-size:13px;margin:13px;letter-spacing:0.3px;">Hi <?php echo $_SESSION['users']['uname']; ?> ,</h4>
					<h5 style="font-size:12px;font-family:DistrictThin;color:grey;margin:-2px 0px 0px 14px;letter-spacing:0.7px;"><span>Customise what people see when they visit your Profile. Info set to Public appears in this section.</span></h5>
					<table border=0 cellspacing="0" cellpadding="0" class="intr_table">
						<tr>
							<td>Birthday</td>
							<td>8 May 2000</td>
						</tr>
						<tr>
							<td>Lives </td>
							<td><span>Uttar Pradesh</span>&nbsp;,&nbsp;<span>India</span></td>
						</tr>
						<tr>
							<td>Occupation </td>
							<td>student</td>
						</tr>
						<tr>
							<td>Joined </td>
							<td>17 August 2017</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="friends">
				<div>
					<i class="ion-android-happy"></i>
					<span>Friends</span>
					<i class="ion-close-round" id=p_hide title="Remove" style="display:none;top:-6px;left:120px;"></i>
				</div>
				<div>
					<ul id='frnds_qiuckpic'>
					</ul>
					<div class="no_friends" id='nFrnd'>No Friends</div>
				</div>
			</div>

			<div class="friends">
				<div>
					<i class="ion-android-contacts"></i>
					<span>Group</span>
				</div>
				<div id='jgrp_div'>
					<div id='Jgroup_info'>
						<div id='jgrp_img'><img src="../images/atul.jpg"></div>
						<div><span>Bug Boat</span></div>
						<div><span></span><span></span></div>
					</div>
					<div class="no_friends" id=prof_no_grpj>You have not joined any Group</div>
				</div>
			</div>

		</div>

		<!--- POST Area -->
		<div class="Tpost_view">
				<div class="div_1" style="margin-top:-10px;width:107%;">
				<ul>
					<li class="post_box">
						<div>
							<div>
								<i class="ion-compose"></i>
								<span>Status</span>
							</div>
							<div>
								<i class="ion-images"></i>
								<span>Upload photos</span>
							</div>
							<div>
								<i class="ion-ios-videocam-outline"></i>
								<span>Live</span>
							</div>
					  	</div>
					  	<div>
							<div>
								<img src="../images/atul.jpg" id=postProPic>
							</div>
							<div>
								<textarea placeholder="Share what you are thinking" autocomplete="off" spellcheck="false" id='post_textarea'></textarea>
							</div>
						</div>
						<div class="post_action">
							<div>Post</div>
						</div>
					</li>
					<li>
						
					</li>
					<li></li>
				</ul>
			</div><!--post box -->
			
			<div class="no_recent_post">
				<div>
					<i class="ion-sad-outline"></i>
					<span>No Recent Post</span>
					<i class="ion-close-round" id=p_hide title="Remove" style="display:none;top:-6px;left:120px;"></i>
				</div>
				<div>
					<div class="no_post">You have not posted anything recently. When you post something, it will be shown here.</div>
				</div>
			</div><!--no post-->
			<?php
					include("post_pannel.php");
			?>

		</div><!---post pannel-->
	</div>
</div>