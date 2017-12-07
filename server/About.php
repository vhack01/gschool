<script>
	$(document).ready(function(){
		$(".profile_list>ul>li:nth-child(1)>a").css("color","#999a9a");
		$(".profile_list>ul>li:nth-child(3)>a").css("color","#999a9a");
		$(".profile_list>ul>li:nth-child(4)>a").css("color","#999a9a");
		$(".profile_list>ul>li:nth-child(5)>a").css("color","#999a9a");
		$(".profile_list>ul>li:nth-child(2)>a").css("color","#ff694f");
		var id=decodeURIComponent(window.location.search.substring(1));
		s_id=id.split("&");
		uid=s_id[0].split("=");
		getAllAboutDetails();
		function getAllAboutDetails()
		{
				$.post("GroupServer.php",{
					about_det:uid[1]
				},function(result){
					result=JSON.parse(result);
					if(result[0]!="No info")
					{
						if(result[0]['workplace']!=null)
						{
							$(".work_edu>ul>li:nth-child(1)>form>input").val(result[0]['workplace']);
						}
						if(result[0]['professional_skill']!=null)
						{
							$(".work_edu>ul>li:nth-child(2)>form>input").val(result[0]['professional_skill']);	
						}
						if(result[0]['university']!=null)
						{
							$(".work_edu>ul>li:nth-child(3)>form>input").val(result[0]['university']);		
						}
						if(result[0]['high_school']!=null)
						{
							$(".work_edu>ul>li:nth-child(4)>form>input").val(result[0]['high_school']);	
						}
						if(result[0]['city']!=null)
						{
							$(".place_lived>ul>li:nth-child(1)>form>input").val(result[0]['city']);	
						}
						if(result[0]['home_town']!=null)
						{
							$(".place_lived>ul>li:nth-child(2)>form>input").val(result[0]['home_town']);		
						}
						if(result[0]['place']!=null)
						{
							$(".place_lived>ul>li:nth-child(3)>form>input").val(result[0]['place']);	
						}
						if(result[0]['relationship_status']!=null)
						{
							$(".about_relationship>ul>li:nth-child(1)>form>input").val(result[0]['relationship_status']);	
						}
						if(result[0]['family_member']!=null)
						{
							$(".about_relationship>ul>li:nth-child(1)>form>input").val(result[0]['family_member']);		
						}
					}
					else{

					}

					$(".cont_basic_info>table>tbody>tr:nth-child(1)>td:nth-child(2)>span>input").val(result[1]['first_name']);
					$(".cont_basic_info>table>tbody>tr:nth-child(2)>td:nth-child(2)>span>input").val(result[1]['last_name']);
					$(".cont_basic_info>table>tbody>tr:nth-child(3)>td:nth-child(2)>span>input").val(result[1]['email']);
					$(".cont_basic_info>table>tbody>tr:nth-child(4)>td:nth-child(2)>span>input").val(result[1]['mobile']);
					$(".cont_basic_info>table>tbody>tr:nth-child(5)>td:nth-child(2)>span>input").val(result[1]['country']);
					$(".cont_basic_info>table>tbody>tr:nth-child(6)>td:nth-child(2)>span>input").val(result[1]['state']);
					$(".cont_basic_info>table>tbody>tr:nth-child(7)>td:nth-child(2)>span>input").val(result[1]['birthday']);
					$(".cont_basic_info>table>tbody>tr:nth-child(8)>td:nth-child(2)>span").html(result[1]['gender']);
					date=result[1]['signup_date'].split(" ");
					$(".cont_basic_info>table>tbody>tr:nth-child(9)>td:nth-child(2)>span").html(date[0]);

				});
		}

	});
