var group_info=[];
$(document).ready(function(){
	//alert();
	$(".Perror_pannel>div:nth-child(1)").click(function(){
					$(".Perror_pannel").css("display","none");
	});
	MyGroup(1);
	//groupInfo(5);
	$("#close_gmess_pannel").click(function(){
		$(".Group_message_pannel").css("display","none");
	});
	$(".gmess_pannel_inner>div:nth-child(3)>div:nth-child(1)").click(function(){
		$(".Group_message_pannel").css("display","none");
	});
});
window.onload=function()
{
	
}
function MyGroup(index)
{
	$.post('GroupServer.php',{
		gs:'get'
	},
	function(result){
		//console.log(result);
		groupMenusColor(index);
		$("#typing_no_result").remove();
		if(result=="Not joined")
		{
			$(".group_context").remove();
			html="<div class='group_context'><div class='no_group'>You have not joined any group.</div></div>";
			$(html).insertAfter(".group_menus");
		}
		else if(result=="No Groups Found")
		{
			html='<div class="group_context"><div id="typing_no_result"><i class="ion-alert-circled" ></i><span>No group found . Create your own group</span></div></div>';
			//$("#noti_list").css("display","none");
			$(html).insertAfter(".show_group_content");
		}
		else{
			groupInfo(1,result);
		}
	});
}
function CreateGroup(index)
{
	$.post("GroupServer.php",{
			cks:'check'
	},
	function(result){
		//console.log(result);
		if(result==1)
		{
			//$(".group_menus>ul>li:nth-child(2)").css({"background":"#383737","color":"#fff"});
			$(".Perror_pannel").css("display","block");
			$(".Perror_pannel>div:nth-child(2)").html("You have already joined a group,so you can't create a group.If you want to create your own group leave the joined group,after that you can create your group.");
		}
		else if(result==0)
		{
			//$(".group_menus>ul>li:nth-child(2)").css({"background":"#fff","color":"#000"});
			groupInfo(2,'');
		}
	});
}
function validateGroup(num)
{
	var img="";
	if(num==1)
	{
		path=group_logo_edit.files[0];
		form=new FormData();
		form.append('g_logo',path);
		var xml=new XMLHttpRequest();
		xml.open("post","ProfileServer.php",true);
		xml.send(form);
		xml.onreadystatechange=function()
		{
			if(xml.readyState!=4){
				$("#g_logo_loader").css("display","block");
			}
			else if(xml.readyState==4)
			{
				$("#g_logo_loader").css("display","none");
				result=xml.responseText;
				//console.log(result);
				if(result=="false")
				{
					$(".Perror_pannel").css("display","block");
					$(".Perror_pannel>div:nth-child(2)").html("Invalid image type.Please upload only jpg,png,jpeg and gif images");
				}
				else{
					img=result;
					$(".g_uploading_area>div>img").attr("src","../Uploaded/group_logo/"+result);
					$("#gup_logo").attr("value",result);
				}
			}
		}
	}
	else if(num==2)
	{
		a=$("#grp_nm").val().trim();
		b=$("#grp_len").val().trim();
		$(".g_error").css("display","none");
		$("#g_error2").css("display","none");
		if(a.length<=0)
		{
			//console.log("a="+a+" "+a.length);
			$(".g_error").css("display","block");
			return false;
		}
		if(b.length<=0)
		{
			//console.log("b="+b+" "+b.length);
			$("#g_error2").css("display","block");
			return false;
		}
		return true;
	}
	return false;
}
function groupInfo(index,res)
{
	//alert(index);
	$.post('ProfileServer.php',{
		grp_index:index
	},
	function(result){
		//alert(index);
		//console.log(result);
		$(".group_context").remove();
		if(index=="groups")
		{		
			$(result).insertAfter(".group_menus");
			setSearchGroup(res);
			return;
		}
		$(result).insertAfter(".group_menus");
		groupMenusColor(index);
		//alert(index);
		if(index==1)
			setGroupInfo(res);
		if(index==2&&res=="edit")
		{
			//alert(res);
			setEditGroup();
		}
		if(index==3)
		{
			groups_menu(1,res)
		}
		if(index==4)
			Friends_menu(1);
		if(index==5)
			getAllNotifications();
	});
}
function setGroupInfo(object)
{
	object=JSON.parse(object);
	//console.log(object);
	//console.log(object[0].length);
	bm_status=object[object.length-3];
	if(bm_status=="Y")
	{
				$("#gbookmark").attr("status","Y");
				$("#gbookmark>i:nth-child(1)").attr("class","ion-checkmark-round");
				$("#gbookmark span").html("Bookmarked");
				$("#gbookmark").css("background","#3bd55a");
	}
	for(i=0;i<object.length-3;i++)
	{
		var path="../images/ios7-contact.png";
		if(object[i][2]=="Leader")
		{
			$(".li2_ul>li:nth-child(6)>span:nth-child(2)").html(object[i]['first_name']+" "+object[i]['last_name']);
		}
		if(object[i][0]!="null")
			path="../Uploaded/profile/"+object[i][0];
		//alert(path);	
		html='<li onclick="member_profile('+object[i]['id']+')"><div><img src="'+path+'"></div><div><span>'+object[i]['first_name']+' '+ object[i]['last_name']+'</span><br><span>'+object[i][2]+'</span></div><div>';
			var frnd=null;
			if(object[i]['id']!=object[object.length-1])
			{
				if(object[object.length-2][i]=="Add Friend")
				{
					frnd=object[object.length-2][i];
					html+='<div onclick="member_add_frnd('+object[i]['id']+',\'add_friend\',this)" status="'+frnd+'">'+frnd+'</div></div></li>';
				}
				else{

					if(object[object.length-2][i][0]=="Accept"&&object[object.length-2][i]['sender_id']!=object[object.length-1])
					{
						frnd=object[object.length-2][i][0];
						html+='<div onclick="member_add_frnd('+object[i]['id']+',\'accepted\',this)" status="accept" style="height: 80%;width: 46%;background-color: #03A9F4;font-family: Futura Bk BT;color: #fff;margin: 20px 0px 0px 8px;text-align: center;line-height: 42px;border-radius: 26px;float: left;">'+frnd+'</div><div onclick="member_add_frnd('+object[i]['id']+',\'rejected\',this)" status="reject" style="height: 80%;width: 46%;background-color: #03A9F4;font-family: Futura Bk BT;color: #fff;margin: 20px 0px 0px 8px;text-align: center;line-height: 42px;border-radius: 26px;float: left;">Reject</div></div></li>';
					}
					else if(object[object.length-2][i][0]=="Accept"&&object[object.length-2][i]['sender_id']==object[object.length-1])
					{
						frnd="Friend Request send";
						html+='<div status="cancel">'+frnd+'</div></div></li>';		
					}
					else if(object[object.length-2][i][0]=="Friend Request Send"&&object[object.length-2][i]['sender_id']!=object[object.length-1])
					{
						frnd="Accept";
						html+='<div onclick="member_add_frnd('+object[i]['id']+',\'accepted\',this)" status="accept" style="height: 80%;width: 46%;background-color: #03A9F4;font-family: Futura Bk BT;color: #fff;margin: 20px 0px 0px 8px;text-align: center;line-height: 42px;border-radius: 26px;float: left;">'+frnd+'</div><div onclick="member_add_frnd('+object[i]['id']+',\'rejected\',this)" status="reject" style="height: 80%;width: 46%;background-color: #03A9F4;font-family: Futura Bk BT;color: #fff;margin: 20px 0px 0px 8px;text-align: center;line-height: 42px;border-radius: 26px;float: left;">Reject</div></div></li>';
					}
					else if(object[object.length-2][i][0]=="Friend Request Send"&&object[object.length-2][i]['sender_id']==object[object.length-1])
					{
						frnd=object[object.length-2][i][0];
						html+='<div status="cancel">'+frnd+'</div></div></li>';		
					}
					else if(object[object.length-2][i][0]=="Friends")
					{
						frnd=object[object.length-2][i][0];
						html+='<div status="friends">'+frnd+'</div></div></li>';		
					}
					else if(object[object.length-2][i][0]=="Add Friend")
					{
						frnd=object[object.length-2][i][0];
						html+='<div onclick="member_add_frnd('+object[i]['id']+',\'add_friend\',this)" status="add_friend">'+frnd+'</div></div></li>';	
					}
				}
			}
			else{
				frnd="Profile";
				html+='<div onclick="takeToProfile('+object[i]['id']+')" status="profile" style="background-color:#c0ca33;">'+frnd+'</div></div></li>';
			}
		
		document.getElementsByClassName("group_frnds_list")[0].innerHTML+=html;
		frnd=null;
	}
}
function groupMenusColor(num)
{
	for(i=1;i<=5;i++)
	{
		$(".group_menus>ul>li:nth-child("+i+")").css({"background":"#fff","color":"#000"});
	}
	$(".group_menus>ul>li:nth-child("+num+")").css({"background":"#383737","color":"#fff"});
}


