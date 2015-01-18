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
	//显示节点
	$nodeList=getCampusNodeIdList($_POST["nodeCampusId"]);
	$size=sizeof($nodeList);
	for ($i=0;$i<$size;++$i) {
		$nodeItem=getNodeById($nodeList[$i]);
		$X=round($_POST["width"]*$nodeItem->nodeX/100-3);
		$Y=round($_POST["height"]*$nodeItem->nodeY/100-3);
		echo "<div id='nodeItem".$nodeList[$i]."' class='nodeItem' style='left:".$X."px;top:".$Y."px;'></div>";
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
?>