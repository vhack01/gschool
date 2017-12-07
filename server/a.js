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