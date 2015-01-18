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
	$userId=$_REQUEST["userId"];
	//数据库操作
	$actionIdList=array();
	$userFocusList=focusPlaceIdList($userId);
	$size=sizeof($userFocusList);
	for ($i=0;$i<$size;++$i){
		$actionListItem=getPlaceActionIdList($userFocusList[$i]);
		$actionIdList=array_merge($actionIdList,$actionListItem);
		//array_push($actionIdList,$actionListItem);
	}
	$userFriendList=friendIdList($userId);
	$size=sizeof($userFriendList);
	for ($i=0;$i<$size;++$i){
		$actionListItem=getUserActionIdList($userFriendList[$i]);
		$actionIdList=array_merge($actionIdList,$actionListItem);
		//array_push($actionIdList,$actionListItem);
	}
	$actionIdList=array_unique($actionIdList);
	rsort($actionIdList);
	echo json_encode($actionIdList);
	//关闭数据库连接
	closeConnection($exec_mysql);
?>