function member_profile(index)
{
	//alert(index);
}
function member_add_frnd(index,status,ele)
{
	var action_status=null;
	if(status=="add_friend")
	{
		action_status="Friend Request Send";
	}
	else if(status=="accepted")
	{
		action_status="Friends";
	}
	else if(status=="rejected")
	{
		action_status="Add Friend";
	}
	else if(status=="canceled")
	{
		action_status="Add Friend";
	}
	//alert(index+" "+status+" "+action_status);
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
			$(ele).html(action_status);
		}
		else if(result=="false")
		{

		}
	});
}
function member_add_frnd2(index,status,ele)
{
	$.post("GroupServer.php",{
		frnds_box:index,
		frnd_stat:status
	},function(result){
		//alert(result);
		if(result=="true")
		{
			if(status=="unfriend")
				Friends_menu(2);
			else
				Friends_menu(1);
		}
		else if(result=="false")
		{

		}
	});
}
function leaveGroup(name)
{
	$.post('GroupServer.php',{
		leave:name
	},function(result){
		//alert(result);
		if(result=="true")
		{
			MyGroup(1);
		}
		else{

		}
	});
}
function editGroup(name)
{
	$.post('GroupServer.php',{
		edit_grp:name
	},function(result){
		//alert(result);
		//console.log(result);
		group_info=JSON.parse(result);
		groupInfo(2,'edit');
	});
}
function setEditGroup()
{
	//console.log(group_info);
	$("#grp_nm").val(group_info['group_name']);
	$("#grp_type").val(group_info['group_type']);
	$("#grp_len").val(group_info['group_length']);
	$("#grp_location").val(group_info['group_location']);
	$("#g_desc").val(group_info['group_description']);
	$(".group_action>input:nth-child(1)").attr("value","Save");
	$(".group_action>input:nth-child(1)").attr("name","grp_upd");
	if(group_info['group_logo'].length>0)
		$(".g_uploading_area>div:nth-child(1)>img").attr("src","../Uploaded/group_logo/"+group_info['group_logo']);
}
function Groups(index)
{
	$.post('GroupServer.php',{
		srch_group:'get'
	},
	function(result){
		//console.log(result);
		if(result=="No Groups Found")
		{
			//alert("No group Found");
			$("#typing_no_result").remove();
		}
		//else
			groupInfo(3,result);
	});
}
function setGroups(result)
{
	if(result!="No Groups Found")
	{
		result=JSON.parse(result);
		//console.log(result);
		var path="../images/ios7-contact.png";
		$("#srched_grps").html("");
		for (var i =0;i<result.length;i++)
		{
			if(result[i]['group_logo'].length>0)
				path="../Uploaded/group_logo/"+result[i]['group_logo'];

			html='<li onclick="groupSearch('+result[i]['creator_id']+')"><div><div><img src="'+path+'"></div></div><div><span>'+result[i]['group_name']+'</span><br><span>'+result[i]['group_type']+'</span></div><div>Click to view details</div><div><span>Members</span><br><span>'+result[i][0]+'/ '+result[i]['group_length']+'</span></div><div><div>Visit</div></div></li>';
				srched_grps.innerHTML+=html;
		}
	}
}
function groups_menu(index,object)
{
	//alert(index);
	$.post('ProfileServer.php',{
		grps_index:index
	},
	function(result){
		//console.log(result);
		$(".groups_list").html(result);
		if(index==1)
		{
			$("#srch_book>div:nth-child(1)").css({"background":"#fff","color":"#000"});
			$("#srch_book>div:nth-child(2)").css({"background":"#f85530","color":"#fff"});
		}
		else{
			$("#srch_book>div:nth-child(2)").css({"background":"#fff","color":"#000"});	
			$("#srch_book>div:nth-child(1)").css({"background":"#f85530","color":"#fff"});
		}
		
			if(index==1)
			{
				setGroups(object);
			}
			else if(index==2){
				setBookmarkPage();
			}
		
		
	});
}
function  groupSearch(index) 
{
	$.post('GroupServer.php',{
		visit_srch:index
	},
	function(result){
		//console.log(result);
		groupInfo("groups",result);
	});
}
function setSearchGroup(object)
{	
	result=JSON.parse(object);
	//console.log(result);
	setSearchedGroupInfo(result[0],result[1].length,result[3],result[4]);
	setSearchGroupMembers(result[1],result[2],result[0],result[5]);
}
var grp="";
function setSearchedGroupInfo(result,len,bm_status,js)
{
	$.post("GroupServer.php",{
		same_g:'check',
		grp_nm:result['group_identification']
	},
	function(result1){
		if(js=="1")
		{
			if(result1=="1")
				$("#grp_action").html('<li id="leave_group" onclick="leaveGroup(\''+result['group_identification']+'\')">Leave</li>');
			else{
					$("#grp_action").html('<li id="leave_group" onclick="CannotJoinGroup()" style="background-color:#6a6766;">Join</li>');
				}
		}
		else if(js=="0")
		{
			$("#grp_action").html('<li id="leave_group" onclick="JoinSearchedGroup(\''+result['group_identification']+'\')">Join</li>');
		}
	});
	//console.log(result);
	if(bm_status=="Y")
	{
				$("#gbookmark").attr("status","Y");
				$("#gbookmark>i:nth-child(1)").attr("class","ion-checkmark-round");
				$("#gbookmark span").html("Bookmarked");
				$("#gbookmark").css("background","#3bd55a");
	}
	else if(bm_status=="N")
	{
				$("#gbookmark").attr("status","N");
				$("#gbookmark>i:nth-child(1)").attr("class","ion-plus-round");
				$("#gbookmark span").html("Bookmark");
				$("#gbookmark").css("background","#3ecccc");
	}

	$("#gbookmark").attr("group_name",result['group_identification']);
	$(".li2_ul>li:nth-child(1)>span").html(result['group_name']);
	$(".li2_ul>li:nth-child(2)>span:nth-child(2)").html(result['group_type']);
	$(".li2_ul>li:nth-child(3)>span:nth-child(2)").html(result['group_length']);
	$(".li2_ul>li:nth-child(4)>span:nth-child(2)").html(len);
	$(".li2_ul>li:nth-child(5)>span:nth-child(2)").html(result['group_location']);
	$(".li_3>div:nth-child(1)").html(result['group_description']);
	
	$("#gbookmark").attr("onclick","Bookmark('"+result['group_identification']+"')");
	path="../images/ios7-contact.png";
	if(result['group_logo'].length>0)
	{
		path="../Uploaded/group_logo/"+result['group_logo'];
	}
	$(".li_1>div:nth-child(1)>img").attr("src",path);

}
function setSearchGroupMembers(result1,result2,result3,result4)
{
	//console.log(result1);
	//console.log(result2);
	//console.log(result3);
	//console.log(result4);
	$.post("GroupServer.php",{
		index:'get'
	},
	function(res){
		//alert(res);
	for(i=0;i<result1.length;i++)
	{
		var path="../images/ios7-contact.png";
		if(result1[i]['mem_pos']=="Leader")
		{
			$(".li2_ul>li:nth-child(6)>span:nth-child(2)").html(result2[i]['first_name']+" "+result2[i]['last_name']);
		}
		if(result2[i]['gender']=="male")
		{
			if(result2[i][0]!="null")
				path="../Uploaded/profile/"+result2[i][0];
			else
				path="../images/ios7-contact.png";
		}
		else{
			if(result2[i][0]!="null")
				path="../Uploaded/profile/"+result2[i][0];
			else
				path="../images/female.png";
		}
			
		/*----------------------------------------------*/
		//alert(path);
		html='<li><div><img src="'+path+'"></div><div><span>'+result2[i]['first_name']+' '+ result2[i]['last_name']+'</span><br><span>'+result1[i]['mem_pos']+'</span></div><div>';
			var frnd=null;
			if(result1[i]['mem_id']!=res)
			{
				if(result4[i]=="Add Friend")
				{
					frnd=result4[i];
					html+='<div onclick="member_add_frnd('+result2[i]['id']+',\'add_friend\',this)" status="'+frnd+'">'+frnd+'</div></div></li>';
				}
				else{

					if(result4[i][0]=="Accept"&&result4[i]['sender_id']!=res)
					{
						frnd=result4[i][0];
						html+='<div onclick="member_add_frnd('+result2[i]['id']+',\'accepted\',this)" status="accept" style="height: 80%;width: 46%;background-color: #03A9F4;font-family: Futura Bk BT;color: #fff;margin: 20px 0px 0px 8px;text-align: center;line-height: 42px;border-radius: 26px;float: left;">'+frnd+'</div><div onclick="member_add_frnd('+result2[i]['id']+',\'rejected\',this)" status="reject" style="height: 80%;width: 46%;background-color: #03A9F4;font-family: Futura Bk BT;color: #fff;margin: 20px 0px 0px 8px;text-align: center;line-height: 42px;border-radius: 26px;float: left;">Reject</div></div></li>';
					}
					else if(result4[i][0]=="Accept"&&result4[i]['sender_id']==res)
					{
						frnd="Friend Request send";
						html+='<div status="cancel">'+frnd+'</div></div></li>';		
					}
					else if(result4[i][0]=="Friend Request Send"&&result4[i]['sender_id']==res)
					{
						frnd=result4[i][0];
					html+='<div status="cancel">'+frnd+'</div></div></li>';		
					}
					else if(result4[i][0]=="Friend Request Send"&&result4[i]['sender_id']!=res)
					{
						frnd="Accept";
						html+='<div onclick="member_add_frnd('+result2[i]['id']+',\'accepted\',this)" status="accept" style="height: 80%;width: 46%;background-color: #03A9F4;font-family: Futura Bk BT;color: #fff;margin: 20px 0px 0px 8px;text-align: center;line-height: 42px;border-radius: 26px;float: left;">'+frnd+'</div><div onclick="member_add_frnd('+result2[i]['id']+',\'rejected\',this)" status="reject" style="height: 80%;width: 46%;background-color: #03A9F4;font-family: Futura Bk BT;color: #fff;margin: 20px 0px 0px 8px;text-align: center;line-height: 42px;border-radius: 26px;float: left;">Reject</div></div></li>';		
					}
					else if(result4[i][0]=="Friends")
					{
						frnd=result4[i][0];
					html+='<div status="friends">'+frnd+'</div></div></li>';		
					}
					else if(result4[i][0]=="Add Friend")
					{
						frnd=result4[i][0];
						html+='<div onclick="member_add_frnd('+result2[i]['id']+',\'add_friend\',this)" status="add_friend">'+frnd+'</div></div></li>';		
					}
				}
			}
			else{
				frnd="Profile";
				html+='<div onclick="takeToProfile('+result2[i]['id']+')" status="profile" style="background-color:#c0ca33;">'+frnd+'</div></div></li>';
			}
		/*----------------------------------------------*/
		document.getElementsByClassName("group_frnds_list")[0].innerHTML+=html;
	}

	});

}
function JoinSearchedGroup(index)
{	//alert(index);
	$.post("GroupServer.php",{
		join_grp:index
	},function(result){
		//console.log(result);
		if(result=="true")
		{
			MyGroup(1);
		}
		else{}
	});
}
function Bookmark(ele)
{

	status=$("#gbookmark").attr("status");
	grp_nm=$("#gbookmark").attr("group_name");
	
		$.post("GroupServer.php",{
			bookmark:grp_nm,
			status:status
		},
		function(result){
		//	console.log(result);
			if(result=="true")
			{
						$("#gbookmark").attr("status","Y");
						$("#gbookmark>i:nth-child(1)").attr("class","ion-checkmark-round");
						$("#gbookmark span").html("Bookmarked");
						$("#gbookmark").css("background","#3bd55a");
			}
			else if(result=="false")
			{
						$("#gbookmark").attr("status","N");
						$("#gbookmark>i:nth-child(1)").attr("class","ion-plus-round");
						$("#gbookmark span").html("Bookmark");
						$("#gbookmark").css("background","#3ecccc");
			}
			if(result=="true1"){
				$("#gbookmark").attr("status","N");
				$("#gbookmark>i:nth-child(1)").attr("class","ion-plus-round");
				$("#gbookmark span").html("Bookmark");
				$("#gbookmark").css("background","#3ecccc");
			}
		});
}
function setBookmarkPage()
{
	$.post("GroupServer.php",{
		marked:'get'
	},
	function(result){
		if(result!="No Bookmark")
		{
			result=JSON.parse(result);
			console.log(result);
			setBookmarkQuickView(result);
		}	
	});
}
function setBookmarkQuickView(result)
{
	//console.log(result);
	var path="../images/ios7-contact.png";
	for (var i =0;i<result[1].length;i++)
	{
		if(result[1][i]['group_logo'].length>0)
			path="../Uploaded/group_logo/"+result[1][i]['group_logo'];

		html='<li onclick="groupSearch('+result[1][i]['creator_id']+')"><div><div><img src="'+path+'"></div></div><div><span>'+result[1][i]['group_name']+'</span><br><span>'+result[1][i]['group_type']+'</span></div><div>Click to view details</div><div><span>Members</span><br><span>'+'1'+'/ '+result[1][i]['group_length']+'</span></div><div><div>Visit</div></div></li>';
			bookmark_page.innerHTML+=html;
	}
}
function CannotJoinGroup()
{
		$("#join_error").css("display","none");
	html='<span id=join_error style="position: relative;left: 69%;top: 21px;font-family: Futura Bk BT;color: #2196F3;font-weight: 500;font-size: 16px;">You have already joined a group</span>';
	$(".li_4>div:nth-child(1)").prepend(html);
	setTimeout(hideErr,1000);
}
function hideErr()
{
	$("#join_error").css("display","none");
}

