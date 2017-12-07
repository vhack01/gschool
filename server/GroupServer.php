<?php
		include("SignupServer.php");
		
		class GroupServer extends SignupDetails
		{
			public $groupVisiter=array();
			public $userjstatus;
			public $row;
			public $group=array();
			public function __constructor()
			{
				if(!isset($_SESSION))
					session_start();
				$_SESSION['group_visiter']=array();// group
				$_SESSION['group_det']=array(); //group_1...
				$_SESSION['member_det']=array(); //g_signup
			}
			public function checkUserGroupStatus()
			{
				$this->getGroupInfo(1);
				//echo $this->userjstatus;
			}
			public function getGroupInfo($st)
			{
				$res=$this->checkTableExist("groups");
				if($res=="true")
				{
					$this->exec=$this->compile("select * from groups");
					while($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
					{
						array_push($this->groupVisiter,$row['group_identification']);
					}
					//print_r($this->groupVisiter);
					$this->myGroupExist($st);				
				}
				else{
					if($st==1)
						echo "0";
					else
						echo "No Groups Found";
				}
			}
			public function myGroupExist($st)
			{
				$flag=0;
				for($i=0;$i<count($this->groupVisiter);$i++)
				{
					$this->exec=$this->compile("select * from ".$this->groupVisiter[$i]);
					while($res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
					{
						if($res['mem_id']==$_SESSION['users']['uid']&&$res['mem_status']=='Y')
						{
							$flag=1;
							$_SESSION['group_visiter']['grp_name']=$this->groupVisiter[$i];
							break;
						}
					}
					//$flag=0;
				}

				if($st==1)
				{
					if($flag==0)
					{
						//echo "0";
						$this->userjstatus="0";
					}
					else if($flag==1)
					{
						//echo "1";
						$this->userjstatus="1";
					}
				}
				else if($st==0)
				{
					if($flag==0)
					{
						echo "Not joined";
					}
					else if($flag==1)
					{
						$this->getJoinedDetails();
					}
				}
			}
			public function getJoinedDetails()
			{
				$this->exec=$this->compile("select * from groups where group_identification='".$_SESSION['group_visiter']['grp_name']."' ");
				$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
				$_SESSION['group_det']=$res;
				$this->exec=$this->compile("select * from ".$_SESSION['group_visiter']['grp_name']." ");

				$num=mysqli_num_rows($this->exec);
				$_SESSION['member_det']=null;
				$i=0;
				while($result=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
				{
					if(trim($result['mem_status'])=='Y')
					{
						$_SESSION['member_det'][$i++]=$result;
					}
				}
				$bm_status=$this->getBookmarkStatus($_SESSION['group_visiter']['grp_name']);
				//print_r($result);
				//print_r($_SESSION['group_det']);
				//print_r($_SESSION['member_det']);
				$this->getMembersDetail($_SESSION['member_det'],$bm_status);
			}
			public function getBookmarkStatus($grp_nm)
			{
				$bm_status=null;
				$this->exec=$this->compile("select * from bookmarks where marker_id='".$_SESSION['users']['uid']."' and group_id='".$grp_nm."' ");
				$num=mysqli_num_rows($this->exec);
				if($num==0){
					$bm_status="N";
				}
				elseif ($num==1) {
					$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					if($res['mark_status']=='N')
						$bm_status="N";
					else if($res['mark_status']=="Y")
						$bm_status="Y";
				}
				return $bm_status;
			}
			public function getMembersDetail($member_det,$bm_status)
			{
				//print_r($member_det);
				$det=array(array());
				$path=null;
				for($j=0;$j<count($member_det);$j++)
				{
					$this->exec=$this->compile("select * from g_signup where id=".$member_det[$j]['mem_id']." ");
					$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					$det[$j]=$res;
					$exec2=$this->compile("select * from g_photos where pid=".$member_det[$j]['mem_id']." ");
					$num=mysqli_num_rows($exec2);
					if($num==1)
					{
						$res2=mysqli_fetch_array($exec2,MYSQLI_ASSOC);
						$path=$res2['pic_path'];
						array_push($det[$j],$path);
					}
					else{
						array_push($det[$j],"null");	
					}
					array_push($det[$j],$_SESSION['group_det']['group_name']);
					array_push($det[$j],$member_det[$j]['mem_pos']);
					$path=null;
				}
				array_push($det,$bm_status);	
				$relation=array();
				$relation=$this->getRelationshipStatus($_SESSION['member_det']);
				array_push($det,$relation);
				array_push($det,$_SESSION['users']['uid']);
				//print_r($det);
				echo json_encode($det);
			}
			public function leaveGroup($name)
			{
				$this->exec=$this->compile("update ".$name." set mem_status='N' where mem_id='".$_SESSION['users']['uid']."' ");
				if($this->exec)
				{
					echo "true";
				}
				else{
					echo "false";
				}
			}
			public function editGroup()
			{
				$this->exec=$this->compile("select * from groups where group_identification='".$_SESSION['group_visiter']['grp_name']."' ");
				$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
				//print_r($res);
				echo json_encode($res);
			}
			public function searchedGroups()
			{

				$table=$this->checkTableExist("groups");
				if($table=="true")
				{
					$groups=array();
					$this->exec=$this->compile("select * from groups");
					while($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
					{
						$res=$this->compile("select * from ".$row['group_identification']." where mem_status='Y' ");
						$num=mysqli_num_rows($res);
						array_push($row,$num);
						array_push($groups,$row);

					}
					echo json_encode($groups);	
				}
				else{
					echo "No Groups Found";
				}
			}
			public function visitSearchedGroup($index)
			{	
				$ray=array();
				$member_id=array();
				$member_details=array();
				$gmember_details=array();
				$this->exec=$this->compile("select * from groups where creator_id='".$index."' ");	
				$res1=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
				array_push($ray, $res1);
				$this->exec=$this->compile("select * from ".$res1['group_identification']." where mem_status='Y' ");	
				
				while($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
				{
					array_push($gmember_details,$row);
					array_push($member_id,$row['mem_id']);
				}
				$member_details=$this->getSearchedMembersDetail($member_id);
				$bm_status=$this->getBookmarkStatus($res1['group_identification']);
				array_push($ray, $gmember_details);
				array_push($ray, $member_details);
				array_push($ray, $bm_status);
				$this->checkUserGroupStatus();
				array_push($ray,$this->userjstatus);
				$relation=array();
				$relation=$this->getRelationshipStatus($gmember_details);
				array_push($ray,$relation);
				echo json_encode($ray);
			}
			public function getRelationshipStatus($gmember_details)
			{
				
				$relation=array();
				$req_status=null;
				for($i=0;$i<count($gmember_details);$i++)
				{
					$this->exec=$this->compile("select * from g_relationship where ((sender_id='".$_SESSION['users']['uid']."' and receiver_id='".$gmember_details[$i]['mem_id']."') or (sender_id='".$gmember_details[$i]['mem_id']."' and receiver_id='".$_SESSION['users']['uid']."'))");
					$num=mysqli_num_rows($this->exec);
					if($num==1)
					{
						$row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
						if($row['req_status']=="-1")
							$req_status="Friend Request Send";
						else if($row['req_status']=="0")
							$req_status="Accept";
						else if($row['req_status']=="1")
							$req_status="Friends";
						else if($row['req_status']=="2")
							$req_status="Add Friend";
						array_push($row,$req_status);
						array_push($relation,$row);
					}
					else{
							$req_status="Add Friend";
							array_push($relation,$req_status);
					}
				}
				return $relation;
			}
			public function getSearchedMembersDetail($member_det)
			{
				//print_r($member_det);
				$det=array(array());
				$path=null;
				for($j=0;$j<count($member_det);$j++)
				{
					$this->exec=$this->compile("select * from g_signup where id=".$member_det[$j]." ");
					$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					$det[$j]=$res;
					$exec2=$this->compile("select * from g_photos where pid=".$member_det[$j]." ");
					$num=mysqli_num_rows($exec2);
					if($num==1)
					{
						$res2=mysqli_fetch_array($exec2,MYSQLI_ASSOC);
						$path=$res2['pic_path'];
						array_push($det[$j],$path);
					}
					else{
						array_push($det[$j],"null");	
					}
					$path=null;
				}			
				return $det;
			}
			public function bookmarkGroup($gid)
			{
				$this->exec=$this->compile("select * from bookmarks where (marker_id='".$_SESSION['users']['uid']."' and group_id='".$gid."') and mark_status='N' ");
				$num=mysqli_num_rows($this->exec);
				if($num==1)
				{
					$this->compile("update bookmarks set mark_status='Y' where (marker_id='".$_SESSION['users']['uid']."' and group_id='".$gid."') and mark_status='N'");
					if($this->exec)
					{
						echo "true";
					}
					else
						echo "false";
				}
				else{
						$this->compile("insert into bookmarks(marker_id,group_id,mark_status,mark_date) values('".$_SESSION['users']['uid']."','".$gid."','Y',now())");
						if($this->exec)
						{
							echo "true";
						}
						else
							echo "false";
				}
			}
			public function unBookmarkGroup($grp_nm)
			{
					$this->exec=$this->compile("update bookmarks set mark_status='N' where (marker_id='".$_SESSION['users']['uid']."' and group_id='".$grp_nm."') and mark_status='Y' ");

					if($this->exec)
					{
						echo "true1";
					}
					else
						echo "false1";				
			}
			public function getBookmarkedGroups()
			{
				$ray=array();
				$book=array();
				$groups=array();
				$respo=$this->checkTableExist("bookmarks");
				if($respo=="true")
				{
					$this->exec=$this->compile("select * from bookmarks where marker_id='".$_SESSION['users']['uid']."' and mark_status='Y' ");
					$num=mysqli_num_rows($this->exec);
					if($num>0)
					{
						while ($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
						{
							array_push($book,$row);
						}
					}
					else{
						return;
					}
					for($i=0;$i<count($book);$i++)
					{
						$exe1=$this->compile("select * from groups where group_identification='".$book[$i]['group_id']."' ");	
						$group=mysqli_fetch_array($exe1,MYSQLI_ASSOC);		
						array_push($groups,$group);
					}
						//print_r(expression)
					//print_r($book);
					//print_r($groups);
					array_push($ray,$book);
					array_push($ray,$groups);
					echo json_encode($ray);
				}
				else
				{
					echo "No Bookmark";
				}
			}
			public function joinGroup($grp_nm)
			{
				$this->exec=$this->compile("select * from ".$grp_nm." where mem_id='".$_SESSION['users']['uid']."' ");
				$num=mysqli_num_rows($this->exec);
				//echo $num;
				if($num==1)
				{
					$row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					if($row['mem_status']=="N")
					{
						//print_r($row);
						$this->compile("update ".$grp_nm." set mem_status='Y' where mem_id='".$_SESSION['users']['uid']."' and mem_status='N'");
						if($this->exec)
						{
							echo "true";
						}
					else
						echo "false";
					}
				}
				else
				{
					$this->compile("insert into ".$grp_nm."(mem_id,mem_pos,mem_status,join_date) values('".$_SESSION['users']['uid']."','Member','Y',now())");
					if($this->exec)
					{
						echo "true";
					}
					else
						echo "false";	
				}
			}
			public function getFreindsRequest()
			{
				$result=array();
				$groups=array();
				$detail=array();
				$package=array(array());
				$flag=0;
				$get=null;
				$this->exec=$this->compile("select * from g_relationship where (sender_id='".$_SESSION['users']['uid']."' or receiver_id='".$_SESSION['users']['uid']."')");
				$num=mysqli_num_rows($this->exec);
				if($num>0)
				{
					while($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
					{
						//array_push($result,$row);
						if($row['sender_id']==$_SESSION['users']['uid'])
							$get=$row['receiver_id'];
						else
							$get=$row['sender_id'];
						array_push($row,$get);
						array_push($result,$row);
					}
				}
				else{
						array_push($result,"No friend req");
						return $result;
				}

				$exe1=$this->compile("select * from groups");
				$num1=mysqli_num_rows($exe1);
				if($num1>0)
				{
					while ($row=mysqli_fetch_array($exe1,MYSQLI_ASSOC))
					{
						array_push($groups,$row);
					}
				}
				else
				{					
						array($result,"No group found");	
						return $result;
				}

					$index=0;
					for($i=0;$i<count($result);$i++)
					{	
						$pic=array();
						$path="null";
						$detail=array();
						$group_det=array();
						$flag=0;
						for($j=0;$j<count($groups);$j++)
						{
							$exe2=$this->compile("select * from ".$groups[$j]['group_identification']." where mem_id='".$result[$i][0]."' and mem_status='Y'");
							$num2=mysqli_num_rows($exe2);
							if($num2==1)
							{
								$row=mysqli_fetch_array($exe2,MYSQLI_ASSOC);
								$group_det=$groups[$j];
								$flag=1;
							}
						}
						if($flag==0)
							$group_det="null";
						$exe3=$this->compile("select * from g_signup where id='".$result[$i][0]."' ");
						$row2=mysqli_fetch_array($exe3);
						$exe4=$this->compile("select * from g_photos where uploader_id='".$result[$i][0]."' ");
						$num3=mysqli_num_rows($exe4);
						if($num3==1)
						{
							$row3=mysqli_fetch_array($exe4,MYSQLI_ASSOC);
							$path=$row3['pic_path'];
						}
						array_push($row2,$path);
						$row3=mysqli_fetch_array($exe3);
						array_push($detail,$result[$i]);
						array_push($detail,$group_det);
						array_push($detail,$row2);
						$package[$i]=$detail;
					}
					if(isset($_SESSION['users']['uid']))
						array_push($package,$_SESSION['users']['uid']);
					return $package;
			}
			public function groupSearchByType($txt)
			{
				//echo $txt;
				$table=$this->checkTableExist("groups");
				if($table=="true")
				{
					$groups=array();
					$this->exec=$this->compile("select * from groups where group_name like '".$txt."%' ");
					$gnum=mysqli_num_rows($this->exec);
					if($gnum>0)
					{
						while($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
						{
							//print_r($row);
							$res=$this->compile("select * from ".$row['group_identification']." where mem_status='Y' ");
							$num=mysqli_num_rows($res);
							array_push($row,$num);
							array_push($groups,$row);
						}
						//print_r($groups);
						echo json_encode($groups);	
					}
					else{
						echo "false";
					}
				}
				else{
					echo "No Groups Found";
				}
			}
			public function updateFriendshipStatus($id,$status)
			{
				$exe=$this->compile("select * from g_relationship where (sender_id='".$_SESSION['users']['uid']."' and receiver_id='".$id."') or (sender_id='".$id."' and receiver_id='".$_SESSION['users']['uid']."') ");
				$num=mysqli_num_rows($exe);
				if($num>0)
				{
					$this->exec=$this->compile("update g_relationship set req_status='".$status."' where (sender_id='".$_SESSION['users']['uid']."' and receiver_id='".$id."') or (sender_id='".$id."' and receiver_id='".$_SESSION['users']['uid']."') ");
					if($this->exec)
					{
						echo "true";
					}
					else
						echo "false";
				}
				else{
					$this->exec=$this->compile("insert into g_relationship(sender_id,receiver_id,req_status,req_date) values('".$_SESSION['users']['uid']."','".$id."','-1',now())");
					if($this->exec)
						echo "true";
					else 
						echo "false";
				}
			}
			public function sendMGroupMate($val)
			{
				$this->exec=$this->compile("select * from groups where creator_id='".$_SESSION['users']['uid']."' ");
				$num=mysqli_num_rows($this->exec);
				if($num>0)
				{
					$row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					//print_r($row);
					$exe=$this->compile("select * from ".$row['group_identification']." where mem_status='Y'");	
					while($row2=mysqli_fetch_array($exe,MYSQLI_ASSOC))
					{
						$this->exec=$this->compile("insert into g_notification(sender_id,receiver_id,group_name,group_message,note_date) values('".$_SESSION['users']['uid']."','".$row2['mem_id']."','".$row['group_identification']."','".$val."',now())");
					}
					echo "true";
				}	
				else{

				}
			}
			public function getAllNotifications()
			{
				$ray=array();
				$this->exec=$this->compile("select * from g_notification where receiver_id='".$_SESSION['users']['uid']."' order by sr_no desc");
				$num=mysqli_num_rows($this->exec);
				if($num>0)
				{
					while($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
					{
						$detail=array();
						$res2=array();
						$path=null;
						$exe1=$this->compile("select * from groups where group_identification='".$row['group_name']."' ");
						$res1=mysqli_fetch_array($exe1,MYSQLI_ASSOC);
						$exe2=$this->compile("select * from g_signup where id='".$row['sender_id']."' ");
						$res2=mysqli_fetch_array($exe2,MYSQLI_ASSOC);
						$exe3=$this->compile("select * from g_photos where uploader_id='".$row['sender_id']."' ");
						$num1=mysqli_num_rows($exe3);
						if($num1>0)
						{
							$res3=mysqli_fetch_array($exe3,MYSQLI_ASSOC);
							array_push($res2,$res3['pic_path']);
						}
						else{
							array_push($res2,"null");	
						}
						array_push($detail,$row);
						array_push($detail,$res1);
						array_push($detail,$res2);
						array_push($ray,$detail);
					}
					//print_r($ray);
					echo json_encode($ray);
				}
				else{
					echo "No notification";
				}
			}
			public function getAllSearchedResult($val)
			{
				$ray=array();
				$group=array();
				$groups=array();
				$this->exec=$this->compile("select * from g_signup where concat(concat(first_name,' '),last_name) like '".$val."%' ");
				$num=mysqli_num_rows($this->exec);
				if($num>0)
				{
					while($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
					{
						$res=$this->checkTableExist("groups");
						if($res=="true")
						{
							$exe1=$this->compile("select * from groups");
							while($row2=mysqli_fetch_array($exe1,MYSQLI_ASSOC))
							{
								array_push($group,$row2);
							}

								$flag=0;
								for($i=0;$i<count($group);$i++)
								{
									$exe2=$this->compile("select * from ".$group[$i]['group_identification']." where mem_id='".$row['id']."' and mem_status='Y' ");
									$num1=mysqli_num_rows($exe2);
									//echo $num1;
									if($num1==1)
									{
										$row3=mysqli_fetch_array($exe2,MYSQLI_ASSOC);
										$groups=$group[$i];
										$flag=1;
									}
								}
								if($flag==0)
									$groups="null";
						}
						else{
							echo "No Groups Found";
							return;
						}
						$detail=array();
						$path=null;
						
						$exe3=$this->compile("select * from g_photos where uploader_id='".$row['id']."' ");
						$num2=mysqli_num_rows($exe3);
						if($num2>0)
						{
							$res3=mysqli_fetch_array($exe3,MYSQLI_ASSOC);
							array_push($row,$res3['pic_path']);
						}
						else{
							array_push($row,"null");	
						}
						array_push($detail,$groups);
						array_push($detail,$row);
						array_push($ray,$detail);
					}
					echo json_encode($ray);
				}
				else{
					echo "No result found";
				}
			}
			public function uploadPost($mess,$pm)
			{
				$post_id=0;
				$this->exec=$this->compile("select * from g_relationship where (sender_id='".$_SESSION['users']['uid']."' or receiver_id='".$_SESSION['users']['uid']."') and req_status='1' ");
				$num=mysqli_num_rows($this->exec);
				
				$exe1=$this->compile("select max(post_id) as post_id from g_post where sender_id='".$_SESSION['users']['uid']."' ");
				$num1=mysqli_num_rows($exe1);
				//echo "len-> ".$num1;
				if($num1==1)
				{
					$row1=mysqli_fetch_array($exe1,MYSQLI_ASSOC);
					if(strlen($row1['post_id'])>0)
						$post_id=$row1['post_id']+1;
					else
						$post_id+=1;
				}
				else{
					$post_id+=1;
				}
				$rec_id=null;
				$this->compile("insert into g_post(post_id,sender_id,receiver_id,text_post,post_date) values(".$post_id.",'".$_SESSION['users']['uid']."','".$pm."','".$mess."',now())");
				if($num>0)
				{
					while($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
					{	
						if($row['sender_id']==$_SESSION['users']['uid'])
							$rec_id=$row['receiver_id'];
						else
							$rec_id=$row['sender_id'];

						$exe2=$this->compile("insert into g_post(post_id,sender_id,receiver_id,text_post,post_date) values(".$post_id.",'".$_SESSION['users']['uid']."','".$rec_id."','".$mess."',now())");
					}
					echo "true";
				}
			}
			public function getNewPost()
			{
				$row=null;
				$detail=array();
				$this->exec=$this->compile("select * from g_post where sr_no=(select max(sr_no) from g_post where sender_id='".$_SESSION['users']['uid']."' and receiver_id='".$_SESSION['users']['uid']."') limit 1 ");
				$num=mysqli_num_rows($this->exec);
				if($num>0)
				{
					$like=0;
					$path=null;
					$row2=array();
					$row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					$exe1=$this->compile("select * from g_signup where id='".$row['sender_id']."' ");
					$row2=mysqli_fetch_array($exe1,MYSQLI_ASSOC);

					$exe3=$this->compile("select * from g_photos where uploader_id='".$row['sender_id']."' ");
					$num3=mysqli_num_rows($exe3);
					if($num3>0)
					{
						$row4=mysqli_fetch_array($exe3,MYSQLI_ASSOC);
						$path=$row4['pic_path'];
					}
					else{
						$path="null";
					}
					array_push($row2,$path);

					$exe2=$this->compile("select * from g_post where post_id in (select max(post_id) from g_post where sender_id='".$_SESSION['users']['uid']."')");

					while($row3=mysqli_fetch_array($exe2,MYSQLI_ASSOC))
					{
						if(($row3['plike']=="Y"||$row3['plike']=="y"))
						{
							$like+=1;
						}
					}

					array_push($detail,$row);
					array_push($detail,$row2);
					array_push($detail,$like);
					echo json_encode($detail);
					//print_r($detail);
				}
				else{
						echo "no new post";
				}
			}
			public function likedPost($post_id,$send_id,$rec_id,$status)
			{
				$mode=null;
				if($status=="like")
					$status="Y";
				else
					$status="N";
				$this->exec=$this->compile("update g_post set plike='".$status."' where post_id=".$post_id." and sender_id='".$send_id."' and receiver_id='".$rec_id."' ");
				if($this->exec)
					echo "true";
				else
					echo "false";
			}
			public function uploadMultiplePhotos($file)
			{
				$sourcePath = $file['tmp_name'];
				$targetPath = "../Uploaded/add_photos/".$file['name'];
				if(move_uploaded_file($sourcePath,$targetPath))
				{
					$this->insertMultipleAddedPhotos($file['name']);
				}
			}
			public function insertMultipleAddedPhotos($fl_nm)
			{
				$post_id=0;
				$this->exec=$this->compile("select * from g_relationship where (sender_id='".$_SESSION['users']['uid']."' or receiver_id='".$_SESSION['users']['uid']."') and req_status='1' ");
				$num=mysqli_num_rows($this->exec);
				
				$exe1=$this->compile("select max(post_id) as post_id from g_post where sender_id='".$_SESSION['users']['uid']."' ");
				$num1=mysqli_num_rows($exe1);
				//echo "len-> ".$num1;
				if($num1==1)
				{
					$row1=mysqli_fetch_array($exe1,MYSQLI_ASSOC);
					if(strlen($row1['post_id'])>0)
						$post_id=$row1['post_id']+1;
					else
						$post_id+=1;
				}
				else{
					$post_id+=1;
				}
				$rec_id=null;
				$this->compile("insert into g_post(post_id,sender_id,receiver_id,post_photos,post_date) values(".$post_id.",'".$_SESSION['users']['uid']."','".$_SESSION['users']['uid']."','".$fl_nm."',now())");
				
				if($num>0)
				{
					while($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
					{	
						if($row['sender_id']==$_SESSION['users']['uid'])
							$rec_id=$row['receiver_id'];
						else
							$rec_id=$row['sender_id'];

						$exe2=$this->compile("insert into g_post(post_id,sender_id,receiver_id,post_photos,post_date) values(".$post_id.",'".$_SESSION['users']['uid']."','".$rec_id."','".$fl_nm."',now())");
					}
					echo "true";
				}
			}
			public function getAllProfileDetails($id)
			{
				$cover_p=array();
				$friends=array();
				$group=array();
				$groups=array();
				$signup=array();
				$ray=array();
				$postGroup=array();
				$postGroup1=array();
				$upost=array();
				$posts=array();
				$likes=array();
				$this->exec=$this->compile("select * from g_signup where id='".$id."' ");
				$num=mysqli_num_rows($this->exec);
				if($num==1)
				{
					$signup=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					/*---- Profile Photos-----*/
					$exe6=$this->compile("select * from g_photos where uploader_id='".$id."' ");
					$num5=mysqli_num_rows($exe6);
					if($num5==1)
					{
						$row6=mysqli_fetch_array($exe6,MYSQLI_ASSOC);
						array_push($signup,$row6['pic_path']);
					}
					else{
						array_push($signup,"null");
					}
					/*---- Cover Photos-----*/
					$exe1=$this->compile("select * from g_coverphotos where uploader_id='".$id."' ");
					$num1=mysqli_num_rows($exe1);
					if($num1==1)
					{
						$row2=mysqli_fetch_array($exe1,MYSQLI_ASSOC);
						array_push($signup,$row2['pic_path']);	
					}
					else{
						array_push($signup,"null");
					}
					/*---- Friends-----*/
					$get=null;
					$frnd=array();
					$exe2=$this->compile("select * from g_relationship where (sender_id='".$id."' or receiver_id='".$id."') and req_status='1' ");
					$num2=mysqli_num_rows($exe2);
					if($num2==1)
					{
						while ($row3=mysqli_fetch_array($exe2,MYSQLI_ASSOC))
						{
							if($row3['sender_id']==$id)
								$get=$row3['receiver_id'];
							else
								$get=$row3['sender_id'];
							//echo $get;
							$exec=$this->compile("select * from g_signup where id='".$get."' ");
							$frnd=mysqli_fetch_array($exec,MYSQLI_ASSOC);
							$exec2=$this->compile("select * from g_photos where uploader_id='".$get."' ");

								$numm=mysqli_num_rows($exec2);
								if($numm==1)
								{
									$rowl=mysqli_fetch_array($exec2,MYSQLI_ASSOC);
									array_push($frnd,$rowl['pic_path']);
								}
								else{
									array_push($frnd,"null");
								}
								array_push($frnd,$row3);

							array_push($friends,$frnd);
							//print_r($friends);
							//echo $id;
						}
					}
					else{
						$friends="null";
					}
					/*---- Groups-----*/

						$exe3=$this->compile("select * from groups");
						$num3=mysqli_num_rows($exe3);
						if($num3>0)
						{
							while($row4=mysqli_fetch_array($exe3,MYSQLI_ASSOC))
							{
								array_push($group,$row4);
							}
								$flag=0;
								for($i=0;$i<count($group);$i++)
								{
									$exe4=$this->compile("select * from ".$group[$i]['group_identification']." where mem_id='".$id."' and mem_status='Y' ");
									$num4=mysqli_num_rows($exe4);
									if($num4==1)
									{
										$exe5=$this->compile("select count(*) as len from ".$group[$i]['group_identification']." ");
										$row5=mysqli_fetch_array($exe5,MYSQLI_ASSOC);
										$groups=$group[$i];
										array_push($groups,$row5);
										$flag=1;
									}
								}
								if($flag==0)
									$groups="null";
						}
						else{
							$groups="No group found";
						}

					/*----  Posts ----- */
					$exe7=$this->compile("select * from g_post where sender_id='".$id."' or receiver_id='".$id."' ");
					$num7=mysqli_num_rows($exe7);
					$upost=array();

					if($num7>0)
					{
						while($row7=mysqli_fetch_array($exe7,MYSQLI_ASSOC))
						{
							array_push($postGroup,$row7);
						}
						//$postGroup1=$postGroup;
						//print_r($postGroup);
						for($i=0;$i<count($postGroup);$i++)
						{
							for($j=$i;$j<count($postGroup);$j++)
							{
								if((($postGroup[$i]['post_id']==$postGroup[$j]['post_id'])&&($postGroup[$i]['sender_id']==$postGroup[$j]['sender_id']))&&($postGroup[$j]['receiver_id']==$id))
								{
									array_push($postGroup1,$postGroup[$j]);
									//echo $_SESSION['users']['uid']." ---- ";
									//echo $postGroup[$j]['receiver_id'];
								}
							}
						}
						for($k=0;$k<count($postGroup1);$k++)
						{
							$like=0;
							for($l=0;$l<count($postGroup);$l++)
							{
								if(($postGroup1[$k]['post_id']==$postGroup[$l]['post_id'])&&($postGroup1[$k]['sender_id']==$postGroup[$l]['sender_id']))
								{
									if($postGroup[$l]['plike']=='Y')
									{
										$like++;
									}
								}
							}
							array_push($postGroup1[$k],$like);
						}
					}
					else
					{	
						array_push($postGroup1,"No recent post");
					}
					//print_r($postGroup1);
					/*----- Sending ------*/
					array_push($ray,$signup);
					array_push($ray,$friends);
					array_push($ray,$groups);
					array_push($ray,$postGroup1);
					array_push($ray,$_SESSION['users']['uid']);
					//print_r($ray);
					echo json_encode($ray);

				}/*----- if condition user exist ---*/
				else
				{
					header("Location:Profile.php?id=".$_SESSION['users']['uid']);
				}
			}
			public function insertAboutInfo($val,$id,$index)
			{	
				$fld=null;
				if($index==1)
					$fld="workplace";
				else if($index==2)
					$fld="professional_skill";
				else if($index==3)
					$fld="university";
				else if($index==4)
					$fld="high_school";
				else if($index==5)
					$fld="city";
				else if($index==6)
					$fld="home_town";
				else if($index==7)
					$fld="place";
				else if($index==8)
					$fld="relationship_status";
				else if($index==9)
					$fld="family_member";

				$this->exec=$this->compile("select * from g_about where user_id=".$id." ");
				$num=mysqli_num_rows($this->exec);
				if($num==1)
				{
					$res=$this->compile("update g_about set ".$fld."='".$val."' where user_id=".$id." ");
					if($res)
					{
						echo "true";
					}
					else
					{
						echo "false";
					}
				}
				else{
					$res=$this->compile("insert into g_about(user_id,".$fld.") values(".$id.",'".$val."')");
					if($res)
					{
						echo "true";
					}
					else
					{
						echo "false";
					}
				}
			}
			public function getAllAboutDetails($id)
			{
				$ray=array();
				$this->exec=$this->compile("select * from g_about where user_id=".$id." ");
				$exec=$this->compile("select * from g_signup where id=".$id." ");
				$row1=mysqli_fetch_array($exec,MYSQLI_ASSOC);
				$num=mysqli_num_rows($this->exec);
				if($num==1)
				{
					$row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
				}
				else
				{
					$row="No info";
				}
				array_push($ray,$row);
				array_push($ray,$row1);
				echo json_encode($ray);
			}
			public function getUserImage()
			{
				$this->exec=$this->compile("select * from g_photos where uploader_id=".$_SESSION['users']['uid']." ");
				$num=mysqli_num_rows($this->exec);
				
				$exec=$this->compile("select * from g_signup where id='".$_SESSION['users']['uid']."' ");
				$frnd=mysqli_fetch_array($exec,MYSQLI_ASSOC);
				
				$path="";
				if($num)
				{
					$row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					$path="../Uploaded/profile/".$row['pic_path'];
				}
				else
				{
					if($frnd['gender']=="male")
					{
						$path="../images/ios7-contact.png";
					}
					else{
						$path="../images/female.png";	
					}
				}
				echo $path;
			}
			public function getAllSomeFriends($id)
			{
				$path=array();
				$row=array();
				$get=array();
				$ray=array();
				$exec3=$this->compile("select * from g_relationship where (sender_id='".$_SESSION['users']['uid']."' or receiver_id='".$_SESSION['users']['uid']."') and (req_status='-1' or req_status='1') ");
				$num3=mysqli_num_rows($exec3);
				//echo $num3;
				if($num3>0)
				{
					while ($row4=mysqli_fetch_array($exec3,MYSQLI_ASSOC))
					{
						if($row4['sender_id']==$_SESSION['users']['uid'])
							array_push($get,$row4['receiver_id']);
						else
							array_push($get,$row4['sender_id']);

					}
				}
				else{
					
				}
				//echo "id = ".$id;
				if($id==1)
				{
					$this->exec=$this->compile("select * from g_signup where id!=".$_SESSION['users']['uid']." ");
				}
				else if($id==2)
				{
					$exe1=$this->compile("select * from g_signup where id=".$_SESSION['users']['uid']." ");
					$ro=mysqli_fetch_array($exe1,MYSQLI_ASSOC);
				//	print_r($ro);
					$this->exec=$this->compile("select * from g_signup where id!=".$_SESSION['users']['uid']." and state='".$ro['state']."' ");
				}
				else if($id==3)
				{
					$this->exec=$this->compile("select * from g_signup where id!=".$_SESSION['users']['uid']." ");
				}	

				$num=mysqli_num_rows($this->exec);
				if($num>0)
				{
					$flag=0;
					if(count($get)>0)
					{
						$k=0;
						while ($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
						{							
							if(isset($get[$k])&&$row['id']==$get[$k])
							{}
							else{
								$flag=1;
								/*------------ Profile pic -------*/
								$exec1=$this->compile("select * from g_photos where uploader_id=".$row['id']." ");
								$num1=mysqli_num_rows($exec1);
								if($num1>0)
								{	
									$row1=mysqli_fetch_array($exec1,MYSQLI_ASSOC);		
									array_push($row,$row1['pic_path']);
								}
								else{
									array_push($row,"null");
								}
								/*------------ Cover pic -------*/
								$exec2=$this->compile("select * from g_coverphotos where uploader_id=".$row['id']." ");
								$num2=mysqli_num_rows($exec1);
								if($num2>0)
								{	
									$row2=mysqli_fetch_array($exec2,MYSQLI_ASSOC);		
									array_push($row,$row2['pic_path']);
								}
								else{
									array_push($row,"null");
								}
								array_push($ray,$row);
							}
							$k++;
						}
						//print_r($ray);
					}
					else{
						$flag=0;
						while ($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
						{
							$flag=1;
								/*------------ Profile pic -------*/
								$exec1=$this->compile("select * from g_photos where uploader_id=".$row['id']." ");
								$num1=mysqli_num_rows($exec1);
								if($num1>0)
								{	
									$row1=mysqli_fetch_array($exec1,MYSQLI_ASSOC);		
									array_push($row,$row1['pic_path']);
								}
								else{
									array_push($row,"null");
								}
								/*------------ Cover pic -------*/
								$exec2=$this->compile("select * from g_coverphotos where uploader_id=".$row['id']." ");
								$num2=mysqli_num_rows($exec1);
								if($num2>0)
								{	
									$row2=mysqli_fetch_array($exec2,MYSQLI_ASSOC);		
									array_push($row,$row2['pic_path']);
								}
								else{
									array_push($row,"null");
								}

								array_push($ray,$row);
						}
					}
					/*---- send- ---*/
						if($flag==0)
							echo "No result";
						else
						{
							echo json_encode($ray);	
						}
				}
				else{
						echo "No Friends";
						//return;
				}

			}
			public function getShowerFriendshipStatus($id)
			{
					$relation=array();
					$req_status=null;
					$ray=array();
					$this->exec=$this->compile("select * from g_relationship where ((sender_id='".$_SESSION['users']['uid']."' and receiver_id='".$id."') or (sender_id='".$id."' and receiver_id='".$_SESSION['users']['uid']."'))");
						$num=mysqli_num_rows($this->exec);
						if($num==1)
						{
							$row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
							//print_r($row);
							if($row['req_status']=="-1"&&$row['sender_id']==$_SESSION['users']['uid'])
								$req_status="Friend Request Send";
							else if($row['req_status']=="-1"&&$row['sender_id']!=$_SESSION['users']['uid'])
								$req_status="Accept";
							else if($row['req_status']=="0")
								$req_status="Accept";
							else if($row['req_status']=="1")
								$req_status="Friends";
							else if($row['req_status']=="2")
								$req_status="Add Friend";
							array_push($row,$req_status);
							array_push($relation,$row);
							//print_r($relation);
						}
						else{
								$req_status="Add Friend";
								array_push($relation,$req_status);
						}
						array_push($ray,$relation);
						array_push($ray,$_SESSION['users']['uid']);
						//print_r($ray);
						echo json_encode($ray);
						
			}

			public function getUserGroupExistence($id)
			{
				$groups=array();
				$ray=array();
				$res=$this->checkTableExist("groups");
				if($res=="true")
				{
					$this->exec=$this->compile("select * from groups");
					while($row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
					{
						array_push($groups,$row);
					}					
					/*------ Group searching ------*/
								$flag=0;
								for($i=0;$i<count($groups);$i++)
								{
									$this->exec=$this->compile("select * from ".$groups[$i]['group_identification']." where mem_id='".$id."' and mem_status='Y' ");
									$num=mysqli_num_rows($this->exec);

									if($num==1)
									{
										$flag=1;
										$_SESSION['jgroup_id']=$groups[$i]['creator_id'];

										$mexe=$this->compile("select * from group_msg_".$groups[$i]['creator_id']);
										$num2=mysqli_num_rows($mexe);
										$_SESSION['groupchat_max_id']=$num2;
										if($num2>0)
										{
											while ($messX=mysqli_fetch_array($mexe,MYSQLI_ASSOC)) 
											{
												$signup=array();
													$sexe=$this->compile("select * from g_signup where id='".$messX['sender_id']."' ");
													$signup=mysqli_fetch_array($sexe,MYSQLI_ASSOC);
															/*---- Profile Photos-----*/
															$exe6=$this->compile("select * from g_photos where uploader_id='".$messX['sender_id']."' ");
															$num5=mysqli_num_rows($exe6);
															if($num5==1)
															{
																$row6=mysqli_fetch_array($exe6,MYSQLI_ASSOC);
																array_push($signup,$row6['pic_path']);
															}
															else{
																array_push($signup,"null");
															}
														$gexe=$this->compile("select * from group_".$_SESSION['jgroup_id']." where mem_id='".$messX['sender_id']."' and mem_status='Y' ");	
														$grow=mysqli_fetch_array($gexe,MYSQLI_ASSOC);	
														array_push($signup,$grow['mem_pos']);
											array_push($signup,$messX);
											array_push($ray,$signup);
											}
											//print_r($ray);
										}
										else{
											array_push($ray,"No message");
										}
												array_push($ray,$groups[$i]);
												echo json_encode($ray);
									}
								}
								if($flag==0)
								{
									echo "Not joined";
								}

				}//group exist or not
				else
				{
						echo "No Groups Found";
				}
			}
		}
		$gs=new GroupServer;
		if(isset($_POST['gs']))
		{
			$gs->getGroupInfo(0);
		}
		if(isset($_POST['leave']))
		{
			$gs->leaveGroup($_POST['leave']);
		}
		if(isset($_POST['edit_grp']))
		{
			$gs->editGroup();
		}
		if(isset($_POST['srch_group']))		
		{
			$gs->searchedGroups();	
		}
		if(isset($_POST['visit_srch']))		
		{
			$gs->visitSearchedGroup($_POST['visit_srch']);
		}
		if(isset($_POST['bookmark']))		
		{
			if($_POST['status']=="N")
				$gs->bookmarkGroup($_POST['bookmark']);
			else if($_POST['status']=="Y")
				$gs->unBookmarkGroup($_POST['bookmark']);
		}
		if(isset($_POST['marked']))		
		{
			$gs->getBookmarkedGroups();
		}
		if(isset($_POST['cks']))		
		{
			$gs->checkUserGroupStatus();
			echo $gs->userjstatus;
		}
		if(isset($_POST['same_g']))		
		{
			if(isset($_SESSION['group_det']))
			{
				if($_POST['grp_nm']==$_SESSION['group_det']['group_identification'])
				{
					echo "1";
				}
				else{
					echo "0";
				}
			}
		}
		if(isset($_POST['join_grp']))
		{
			$gs->joinGroup($_POST['join_grp']);
		}
		if(isset($_POST['frnds_req']))
		{
			$res=array();
			$res=$gs->getFreindsRequest();
			if($res[0]==" friend req")
			{
				echo $res[0];
			}
			else if($res[count($res)-1]=="No group found")
			{
				print_r($res);
			}
			else{
				echo json_encode($res);
			}
		}
		if(isset($_POST['index']))
		{
			if(isset($_SESSION['users']))
				echo $_SESSION['users']['uid'];
		}
		if(isset($_POST['srch_text']))
		{
			$gs->groupSearchByType($_POST['srch_text']);
		}
		if(isset($_POST['frnd_id']))
		{
			//echo $_POST['frnd_stat'];
			if($_POST['frnd_stat']=="add_friend")	
			{
				$rel="-1";
			}
			else if($_POST['frnd_stat']=="accepted")	
			{
				$rel="1";
			}
			else if($_POST['frnd_stat']=="rejected")	
			{
				$rel="2";
			}
			else if($_POST['frnd_stat']=="canceled")	
			{
				$rel="2";
			}
			$gs->updateFriendshipStatus($_POST['frnd_id'],$rel);
		}

		if(isset($_POST['frnds_box']))
		{
			//echo $_POST['frnd_stat'];
			if($_POST['frnd_stat']=="unfriend")	
			{
				$rel="2";
			}
			else if($_POST['frnd_stat']=="accepted")	
			{
				$rel="1";
			}
			else if($_POST['frnd_stat']=="rejected")	
			{
				$rel="2";
			}
			else if($_POST['frnd_stat']=="canceled")	
			{
				$rel="2";
			}
			$gs->updateFriendshipStatus($_POST['frnds_box'],$rel);
		}
		if(isset($_POST['group_message']))
		{
			$gs->sendMGroupMate($_POST['group_message']);
		}
		if(isset($_POST['notifi']))
		{
			$gs->getAllNotifications();
		}
		if(isset($_POST['srched_txt']))
		{
			$gs->getAllSearchedResult($_POST['srched_txt']);
		}
		if(isset($_POST['all_add_frnd']))
		{
			$res=array();
			$res=$gs->getFreindsRequest();
			if($res[0]=="No friend req")
			{
				echo $res[0];
			}
			else if($res[count($res)-1]=="No group found")
			{
				print_r($res);
			}
			else{
				echo json_encode($res);
			}
		}
		if(isset($_POST['post_mess']))
		{
			$gs->uploadPost($_POST['post_mess'],$_POST['post_man']);
		}
		if(isset($_POST['new_post']))
		{
			$gs->getNewPost();
		}
		if(isset($_POST['new_post_pannel']))
		{
			 include("post_pannel.php");
		}
		if(isset($_POST['p_like']))
		{
			$gs->likedPost($_POST['ppost_id'],$_POST['psend_id'],$_POST['prec_id'],$_POST['p_like']);
		}
		if(isset($_FILES['mulPro_img']))
		{
			$gs->uploadMultiplePhotos($_FILES['mulPro_img']);
		}
		if(isset($_POST['logout']))
		{
			session_unset();
			session_destroy();
			echo "logout";
		}
		if(isset($_POST['profile_details']))
		{
			$gs->getAllProfileDetails($_POST['profile_details']);
		}
		if(isset($_POST['abt_val']))
		{
			$gs->insertAboutInfo($_POST['abt_val'],$_POST['abt_id'],$_POST['abt_index']);
		}
		if(isset($_POST['about_det']))
		{
			$gs->getAllAboutDetails($_POST['about_det']);
		}
		if(isset($_POST['Uimg']))
		{
			$gs->getUserImage();
		}
		if(isset($_POST['logger_id']))
		{
			echo $_SESSION['users']['uid'];
		}
		if(isset($_POST['sfrnd']))
		{
			$gs->getAllSomeFriends($_POST['sfrnd']);
		}
		if(isset($_POST['user_frnd_status']))
		{
			$gs->getShowerFriendshipStatus($_POST['user_frnd_status']);
		}
		if(isset($_POST['hgrpexist']))
		{
			$gs->getUserGroupExistence($_SESSION['users']['uid']);
		}

?>