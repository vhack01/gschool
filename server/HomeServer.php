<?php
		include("SignupServer.php");
		class HomeServer extends SignupDetails
		{
			public $set=array();
			public function __constructor()
			{
				if(!isset($_SESSION))
					session_start();
				$_SESSION['global_det']=null;
				//print_r($sd->link);
				$_SESSION['glob_message']=array();
			}
			public function getGlobalRecentMessages()
			{
				//echo $_SESSION['global_maxid'];
				$this->exec=$this->compile("select * from global_msg where msg_id>".$_SESSION['global_maxid']." limit 1");
				$num=mysqli_num_rows($this->exec);
				//print_r($num);
				if($num)
				{
					$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					$_SESSION['global_det']['msg']=$res['message'];
					$name=$this->getGlobalName($res['sender_id']);
					if($name=="null")
					{}
					else{
						$_SESSION['global_det']['name']=$name['first_name']." ".$name['last_name'];
						$_SESSION['global_det']['gender']=$name['gender'];
						$_SESSION['global_det']['id']=$name['id'];
					}
					$pic=$this->getGlobalPhotos($res['sender_id']);
					$_SESSION['global_det']['img']=$pic;
					$_SESSION['global_maxid']=$res['msg_id'];
					
					if(isset($_SESSION['glob_message']))
						$_SESSION['glob_message'].=$this->setGlobalChats();
					else
						$_SESSION['glob_message']=$this->setGlobalChats();
					//echo $_SESSION['global_det']['img'];
					echo json_encode($_SESSION['global_det']);
				}
				else{
					echo "No data";
				}
			}
			public function setGlobalChats()
			{
					if($_SESSION['global_det']['img']=="null")
		        	{
		        		if($_SESSION['global_det']['gender']=="male")
		        			$_SESSION['global_det']['img']='ios7-contact.png';
		        		else
		        			$_SESSION['global_det']['img']='female.png';

			        		$chat='<li class="users_list" onclick="g_tooltip(this)"><div><img src="../images/'.$_SESSION['global_det']['img'].'"></div><div class="user_content"><div><span style="text-transform:capitalize">'.$_SESSION['global_det']['name'].'</span><br><span class="group_nm">Bug Boat</span></div><div>'.$_SESSION['global_det']['msg'].'</div></div></li>';
			        		return $chat;
		        	}
		        	$chat='<li class="users_list" onclick="g_tooltip()"><div><img src="../Uploaded/profile/'.$_SESSION['global_det']['img'].'"></div><div class="user_content"><div><span style="text-transform:capitalize">'.$_SESSION['global_det']['name'].'</span><br><span class="group_nm">Bug Boat</span></div><div>'.$_SESSION['global_det']['msg'].'</div></div></li>';
			        	return $chat;
			}
			public function getGlobalPhotos($id)
			{
				$this->exec=$this->compile("select * from g_photos where uploader_id='".$id."' ");
				$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
				$num=mysqli_num_rows($this->exec);
				//print_r($num);
				if($num==0)
				{
					return "null";		
				}
				else{
					return $res['pic_path'];
				}
			}
			public function getGlobalName($id)
			{
				$this->exec=$this->compile("select * from g_signup where id='".$id."' ");
				$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
				return $res;
			}
			public function insertGlobalChat($msg)
			{
				$res=$this->compile("insert into global_msg(sender_id,message,date_stamp) values('".$_SESSION['users']['uid']."','".$msg."',now())");
				echo $res;
			}
			public function insertGroupChat($msg)
			{
				//echo $_SESSION['jgroup_id'];
				$this->exec=$this->compile("insert into group_msg_".$_SESSION['jgroup_id']."(sender_id,message,join_date) values('".$_SESSION['users']['uid']."','".$msg."',now())");
				if($this->exec)
					echo "true";
				else
					echo "false";
			}
			public function getGroupRecentMessages()
			{
				$signup=array();
				$ray=array();
				//echo $_SESSION['global_maxid'];
				//echo $_SESSION["groupchat_max_id"]." === ";
				$this->exec=$this->compile("select * from group_msg_".$_SESSION['jgroup_id']." where sr_no>".$_SESSION['groupchat_max_id']." limit 1");
				$num=mysqli_num_rows($this->exec);
				//print_r($num);
				if($num>0)
				{	
					$maxm=$this->compile("select * from group_msg_".$_SESSION['jgroup_id']." ");
					$numM=mysqli_num_rows($maxm);
					$_SESSION['groupchat_max_id']=$numM;
					$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);

							$sexe=$this->compile("select * from g_signup where id='".$res['sender_id']."' ");

							$signup=mysqli_fetch_array($sexe,MYSQLI_ASSOC);
								/*---- Profile Photos-----*/
								$exe6=$this->compile("select * from g_photos where uploader_id='".$res['sender_id']."' ");
								$num5=mysqli_num_rows($exe6);
								if($num5==1)
								{
									$row6=mysqli_fetch_array($exe6,MYSQLI_ASSOC);
									array_push($signup,$row6['pic_path']);
								}
								else{
									array_push($signup,"null");
								}
							$gexe=$this->compile("select * from group_".$_SESSION['jgroup_id']." where mem_id='".$res['sender_id']."' and mem_status='Y' ");			
							$grow=mysqli_fetch_array($gexe,MYSQLI_ASSOC);
							//print_r($grow);
							array_push($signup,$grow['mem_pos']);

						array_push($ray,$signup);
						array_push($ray,$res);
						echo json_encode($ray);
				}
				else{
					echo "No recent group message";
				}
			}
			public function getAllGroupChats()
			{

			}
		}
		$home=new HomeServer;
		if(isset($_POST['msg']))
		{
			$home->getGlobalRecentMessages();
		}
		if(isset($_POST['grpmsg']))
		{
			$home->getGroupRecentMessages();
		}
		if(isset($_POST['chat']))
		{
			$home->insertGlobalChat($_POST['chat']);
		}
		if(isset($_POST['grpchat']))
		{
			$home->insertGroupChat($_POST['grpchat']);
		}
		if(isset($_POST['session']))
		{
			if(!isset($_SESSION))
				session_start();
			//session_unset($_SESSION['glob_message']);
			//$home->insertGlobalChat($_POST['chat']);
			if(isset($_SESSION['glob_message']))
			{
				print_r($_SESSION['glob_message']);
			}
		}
		if(isset($_POST['emoji']))
		{
			echo "<img src='../icons/emoji/icon/1.png'>";
		}
		if(isset($_POST['chats_index']))
		{
			if($_POST['chats_index']==1)
				include("GlobalChats.php");
			else if($_POST['chats_index']==2)
			{
				include("GroupChats.php");
			}
			else if($_POST['chats_index']==3)
				include("GroupJoinPage.php");
		}
		if(isset($_POST['grpchat_typer']))
		{
			include("GroupchatTyper.php");
		}
		if(isset($_POST['glbchat_typer']))
		{
			include("GlobalchatTyper.php");
		}
		if(isset($_POST['grp_allmsg']))
		{
			$home->getAllGroupChats();
		}

?>