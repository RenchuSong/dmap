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
	$v=openConnection($exec_mysql);
	//获取该校区所有节点Id
	$nodeList=getCampusNodeIdList(safeParam(/*$_GET["nodeCampusId"]*/$_REQUEST["nodeCampusId"]));
	$size=sizeof($nodeList);
	//边列表
	$edgeList=array();
	for ($i=0;$i<$size;++$i) {
		$node1=$nodeList[$i];
		$linkList=getLinkNodeList($node1);
		$neighborSize=sizeof($linkList);
		for ($j=0;$j<$neighborSize;++$j)
			if ($linkList[$j]>$node1)
				array_push($edgeList,array($node1,$linkList[$j]));
	}
	//获取节点坐标列表
	$width=/*$_GET["width"];*/$_REQUEST["width"];
	$height=/*$_GET["height"];*/$_REQUEST["height"];
	$coordinateList=array();
	for ($i=0;$i<$size;++$i){
		$node=getNodeById($nodeList[$i]);
		array_push($coordinateList,array(round($width*$node->nodeX/100),round($height*$node->nodeY/100)));
	}
	//关闭数据库连接
	$v=closeConnection($exec_mysql);
	//结果Array
	$edgeSize=sizeof($edgeList);
	$pathList="";
	for ($i=0;$i<$edgeSize;++$i) {
		for ($j=0;$j<$size;++$j) {
			if ($nodeList[$j]==$edgeList[$i][0]) $node1=$j;
			if ($nodeList[$j]==$edgeList[$i][1]) $node2=$j;
		}
		$pathList.="|".$coordinateList[$node1][0]."|".$coordinateList[$node1][1]."|".
				   $coordinateList[$node2][0]."|".$coordinateList[$node2][1];
		/*array_push($pathList,
		array(
			'nodeX1'=>$coordinateList[$node1][0],
			'nodeY1'=>$coordinateList[$node1][1],
			'nodeX2'=>$coordinateList[$node2][0],
			'nodeY2'=>$coordinateList[$node2][1],
		));*/
	}
	echo $pathList;
?>