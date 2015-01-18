<!DOCTYPE html PUBLIC
"-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="zh-cn" />
	</head>
	<body>
<?php
	/**用户身份验证
	*/
	@include("../php/userVerify.php");
	if (!userIsAdmin()) {
		echo "非管理员禁止数据库操作";
		exit;
	}
	
	/**
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("../php/dbBasicOperate.php");
	@include("../php/dbNodeOperate.php");

	//获取数据库连接
	$exec_mysql=getConnection();
	//打开数据库连接
	openConnection($exec_mysql);
	//处理校区数据
	$campusId=safeParam($_REQUEST["campusId"]);
	//获取节点列表
	$nodeIdList=getCampusNodeIdList($campusId);
	//打开文件
	$file_name = "./Campus_".$campusId.".txt";
	$file_pointer = fopen($file_name, "w"); 
	//输出节点个数
	$size=sizeof($nodeIdList);
	fwrite($file_pointer, $size."\n"); 
	//输出节点Id和位置
	for ($i=0;$i<$size;++$i){
		$node=getNodeById($nodeIdList[$i]);
		fwrite($file_pointer, $nodeIdList[$i]." ".$node->nodeX." ".$node->nodeY."\n"); 
	}
	//输出节点关联节点列表
	for ($i=0;$i<$size;++$i){
		$linkList=getLinkNodeList($nodeIdList[$i]);
		$sizeList=sizeof($linkList);
		fwrite($file_pointer, $nodeIdList[$i]." ".$sizeList." ");
		for ($j=0;$j<$sizeList;++$j)
			fwrite($file_pointer, $linkList[$j]." "); 
		fwrite($file_pointer, "\n"); 
	}
	
	fclose($file_pointer); 
	//关闭数据库连接
	closeConnection($exec_mysql);
	exec("main.exe");
	echo "操作成功";
?>
	</body>
</html>