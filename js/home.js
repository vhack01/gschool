var loader='<li><div class="glob_loader"><svg width="90" height="70" viewBox="0 0 135 140" xmlns="http://www.w3.org/2000/svg" fill="silver" class=svg><rect y="10" width="15" height="120" rx="6"><animate attributeName="height" begin="0.5s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite" /><animate attributeName="y" begin="0.5s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite" /></rect><rect x="30" y="10" width="15" height="120" rx="6"><animate attributeName="height" begin="0.25s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite" /><animate attributeName="y" begin="0.25s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite" /></rect><rect x="60" width="15" height="140" rx="6"><animate attributeName="height" begin="0s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite" /><animate attributeName="y" begin="0s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite" /></rect><rect x="90" y="10" width="15" height="120" rx="6"><animate attributeName="height" begin="0.25s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite" /><animate attributeName="y" begin="0.25s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite" /></rect><rect x="120" y="10" width="15" height="120" rx="6"><animate attributeName="height" begin="0.5s" dur="1s" values="120;110;100;90;80;70;60;50;40;140;120" calcMode="linear" repeatCount="indefinite" /><animate attributeName="y" begin="0.5s" dur="1s" values="10;15;20;25;30;35;40;45;50;0;10" calcMode="linear" repeatCount="indefinite" /></rect></svg><div>Loading</div></div></li>';

