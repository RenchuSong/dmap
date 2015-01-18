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
	//数据库添加
	
	$file = '../game/'.time().'_'.rand(100000,200000).'_'.$_FILES['uploadfile']['name'];   
	if (!addGame(safeParam($_REQUEST["placeId"]),$file))
		echo " Error:删除失败";
	//关闭数据库连接
	closeConnection($exec_mysql);
	
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], mb_convert_encoding($file,"gb2312","utf-8"))) {  
		echo "success";  
	} else {  
		echo "error";  
	}
?>