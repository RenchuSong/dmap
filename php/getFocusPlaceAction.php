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
	
	@$userId = @safeParam($_REQUEST['userId']);
	if($userId!=""){
		$focusPlaceId = focusPlaceIdList($userId);
		if(count($focusPlaceId)!=0){
			echo json_encode($focusPlaceId);
			}
		else echo '[]';
		}
	
	//关闭数据库连接
    closeConnection($exec_mysql);
?>