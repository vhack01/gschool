$(document).ready(function(){
	$(".p_li3").css("display","none");
		$.post("ProfileServer.php",
			{
			  	cover:'get'
			},
			  function(result){
			  	result=JSON.parse(result);
			  //	console.log(result);
			  	if(result[0]!="null")
			 		$("#cover_pic").attr("src","../Uploaded/cover/"+result[0]);
			 	else
			 		$("#cover_pic").attr("src","../images/cover1.jpg");
			 	if(result[1]!="null")
			 		$("#profile_pic_img").attr("src","../Uploaded/profile/"+result[1]);
			 	else
			 		$("#profile_pic_img").attr("src","../images/ios7-contact.png");
		});
		$(".Perror_pannel>div:nth-child(1)").click(function(){
			$('.Perror_pannel').hide();
		});
		
		$(".profile_list>ul>li:nth-child(1)>a").css("color","#ff694f");
		$(".about_info>div:nth-child(1)").css("display","block");
		$("#about_menu_list>li:nth-child(1)").css({"border-left":"5px solid #408bff","color":"#000"});

		function colorManagement(index)
		{	
			for(i=0;i<4;i++)
			{
				$("#about_menu_list>li:nth-child("+(i+1)+")").css({"border-left":"none","color":"#7b7b7b"});
				$(".about_info>div:nth-child("+(i+1)+")").css("display","none");
			}
			//alert(index);
			$(".about_info>div:nth-child("+(index+1)+")").css("display","block");
			$("#about_menu_list>li:nth-child("+(index+1)+")").css({"border-left":"5px solid #408bff","color":"#000"});
		}
		$("#about_menu_list>li:nth-child(1)").click(function(){
			colorManagement(0);
			$(this).css({"border-left":"5px solid #408bff","color":"#000"});
		});
		$("#about_menu_list>li:nth-child(2)").click(function(){
			colorManagement(1);
			$(this).css("border-left","5px solid #408bff");
		});
		$("#about_menu_list>li:nth-child(3)").click(function(){
			colorManagement(2);
			$(this).css("border-left","5px solid #408bff");
		});
		$("#about_menu_list>li:nth-child(4)").click(function(){
			colorManagement(3);
			$(this).css("border-left","5px solid #408bff");
			$(this).css("cursor","default");
		});

		$(".work_edu>ul>li>form>input").dblclick(function(){
			$(this).removeAttr("readonly");
		});
		$(".place_lived>ul>li>form>input").dblclick(function(){
			$(this).removeAttr("readonly");
		});
		$(".about_relationship>ul>li>form>input").dblclick(function(){
			$(this).removeAttr("readonly");
		});

		
		$("li.post_box>div:nth-child(1)>div:nth-child(1)").css({"color":"#ff5e3a","border-bottom":"1px solid #fff"});

		$(".post_action>div:nth-child(1)").click(function(){

			var val=($("#post_textarea").val()).trim();
			if(val.length==0)
			{

			}
			else{
				$(".Perror_pannel").css("display","block");
				html='<div id="confirm_txt">Are you sure you want to public your post ?</div><div id="confirm_action"><div onclick="closePostPannel()">Cancel</div><div onclick="sendPost()">Post</div></div>';
					$(".Perror_pannel>div:nth-child(2)").html(html);
			}
		});
		//getNewPost();
		function imageValidation(img)
		{
			//console.log(img);
			val=img.name;
			size=img.size;
			ext=val.substring(val.lastIndexOf('.') + 1).toLowerCase();
			//console.log(ext+" "+size);
			if((ext=="png"||ext=="jpeg"||ext=="jpg"||ext=="gif")&&(size>5120&&size<5242880))
			{
				return "true";
			}
			else{
				return "false";
			}
		}
		
		$("#add_Prophoto").on('change',function(){
			var file=this.files;
			var total_file=this.files.length;
			if(total_file>0)
			{
				$("#addUploadIcon").css("display","none");
				$(".multiple_img_control").css("display","block");
				 for(var i=0;i<total_file;i++)
				 {
				 	res=imageValidation(file[i]);
				 	
				 	if(res=="true")
				 	{
				 		html='<li><img src="'+URL.createObjectURL(event.target.files[i])+'"></li>';
				 		document.getElementsByClassName("m_ul")[0].innerHTML+=html;
				 	}
				 	else{
				 		$("#addUploadIcon").css("display","block");
						$(".multiple_img_control").css("display","none");
				 		alert("Invalid image type.Image must be bigger than 10 KB and smaller than 5 MB.");
				 		return;
				 	}
				 }
			}
	    });
	    $("#save_mimg").click(function(){
	    	$(".Profile_pic_pannel").css("display","none");
	    	$(".m_ul").html("");
	    	$("#addUploadIcon").css("display","block");
			$(".multiple_img_control").css("display","none");
	    	var path=[];
	    	var xml=new XMLHttpRequest();
			path=document.getElementById("add_Prophoto").files;
			//alert(path.length);
			for(var i=0;i<path.length;i++)
			{
				var data=new FormData();
				data.append("mulPro_img",path[i]);
				//console.log(data);
				xml.open("post","GroupServer.php",true);
				xml.onreadystatechange=function()
				{
					if(xml.readyState==4)
					{

						result=xml.responseText;
						//alert(result);
						//console.log(result);
						getNewPostPhotos();
					}
				}
				xml.send(data);
			}
		});
		$(".post_box>div:nth-child(1)>div:nth-child(2)").click(function(){
			$(".Profile_pic_pannel").css("display","block");
		});
		
		$("#cancel_mimg").click(function(){
			$(".Profile_pic_pannel").css("display","none");
	    	$(".m_ul").html("");
	    	$("#addUploadIcon").css("display","block");
			$(".multiple_img_control").css("display","none");
		});
		//getNewPostPhotos();
		function getNewPostPhotos()
		{
				$.post("GroupServer.php",{
					new_post:'get'
				},function(result){

					$(".no_recent_post").remove();
					if(result!="no new post")
						setNewPostPhotosBox(result);
				});	
		}
		function setNewPostPhotosBox(result)
		{
			result=JSON.parse(result);
			//console.log(result);
			if(result[1]['gender']=="male")
			{
				if(result[1][0]=="null")
					path="../images/ios7-contact.png";
				else
					path="../Uploaded/profile/"+result[1][0];
			}
			else{	
				if(result[1][0]=="null")
					path="../images/female.png";
				else
					path="../Uploaded/profile/"+result[1][0];
			}
			//alert(path);
				html='<div class="posts-pannel"><div><div class="post_profile_img"><img src='+path+'></div><div class="posts_name_header"><div><span><a href="Profile.php?id='+result[1]['id']+'">'+result[1]['first_name']+" "+result[1]['last_name']+'</a></span>';
				html+='</div><div><span>'+result[0]['post_date']+'</span></div></div><div><i class="ion-navicon-round"></i></div></div>';

				html+='<div class="post_area"><div style="background-color: #fff;height:50%;width:95%;border-bottom: 1px solid #e2e1e1;font-size: 22px;font-family: monospace;padding:20px 19px;"><img src="../Uploaded/add_photos/'+result[0]['post_photos']+'" style="height:100%;width:100%;"></div></div>';	

				html+='<div class="post_action_box"><div class="like_comm_share_icon_box"><ul>';
				if(result[0]['plike']!=null&&result[0]['plike']=='Y')
				{
					html+='<li onclick="sendLike(\''+result[0]['post_id']+'\',\''+result[0]['receiver_id']+'\',\'dislike\',this)" style="color:#2196f3;"><i class="ion-thumbsup"></i><span id=post_like_btn>Like</span><span>'+result[2]+'</span></li>';
				}
				else{
				
					html+='<li onclick="sendLike(\''+result[0]['post_id']+'\',\''+result[0]['receiver_id']+'\',\'like\',this)"><i class="ion-thumbsup"></i><span id=post_like_btn>Like</span><span>'+result[2]+'</span></li>';
				}
				html+='</ul></div></div></div>';
				$(html).insertAfter(".div_1");
		}

		/*------------ Profile Details --------*/
		getAllProfileDetails();
		function getAllProfileDetails()
		{
			var id=decodeURIComponent(window.location.search.substring(1));
			//alert(id);
			s_id=id.split("&");
			if(s_id.length>1)
			{
				uid=s_id[0].split("=");
				mid=s_id[1].split("=");
			}
			else
			{
				uid=s_id[0].split("=");
			}
			$.post("GroupServer.php",{
				profile_details:uid[1]
			},function(result){
				result=JSON.parse(result);
				//console.log(result);
				if(uid[0]=="id")
				{
					if(s_id.length>1)
					{
						if(mid[1]=="1")
							setAllProfileDetails(result);		
						else{
							setProfileMainDetail(result);					
						}
					}
					else{
						setAllProfileDetails(result);		
					}
				}
			});
		}
		function setProfileMainDetail(result)
		{
			//console.log(result);	
			var path="";
			var cpath="";
			if(result[0]['gender']=="male")
			{
				if(result[0][0]!="null")
					path="../Uploaded/profile/"+result[0][0];
				else
					path="../images/ios7-contact.png";
			}
			else{
				if(result[0][0]!="null")
					path="../Uploaded/profile/"+result[0][0];
				else
					path="../images/female.png";
			}			
			if(result[0][1]!="null")
			{
				cpath="../Uploaded/cover/"+result[0][1];
			}
			else{
				cpath="../images/cover1.jpg";
			}
			$("#cover_pic").attr("src",cpath);
			$("#profile_pic_img").attr("src",path);
			$(".profile_list>ul>li:nth-child(4)>a").html(result[0]['first_name']+" "+result[0]['last_name']);
		}
		function setAllProfileDetails(result)
		{
			//console.log(result);	
			var path="";
			var cpath="";
			if(result[0]['gender']=="male")
			{
				if(result[0][0]!="null")
					path="../Uploaded/profile/"+result[0][0];
				else
					path="../images/ios7-contact.png";
			}
			else{
				if(result[0][0]!="null")
					path="../Uploaded/profile/"+result[0][0];
				else
					path="../images/female.png";
			}
			if(result[0][1]!="null")
			{
				cpath="../Uploaded/cover/"+result[0][1];
			}
			else{
				cpath="../images/cover1.jpg";
			}

				$(".header_srch_box>input").val(result[0]['first_name']+" "+result[0]['last_name']);
				html='<div class="posts-pannel"><div><div class="post_profile_img"><img src='+path+'></div><div class="posts_name_header"><div><span><a href="Profile.php?id='+result[0]['id']+'">'+result[0]['first_name']+" "+result[0]['last_name']+'</a></span>';
					date=result[0]['signup_date'].split(" ");

					html+='</div><div><span>'+date[0]+'</span></div></div><div><i class="ion-navicon-round"></i></div></div>';

					html+='<div class="post_area"><div><img src="../images/birthday.png" id=birth_img><span id=birth_txt>Born on '+result[0]['birthday']+'</span></div></div>';	

					html+='</div>';
					$(html).insertAfter(".div_1");
									
				/*---------------- birthday banner ---------*/

			$("#cover_pic").attr("src",cpath);
			$("#profile_pic_img").attr("src",path);
			$("#postProPic").attr("src",path);
			$(".profile_list>ul>li:nth-child(4)>a").html(result[0]['first_name']+" "+result[0]['last_name']);
			$(".p_li1").css("display","none");
			if(result[0]['id']==result[4])
			{
				$(".p_li3").css("display","block");
				$(".p_li3").css("left","21%");
			}
			else{
				$(".p_li3").css("display","none");
			}
			$(".t_intro>div:nth-child(2)>h4:nth-child(1)").html("Hi "+result[0]['first_name']+" "+result[0]['last_name']+" ,");
			$(".intr_table>tbody>tr:nth-child(1)>td:nth-child(2)").html(result[0]['birthday']);
			$(".intr_table>tbody>tr:nth-child(2)>td:nth-child(2)>span:nth-child(1)").html(result[0]['state']);
			$(".intr_table>tbody>tr:nth-child(2)>td:nth-child(2)>span:nth-child(2)").html(result[0]['country']);
			$(".intr_table>tbody>tr:nth-child(3)>td:nth-child(2)").html("unknown");
			$(".intr_table>tbody>tr:nth-child(4)>td:nth-child(2)").html(result[0]['signup_date']);

			if(result[1]!="null")
			{
				var fpath="";
				$("#frnds_qiuckpic").css("display","block");
				$("#frnds_qiuckpic").html("");
				$("#nFrnd").css("display","none");
				for(var m=0;m<result[1].length;m++)
				{
					if(result[1][m]['gender']=="male")
					{
						//alert(result[1][m][0]);
						if(result[1][m][0]!="null")
							path="../Uploaded/profile/"+result[1][m][0];
						else
							path="../images/ios7-contact.png";
					}
					else{
						if(result[1][m][0]!="null")
							path="../Uploaded/profile/"+result[1][m][0];
						else
							path="../images/female.png";
					}
					//alert(path);
					html='<li title="'+result[1][m]['first_name']+" "+result[1][m]['last_name']+'"><a href="Profile.php?id='+result[1][m]['id']+'"><img src="'+path+'"></a></li>';
					document.getElementById("frnds_qiuckpic").innerHTML+=html;
				}
			}
			else{
				$("#frnds_qiuckpic").html("");
				$("#frnds_qiuckpic").css("display","none");
				$(".nFrnd").css("display","block");
			}

			if(result[2]!="null")
			{
				var gpath="";
				$(".Jgroup_info").css("display","block");
				$(".Jgroup_info").html("");
				$("#prof_no_grpj").css("display","none");	
				if(result[2]['group_logo'].length>0)
				{
						gpath="../Uploaded/group_logo/"+result[2]['group_logo'];
				}
				else
				{
					gpath="../images/ios7-people.png";
				}	
				//alert(gpath);
				$("#jgrp_img>img").attr("src",gpath);
				$("#Jgroup_info>div:nth-child(2)>span").html(result[2]['group_name']);
				$("#Jgroup_info>div:nth-child(3)>span:nth-child(1)").html(result[2][0]['len']+" / ");
				$("#Jgroup_info>div:nth-child(3)>span:nth-child(2)").html(result[2]['group_length']);
			}
			else{
				$("#Jgroup_info").html("");
				$("#Jgroup_info").css("display","none");
				$("#prof_no_grpj").css("display","block");	
			}

			if(result[3]!="No recent post")
			{
				$(".no_recent_post").remove();
				var data=[];
				for(var p=0;p<result[3].length;p++)
				{
					if(result[3][p]['post_photos']!=null)
					{
						if(result[3][p]['sender_id']==result[0]['id'])
						{
							data=result[0];
						}
						else
						{
							for(r=0;r<result[1].length;r++)
							{
								if(result[1][r]['id']==result[3][p]['sender_id'])
								{
									data=result[1][r];
								}
							}
						}
						//console.log(data);
								if(data['gender']=="male")
								{
									if(data[0]=="null")
										ppath="../images/ios7-contact.png";
									else
										ppath="../Uploaded/profile/"+data[0];
								}
								else{	
									if(data[0]=="null")
										ppath="../images/female.png";
									else
										ppath="../Uploaded/profile/"+data[0];
								}
								
									html='<div class="posts-pannel"><div><div class="post_profile_img"><img src='+ppath+'></div><div class="posts_name_header"><div><span><a href="Profile.php?id='+data['id']+'">'+data['first_name']+" "+data['last_name']+'</a></span><span style="font-size: 16px;font-family: Calibri;margin-left: 12px;color: #369bf4;font-weight: 500;letter-spacing: 0.5px;">add a new photo</span>';
									html+='</div><div><span>'+result[3][p]['post_date']+'</span></div></div><div><i class="ion-navicon-round"></i></div></div>';

									html+='<div class="post_area"><div style="background-color: #fff;height:50%;width:95%;border-bottom: 1px solid #e2e1e1;font-size: 22px;font-family: monospace;padding:20px 19px;"><img src="../Uploaded/add_photos/'+result[3][p]['post_photos']+'" style="height:100%;width:100%;"></div></div>';	

									html+='<div class="post_action_box"><div class="like_comm_share_icon_box"><ul>';
									if(result[3][p]['plike']!=null&&result[3][p]['plike']=='Y')
									{
										html+='<li onclick="sendLike(\''+result[3][p]['post_id']+'\',\''+result[3][p]['sender_id']+'\',\''+result[3][p]['receiver_id']+'\',\'dislike\',this)" style="color:#2196f3;"><i class="ion-thumbsup"></i><span id=post_like_btn>Like</span><span>'+result[3][p][0]+'</span></li>';
									}
									else{
									
										html+='<li onclick="sendLike(\''+result[3][p]['post_id']+'\',\''+result[3][p]['sender_id']+'\',\''+result[3][p]['receiver_id']+'\',\'like\',this)"><i class="ion-thumbsup"></i><span id=post_like_btn>Like</span><span>'+result[3][p][0]+'</span></li>';
									}
									html+='</ul></div></div></div>';
									$(html).insertAfter(".div_1");
					}
					else{
									if(result[3][p]['sender_id']==result[0]['id'])
									{
										data=result[0];
									}
									else if(result[1]!="null")
									{
										for(r=0;r<result[1].length;r++)
										{
											if(result[1][r]['id']==result[3][p]['sender_id'])
											{
												data=result[1][r];
											}
										}
									}
									else if(result[1]=="null")
									{
										data=result[0];	
									}
									//console.log(data);
											if(data['gender']=="male")
											{
												if(data[0]=="null")
													ppath="../images/ios7-contact.png";
												else
													ppath="../Uploaded/profile/"+data[0];
											}
											else{	
												if(data[0]=="null")
													ppath="../images/female.png";
												else
													ppath="../Uploaded/profile/"+data[0];
											}
											//alert(path);
												html='<div class="posts-pannel"><div><div class="post_profile_img"><img src='+ppath+'></div><div class="posts_name_header"><div><span><a href="Profile.php?id='+data['id']+'">'+data['first_name']+" "+data['last_name']+'</a></span>';
												html+='</div><div><span>'+result[3][p]['post_date']+'</span></div></div><div><i class="ion-navicon-round"></i></div></div>';

												html+='<div class="post_area"><div style="background-color: #fff;height: auto;width:90%;border-bottom: 1px solid #e2e1e1;font-size: 22px;font-family: monospace;padding:20px 25px;">'+result[3][p]['text_post']+'</div></div>';	

												html+='<div class="post_action_box"><div class="like_comm_share_icon_box"><ul>';
												if(result[3][p]['plike']!=null&&result[3][p]['plike']=='Y')
												{
													html+='<li onclick="sendLike(\''+result[3][p]['post_id']+'\',\''+result[3][p]['sender_id']+'\',\''+result[3][p]['receiver_id']+'\',\'dislike\',this)" style="color:#2196f3;"><i class="ion-thumbsup"></i><span id=post_like_btn>Like</span><span>'+result[3][p][0]+'</span></li>';
												}
												else{
												
													html+='<li onclick="sendLike(\''+result[3][p]['post_id']+'\',\''+result[3][p]['sender_id']+'\',\''+result[3][p]['receiver_id']+'\',\'like\',this)"><i class="ion-thumbsup"></i><span id=post_like_btn>Like</span><span>'+result[3][p][0]+'</span></li>';
												}
												html+='</ul></div></div></div>';
												$(html).insertAfter(".div_1");

					}
				}

			}
			else{
				
			}	
		}
		/*--------------- End here ---------*/
		getFriendshipStatus();
		function getFriendshipStatus()
		{
			var id=decodeURIComponent(window.location.search.substring(1));
			s_id=id.split("&");
			if(s_id.length>1)
			{
				uid=s_id[0].split("=");
				mid=s_id[1].split("=");
			}
			else
				uid=s_id[0].split("=");
					
				$.post("GroupServer.php",
				{
				 	user_frnd_status:uid[1]
				},
				function(results){
					result=JSON.parse(results);
				//	console.log(result);
					if(uid[1]!=result[1])
					{
						$(".p_li1").css("display","block");
						
						var status=null;
						var data="";
						if(result[0]=="Add Friend")
						{
							status="add_friend";
							data=result[0];
						}
						else{

							if(result[0][0][0]=="Friend Request Send")
							{	
								$(".p_li1").css("display","block");
								data=result[0][0][0];
								status="canceled";
							}
							else if(result[0][0][0]=="Add Friend")
							{
								$(".p_li1").css("display","block");
								data=result[0][0][0];
								status="add_friend";
							}
							else if(result[0][0][0]=="Accept")
							{
								$("#relation_setting_action>li:nth-child(1)").css("display","block");	
								status="accepted";
								html='<div id="profrndStat" style="display:flex;"><div style="background: green;padding: 0px 17px;" onclick="member_add_frnd2(\''+uid[1]+'\',\''+status+'\',this)">Accept</div><div style="background: #ef3c03;padding: 0px 17px;" onclick="member_add_frnd2(\''+uid[1]+'\',\''+'rejected'+'\',this)">Reject</div></div>';
								//alert(html);
								$(".p_li1").html(html);		
								return;
							}
							else if(result[0][0][0]=="Friends")
							{
								data=result[0][0][0];
								status="unfriend";

								html='<div id="profrndStat"><div onclick="member_add_frnd2(\''+uid[1]+'\',\''+status+'\',this)" style="padding:0px 20px">Friends</div></div>';
								$(".p_li1").html(html);		
								return;
							}

						}

						$(".p_li1>div>div").html(data);
						$(".p_li1>div:nth-child(1)").attr("onclick","member_add_frnd('"+uid[1]+"','"+status+"',this)");
					}
					else
					{

					}
				});
		}
		$(".p_li1>div>div").on({
			mouseenter:function()
			{
				var val=$(this).html();
				if(val=="Friend Request Send")
				{
					$(this).html("Cancel Request");
				}
			},
			mouseleave:function()
			{
					var val=$(this).html();
					if(val=="Cancel Request")
					{
						$(this).html("Friend Request Send");
					}	
			}
		});

		$(".Profile_pic_pannel>div:nth-child(1)").click(function(){
			$(".Profile_pic_pannel").css("display","none");
		});
});

