<?php
	
		class SignupDetails
		{
			public $link;
			public $exec;
			public $nameErr;
			public $lasterr;
			public $emailerr;
			public $c_emlerr;
			public $psderr;
			public $cpsderr;
			public $stateerr;
			public $moberr;
			public $dayerr;
			public $montherr;
			public $yearerr;
			public $row;
			public $table;
			public function __construct()
	        {
	        	if(!isset($_SESSION))
	        		session_start();
	        	
	            //$this->link=mysqli_connect("sql305.epizy.com","epiz_20966551","vhackGaint1","epiz_20966551_gschool");
	           $this->link=mysqli_connect("localhost","root","","gschool");
	        }
			public function compile($query)
			{
				return mysqli_query($this->link,$query);
			}
	        public function checkTableExist($tab)
	        { 
	              //$this->exec=$this->compile("show tables from epiz_20966551_gschool");
	              $this->exec=$this->compile("show tables from gschool");
	              $num=mysqli_num_rows($this->exec);
	              //print_r($num);
	              if($num>0)
	              {
		            while($this->row=mysqli_fetch_array($this->exec,MYSQLI_ASSOC))
		            {
		                 // if($this->row['Tables_in_epiz_20966551_gschool']==$tab)
		            	if($this->row['Tables_in_gschool']==$tab)
		                  {
		            	  		return "true";
		                  }
		              }
		              return "false";
		          	}
		          else {
						return "false";
		          }
	        }
	        public function validation($fnm,$lnm,$eml,$c_eml,$psd,$c_psd,$country_nm,$state_nm,$mobile,$birth_day,$birth_month,$birth_year,$gender)
	        {
	        			$eml=mysqli_escape_string($this->link,$eml);
	        			if (empty($fnm)) {
					        $this->nameErr = "Required..!";					      
					    }
					    else if($fnm[0]==' ')
					    {
					        $this->nameErr = "Required..!";					      	
					    }
					    else if(strlen($fnm)>20)
					    {
					    	$this->nameErr = "Max 20 character";
					    }
					    else {
					        //$name =;
					    }

					    if (empty($lnm)) {
					        $this->lasterr = "Required..!";
					    }
					    else if($lnm[0]==' ') {
					        $this->lasterr = "Required..!";					      
					    }
					    else if(strlen($lnm)>20)
					    {
					    	$this->lasterr = "Max 20 character";
					    }
					    else {
					       // $address = $_POST["address"];
					    }

					    if (empty($eml))  {
					        $this->emailErr = "Required..!";
					    }
					    else if($eml[0]==' ')  {
					        $this->emailErr = "Required..!";
					    }				
					    else { 
					     	$f=substr($eml,0,strpos($eml,'@'));					     	
					     	$fd=substr($eml,strpos($eml,'@')+1,strlen($eml)-1);	
					     	$mail=substr($fd,0, strpos($fd,'.'));
					     	$fc=substr($fd,strpos($fd,'.')+1);
					     	$domain=array("gmail","yahoo","rediffmail","orkut");

					     	if(strlen($f)<8)
					     	{
					     		$this->emailErr="Invalid email address";
					     	}
					     	else if(preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $f))
							{
							  $this->emailErr="Invalid symbols";
							}
							else if($mail!=$domain[0]&&$mail!=$domain[1]&&$mail!=$domain[2]&&$mail!=$domain[3])
							{	
								$this->emailErr="Invalid domain";
							}
							else if($fc!="com"){
								$this->emailErr="Invalid domain";	
							}
					    }

					    if (empty($c_eml)) {
					        $this->c_emlerr= "Required..!";
					    }
					    else if(strcmp($eml, $c_eml)){
					        $this->c_emlerr = "Email does not match";
					    }
					    else {
					    }

						if (empty($psd)) {
					        $this->psderr = "Required..!";
					    }
					    else if(!(strlen($psd)<=30&&strlen($psd)>=8))
					    {
					    	$this->psderr = "Min 8 & Max 30 char";
					    }
					    else {
					    
					    }

					    if (empty($c_psd)) {
					        $this->cpsderr = "Required..!";
					    }
					    else if(strcmp($psd, $c_psd)){
					        $this->cpsderr = "Password does not match";
					    }
					    else {
					    
					    }

					    if (empty($state_nm)) {
					        $this->stateerr = "Required..!";
					    }
					    else {
					        //$favFruit = $_POST["favFruit"];
					    }					  
					    if (empty($mobile)) {
					        $this->moberr= "Required..!";
					    }
					    else if(strlen($mobile)!=10)
					    {
					    	$this->moberr = "Invalid Phone Number";
					    }
					    else {
					        //$favFruit = $_POST["favFruit"];
					    }
					    if (empty($birth_day)) {
					        $this->dayerr= "Required..!";
					    }
					    else {
					        //$favFruit = $_POST["favFruit"];
					    }
					    if(empty($birth_month)) {
					        $this->montherr= "Required..!";
					    }
					    else {
					        //$favFruit = $_POST["favFruit"];
					    }
					    if (empty($birth_year)) {
					        $this->yearerr= "Required..!";
					    }
					    else {
					        //$favFruit = $_POST["favFruit"];
					    }
					    if(empty($this->nameErr)&&empty($this->lasterr)&&empty($this->emailErr)&&empty($this->c_emlerr)&&empty($this->psderr)&&empty($this->cpsderr)&&empty($this->stateerr)&&empty($this->moberr)&&empty($this->dayerr)&&empty($this->montherr)&&empty($this->yearerr))
					    	return "true";
					    else
					    	return "false";

			}
			public function validate($fnm,$lnm,$eml,$c_eml,$psd,$c_psd,$country_nm,$state_nm,$mobile,$birth_day,$birth_month,$birth_year,$gender)
			{
				$val=$this->validation($fnm,$lnm,$eml,$c_eml,$psd,$c_psd,$country_nm,$state_nm,$mobile,$birth_day,$birth_month,$birth_year,$gender);
				if($val=="true")
				{
					$otp=$this->generateOTP();
					$birth=$birth_day."/".$birth_month."/".$birth_year;
					$res=$this->checkTableExist("g_signup");
					if($res=="false")
					{
						 $this->compile("create table g_signup(id int(255) primary key auto_increment,first_name varchar(255) not null,last_name varchar(255) not null,email varchar(255),password varchar(200) not null,country varchar(100),state varchar(100),mobile varchar(10) not null,birthday varchar(50) not null,gender varchar(10) not null,signup_date varchar(100) not null,OTP varchar(10),verified varchar(10))");
							 $this->insertDetail($fnm,$lnm,$eml,$psd,$country_nm,$state_nm,$mobile,$birth,$gender,$otp); 

							$this->compile("create table g_photos(pid int(255) primary key auto_increment,uploader_id varchar(255) not null,pic_path varchar(255) not null,time_stamp varchar(255))");

							$this->compile("create table g_CoverPhotos(pid int(255) primary key auto_increment,uploader_id varchar(255) not null,pic_path varchar(255) not null,time_stamp varchar(255))");

							$this->exec=$this->compile("create table global_msg(msg_id int(10) primary key auto_increment,sender_id varchar(10) not null,message varchar(600000),date_stamp varchar(100))");

							$this->exec=$this->compile("create table g_relationship(sr_no int(10) primary key auto_increment,sender_id varchar(10) not null,receiver_id varchar(10) not null,req_status varchar(100),req_date varchar(100))");

							$this->exec=$this->compile("create table g_notification(sr_no int(10) primary key auto_increment,sender_id varchar(10) not null,receiver_id varchar(10) not null,group_name varchar(100),notification_msg varchar(10000),group_message varchar(40000),note_date varchar(100))");

							$this->exec=$this->compile("create table g_post(sr_no int(10) primary key auto_increment,post_id int(255) not null,sender_id varchar(10) not null,receiver_id varchar(10) not null,text_post varchar(10000),post_photos varchar(10000),plike varchar(100),post_date varchar(100))");

							$this->exec=$this->compile("create table g_about(sr_no int(10) primary key auto_increment,user_id int(255) not null,workplace varchar(1000),professional_skill varchar(1000),university varchar(1000),high_school varchar(10000),city varchar(10000),home_town varchar(1000),place varchar(1000),relationship_status varchar(1000),family_member varchar(1000))");
					}
					else
					{
						$this->exec=$this->compile("select * from g_signup where email='".$eml."'");	
						$num=mysqli_num_rows($this->exec);
						$exec=$this->compile("select * from g_signup where mobile='".$mobile."'");	
						$num2=mysqli_num_rows($exec);
						if($num){
							$this->emailErr="Email alreay exist";
							return false;
						}
						if($num2)
						{
								$this->moberr="Phone alreay registered";
								return false;
						}
						$otp=$this->generateOTP();
						$this->insertDetail($fnm,$lnm,$eml,$psd,$country_nm,$state_nm,$mobile,$birth,$gender,$otp);
					}
				}				
			}
			function insertDetail($fnm,$lnm,$eml,$psd,$country_nm,$state_nm,$mobile,$birth,$gender,$otp)
			{
				$this->exec=$this->compile("insert into g_signup(first_name,last_name,email,password,country,state,mobile,birthday,gender,signup_date,OTP,verified) values('".$fnm."','".$lnm."','".$eml."','".$psd."','".$country_nm."','".$state_nm."','".$mobile."','".$birth."','".$gender."',now(),'".$otp."','N')");
					if($this->exec)
					{
						session_start();
						$this->setLocalInfo($eml,$psd);
						$_SESSION['verify']=array("mobile"=>$mobile,"OTP"=>$otp);
						include("VerificationCode.php");
						header("Location:Verification.php?v=0");
					}
			}

			public function generateOTP()
			{
				$num=array(0,1,2,3,4,5,6,7,8,9);
				$a=array_rand($num);
				$b=array_rand($num);
				$c=array_rand($num);
				$d=array_rand($num);
				$otp=$a.$b.$c.$d;
				return $otp;
			}
			public function resendOTP()
			{
				$otp=$this->generateOTP();
				if(!isset($_SESSION))
					session_start();
				$_SESSION['verify']['OTP']=$otp;
				$this->exec=$this->compile("Update g_signup set OTP='".$otp."' where mobile='".$_SESSION['verify']['mobile']."' ");
				if($this->exec)
				{
					include("VerificationCode.php");
					header("Location:Verification.php?r=true");
				}
			}
			public function verifyOTP($ver_code)
			{
				if(empty($ver_code))
				{
					header("Location:Verification.php?r=false");
				}
				else{
					$this->exec=$this->compile("select OTP from g_signup where mobile='".$_SESSION['verify']['mobile']."' ");
					$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					if($res['OTP']==$ver_code)
					{
						$this->exec=$this->compile("Update g_signup set verified='Y' where mobile='".$_SESSION['verify']['mobile']."' ");
						if($this->exec){
							header("location:home.php");
						}
						else
							header("Location:Verification.php?r=f");	
					}
					else{
						header("Location:Verification.php?r=f");
					}
				}
			}
			public function loginAuth($eml,$psd)	
			{
				$res=$this->checkTableExist("g_signup");				
				if($res=="false")
				{
					header("location:../index.php?log=false");
				}
				else{
						$this->exec=$this->compile("select * from g_signup where (email='".$eml."' or mobile='".$eml."') and password='".$psd."' ");
						$detail=$this->exec;
						$num=mysqli_num_rows($this->exec);
						if($num)
						{
							$this->setLocalInfo($eml,$psd);
							//print_r($_SESSION['users']);
							header("location:home.php");
						}
						else{
							header("location:../index.php?log=false");
						}
					}
			}
			public function setLocalInfo($eml,$psd)
			{
				$this->exec=$this->compile("select * from g_signup where (email='".$eml."' or mobile='".$eml."') and password='".$psd."' ");
				$detail=$this->exec;
				$num=mysqli_num_rows($this->exec);
				if($num)
				{
					$data=mysqli_fetch_array($detail,MYSQLI_ASSOC);
					if(!isset($_SESSION))
						session_start();
					$_SESSION['users']=array("uid"=>$data['id'],"uname"=>$data['first_name']." ".$data['last_name'],"img"=>"ios7-contact");

					$this->getGlobalMaxMessageId();
				}
			}
			function table()
			{
				return $this->checkTableExist("global_msg");
			}
			public function getGlobalMaxMessageId()
			{
				$this->exec=$this->compile("select * from global_msg where msg_id=(select max(msg_id) from global_msg)");
				$num=mysqli_num_rows($this->exec);
				if(!isset($_SESSION))
					session_start();
				if($num==null)
				{
					$_SESSION['global_maxid']=0;
				}
				else
				{
					$res=mysqli_fetch_array($this->exec,MYSQLI_ASSOC);
					$_SESSION['global_maxid']=$res['msg_id'];
				}
			}

		}

		$sd=new SignupDetails;
		if(isset($_POST['eml']))
		{
			$sd->validate($_POST['first_nm'],$_POST['last_nm'],$_POST['eml'],$_POST['c_eml'],$_POST['psd'],$_POST['con_psd'],$_POST['country_nm'],$_POST['state_nm'],$_POST['mobile'],$_POST['birth_day'],$_POST['birth_month'],$_POST['birth_year'],$_POST['gender']);
		}
		if(isset($_POST['resend_otp']))
		{
			$sd->resendOTP();
		}
		if(isset($_POST['verify_otp']))
		{
			$sd->verifyOTP($_POST['ver_code']);	
		}
		if(isset($_POST['login']))
		{	
			$eml=mysqli_real_escape_string($sd->link,$_POST['log_eml']);
			$psd=mysqli_real_escape_string($sd->link,$_POST['log_psd']);
			$sd->loginAuth($eml,$psd);
		}
?>