$(document).ready(function(){

	globalGroupChats(1,'');
	function globalGroupChats(index,res)
	{
		$.post("HomeServer.php",
		{
		 	chats_index:index,
		  	beforeSend:loadStart,
		  	complete:loadStop
		},
		function(result){
		  	//alert(result);
	  		$("#group_message_li").remove();
	  		$("#gchat_box").remove();
	  		$(".text_box").remove();
		  	if(index==1)
		  	{	
		  		$(result).insertAfter(".qchat_pannel_ul>li:nth-child(1)");
		  		$.post("HomeServer.php",
				{
					glbchat_typer:'get'
				},
				function(typer){
					$("#g_typer").html(typer);
				});
		  		getGlobalChats();
		  	}
		  	else if(index==2)
		  	{
		  		//alert(index);
		  		$(result).insertAfter(".qchat_pannel_ul>li:nth-child(1)");
		  		$.post("HomeServer.php",
				{
					grpchat_typer:'get'
				},
				function(typer){
					$("#g_typer").html(typer);
				});
				getGroupChats(res);
		  	}
		  	else if(index==3)
		  	{
		  		$(result).insertAfter(".qchat_pannel_ul>li:nth-child(1)");
		  		$(".text_box").remove();
		  	}
		});
	}
	
function getGlobalChats()
{
	$.post("HomeServer.php",
	{
	  	session:'check',
	},
	function(result,status){
		//alert(result);
	  	//console.log(result);
	  	$(".chat_area_ul").append(result);
	  	setGlobalScroller();
	});
}
function getGroupChats(result)
{
		var top=[];
		top=result[result.length-1];
		var logo="";
		if(top['group_logo'].length>0)
		{
			logo="../Uploaded/group_logo/"+top['group'];
		}
		else{
			logo="../images/ios7-contact.png";
		}
		$("#groupchat_logo").attr("src",logo);
		$("#groupchat_name").html(top['group_name']);

	//console.log(result);
	if(result[result.length-2]=="No message")
	{
		//alert("no message");
	}
	else
	{
		//console.log(result);
		for(i=0;i<result.length-1;i++)
		{
			var path="";
				if(result[i]['gender']=="male")
				{
					if(result[i][0]=="null")
						path="../images/ios7-contact.png";
					else
						path="../Uploaded/profile/"+result[i][0];
				}
				else{	
					if(result[i][0]=="null")
						path="../images/female.png";
					else
						path="../Uploaded/profile/"+result[i][0];
				}
        	html='<li class="users_list" onclick="g_tooltip(this)"><div><img src="'+path+'"></div><div class="user_content"><div><span style="text-transform:capitalize">'+result[i]['first_name']+" "+result[i]['last_name']+'</span><br><span class="group_nm">'+result[i][1]+'</span></div><div>'+result[i][2]['message']+'</div></div></li>';
        	$(".groupchat_list").append(html);
       }		
    		setGlobalScroller1();	
    }
}

	function loadStart()
	{
		$(loader).insertAfter(".qchat_pannel_ul>li:nth-child(1)");
	}
	function loadStop()
	{
		$(".glob_loader").parent().remove();
	}

	/*----------------- Global Recent Message -------------*/
	var timestop=null;
	Globaltimer();
	function Globaltimer()
	{
		timestop=setInterval(call,100);
	}
	function call()
	{
		getGlobalRecentMessage();
	}
	function getGlobalRecentMessage()
	{
			$.post("HomeServer.php",
			{
			  	msg:'get'
			},
			  function(result){
			  	//console.log(result);
	        	if(result!="No data")
	        	{	
	        		//alert(result);
	        		result=JSON.parse(result);
		        	if(result['img']=="null")
		        	{
		        		if(result['gender']=="male")
		        			result['img']='ios7-contact.png';
		        		else
		        			result['img']='female.png';

			        		$(".chat_area_ul").append('<li class="users_list" onclick="g_tooltip(this)"><div><img src="../images/'+result['img']+'"></div><div class="user_content"><div><span style="text-transform:capitalize">'+result['name']+'</span><br><span class="group_nm">Bug Boat</span></div><div>'+result['msg']+'</div></div></li>');
			        			setGlobalScroller();
			        		return;
		        	}
		        	$(".chat_area_ul").append('<li class="users_list" onclick="g_tooltip(this)"><div><img src="../Uploaded/profile/'+result['img']+'"></div><div class="user_content"><div><span style="text-transform:capitalize">'+result['name']+'</span><br><span class="group_nm">Bug Boat</span></div><div>'+result['msg']+'</div></div></li>');
		        		setGlobalScroller();
			        		return;
				}
	  		  }); 	
		}
		/*----------------- Group Recent Message -------------*/
	var gtimestop=null;
	function Grouptimer()
	{
		gtimestop=setInterval(gcall,100);
	}
	function gcall()
	{
		getGroupRecentMessage();
	}
	function getGroupRecentMessage()
	{
			$.post("HomeServer.php",
			{
			  	grpmsg:'get'
			},
			  function(result){
			  	//console.log(result);
	        	if(result!="No recent group message")
	        	{
	        		result=JSON.parse(result);
			  		//console.log(result);
	        			
			        var path="";
					if(result[0]['gender']=="male")
					{
						if(result[0][0]=="null")
							path="../images/ios7-contact.png";
						else
							path="../Uploaded/profile/"+result[0][0];
					}
					else{	
						if(result[0][0]=="null")
							path="../images/female.png";
						else
							path="../Uploaded/profile/"+result[0][0];
					}
	        		html='<li class="users_list" onclick="g_tooltip(this)"><div><img src="'+path+'"></div><div class="user_content"><div><span style="text-transform:capitalize">'+result[0]['first_name']+" "+result[0]['last_name']+'</span><br><span class="group_nm">'+result[0][1]+'</span></div><div>'+result[1]['message']+'</div></div></li>';
	        			$(".groupchat_list").append(html);
		        		setGlobalScroller1();
				}
	  		  }); 	
	}


		/*----------------- END HERE -------------*/
	function setGlobalScroller()
	{
		var s=document.getElementById("gchat_box");
		s.scrollTop=s.scrollHeight;
	}
	function setGlobalScroller1()
	{
		var s=document.getElementById("group_message_li");
		s.scrollTop=s.scrollHeight;
	}
	var v=0;
	$(".hider").click(function(){
		if(v==0){

			$(".qchat_pannel").animate({
				left:'-23%'
			},300);
			$(this).animate({
				left:'0'
			},300);
			$(".hider>i:nth-child(2)").attr("class","ion-ios-redo");
			$(".glob_tooltip").hide();
		}
		else{
				$(".qchat_pannel").animate({
				left:'0%'
			},300);
			$(this).animate({
				left:'23%'
			},300);	
			$(".hider>i:nth-child(2)").attr("class","ion-ios-undo");
			//$(".glob_tooltip").show(300);
		}
		v=! v;

	});


	$(".chat_area_ul").each(function(){
		$(this).find("li:has(.users_list)").on({
			mouseenter:function(){
				//$(".glob_tooltip").css("visibility","visible");
				alert("show");
			},
			mouseleave:function(){
				alert("hide");	//$(".glob_tooltip").css("visibility","hidden");	
			}
		});
	});


	$(".qchat_pannel_ul>li:nth-child(1)>div:nth-child(1)").css({"background":"#fff","color":"#000","box-shadow":"0px 0px 2px grey"});
	$(".qchat_pannel_ul>li:nth-child(1)>div:nth-child(1)").click(function(){
		$(this).css({"background":"#fff","color":"#000","box-shadow":"0px 0px 2px grey"});
		$(".qchat_pannel_ul>li:nth-child(1)>div:nth-child(2)").css({"background":"#ff5e3a","color":"#fff","box-shadow":"0px 0px 0px #fff"});
		$(".qchat_pannel_ul>li:nth-child(2)").show();
		clearInterval(gtimestop);
		Globaltimer();
		globalGroupChats(1,'');
	});
	$(".qchat_pannel_ul>li:nth-child(1)>div:nth-child(2)").click(function(){
		$(this).css({"background":"#fff","color":"#000","box-shadow":"0px 0px 2px grey"});
		$(".qchat_pannel_ul>li:nth-child(1)>div:nth-child(1)").css({"background":"#ff5e3a","color":"#fff","box-shadow":"0px 0px 0px #fff"});
		$(".qchat_pannel_ul>li:nth-child(2)").hide();
  		$(".glob_tooltip").css("visibility","hidden");	
  		getUserGroupExisitence();
		clearInterval(timestop);
		//getGroupRecentMessage();
	});

	/*----------- Group existence or not ----------*/

		function getUserGroupExisitence()
		{
			
			$.post("GroupServer.php",{
				hgrpexist:'get',
				beforeSend:function(){
					$(loader).insertAfter(".qchat_pannel_ul>li:nth-child(1)");	
					$("#group_message_li").remove();
			  		$("#gchat_box").remove();
			  		$(".text_box").remove();	
				},
		  		complete:function(){
		  			$("#grp_loader").remove();			
		  		}
			},function(result){
				
				if(result=="Not joined")
				{
					globalGroupChats(3,'');			
				}
				else{	
						Grouptimer();
						result=JSON.parse(result);
						//console.log(result);
						globalGroupChats(2,result);	
				}
			});
		}

	/*----------------------------------------------------------------*/

	/*------------ Profile Details --------*/		
		
			
			//alert(UID);
		getAllProfileDetails();
		function getAllProfileDetails()
		{
			$.post("GroupServer.php",{
				logger_id:'get'
			},function(id){

				$.post("GroupServer.php",{
					profile_details:id
				},function(result){
					result=JSON.parse(result);
					//console.log(result);
					setAllProfileDetails(result);		
					
				});
			});
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
									
					$("#hPostProPic").attr("src",path);
				/*---------------- birthday banner ---------*/
			
			if(result[3]!="No recent post")
			{
				$(".no_recent_post").remove();
				var data=[];
				for(var p=result[3].length-1;p>=0;p--)
				{
					if(result[3][p]['post_photos']!=null)
					{
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
								
									html='<li><div class="posts-pannel"><div><div class="post_profile_img"><img src='+ppath+'></div><div class="posts_name_header"><div><span><a href="Profile.php?id='+data['id']+'">'+data['first_name']+" "+data['last_name']+'</a></span><span style="font-size: 16px;font-family: Calibri;margin-left: 12px;color: #369bf4;font-weight: 500;letter-spacing: 0.5px;">add a new photo</span>';
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
									html+='</ul></div></div></div></li>';
									$(".hPostList").append(html);
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
												html='<li><div class="posts-pannel"><div><div class="post_profile_img"><img src='+ppath+'></div><div class="posts_name_header"><div><span><a href="Profile.php?id='+data['id']+'">'+data['first_name']+" "+data['last_name']+'</a></span>';
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
												html+='</ul></div></div></div></li>';
												$(".hPostList").append(html);

					}//else text post
				}// for loop

						html='<li><div class="posts-pannel"><div><div class="post_profile_img"><img src='+path+'></div><div class="posts_name_header"><div><span><a href="Profile.php?id='+result[0]['id']+'">'+result[0]['first_name']+" "+result[0]['last_name']+'</a></span>';
					date=result[0]['signup_date'].split(" ");

					html+='</div><div><span>'+date[0]+'</span></div></div><div><i class="ion-navicon-round"></i></div></div>';

					html+='<div class="post_area"><div><img src="../images/birthday.png" id=birth_img><span id=birth_txt>Born on '+result[0]['birthday']+'</span></div></div>';	

					html+='</div></li>';
					
					$(".hPostList").append(html);
			}
			else{
							html='<li><div class="posts-pannel"><div><div class="post_profile_img"><img src='+path+'></div><div class="posts_name_header"><div><span><a href="Profile.php?id='+result[0]['id']+'">'+result[0]['first_name']+" "+result[0]['last_name']+'</a></span>';
					date=result[0]['signup_date'].split(" ");

					html+='</div><div><span>'+date[0]+'</span></div></div><div><i class="ion-navicon-round"></i></div></div>';

					html+='<div class="post_area"><div><img src="../images/birthday.png" id=birth_img><span id=birth_txt>Born on '+result[0]['birthday']+'</span></div></div>';	

					html+='</div></li>';
					
					$(".hPostList").append(html);	
			}			
		}
		$(".home_frndquickview>div:nth-child(1)").click(function(){
			$(".home_frndquickview>div:nth-child(1)").css({"background":"#3e3e3e","color":"#fff"});
			$(".home_frndquickview>div:nth-child(2)").css({"background":"#fff","color":"#464646"});
			$(".home_frndquickview>div:nth-child(3)").css({"background":"#fff","color":"#464646"});
			$(".qfrnd_list>ul").html("");
			getSomeFriends(1);
		});
		$(".home_frndquickview>div:nth-child(2)").click(function(){
			$(".home_frndquickview>div:nth-child(2)").css({"background":"#3e3e3e","color":"#fff"});
			$(".home_frndquickview>div:nth-child(1)").css({"background":"#fff","color":"#464646"});
			$(".home_frndquickview>div:nth-child(3)").css({"background":"#fff","color":"#464646"});
			$(".qfrnd_list>ul").html("");
			getSomeFriends(2);
		});
		$(".home_frndquickview>div:nth-child(3)").click(function(){
			$(".home_frndquickview>div:nth-child(3)").css({"background":"#3e3e3e","color":"#fff"});
			$(".home_frndquickview>div:nth-child(1)").css({"background":"#fff","color":"#464646"});
			$(".home_frndquickview>div:nth-child(2)").css({"background":"#fff","color":"#464646"});
			$(".qfrnd_list>ul").html("");
			getSomeFriends(3);
		});
		$(".home_frndquickview>div:nth-child(1)").css({"background":"#3e3e3e","color":"#fff"});
		getSomeFriends(1);
		function getSomeFriends(index)
		{
			$.post("GroupServer.php",{
				sfrnd:index
			},function(result){
				if(result=="No Friends")
				{
					$("#no_nearbyu").remove();
					html='<div id="no_nearbyu" style="height: 10%;width: 96%;background: silver;background: #fff;box-shadow: 0px 5px 9px grey;margin-left: 3%;border-radius: 2px;font-family: Ancillary;line-height: 64px;font-size: 16px;letter-spacing: 0.5px;font-weight: 500;text-align: center;">No member near by you</div>';
					$(".qfrnd_list").prepend(html);
				}
				else if(result=="No result")
				{
					alert("No result");
				}
				else
				{
					$("#no_nearbyu").remove();
					result=JSON.parse(result);
					//console.log(result);
					for(i=0;i<result.length;i++)
					{
						var path="";
						var cath="";
							if(result[i]['gender']=="male")
							{
								if(result[i][0]!="null")
									path="../Uploaded/profile/"+result[0][0];
								else
									path="../images/ios7-contact.png";
							}
							else{
								if(result[i][0]!="null")
									path="../Uploaded/profile/"+result[0][0];
								else
									path="../images/female.png";
							}
							if(result[i][1]!="null")
							{
								cpath="../Uploaded/cover/"+result[i][1];
							}
							else{
								cpath="../images/cover1.jpg";
							}

							html='<a href="Profile.php?id='+result[i]['id']+'"><li><div style="background-images:url('+cpath+')"><div><img src="'+path+'"></div></div><div><div><span>'+result[i]['first_name']+" "+result[i]['last_name']+'</span><span>'+result[i]['state']+' , '+result[i]['country']+'</span></div></div></li></a>';
							$(".qfrnd_list>ul").append(html);
					}
				}
			});
		}

		$(".post_box>div:nth-child(1)>div:nth-child(2)").click(function(){
			$(".Profile_pic_pannel").css("display","block");
		});
		$(".Profile_pic_pannel>div:nth-child(1)").click(function(){
			//alert();
			$(".Profile_pic_pannel").css("display","none");
		});

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

		/*---------------- HOME POST --------*/
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
			alert();
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
				$(html).insertAfter("#home_post_box");
		}


});
function sendGroupTypedMessage(e,ele)
{
	if(e.key=="Enter")
	{
		var val=(ele.value).trim();
		//alert(val);
			if(val.length>0) 
			{
					$.post("HomeServer.php",
					{
						grpchat:val
					},
					function(result){
						//console.log(result);
						ele.value="";
	        		});	
			}
	}
}
function sendGlobalTypedMessage(e,ele)
{
	if(e.key=="Enter")
	{
		var val=(ele.value).trim();
		//alert(val);
			if(val.length>0) 
			{
					$.post("HomeServer.php",
					{
						chat:val
					},
					function(result){
						ele.value="";
	        		});	
			}
	}
}
function closePostPannel()
{
	$(".Perror_pannel").css("display","none");
	$("#post_textarea").val("");
}
function g_tooltip(e)
{
	//console.log(e.innerHTML);
	$(".glob_tooltip").css("visibility","visible");	

}
function sendLike(post_id,send_id,rec_id,status,e)
{
	//alert(post_id+send_id+rec_id+status);
	$(e).removeAttr("onclick");
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
function sendPost()
{
	var val=$("#post_textarea").val();
	$.post("GroupServer.php",{
			logger_id:'get'
		},function(userid){
		
			$.post("GroupServer.php",{
				post_mess:val,
				post_man:userid
			},function(result){
	//			console.log(result);
				if(result=="true")
				{
					$(".Perror_pannel").css("display","none");
					$("#post_textarea").val("");
					getNewPost();			
				}
			});
	});
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
		$(html).insertAfter("#home_post_box");
}

var emoji=0;
function groupchatemoji()
{
		if(emoji==0)
			$(".emoji_box").css("visibility","visible");
		else
			$(".emoji_box").css("visibility","hidden");

		emoji=!emoji;
}
function emojiIcon1(index)
{
	if(index==1)
	{
		$(".emoji_1").css("display","block");
		$(".emoji_2").css("display","none");
	}
	else if(index==2)
	{
		$(".emoji_1").css("display","none");
		$(".emoji_2").css("display","block");
	}
}
	

	