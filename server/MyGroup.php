<div class="group_context">
<div class="grp_det_pannel">
					
					<ul>
						<li class="li_1">
							<div>
								<img src="<?php if(strlen($_SESSION['group_det']['group_logo'])>0){echo '../Uploaded/group_logo/'.$_SESSION['group_det']['group_logo'];}else{echo '../images/ios7-contact.png';}?>">
								</div>
								<div id='gbookmark' group_name='<?php echo $_SESSION["group_det"]["group_identification"]; ?>' status='N' onclick="Bookmark(this)">
									<i class="ion-plus-round"></i>
									<span>Bookmark</span>
								</div>
						</li>
						<li class="li_2">
							<div>
									<ul class="li2_ul">
										<li>
											<span>
												<?php
													echo $_SESSION['group_det']['group_name'];
												?>
											</span>
										</li>
										<li>
											<span>Type :</span>
											<span>
												<?php
													echo $_SESSION['group_det']['group_type'];
												?>
											</span>
										</li>
										<li>
											<span>Strength :</span>
											<span>
												<?php
													echo $_SESSION['group_det']['group_length'];
												?>
											</span>
										</li>
										<li>
											<span>Members :</span>
											<span>
												<?php
													echo count($_SESSION['member_det'])." / ".$_SESSION['group_det']['group_length'];
												?>
											</span>
										</li>
										<li>
											<span>Group Location :</span>
											<span>
												<?php
													echo $_SESSION['group_det']['group_location'];
												?>
											</span>
										</li>
										<li>
											<span>Leader :</span>
											<span>
												<?php
													//echo $_SESSION['group_det']['group_'];
												?>
											</span>
										</li>
									</ul>
							</div>
						</li>
						<li class="li_3">
							<div>
									<?php
										echo $_SESSION['group_det']['group_description'];
									?>
							</div>
						</li>
						<li class="li_4">
								<div>
									<ul id='grp_action'>
										<?php
											if(isset($_SESSION['member_det']))
											{
												for ($i=0; $i <count($_SESSION['member_det']) ; $i++) { 
													if(($_SESSION['users']['uid']==$_SESSION['member_det'][$i]['mem_id'])&&($_SESSION['member_det'][$i]['mem_pos']=="Leader"))
													{
echo '<li id="send_group_mess" onclick="sendGroupMess()">Send Group Message</li><li id="edit_group" onclick="editGroup('.'\''.$_SESSION["group_visiter"]["grp_name"].'\''.')">Edit</li>';				
													}	
												}
											}
										?>
										<li id='leave_group' onclick="leaveGroup('<?php echo $_SESSION["group_visiter"]["grp_name"];?>')">Leave</li>
									</ul>
								</div>
						</li>
					</ul>
			</div>

			<div class="group_member_pannel">
				<div></div>
				<ul class='group_frnds_list'>
				</ul>
			</div><!--member details-->

</div><!--Group Context-->