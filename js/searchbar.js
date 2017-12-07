$(document).ready(function(){

	$("#head_search_pannel_close").click(function(){
		$(".head_srch_result").css("display","none");
	});


	$.post("GroupServer.php",{
		Uimg:'get'
	},function(result){
		//alert(result);
		$("#hpro_pic>img").attr("src",result);
	});
	$("#srched_loader").css("display","none");
	$(".header_srch_box>input[type='text']").on('focus',function(){

	});
	$(".header_profile_div").on({
		mouseenter:function(){
			$(".profile_sub_menu").css("display","block");
		},
		mouseleave:function(){
			$(".profile_sub_menu").css("display","none");
		}
	});
	$(".header_srch_box>input[type='text']").on('keyup',function(){
		var val=($(".header_srch_box>input[type='text']").val()).trim();	
		//console.log(val);
		if(val.length==0)
		{

		}
		else{
				$.post("GroupServer.php",{
					srched_txt:val,
					beforeSend:loadStart,
		  			complete:loadStop
				},function(result){
					document.getElementsByClassName("search_bar_res")[0].innerHTML="";

					if(result=="No result found")
					{
						$("#srched_loader").css("display","block");
						$(".head_srch_result").css("height","13%");
						$("#srched_loader").css("height","100%");
						$("#srched_loader").html("<span style='font-size:20px;font-family: Candara;font-weight: bold;margin: 0px 0px 0px 28%;line-height: 68px;'>No result found</span>");
					}
					else if(result=="No Group Found")
					{
						$("#srched_loader").css("display","block");
						$(".head_srch_result").css("height","13%");
						$("#srched_loader").css("height","100%");
						$("#srched_loader").html("<span style='font-size:20px;font-family: Candara;font-weight: bold;margin: 0px 0px 0px 28%;line-height: 68px;'>No result found</span>");
					}
					else{
						$("#srched_loader").css("display","none");
						$(".head_srch_result").css("height","66%");

						$(".head_srch_result").css("display","block");
						result=JSON.parse(result);
						//console.log(result);
						for(i=0;i<result.length;i++)
						{
							path="";
							if(result[i][1]['gender']=="male")
							{
								if(result[i][1][0]!="null")
								{
									path="../Uploaded/profile/"+result[i][1][0];
								}
								else{
									path="../images/ios7-contact.png";
								}
							}
							else{
								if(result[i][1][0]!="null")
								{
									path="../Uploaded/profile/"+result[i][1][0];
								}
								else{
									path="../images/female.png";
								}	
							}
							html='<li onclick="redirectToProfile(\''+result[i][1]['id']+'\')"><div><div><img src="'+path+'"></div></div><div><span>'+result[i][1]['first_name']+" "+result[i][1]['last_name']+'</span><br>';
							if(result[i][0]!="null")
								html+='<span>'+result[i][0]['group_name']+'</span></div></li>';
							else
								html+='<span> </span></div></li>';

							document.getElementsByClassName("search_bar_res")[0].innerHTML+=html;
						}
					}
				});
		}

	});
	function loadStart()
	{
		$("#srched_loader").css("display","block");
	}
	function loadStop()
	{
		$("#srched_loader").css("display","none");
	}
	$("#h_add_Frnd").on({
		mouseenter:function(){
			$(".header_mbox").show();	
			//setAllAddFriend();	
		},
		mouseleave:function(){
			$(".header_mbox").show();
		}
	});

	$("a.sm_addfrnd").click(function(e){
		e.preventDefault();
		alert();
	});

	$("#logout_btn").click(function(e){
		e.preventDefault();
		$.post("GroupServer.php",{	
			logout:'set'
		},function(result){
			if(result=="logout")
			{
				window.location.href="../index.php";
			}
		});	
	});
	
});
function redirectToProfile(id)
{
	document.location.href="profile.php?id="+id;
}