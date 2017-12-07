
<div class="group_context" style="background-color:transparent;box-shadow:none;">
	<div class="create_group_content">
		<div>
			<div class="g_uploading_area">
				<div><img src="../images/ios7-contact.png"></div>
				<div>
					<form style="display: none;">
						<input type="file" name="" id=group_logo_edit onchange="validateGroup(1)">
					</form>
					<label for=group_logo_edit>
						<div>Change Group Logo</div>
					</label>
				</div>
				<div id='g_logo_loader'>
					<img src="../images/SVG-Loaders-master/svg-loaders/oval.svg" width="50" alt="">
				</div>
			</div>
			<div class="g_form">
				<div>
					<i class="ion-fireball"></i>
					<span>Create your own group</span>
				</div>
				<form action='ProfileServer.php' method="post" onsubmit="return validateGroup(2)"> 
				<div>
						<table border=0 class="cgroup_form">
							<tr>
								<td>
									<span class='g_error'>Required...!</span>
									<fieldset>
										<legend>Group Name</legend>
										<input type="text" name="group_nm" spellcheck="false" id=grp_nm>
									</fieldset>
								</td>
							</tr>
							<tr>
								<td>
									<fieldset>
										<legend>Group Type</legend>
										<select name="group_type" id='grp_type'>
											<option selected value="Any one can join">Any one can join</option>
											<option value="Invite only">Invite only</option>
											<option value="Closed">Closed</option>
										</select>
									</fieldset>
								</td>
							</tr>
							<tr>
								<td>
									<span id='g_error2'>Required...!</span>
									<fieldset>
										<legend>Numbers of member can join</legend>
										<input type="number" name="grp_len" id=grp_len>
									</fieldset>
								</td>
							</tr>
							<tr>
								<td>
									<fieldset>
										<legend>Group location</legend>
										<select name="group_location" id='grp_location'>
											<option selected value="India">India</option>
										</select>
									</fieldset>
								</td>
							</tr>
							<tr>
								<td>
									<fieldset>
										<legend>Description</legend>
										<textarea id=g_desc name="g_description"></textarea>
									</fieldset>
								</td>
							</tr>
							<input type="hidden" name="grop_logo" value="" id='gup_logo'>
						</table>
				</div>
					<div class="group_action">
						<input type="submit" name="create_grp" value="Create" id='grp_update_create'>
						<input type="submit" name="cancel_grp" value="Cancel">
					</div>
				</form>
			</div>
		</div>
	</div>
</div><!-- group_context-->