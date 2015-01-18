<?php
	session_start();
	/**用户身份验证
	*/
	if (!isset($_SESSION["dmapUser"]) || $_SESSION["dmapUser"]==""){
		echo "只有登录用户才能使用DMap的社交功能哦~";
		exit;
	}
	/**
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("./dbOperate.php");
	//获取数据库连接
	$exec_mysql=getConnection();
	//打开数据库连接
	openConnection($exec_mysql);
	//获取客户端数据
	$placeId=safeParam($_POST["placeId"]);
	$title=safeParam($_POST["title"]);
	$introduce=safeParam($_POST["introduce"]);
	$topictime=safeParam($_POST["topictime"]);
	$organizer=safeParam($_POST["organizer"]);
	$notice=safeParam($_POST["notice"]);
	$content="<span style=\'line-height:25px;\'><b>活动名称：</b></span>".$title."<br/>";
	if ($topictime!="") $content.="<span style=\'line-height:25px;\'><b>活动时间：</b></span>".$topictime."<br/>";
	if ($organizer!="") $content.="<span style=\'line-height:25px;\'><b>主办单位：</b></span>".$organizer."<br/>";
	if ($introduce!="") $content.="<span style=\'line-height:25px;\'><b>活动简介：</b></span>".$introduce."<br/>";
	if ($notice!="") $content.="<span style=\'line-height:25px;\'><b>注意事项：</b></span>".$notice."<br/><br/>";
	echo $placeId." ".$title." ".$content." ".$_SESSION["dmapUser"];
	if (addTopic($placeId,$title,$content,$_SESSION["dmapUser"])) echo "_success";
	else echo "操作失败~";
	//关闭数据库连接
	closeConnection($exec_mysql);
?>	