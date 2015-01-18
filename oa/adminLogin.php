<?php
	session_start();
	if ((isset($_SESSION['dmapUserAuthority'])) &&  ($_SESSION['dmapUserAuthority']!="0"))
		header("location: ./adminMapData.php");
?>
<!DOCTYPE html PUBLIC
"-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="zh-cn" />
		<link rel="stylesheet" type="text/css" href="../css/admin.css" />
		<link rel="stylesheet" type="text/css" href="../css/adminDialog.css" />
		<script type="text/javascript" src="../js/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="../js/md5.js"></script>
		<script type="text/javascript" src="../js/admin.js"></script>
		<title>DMap后台管理-管理员登陆</title>
	</head>
	<body>
		<div id="mainFrame" style="width:500px;height:250px;margin-top:108px;">
			<div class="adminDialog" style="margin-left:40px;margin-top:50px;">
				<div class="dialogItem" style="height:50px;">管理员账号：</div><div class="dialogItemValue"><input type="text" class="adminDialogText" id="adminName" value="" /></div>
				<div class="clear"></div>
				<div class="dialogItem" style="height:50px;">管理员口令：</div><div class="dialogItemValue"><input type="password" class="adminDialogText" id="adminPassword" value="" /></div>
				<div class="clear"></div>
			</div>
			<div class="dialogItem">&nbsp;</div>
			<div class="dialogItem"><a id="submitBuildingData" class="adminDialogButton" onclick="adminLogin();" >登陆</a></div>
			<div class="dialogItem">&nbsp;</div>
			<div class="dialogItem"><a id="submitBuildingData" class="adminDialogButton" href="../index.php" >主界面</a></div>
		</div>
	</body>
</html>