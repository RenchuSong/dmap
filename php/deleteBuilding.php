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
	//删除节点
	if (removeBuildingById(safeParam($_POST["buildingId"])))
		echo "删除成功";
	else echo "删除失败";
	//关闭数据库连接
	closeConnection($exec_mysql);
?>