function member_add_frnd(index,status,ele)
{
	var action_status=null;
	var naction_status=null;
	if(status=="add_friend")
	{
		action_status="Friend Reqeust Send";
		naction_status="canceled";
	}
	else if(status=="Friend Reqeust Send")
	{
		action_status="canceled";
	}
	else if(status=="Friends")
	{
		action_status="Add Friend";
	}
	else if(status=="canceled")
	{
		action_status="Add Friend";
		naction_status="add_friend";
	}
	//alert(index+" "+action_status);
	$.post("GroupServer.php",{
		frnd_id:index,
		frnd_stat:status
	},function(result){
		//alert(result);
		if(result=="true")
		{
			if(status=="accepted")
			{
				$(ele).next().remove();
				$(ele).html(action_status);
				$(ele).css({"width":"82%","margin":"20px 0px 0px 22px"});
			}
			else if(status=="rejected")
			{
				$(ele).prev().remove();
				$(ele).html(action_status);
				$(ele).css({"width":"82%","margin":"20px 0px 0px 22px"});
			}
			$(ele).attr("onclick","member_add_frnd('"+index+"','"+naction_status+"',this)");
			$(ele).find("#profrndStat").html(action_status);
		}
		else if(result=="false")
		{

		}
	});
}
function member_add_frnd2(index,status,ele)
{
	//alert(index+' '+status);
	$.post("GroupServer.php",{
		frnds_box:index,
		frnd_stat:status
	},function(result){
		//alert(result);
		if(result=="true")
		{
			if(status=="accepted")
			{
				$(ele).attr("onclick","member_add_frnd('"+index+"','"+'add_friend'+"',this)");
				$(ele).parent().html();
				$(ele).parent().html("<div>Friends</div>");
			}
			else if(status=="unfriend")
			{
				$(ele).attr("onclick","member_add_frnd('"+index+"','"+'add_friend'+"',this)");
				$(ele).parent().html();
				$(ele).parent().html("<div>Add Friend</div>");
			}
			else if(status=="rejected")
			{
				$(ele).attr("onclick","member_add_frnd('"+index+"','"+'add_friend'+"',this)");
				$(ele).parent().html();
				$(ele).parent().html("<div>Add Friend</div>");
			}
		}
		else if(result=="false")
		{

		}
	});
}
/*-----------------------------*/
function closePostPannel()
{
	$(".Perror_pannel").css("display","none");
	$("#post_textarea").val("");
}
function sendPost()
{
	var val=$("#post_textarea").val();
	s_id=[];
		var id=decodeURIComponent(window.location.search.substring(1));
		//alert(id);
		s_id=id.split("&");
		if(s_id.length>1)
		{
			uid=s_id[0].split("=");
			mid=s_id[1].split("=");
		}
		else
		{
			uid=s_id[0].split("=");
		}
		//alert(uid);
	$.post("GroupServer.php",{
		post_mess:val,
		post_man:uid[1]
	},function(result){
		//console.log(result);
		if(result=="true")
		{
			$(".Perror_pannel").css("display","none");
			$("#post_textarea").val("");
			getNewPost();			
		}
	});
}
function close()
{
		//alert();
		$(".profile_cover_loader").css("display","none");
		$(".prof_loader").css("display","none");
}
function getNewPost()
{
	$.post("GroupServer.php",{
		new_post:'get'
	},function(result){
		$(".no_recent_post").remove();
		setNewPostBox(result);
	});	
}
function setNewPostBox(result)
{
	result=JSON.parse(result);
	//console.log(result);
	if(result[1]['gender']=="male")
	{
		if(result[1][0]=="null")
			path="../images/ios7-contact.png";
		else
			path="../Uploaded/profile/"+result[1][0];
	}
	else{
		if(result[1][0]=="null")
			path="../images/female.png";
		else
			path="../Uploaded/profile/"+result[1][0];
	}
	//alert(path);
		html='<div class="posts-pannel"><div><div class="post_profile_img"><img src='+path+'></div><div class="posts_name_header"><div><span><a href="Profile.php?id='+result[1]['id']+'">'+result[1]['first_name']+" "+result[1]['last_name']+'</a></span>';
		html+='</div><div><span>'+result[0]['post_date']+'</span></div></div><div><i class="ion-navicon-round"></i></div></div>';
		html+='<div class="post_area"><div style="background-color: #fff;height: auto;width:90%;border-bottom: 1px solid #e2e1e1;font-size: 22px;font-family: monospace;padding:20px 25px;">'+result[0]['text_post']+'</div></div>';	

		html+='<div class="post_action_box"><div class="like_comm_share_icon_box"><ul>';
		if(result[0]['plike']!=null&&result[0]['plike']=='Y')
		{
			html+='<li onclick="sendLike(\''+result[0]['post_id']+'\',\''+result[0]['receiver_id']+'\',\'dislike\',this)" style="color:#2196f3;"><i class="ion-thumbsup"></i><span id=post_like_btn>Like</span><span>'+result[2]+'</span></li>';
		}
		else{
		
			html+='<li onclick="sendLike(\''+result[0]['post_id']+'\',\''+result[0]['receiver_id']+'\',\'like\',this)"><i class="ion-thumbsup"></i><span id=post_like_btn>Like</span><span>'+result[2]+'</span></li>';
		}
		html+='</ul></div></div></div>';
		$(html).insertAfter(".div_1");
}
function sendLike(post_id,send_id,rec_id,status,e)
{
	//alert(post_id+send_id+rec_id+status);

	$.post("GroupServer.php",{
		ppost_id:post_id,
		psend_id:send_id,
		prec_id:rec_id,
		p_like:status
	},function(result){
		//alert(result);
	//	console.log(result);
		if(result=="true")
		{
			if(status=="like")
			{
				num=$(e).find("span:nth-child(3)").html();
				num=parseInt(num);
				$(e).find("span:nth-child(3)").html(num+1);
				$(e).find("i").css("color","#2196f3");
				$(e).find("span:nth-child(2)").css("color","#2196f3");
				$(e).find("span:nth-child(3)").css("color","#2196f3");
				$(e).attr("onclick",'sendLike(\''+post_id+'\',\''+send_id+'\',\''+rec_id+'\',\'dislike\',this)');
			}
			else if(status=="dislike"){
				num=$(e).find("span:nth-child(3)").html();
				num=parseInt(num);
				$(e).find("span:nth-child(3)").html(num-1);
				$(e).find("i").css("color","#3a3939");
				$(e).find("span:nth-child(2)").css("color","#3a3939");
				$(e).find("span:nth-child(3)").css("color","#3a3939");
				$(e).attr("onclick",'sendLike(\''+post_id+'\',\''+send_id+'\',\''+rec_id+'\',\'like\',this)');
			}
		}
		else{

		}
	});

}
function cover_uploading()
{
	var xml=new XMLHttpRequest();
	path=profile_upload.files[0];
	var data=new FormData();
	data.append("profile_img",path);
	xml.open("post","ProfileServer.php",true);
	xml.onreadystatechange=function()
	{
		if(xml.readyState!=4)
		{
				document.getElementsByClassName("profile_cover_loader")[0].style.display="block";		
				$(".prof_loader").css("display","block");
		}
		else if(xml.readyState==4)
		{
			result=xml.responseText;
	//		console.log("res -> "+result);
			document.getElementsByClassName("profile_cover_loader")[0].style.display="none";		
			if(result!="error")
			{
				$(".prof_loader").css("display","none");
				$("#cover_pic").attr("src","../Uploaded/cover/"+result);
				$(".profile_cover_loader").css("display","block");
				$(".prof_loader").css("display","block");
			}
			else
			{
				$(".prof_loader").css("display","none");
				$(".Perror_pannel").css("display","block");
				$(".Perror_pannel>div:nth-child(2)").html("Invalid image type.Please upload only jpg,png,jpeg and gif images");
			}
		}
	}
	xml.send(data);

}
function profile_uploading()
{
	var xml=new XMLHttpRequest();
	path=profileP_upload.files[0];
	var data=new FormData();
	data.append("profileP_img",path);
	xml.open("post","ProfileServer.php",true);
	xml.onreadystatechange=function()
	{
		if(xml.readyState!=4)
		{
				document.getElementsByClassName("profileP_loader")[0].style.display="block";		
		}
		else if(xml.readyState==4)
		{
			result=xml.responseText;
	//		console.log(result);
			document.getElementsByClassName("profileP_loader")[0].style.display="none";		
			if(result!="error")
			{
				document.getElementsByClassName("profileP_loader")[0].style.display="none";		
				window.location.reload();
			}
			else
			{
				$(".prof_loader").css("display","none");
				$(".Perror_pannel").css("display","block");
				$(".Perror_pannel>div:nth-child(2)").html("Invalid image type.Please upload only jpg,png,jpeg and gif images");
			}
		}
	}
	xml.send(data);

}
function saveCover(index)
{
	if(index)
	{
		$("#save_cpic").removeAttr("onclick");
		path=$("#cover_pic").attr("src");
		//console.log(path);
		path=path.substr(18,path.length-1);
		//console.log(path[1]);
		var xml=new XMLHttpRequest();
		xml.open("post","ProfileServer.php",true);
		xml.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xml.send("path="+path);	
		xml.onreadystatechange=function()
		{
			if(xml.readyState==4)
			{
				result=xml.responseText;
				//console.log(result);
				//alert(result);
				if(result==1)
				{
					window.location.reload();
				}
			}
		}
	}
	else{
		window.location.reload();
	}
}


function saveAboutInfo(index,e)
{
	//alert(index,e);
	var id=decodeURIComponent(window.location.search.substring(1));
	s_id=id.split("&");
	uid=s_id[0].split("=");
	var val=$(e).siblings("form").children().val();
	val=val.trim();
	if(val.length==0)
	{

	}
	else
	{
		$.post("GroupServer.php",{
			abt_val:val,
			abt_id:uid[1],
			abt_index:index
		},function(result){
	//		console.log(result);
			if(result=="true"){
				$(e).siblings("form").children().css("border","1px solid green");
				$(e).siblings("form").children().attr("readonly","readonly");
			}
		});
	}
}

