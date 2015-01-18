<?php
	/**用户身份验证
	*/
	@include("./userVerify.php");
	if (!userIsAdmin()) {
		echo "非管理员禁止数据库操作";
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
	//添加节点
	addNode(safeParam($_POST["nodeCampusId"]),safeParam($_POST["nodeX"]),safeParam($_POST["nodeY"]));
	//返回插入节点编号
	echo recentInsertId();
	//关闭数据库连接
	closeConnection($exec_mysql);
?>