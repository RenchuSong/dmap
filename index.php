<?php
	session_start();
	//注册时的session: $_SESSION['userregister']=userName 注册后暂时保存，用作注册后的操作：比如登录，弹出信息
	//登录后的session: $_SESSION['dmapUserId']=$getlogin->userId; 当前登录用户的id
	//				   $_SESSION['dmapUser']=$UserName;  当前登录用户的名字
	//				   $_SESSION['dmapUserAuthority']=$getlogin->userAuthority; 当前登录用户的权限
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Welcome to Dmap</title>
	<link type="text/css" rel="stylesheet" href="./css/style.css">
	<link type="text/css" rel="stylesheet" href="./css/dialog.css" />
	<link type="text/css" rel="stylesheet" href="./css/map.css" />
	<link type="text/css" rel="stylesheet" href="./css/userSpace.css" />

	<script language="javascript" src="./js/jquery-1.6.min.js"></script>
	<script language="javascript" src="./js/function.js"></script>
	<script language="javascript" src="./js/showThePath.js"></script>
	<script language="javascript" src="./js/md5.js"></script>

	<script language="javascript" src="./js/dialog.js"></script>
	<script language="javascript" src="./js/register.js"></script>
	<script language="javascript" src="./js/mapControl.js"></script>
	<script language="javascript" src="./js/insideBuilding.js"></script>
	<script language="javascript" src="./js/mySpace.js"></script>
</head>

<!--body onload="initialize();"-->
<body>
<?php if (isset($_GET["placeid"])){ ?>
<script language="javascript">selectflag=true;</script>
<?php } ?>
<?php require_once("function.php"); ?>
<?php addDialog(); ?>
<?php addImageDialog(); ?>
<script language="javascript">
	$("#fullbg").css("opacity","0.5");
	$("#fullbgImage").css("opacity","0.5");
</script>
<?php registerDone(); ?>
<div id="tempDiver" style="position:absolute;border:2px solid yellow;font-size:14px;font-weight:bold;color:yellow;padding:2px;z-index:10000;"></div>
<script language="javascript">$("#tempDiver").css("opacity","0");</script>
<div id="top-nav">
     <div id="topmain">
     <?php require_once("topmenu.php");?>
     <div id="userInfo"><?php getUserInfo(); ?></div>
     </div>	
</div>
<script language="javascript">
	$("#userInfo").css("left",352-parseInt($("#userInfo").width()));
<?php
	switch(@$_GET['topid']){
		 case 'home':$whichToReco= "topmenu-home";break;
		 case 'help':$whichToReco="topmenu-help";break;
		 case 'contact':$whichToReco="topmenu-contact";break;
		 case 'myspace':case 'userinfo':case 'userspots':case 'userfriends':case 'edituserinfo':$whichToReco="topmenu-myspace";break;
		 default:$whichToReco="topmenu-home";
	}
?>
	$("#<?php echo $whichToReco; ?>").attr("class","LinkOver");
	$("#<?php echo $whichToReco; ?>").css("color","yellow");
</script>
<div class="mainwrapper">
<?php
    switch(@$_GET['topid']){
		case 'home':require_once("home.home.php");break;
		case 'help':require_once("home.help.php");break;
		case 'contact':require_once("home.contact.php");break;
		case 'myspace':require_once("home.myspace.php");break;
		case 'userinfo':require_once("home.myspace.php");break;
		case 'userspots':require_once("home.myspace.php");break;
		case 'userfriends':require_once("home.myspace.php");break;
		case 'edituserinfo':require_once("home.myspace.php");break;
		default:require_once("home.home.php");
	}
?>
</div>
<div class="clear"></div>
<div id="footer">www.dmap.com</div>
</body>
</html>