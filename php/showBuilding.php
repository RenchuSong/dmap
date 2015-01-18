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
	//显示建筑
	$buildingList=getCampusBuilding($_POST["nodeCampusId"]);
	$size=sizeof($buildingList);
	for ($i=0;$i<$size;++$i) {
		$buildingItem=getBuildingNodeId($buildingList[$i]->buildingId);
		$nodeItem=getNodeById($buildingItem);
		$X=round($_POST["width"]*$nodeItem->nodeX/100);
		$Y=round($_POST["height"]*$nodeItem->nodeY/100);
		//echo "<div id='nodeItem".$nodeList[$i]."' class='nodeItem' style='left:".$X."px;top:".$Y."px;'></div>";
		echo "<div id='buildingItem".$buildingList[$i]->buildingId."' class='buildingItem' style='left:".($X-15)."px;top:".($Y-20)."px;' title='".$buildingList[$i]->buildingName."'></div>";
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
?>