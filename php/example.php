<?php
	//引入数据库操作程序文件
	@include("./dbOperate.php");
	//获取数据库连接
	$exec_mysql=getConnection();
	//打开数据库连接
	openConnection($exec_mysql);
	
	//数据库操作（示例）
	/**********************************************************************************
		特别注意：为了使数据库不被注入，请对数据库操作参数使用safeParam()函数进行处理
	**********************************************************************************/
	/*addUser(
		safeParam("testUser"),
		safeParam("这里应该是在客户端md5加密后的密码"),
		safeParam("用户信息"),
		safeParam("test@sina.com"),
		safeParam(http://testUrl")
	);*/
        $user=getNewsByid(19);
        echo json_encode($user);
		//$news=getNewsByid(18);
		$news=getPageNews(1,4);
		echo json_encode($news);
	
	//关闭数据库连接
	closeConnection($exec_mysql);
?>