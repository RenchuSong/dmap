<?php 
     /**
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("./dbOperate.php");
	//获取数据库连接
	@$exec_mysql=getConnection();
	//打开数据库连接
	@openConnection($exec_mysql);
	
	@$userId = $_REQUEST['userId'];
	$friends = friendIdList($userId);
	$userNameList=array();
	$size=sizeof($friends);
	for ($i=0;$i<$size;++$i){
		$friendItem=getUserById($friends[$i]);
		array_push($userNameList,$friendItem->userName);
	}
	$result=array(
		"Id" => $friends,
		"Title" => $userNameList
	);
	echo json_encode($result);

	
	//关闭数据库连接
    closeConnection($exec_mysql);
?>