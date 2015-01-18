<?php 
        session_start();
		date_default_timezone_set("Asia/Shanghai");	
        //引入数据库操作程序文件
	    require_once("dbOperate.php");
	    //获取数据库连接
	    $exec_mysql=getConnection();
	    //打开数据库连接
	    openConnection($exec_mysql);

      if(isset($_POST['action'])){
		  switch($_POST['action']){
			  case 'getLatestNews'     : getLatestNews(); break;
			  case 'getNewsById'       : servicegetNewsById(); break;
			  case 'searchPlace'       : getSearchResult(); break;
			  case 'checkusernamecount': checkUserName(); break;
			  case 'checkemailcount'   : checkEmailCount(); break;
			  case 'checkcode'         : checkCode(); break;
			  case 'register'          : register(); break;
			  case 'login'             : login(); break;
			  case 'unsetUserSession'  : unsetUserSession();break;
			  case 'getUserByName'     : sgetUserByName();break; 
			  case 'getUserById'       : sgetUserById();break; 
			  case 'getpassword'       : getPassword();break; 
			  case 'savecomment'       : saveComment();break;
			  case 'savequestion'      : saveQuestion();break;
			  case 'updateuserinfo'    : saveUpdateUserInfo();break;
			  case 'getDestinationInfo': getDestinationInfo();break;
			  case 'contact'           : sendContactEmail();  break;
			  default:break;
			  }
		  }
	   function getLatestNews(){
		   $news=getPageNews(1,5);
		   for ($i=0;$i<sizeof($news);++$i){
				$news[$i]->newsTime=date("Y-m-d",$news[$i]->newsTime);
		   }
		   echo json_encode($news);
		   }
	   function servicegetNewsById(){
		   @$newsId = $_POST['newsId'];
		   $news = getNewsById($newsId);
		   $news->newsTime=date("Y-m-d H:i",$news->newsTime);
		   echo json_encode($news);
		   }
	   function getSearchResult(){
		   @$searchstr=$_POST['searchstr'];
           echo "this is the result of ".$searchstr;
		   }
       function checkUserName(){
		  @$UserName = $_POST['UserName'];
		  if(getUserByName($UserName)!=null){
			  echo '{"isExist":"Y"}';
			  }
		  else echo '{"isExist":"N"}';
		  }   
	   function sgetUserByName(){
		  @$UserName = $_POST['UserName'];
		  $getuser = getUserByName($UserName);
		  if($getuser!=null){
			  echo json_encode($getuser);
			  }
		   }
		function sgetUserById(){
		  @$UserId = $_POST['UserId'];
		  $getuser = getUserById($UserId);
		  if($getuser!=null){
			  echo json_encode($getuser);
			  }
		   }
		
	   function checkEmailCount(){
		   @$email = $_POST['email'];
		   if(getUserByEmail($email)!=null){
			   echo '{"isExist":"Y"}';
			   }
		   else echo '{"isExist":"N"}';
		   }
	   function checkCode(){
		   ini_set('display_errors', 'Off');
           session_start();
		   @$postcode = $_POST['code'];
           if((strtoupper($postcode)) == strtoupper(($_SESSION["VerifyCode"]))){
			   echo '{"verifycode":"Y"}';
			   }
			   else echo '{"verifycode":"N"}';
		   }
	   function register(){
		   @$UserName = $_POST['R-username'];
		   @$UserPassword = md5($_POST['R-password']);
		   @$UserEmail = $_POST['R-mail'];
		   @$UserSex = $_POST['R-sex'];
		   @$UserInfomation = $_POST['R-information'];
		   @$UserWebpage = $_POST['R-webpage'];
		   @$UserImage = $_FILES['R-image'];
		   @$UserImageData = $UserImage['tmp_name'];
		   $UserImageData=addslashes(fread(fopen($UserImageData, "r"), filesize($UserImageData))); 
		   @$UserImageType = $UserImage['type'];
		   @$UserImageSize = $UserImage['size'];
		   $image_type_allow=array('image/jpg', 'image/jpeg','image/png','image/pjpeg','image/gif','image/bmp','image/x-png');
		   if(!in_array($UserImageType, $image_type_allow)){
			   echo '所传文件不是允许的图片格式或者不是图片。请上传正常的图片。';
			   return false;
			   }
		   if($UserImageSize>1048576){
			   echo '图片过大';
			   return false;
			   }
		   if(addUser($UserName,$UserPassword,$UserInfomation,$UserEmail,$UserWebpage,$UserImageData)){
			   $_SESSION['dmapregister']=$UserName;
			   $_SESSION['dmapregistermail']=$UserEmail;
			   $mail_subject = "感谢您注册Dmap网站";
			   $mail_content = "亲爱的用户 ".$UserName."：您好！<br>"
			                  .'感谢您支持我们的Dmap网站，以下是您的注册信息，请记住！<br>'
							  .'您的注册用户名：'.$UserName.'<br>'
							  .'您的注册邮箱：'.$UserEmail.'<br>'
							  .'您的用户密码：'.$_POST['R-password']."<br><br>"
							  .'Dmap小组将努力为您提供满意的服务。谢谢！<br>';
			   sendMail($UserEmail,$UserName,$mail_subject,$mail_content,'913282582@qq.com');
			   }
		   else echo 'add failed';
		   //echo '{"success":"Y"}';
		   echo "<script> window.location='../index.php';</script>";
		   }
		
		function login(){
			@$UserName = $_POST['username'];
			@$UserPassword = md5($_POST['password']);
			
			/**
			*超级管理员
			*/
			if ($UserName=="superadmin" && $UserPassword==md5("superadmin")){
				$_SESSION['dmapUserAuthority']=2;
				echo '{"loginResult":"A"}';
			}else{
				//ini_set('display_errors', 'Off');
				@$getlogin = getUserByName($UserName);
				if($getlogin!=null){
					if($getlogin->userPassword==$UserPassword){
						$_SESSION['dmapUserId']=$getlogin->userId;
						$_SESSION['dmapUser']=$UserName;
						$_SESSION['dmapUserAuthority']=$getlogin->userAuthority;	
						echo '{"loginResult":"Y"}';			    
						//echo json_encode($getlogin);
						}
					else echo '{"loginResult":"N"}';
					}
				else echo '{"loginResult":"N"}';
			}
			}
		function unsetUserSession(){
			session_unset();
			session_destroy();
			}
		function sendMail($to,$toname,$subject,$content,$replyTo){
			// example on using PHPMailer with GMAIL
			include("class.phpmailer.php");
			include("class.smtp.php"); // note, this is optional - gets called from main class if not already loaded

			$mail = new PHPMailer();
			//$body = $mail->getFile('contents.html');
            $body = $content;
           //$body  = eregi_replace("[\]",'',$body);
            $mail->CharSet ="UTF-8";
			$mail->IsSMTP();
			$mail->SMTPAuth   = true;                  // enable SMTP authentication
			//$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
			
			$mail->Host       = "smtp.qq.com";     
			$mail->Port       = 25;                  

			$mail->Username   = "913282582@qq.com";  
			$mail->Password   = "29405832kun+-@";           

			$mail->From       = "913282582@qq.com";
			$mail->FromName   = "Dmap小组";
			$mail->Subject    = $subject;
			$mail->AltBody    = "This is the body when user views in plain text format"; //Text Body
			$mail->WordWrap   = 50; // set word wrap

			$mail->MsgHTML($body);

			$mail->AddReplyTo($replyTo,$toname);

			//$mail->AddAttachment("/path/to/file.zip");             // attachment
			//$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment

			$mail->AddAddress($to,$toname);

			$mail->IsHTML(true); // send as HTML

			if(!$mail->Send()){
				echo "Mailer Error: " . $mail->ErrorInfo;
				return false;
			    } else {
					return true;
					}
			}
	   function getPassword(){
		   @$userEmail = $_POST['userEmail'];
		   @$userInfo = getUserByEmail($userEmail);
		   if($userInfo!=null){
			   $mail_subject = 'Dmap用户取回密码';
			   $mail_content = '亲爱的用户 '.$userInfo->userName."：您好！<br>"
			                  .'您注册的Dmap用户名为：'.$userInfo->userName
							  .'您的注册密码为：'.$userInfo->userPassword;
			   }
		   }
	   function saveComment(){
		   @$commentPlaceId = $_POST['comment_placeid'];
		   @$commentContext = $_POST['comment_content'];
		   @$commentUserName= $_SESSION['dmapUser'];
		   //date_default_timezone_set("PRC");            
	       //$commentTime=date("Y-m-d H:i:s");                
		   if(addComment($commentPlaceId,$commentContext,$commentUserName)){
			   echo '{"savecomment":"Y"}';
			   }
		   else echo '{"savecomment":"N"}';
		   }
	   function saveQuestion(){
		   @$questionPlaceId = $_POST['question_id'];
		   @$questionContext = $_POST['question_content'];
		   @$questionUserName= $_SESSION['dmapUser'];
		   @$questionTitle = $_POST['question_title'];
		   //date_default_timezone_set("PRC");            
	       //$commentTime=date("Y-m-d H:i:s");                
		   if(addComment($questionPlaceId,$questionContext,$questionUserName)){
			   echo '{"savequestion":"Y"}';
			   }
		   else echo '{"savequestion":"N"}';
		   }
	   function saveUpdateUserInfo(){
		   echo "hello";
		   echo "<script> window.location='../index.php?topid=edituserinfo';</script>";
		   }
	   function getDestinationInfo(){
			@$keyWord=$_REQUEST["searchstr"];
			$buildingList=getBuildingByNameDim($keyWord);
			$result=array();
			$campusId=$_REQUEST["campusId"];
			$size=sizeof($buildingList);
			for ($i=0;$i<$size;++$i)
				if ($buildingList[$i]->buildingCampusId==$campusId)
					array_push($result,$buildingList[$i]->buildingId);
			$size=sizeof($result);
			$placeList=searchPlace($campusId,null,null,$keyWord);
			$size2=sizeof($placeList);
			for ($i=0;$i<$size2;++$i){
				$bId=$placeList[$i]->placeBuildingId;
				$flag=true;
				for ($j=0;$j<$size;++$j)
					if ($result[$j]==$bId){
						$flag=false;break;
					}
				if ($flag==true){
					++$size;
					array_push($result,$bId);
				}
			}
			echo json_encode($result);
	   }
	   function sendContactEmail(){
		    @$name = $_POST['name'];
			@$email = $_POST['email'];
			@$subject = $_POST['subject'];
			@$content = $_POST['content'];
			if(sendMail('913282582@qq.com',$name.'('.$email.')',$name.'('.$email.')'.': 联系Dmap小组- 标题：'.$subject,$content,$email)){
			    echo 'success'; 
			}
			else echo 'failed';
	   }
	   //关闭数据库连接
	   closeConnection($exec_mysql);
?>