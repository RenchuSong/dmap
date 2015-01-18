<?php
	session_start();
	if (!isset($_SESSION["dmapUser"])){
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
	//客服端数据
	$actionId=$_REQUEST["actionId"];
	//数据库操作
	echo json_encode(getActionById($actionId));
	//关闭数据库连接
	closeConnection($exec_mysql);
?>