</script>
<div class="about_pannel">
	<div>
		<div class="about_menu">
			<div><i class="ion-ios-contact-outline"></i><span>About</span></div>
			<div>
				<ul id='about_menu_list'>
					<li>Work and education</li>
					<li>Places you've lived</li>
					<li>Details about you</li>
					<li>Family and relationships</li>
				</ul>
			</div>
		</div>
		<div class="about_info">
			<div class="work_edu">
					<ul>
						<li>
							<form>
								<input type="text" name="work_edu_add_place" placeholder="Add a workplace" readonly="readonly">
							</form>
							<div class="work_edu_save" onclick="saveAboutInfo(1,this)">Save</div>
							
						</li>
						<li>
							<form>
								<input type="text" name="work_edu_add_place" placeholder="Add a professoinal skill" readonly="readonly">	
							</form>
							<div class="work_edu_save" onclick="saveAboutInfo(2,this)">Save</div>
							
						</li>
						<li>
							<form>
								<input type="text" name="work_edu_add_place" placeholder="Add a university" readonly="readonly">	
							</form>
							<div class="work_edu_save" onclick="saveAboutInfo(3,this)">Save</div>
						</li>
						<li>
							<form>
								<input type="text" name="work_edu_add_place" placeholder="Add a high school" readonly="readonly">	
							</form>
							<div class="work_edu_save" onclick="saveAboutInfo(4,this)">Save</div>
						</li>
					</ul>
			</div><!-- work and education -->

			<div class="place_lived">
					<ul>
						<li>
							<form>
								<input type="text" name="work_edu_add_place" placeholder="Add your current city" readonly="readonly">	
							</form>
							<div class="work_edu_save" onclick="saveAboutInfo(5,this)">Save</div>
						</li>
						<li>
							<form>
								<input type="text" name="work_edu_add_place" placeholder="Add your home town" readonly="readonly">	
							</form>
							<div class="work_edu_save" onclick="saveAboutInfo(6,this)">Save</div>
						</li>
						<li>
							<form>
								<input type="text" name="work_edu_add_place" placeholder="Add a place" readonly="readonly">	
							</form>
							<div class="work_edu_save" onclick="saveAboutInfo(7,this)">Save</div>
						</li>
					</ul>
			</div><!-- place lived-->
			<div class="cont_basic_info">
					<table border=0>
						<tr>
							<td>
								<span>First name</span>
							</td>
							<td>
								<span><input type="text" name="" readonly="readonly" value="Vishwas"></span>
							</td>
						</tr>
						<tr>
							<td>
								<span>Last name</span>
							</td>
							<td>
								<span><input type="text" name="" readonly="readonly" value="kumar"></span>
							</td>
						</tr>
						<tr>
							<td>
								<span>Email Address</span>
							</td>
							<td>
								<span><input type="email" name="" readonly="readonly" value="vishwas101kumar@gmail.com"></span>
							</td>
						</tr>
						<tr>
							<td>
								<span>Mobile</span>
							</td>
							<td>
								<span><input type="number" name="" readonly="readonly" value="9140492884"></span>
							</td>
						</tr>
						<tr>
							<td>
								<span>Country</span>
							</td>
							<td>
								<span><input type="text" name="" readonly="readonly" value="India"></span>
							</td>
						</tr>
						<tr>
							<td>
								<span>State</span>
							</td>
							<td>
								<span><input type="text" name="" readonly="readonly" value="Uttar Prades"></span>
							</td>
						</tr>
						<tr>
							<td>
								<span>Birthday</span>
							</td>
							<td>
								<span><input type="text" name="" readonly="readonly" value="8 May 2000"></span>
							</td>
						</tr>
						<tr>
							<td>
								<span>Gender</span>
							</td>
							<td>
								<span>Male</span>
								<!--<span><input type="date" name="" readonly="readonly"></span>-->
							</td>
						</tr>
						<tr>
							<td>
								<span>Joined</span>
							</td>
							<td>
								<span>9 April 2017</span>
							</td>
						</tr>
						<tr class="cont_basic_action">
							<td id='basic_td' colspan="2">
								<div>Save</div>
								<div>Cancel</div>
							</td>
							
						</tr>
					</table>
			</div><!-- place lived-->
			<div class="about_relationship">
					<ul>
						<li>
							<form>
								<input type="text" name="work_edu_add_place" placeholder="Add your relationship status" readonly="readonly">
							</form>
							<div class="work_edu_save" onclick="saveAboutInfo(8,this)">Save</div>
						</li>
						<li>
							<form>
								<input type="text" name="work_edu_add_place" placeholder="Add a Family Member" readonly="readonly">	
							</form>
							<div class="work_edu_save" onclick="saveAboutInfo(9,this)">Save</div>
						</li>
					</ul>
			</div><!-- work and education -->
		</div><!-- about info-->
		
	</div>
</div>