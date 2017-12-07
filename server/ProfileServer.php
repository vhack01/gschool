<?php
		include("SignupServer.php");
		
		class Profile extends SignupDetails
		{
			public function __constructor()
			{
				
			}
			public function uploadCoverPhoto($file)
			{	
				//print_r($file['size']);
				$res=$this->validatePhotos($file);	
				if($res=="true")
				{
					$sourcePath = $file['tmp_name'];
					$targetPath = "../Uploaded/cover/".$file['name'];
					if(move_uploaded_file($sourcePath,$targetPath))
					{
						echo $file['name'];
					}
				}
				else
					echo "error";
			}
			public function uploadProfilePhoto($file)
			{	
				//print_r($file['size']);
				$res=$this->validatePhotos($file);	
				//echo "result -> ".$res;
				if($res=="true")
				{
					$sourcePath = $file['tmp_name'];
					$targetPath = "../Uploaded/profile/".$file['name'];
					if(move_uploaded_file($sourcePath,$targetPath))
					{
						$this->insertProfilePhoto($file['name']);
					}
				}
				else{
					echo "error";
				}
			}
			public function validatePhotos($file)
			{
				$validextensions = array("jpeg", "jpg", "png","gif");
				$temporary = explode(".",$file["name"]);
				$file_extension = end($temporary);
				if((($file["type"] == "image/png") || ($file["type"] == "image/jpg") || ($file["type"] == "image/jpeg")) && ($file["size"] > 20480&&$file["size"] <10485760 )&& in_array($file_extension, $validextensions))
				{
					return "true";
				}
				else
				{
					return "false";
				}
			}
			public function insertCoverPhoto($img)
			{
				$this->exec=$this->compile("select * from g_CoverPhotos where uploader_id='".$_SESSION['users']['uid']."' ");
				$num=mysqli_num_rows($this->exec);
				if($num)
				{
					$this->compile("update g_CoverPhotos set pic_path='".$img."',time_stamp=now() where uploader_id='".$_SESSION['users']['uid']."' ");
					//echo "updated";
				}
				else
				{//echo $num;
					$this->compile("insert into g_CoverPhotos(uploader_id,pic_path,time_stamp) values('".$_SESSION['users']['uid']."','".$img."',now())");	
					//echo "insert";
				}
				echo "1";
			}
			public function insertProfilePhoto($img)
			{
				$this->exec=$this->compile("select * from g_photos where uploader_id='".$_SESSION['users']['uid']."' ");
				$num=mysqli_num_rows($this->exec);
				if($num)
				{
					$this->compile("update g_photos set pic_path='".$img."',time_stamp=now() where uploader_id='".$_SESSION['users']['uid']."' ");
					//echo "updated";
				}
				else
				{//echo $num;
					$this->compile("insert into g_photos(uploader_id,pic_path,time_stamp) values('".$_SESSION['users']['uid']."','".$img."',now())");	
					//echo "insert";
				}
				echo "1";
			}
			public function getPhotos()
			{
				$image=array();
				$this->exec=$this->compile("select * from g_CoverPhotos where uploader_id='".$_SESSION['users']['uid']."' ");
				$num=mysqli_num_rows($this->exec);
				//echo $num;
				if($num)
				{
					$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					array_push($image,$res['pic_path']);
				}
				else
				{
					array_push($image,"null");	
				}
				$this->exec=$this->compile("select * from g_photos where uploader_id='".$_SESSION['users']['uid']."' ");
				$num=mysqli_num_rows($this->exec);
				//echo $num;
				if($num)
				{
					$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					array_push($image,$res['pic_path']);
				}
				else
				{
					array_push($image,"null");	
				}
				echo json_encode($image);

			}
			public function groupLogo($file)
			{	
				//print_r($file['size']);
				$res=$this->validatePhotos($file);	
				//echo "result -> ".$res;
				if($res=="true")
				{
					$sourcePath = $file['tmp_name'];
					$targetPath = "../Uploaded/group_logo/".$file['name'];
					if(move_uploaded_file($sourcePath,$targetPath))
					{
						echo $file['name'];
					}
				}
				else{
					echo "false";
				}
			}
			public function createGroup($group_name,$group_type,$group_len,$group_location,$group_desc,$group_logo)
			{	
				$res=$this->checkTableExist("groups");
				//sprint_r($res);
				if($res=="false")
				{
					$this->exec=$this->compile("create table groups(sr_no int(10) primary key auto_increment,group_identification varchar(1000),creator_id varchar(100) not null,group_name varchar(100) not null,group_type varchar(100),group_length int(100),group_location varchar(1000),group_description varchar(60000),group_logo varchar(100),create_date varchar(100))");

					$this->exec=$this->compile("create table bookmarks(sr_no int(10) primary key auto_increment,marker_id varchar(1000),group_id varchar(100) not null,mark_status varchar(100) not null,mark_date varchar(100))");
					

					if($this->exec)
					{
						$this->insertGroups($group_name,$group_type,$group_len,$group_location,$group_desc,$group_logo);
					}
				}
				else{
					$this->insertGroups($group_name,$group_type,$group_len,$group_location,$group_desc,$group_logo);
				}
			}
			public function insertGroups($group_name,$group_type,$group_len,$group_location,$group_desc,$group_logo)
			{
				$this->exec=$this->compile("select * from groups where creator_id='".$_SESSION['users']['uid']."' ");
				$num=mysqli_num_rows($this->exec);
				if($num==0)
				{
					$res=$this->compile("insert into groups(group_identification,creator_id,group_name,group_type,group_length,group_location,group_description,group_logo,create_date) values('group_".$_SESSION['users']['uid']."','".$_SESSION['users']['uid']."','".$group_name."','".$group_type."','".$group_len."','".$group_location."','".$group_desc."','".$group_logo."',now()) ");
						//print_r($res);

					if($res)
					{
						$res2=$this->compile("create table group_".$_SESSION['users']['uid']."(sr_no int(10) primary key auto_increment,mem_id varchar(1000) not null,mem_pos varchar(1000),mem_status varchar(100),join_date varchar(100))");

						$res3=$this->compile("create table group_msg_".$_SESSION['users']['uid']."(sr_no int(100) primary key auto_increment,sender_id varchar(1000) not null,message varchar(1000),group_message varchar(10000),join_date varchar(100))");

						if($res2)
						{
							$res4=$this->joinGroup($_SESSION['users']['uid'],'Y');
							if($res4)
								header("location:GroupDetails.php");
						}
					}
				}
				else{
					header("location:GroupDetails.php?err=false");
				}
			}
			public function joinGroup($joiner,$status)
			{
				return $this->compile("insert into group_".$_SESSION['users']['uid']."(mem_id,mem_pos,mem_status,join_date) values('".$joiner."','Leader','".$status."',now())");
			}
			public function updateGroup($group_name,$group_type,$group_len,$group_location,$group_desc,$group_logo)
			{
				$this->exec=$this->compile("update groups set group_name='".$group_name."',group_type='".$group_type."',group_length='".$group_len."',group_location='".$group_location."',group_description='".$group_desc."',group_logo='".$group_logo."',create_date=now() where creator_id='".$_SESSION['users']['uid']."' ");
				if($this->exec)
					header("location:GroupDetails.php");
				else
				{}
			}
		}
		$profile=new Profile;
		if(isset($_FILES['profile_img']))
		{	
			$profile->uploadCoverPhoto($_FILES['profile_img']);
			//echo $_FILES['profile_img']['name'];
		}
		if(isset($_FILES['profileP_img']))
		{	
			$profile->uploadProfilePhoto($_FILES['profileP_img']);
			//echo $_FILES['profile_img']['name'];
		}
		if(isset($_POST['path']))
		{		
			$profile->insertCoverPhoto($_POST['path']);
		}
		if(isset($_POST['cover']))
		{		
			$profile->getPhotos();
		}
		if(isset($_FILES['g_logo']))
		{
			$profile->groupLogo($_FILES['g_logo']);
		}
		if(isset($_POST['create_grp']))
		{
			$profile->createGroup($_POST['group_nm'],$_POST['group_type'],$_POST['grp_len'],$_POST['group_location'],$_POST['g_description'],$_POST['grop_logo']);
		}
		if(isset($_POST['grp_index']))
		{
			if($_POST['grp_index']==2)
				include("createGroup.php");
			else if($_POST['grp_index']==3)
				include("Groups.php");
			else if($_POST['grp_index']==4)
				include("Friends.php");
			else if($_POST['grp_index']==5)
				include("Notification.php");
			else
				include("MyGroup.php");
		}
		if(isset($_POST['grps_index']))
		{
			if($_POST['grps_index']==2)
				include("Bookmarks.php");
			else
				include("SearchedGroups.php");
		}
		if(isset($_POST['frnds_index']))
		{
			if($_POST['frnds_index']==1)
				include("FriendRequestSend.php");
			else
				include("AcceptedFriends.php");
		}
		if(isset($_POST['grp_upd']))
		{
			$profile->updateGroup($_POST['group_nm'],$_POST['group_type'],$_POST['grp_len'],$_POST['group_location'],$_POST['g_description'],$_POST['grop_logo']);
		}
		if(isset($_POST['cancel_grp']))
		{
			header("location:GroupDetails.php");
		}
?>