function FriendsRequest(index)
{//alert();
		groupInfo(4);
}
function Friends_menu(index)
{
	$.post('ProfileServer.php',{
		frnds_index:index
	},
	function(result){
		//alert(result);
		$(".groups_list").html(result);
		if(index==1)
		{
			$("#srch_book>div:nth-child(1)").css({"background":"#fff","color":"#000","box-shadow":"rgb(52, 51, 51) 3px 0px 5px 1px"});
			$("#srch_book>div:nth-child(2)").css({"background":"#f85530","color":"#fff","box-shadow":"none"});
		}
		else{
			$("#srch_book>div:nth-child(2)").css({"background":"#fff","color":"#000","box-shadow":"rgb(52, 51, 51) 3px 0px 5px 1px"});	
			$("#srch_book>div:nth-child(1)").css({"background":"#f85530","color":"#fff","box-shadow":"none"});
		}
		getFriendRequest(index);
	});
}
function getFriendRequest(index)
{
	$.post('GroupServer.php',{
		frnds_req:'get'
	},
	function(result){
		if(result=="No group")
		{

		}
		else if(result=="friend req")
		{

		}
		else{
			if(index==1)
			{
				setFriendRequest(result);
			}
			else if(index==2)
			{
				getFriends(result);
			}
		}
	});	
}
function setFriendRequest(object)
{

	$("#typing_no_result").remove();
	var flag=0;
	result=JSON.parse(object);
//	console.log(result);
	for(var i=0;i<result.length;i++)
	{
		var path="../images/ios7-contact.png";
		var group_name="";
		var frnd_status="";
		if(result[i][0]['req_status']=="-1"||result[i][0]['req_status']=="0")
		{
			if(result[i][2][13]!="null")
				path="../Uploaded/profile/"+result[i][2][13];

			html='<li><div><div><img src="'+path+'"></div></div><div><span>'+result[i][2][1]+" "+result[i][2][2]+'</span><br><span>';
			if(result[i][1]!="null")
			{
				group_name=result[i][1]['group_name'];
			}

			html+=group_name+'</span></div><div id="frnds_pannel">';
			if(result[i][1]!="null")
			{
				html+='<div onclick="groupSearch('+result[i][1]['creator_id']+')">View Clan</div>';
			}
			html+='<div>Profile</div></div>';

			if(result[i][0]['req_status']=="0")
			{
				frnd_status='<div style="display:flex;" class="frnd_req_list"><div class="ion-checkmark-round" style="height: 42%;width:26%;border-radius:35px;background:#25c72b;color: #fff;padding:8px 0px 0px 1px;" onclick="member_add_frnd2('+result[i][0][0]+',\'accepted\',this)"></div><div class="ion-close-round" style="height: 41%;width:25%;text-align:center;margin-left:10px;border-radius: 35px;background:#ef3c3c;color: #fff;padding:10px 0px 0px 2px;" onclick="member_add_frnd2('+result[i][0][0]+',\'rejected\',this)"></div></div>';
				html+='<div><span style="font-size: 13px;line-height: 48px;">Received request</span></div>'+frnd_status+'</li>';
			}
			else if(result[i][0]['req_status']=="-1"&&result[i][0]['sender_id']==result[result.length-1])
			{
				frnd_status='<div style="display:flex;" class="frnd_req_list"><div class="ion-close-round" style="height: 41%;width:25%;text-align:center;margin-left:58%;border-radius: 35px;background:#ef3c3c;color: #fff;padding:10px 0px 0px 2px;" onclick="member_add_frnd2('+result[i][0][0]+',\'canceled\',this)"></div></div>';
				
				html+='<div><span style="font-size: 13px;line-height: 48px;">Friend request send</span></div>'+frnd_status+'</li>';
			}
			else if(result[i][0]['req_status']=="-1"&&result[i][0]['sender_id']!=result[result.length-1])
			{
				frnd_status='<div style="display:flex;" class="frnd_req_list"><div class="ion-checkmark-round" style="height: 42%;width:26%;border-radius:35px;background:#25c72b;color: #fff;padding:8px 0px 0px 1px;" onclick="member_add_frnd2('+result[i][0][0]+',\'accepted\',this)"></div><div class="ion-close-round" style="height: 41%;width:25%;text-align:center;margin-left:10px;border-radius: 35px;background:#ef3c3c;color: #fff;padding:10px 0px 0px 2px;" onclick="member_add_frnd2('+result[i][0][0]+',\'rejected\',this)"></div></div>';
				html+='<div><span style="font-size: 13px;line-height: 48px;">Received request</span></div>'+frnd_status+'</li>';	
			}
			document.getElementById("frnd_req_pannel").innerHTML+=html;
			flag=1;
		}
	}
	if(flag==0)
	{
		$("ul#frnd_req_pannel").remove();
			html='<div id="typing_no_result"><i class="ion-android-sad" ></i><span>No Friend Request</span></div>';
			$(html).insertAfter(".groups_list");
	}
}
function getFriends(object)
{
	$("#typing_no_result").remove();
	var flag=0;
	var html=null;
	result=JSON.parse(object);
	//console.log(result);
	for(var i=0;i<result.length-1;i++)
	{
		var path="../images/ios7-contact.png";
		var group_name="";
		var frnd_status="";
		
		if(result[i][0]['req_status']=="1")
		{
			flag=1;
			if(result[i][2][13]!="null")
				path="../Uploaded/profile/"+result[i][2][13];

			html='<li><div><div><img src="'+path+'"></div></div><div><span>'+result[i][2][1]+" "+result[i][2][2]+'</span><br><span>';
			if(result[i][1]!="null")
			{
				group_name=result[i][1]['group_name'];
			}

			html+=group_name+'</span></div><div id="frnds_pannel">';
			if(result[i][1]!="null")
			{
				html+='<div onclick="groupSearch('+result[i][1]['creator_id']+')">View Clan</div>';
			}
			html+='<div>Profile</div></div>';

			frnd_status='<div style="display:flex;" class="frnd_req_list"><div onclick="member_add_frnd2('+result[i][0][0]+',\'unfriend\',this)">Unfriend</div></div>';
				html+='<div></div>'+frnd_status+'</li>';
			document.getElementById("accpt_frnds_pannel").innerHTML+=html;
		}
	}
	if(flag==0)
	{
		$("ul#accpt_frnds_pannel").remove();
			html='<div id="typing_no_result"><i class="ion-android-sad" ></i><span>No Friends</span></div>';
			//$("#srched_grps").css("display","none");
			$(html).insertAfter(".groups_list");
	}
}
function getTypingGroup(t)
{
	$.post("GroupServer.php",{
		srch_text:t.value
	},function(result){
		if(result=="false")
		{
			$("#typing_no_result").remove();
			html='<div id="typing_no_result"><i class="ion-alert-circled" ></i><span>No group found</span></div>';
			$("#srched_grps").css("display","none");
			$(html).insertAfter(".grps_search");
		}
		else if(result!="No Groups Found")
		{
			$("#typing_no_result").remove();
			$("#srched_grps").css("display","block");
			//result=JSON.parse(result);
			//console.log(result);
			setGroups(result);
		}
		else
			alert("search by typing no group found");
	});
}
function sendGroupMess()
{
	$(".Group_message_pannel").css("display","block");
}
function SendGroupMate()
{
	var val=($(".gtext").val()).trim();
	if(val.length==0)
	{
		//$(".Group_message_pannel").css("display","none");
	}
	else{
			$.post("GroupServer.php",{
				group_message:val	
			},function(result){
				if(result=="true")
				{
					$(".Group_message_pannel").css("display","none");
					var num=$("#noti_number").html();
					num=parseInt(num)+1;
					$("#noti_number").css("opacity","1");
					$("#noti_number").html(num);
				}	
				else{

				}
			});
	}
}
function getAllNotifications()
{
	$.post("GroupServer.php",{
		notifi:'get'
	},function(result){

		if(result!="No notification")
		{
			result=JSON.parse(result);
			//console.log(result);
			for(i=0;i<result.length;i++)
			{
				var path="../images/ios7-contact-png";
				if(result[i][2][0]!="null")
					path="../Uploaded/profile/"+result[i][2][0];

				html='<li><div><div onclick="takeToProfile(\''+result[i][2]['id']+'\')"><img src="'+path+'"></div></div><div><span onclick="takeToProfile(\''+result[i][2]['id']+'\')">'+result[i][2]['first_name']+" "+result[i][2]['last_name']+'</span><br><span onclick="groupSearch('+result[i][1]['creator_id']+')">'+result[i][1]['group_name']+'</span></div><div><span>';
				html+=result[i][0]['note_date']+'</span></div><div><div>'+result[i][0]['group_message']+'</div></div></li>';
				document.getElementsByClassName("noti_list")[0].innerHTML+=html;
			}
		}	
		else{
			$("#typing_no_result").remove();
			html='<div id="typing_no_result"><i class="ion-alert-circled" ></i><span>No Notification</span></div>';
			$("#noti_list").css("display","none");
			$("#notification_pannel>div:nth-child(1)").html(html);
		}

	});
}
