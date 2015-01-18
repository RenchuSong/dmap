<?php
	session_start();
	if (!isset($_SESSION["dmapUserId"])){
		echo "只有登录用户才能享受到DMap的社交功能哦~";
		exit;
	}else
	$userId=$_SESSION["dmapUserId"];
	/**
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("./dbOperate.php");
	//获取数据库连接
	$exec_mysql=getConnection();
	//打开数据库连接
	openConnection($exec_mysql);
	//添加关注
	$placeId=safeParam($_POST["placeId"]);
	if ($_POST["flag"]==1) $flag="Add";else $flag="Delete";
	if (changeFocus($userId,$placeId,$flag)) echo "success";
	else echo "操作失败~";
	//关闭数据库连接
	closeConnection($exec_mysql);
?>