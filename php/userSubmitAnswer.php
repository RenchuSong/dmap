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
	$questionId=safeParam($_POST["questionId"]);
	$answer=safeParam($_POST["answer"]);
	if (addAnswer($questionId,$answer,$_SESSION["dmapUser"])) echo "_success";
	else echo "操作失败~";
	//关闭数据库连接
	closeConnection($exec_mysql);
?>	