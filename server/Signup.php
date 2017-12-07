<?PHP
		include("SignupServer.php");
		//echo $sd->c_emlerr;
?>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../style/index.css">
	<link rel="stylesheet" type="text/css" href="../icons/css/ionicons.min.css">
	<script type="text/javascript" src="../js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src="../js/validation.js"></script>
</head>
<body>
<img src="../images/location.png" style="position: absolute;top:16%;">
<div class="cover">
	
	<div class="logo_header">
		<div class="logo_nm">GiantSchool</div>
	</div>	
	<ul class="login-signup">
		<li style="margin-left:51%;">
			<div class="sin_loader">
					<img src="../images/SVG-Loaders-master/svg-loaders/bars.svg" alt="">
					<span>Loading...</span>
			</div>
			<span class="signup_icon">Sign Up</span>
			<div class="logo_border_sin"></div>
			<div class="signup_pannel">
				<div class="signup_form">
					<form action="" method="post"  onsubmit="loader('signup')">
						<table cellspacing="0" cellpadding=0 border=0>
							<tr>
								<td>
									<input type="text" name="first_nm" placeholder="First Name" spellcheck="false" autocomplete="off" class="err_msg1" value="<?php if(isset($_POST['eml'])&&!isset($sd->nameErr)){echo $_POST['first_nm'];}?>">
									<span class="err1 signup_err">
										<?php 
											if(isset($sd->nameErr))
											{
												echo $sd->nameErr;
											}

										?>
									</span>
								</td>
								<td>
									<input type="text" name="last_nm" placeholder="Last Name" spellcheck="false" autocomplete="off" style="border-color:<?php if(isset($_GET['err'])&&$_GET['err']==0){echo 'red';}else{echo '#d8d8d8';} ?>;" class="err_msg2" value="<?php if(isset($_POST['eml'])&&!isset($sd->lasterr)){echo $_POST['last_nm'];}?>">
										<span class="err2 signup_err">
											<?php 
											if(isset($sd->lasterr))
											{
												echo $sd->lasterr;
											}
										?>
										</span>
								</td>
							</tr>
							<tr>
								<td>
									<input type="email" name="eml" placeholder="Email" spellcheck="false" autocomplete="off" class="err_msg3" value="<?php if(isset($_POST['eml'])&&!isset($sd->emailErr)){echo $_POST['eml'];}?>">
										<span class="err3 signup_err">
												<?php 
													if(isset($sd->emailErr))
													{
														echo $sd->emailErr;
													}
												?>
										</span>
								</td>
								<td>
									<input type="email" name="c_eml" placeholder="Confirm Email" spellcheck="false" autocomplete="off" class="err_msg4" value="<?php if(isset($_POST['eml'])&&!isset($sd->c_emailerr)){echo $_POST['c_eml'];}?>">
										<span class="err4 signup_err">
												<?php 
													if(isset($sd->c_emlerr))
													{
														echo $sd->c_emlerr;
													}
												?>
										</span>
								</td>
							</tr>
							<tr>
								<td>
									<input type="password" name="psd" placeholder="Password" spellcheck="false" autocomplete="off" class="err_msg5" value="<?php if(isset($_POST['eml'])&&!isset($sd->psderr)){echo $_POST['psd'];}?>">
										<span class="err5 signup_err">
												<?php 
													if(isset($sd->psderr))
													{
														echo $sd->psderr;
													}
												?>
										</span>
								</td>
								<td>
									<input type="password" name="con_psd" placeholder="Confirm Password" spellcheck="false" autocomplete="off" class="err_msg6" value="<?php if(isset($_POST['eml'])&&!isset($sd->cpsderr)){echo $_POST['con_psd'];}?>">
										<span class="err6 signup_err">
												<?php 
													if(isset($sd->cpsderr))
													{
														echo $sd->cpsderr;
													}
												?>
										</span>
								</td>
							</tr>
							<tr>
								<td>
									<select id="CountryName" name="country_nm" readonly autocomplete="off">
									  <option selected value="India">India</option>
									</select>
								</td>
								<td>
									<ul class="location">
										<li>
											<select name="state_nm">
									  			<option selected>
									  				<?php
												 		if(isset($_POST['state_nm']))
												 		{
												 			echo $_POST['state_nm'];
												 		}
												 		else{
												 			echo "State";
												 		}
												 	?>
									  			</option>
									  			<option value="Banglore">Banglore</option>
									  			<option value="Delhi">Delhi</option>
									  			<option value="Mumbai">Mumbai</option>
									  			<option value="Kolkata">Kolkata</option>
									  			<option value="Uttar Pradesh">Uttar Pradesh</option>
											</select>
										</li>	
									</ul>
									<span class="err7 signup_err">
														<?php 
															if(isset($sd->stateerr))
															{
																echo $sd->stateerr;
															}
														?>
												</span>
								</td>
							</tr>
							<tr>
								<td>
									<input type="number" name="mobile" placeholder="Mobile Number" spellcheck="false" autocomplete="off" style="border-color:<?php if(isset($_GET['err'])&&$_GET['err']==0){echo 'red';}else{echo '#d8d8d8';} ?>;" class="err_msg9" value="<?php if(isset($_POST['eml'])&&!isset($sd->moberr)){echo $_POST['mobile'];}?>">
										<span class="err8 signup_err">
														<?php 
															if(isset($sd->moberr))
															{
																echo $sd->moberr;
															}
														?>
										</span>
								</td>
								<td>
									<!---<input type="date" name="birth" spellcheck="false" autocomplete="off">-->
									<ul class="birth">
										<li style="width:23%;">
											<select name="birth_day" style="border-color:<?php if(isset($_GET['err'])&&$_GET['err']==0){echo 'red';}else{echo '#d8d8d8';} ?>;" class="err_msg10" >
											 <option selected="selected">
											 	<?php
											 		if(isset($_POST['birth_day']))
											 		{
											 			echo $_POST['birth_day'];
											 		}
											 		else{
											 			echo "Day";
											 		}
											 	?>
											 </option>
											 <option value="01">01</option>
											 <option value="02">02</option><option value="03">03</option><option value="04">04</option>
											 <option value="05">05</option><option value="06">06</option><option value="07">07</option>
											 <option value="08">08</option><option value="09">09</option><option value="10">10</option>
											 <option value="11">11</option><option value="12">12</option><option value="13">13</option>
											 <option value="14">14</option><option value="15">15</option><option value="16">16</option>
											<option value="17">17</option><option value="18">18</option><option value="19">19</option>
											<option value="20">20</option><option value="21">21</option><option value="22">22</option>
											<option value="23">23</option><option value="24">24</option><option value="25">25</option>
											<option value="26">26</option><option value="27">27</option><option value="28">28</option>
											<option value="29">29</option><option value="30">30</option><option value="31">31</option>
											</select>
										</li>	
										<li style="width:45%;">
											<select name="birth_month" class="err_msg11">
											 <option selected="selected">
											 		<?php
											 		if(isset($_POST['birth_month']))
											 		{
											 			echo $_POST['birth_month'];
											 		}
											 		else{
											 			echo "Month";
											 		}
											 	?>
											 </option>
											 <option value="01">January</option>
											 <option value="02">February</option><option value="03">March</option><option value="04">April</option>
											 <option value="05">May</option><option value="06">June</option><option value="07">July</option><option value="08">August</option>
											 <option value="09">September</option><option value="10">October</option><option value="11">November</option>
											 <option value="12">December</option>
											</select>
										</li>
										
										<li style="width:29%;margin-left:-25px;">
											<select name="birth_year" style="border-color:<?php if(isset($_GET['err'])&&$_GET['err']==0){echo 'red';}else{echo '#d8d8d8';} ?>;" class="err_msg12">
												<option selected="selected">
														<?php
													 		if(isset($_POST['birth_year']))
													 		{
													 			echo $_POST['birth_year'];
													 		}
													 		else{
													 			echo "Year";
													 		}
													 	?>
												</option>
												<option value="1999">2012</option>
												<option value="1999">2011</option>
												<option value="1999">2010</option>
												<option value="1999">2009</option>
												<option value="1999">2008</option>
												<option value="1999">2007</option>
												<option value="1999">2006</option>
												<option value="1999">2005</option>
												<option value="1999">2004</option>
												<option value="1999">2003</option>
												<option value="1999">2002</option>
												<option value="1999">2001</option>
												<option value="1999">2000</option>
												<option value="1999">1999</option><option value="1998">1998</option><option value="1997">1997</option><option value="1996">1996</option><option value="1995">1995</option><option value="1994">1994</option><option value="1993">1993</option><option value="1992">1992</option><option value="1991">1991</option><option value="1990">1990</option><option value="1989">1989</option><option value="1988">1988</option><option value="1987">1987</option><option value="1986">1986</option><option value="1985">1985</option><option value="1984">1984</option><option value="1983">1983</option><option value="1982">1982</option><option value="1981">1981</option><option value="1980">1980</option>
												<option value="1979">1979</option><option value="1978">1978</option><option value="1977">1977</option><option value="1976">1976</option>
												<option value="1975">1975</option><option value="1974">1974</option><option value="1973">1973</option><option value="1972">1972</option>
												<option value="1971">1971</option><option value="1970">1970</option><option value="1969">1969</option><option value="1968">1968</option>
												<option value="1967">1967</option><option value="1966">1966</option><option value="1965">1965</option><option value="1964">1964</option>
												<option value="1963">1963</option><option value="1962">1962</option><option value="1961">1961</option><option value="1960">1960</option>
												<option value="1959">1959</option><option value="1958">1958</option><option value="1957">1957</option>
											</select>
										</li>
									</ul>
										<span class="err10 signup_err">
												<?php 
														if(isset($sd->dayerr)||isset($sd->montherr)||isset($sd->yearerr))
														{
															echo "Required..!";
														}
												?>
										</span>
								</td>
							</tr>
							<tr>
								<td>
									<label><input type="radio" name="gender" value="male" autocomplete="off" <?php if(isset($_POST['gender'])&&$_POST['gender']=='male'){echo 'checked';}else{echo 'checked';}?> ><span>Male</span></label>
									<label><input type="radio" name="gender" value="female" autocomplete="off" <?php if(isset($_POST['gender'])&&$_POST['gender']=='female'){echo 'checked';}?> ><span>Female</span></label>
								</td>
							</tr>
							<tr>
								<td id='signup_tr'>
										<svg width="60" height="60" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="#dc1156" style="margin:-15px 60px;">
											    <rect y="10" width="15" height="120" rx="6">
											        <animate attributeName="height"
											             begin="0.5s" dur="1s"
											             values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
											             repeatCount="indefinite" />
											        <animate attributeName="y"
											             begin="0.5s" dur="1s"
											             values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
											             repeatCount="indefinite" />
											    </rect>
											    <rect x="30" y="10" width="15" height="120" rx="6">
											        <animate attributeName="height"
											             begin="0.25s" dur="1s"
											             values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
											             repeatCount="indefinite" />
											        <animate attributeName="y"
											             begin="0.25s" dur="1s"
											             values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
											             repeatCount="indefinite" />
											    </rect>
											    <rect x="60" width="15" height="140" rx="6">
											        <animate attributeName="height"
											             begin="0s" dur="1s"
											             values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
											             repeatCount="indefinite" />
											        <animate attributeName="y"
											             begin="0s" dur="1s"
											             values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
											             repeatCount="indefinite" />
											    </rect>
											    <rect x="90" y="10" width="15" height="120" rx="6">
											        <animate attributeName="height"
											             begin="0.25s" dur="1s"
											             values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
											             repeatCount="indefinite" />
											        <animate attributeName="y"
											             begin="0.25s" dur="1s"
											             values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
											             repeatCount="indefinite" />
											    </rect>
											    <rect x="120" y="10" width="15" height="120" rx="6">
											        <animate attributeName="height"
											             begin="0.5s" dur="1s"
											             values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear"
											             repeatCount="indefinite" />
											        <animate attributeName="y"
											             begin="0.5s" dur="1s"
											             values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear"
											             repeatCount="indefinite" />
											    </rect>
											</svg>
											<span id="loader">Loading...</span>

								</td>
								<td><input type="submit" value="Create an account" id='create_act'></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</li>
		
	</ul>


</div>
</body>
</html>