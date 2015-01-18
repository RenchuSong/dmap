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
	$user2=getUserByName($_SESSION["dmapUser"]);
	if (!strpos($user2->friendList,"|".$userId."|")){
?>
	<a class="addFriend" href="javascript:opFriend(<?php echo $userId; ?>,1);">添加为好友</a>
<?php
	}else{
?>
	<a class="addFriend" href="javascript:opFriend(<?php echo $userId; ?>,0);">解除好友关系</a>
<?php
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
?>