<?php
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
	$buildingList=getCampusBuilding($_REQUEST["campusId"]);
	$size=sizeof($buildingList);
	for ($i=0;$i<$size;++$i) {
		$buildingItem=getBuildingNodeId($buildingList[$i]->buildingId);
		$nodeItem=getNodeById($buildingItem);
		$X=round($_REQUEST["width"]*$nodeItem->nodeX/100);
		$Y=round($_REQUEST["height"]*$nodeItem->nodeY/100);
		echo "<div id='buildingItem".$buildingList[$i]->buildingId."' class='buildingItem' style='left:".($X-30)."px;top:".($Y-15)."px;' title='".$buildingList[$i]->buildingName."' onmouseover='showBuildingIcon(".$buildingList[$i]->buildingId.");'  onmouseout='hideBuildingIcon(".$buildingList[$i]->buildingId.");'></div>";
		echo "<div id='buildingItem_Find_".$buildingList[$i]->buildingId."' class='buildingItem2' style='left:".($X-30)."px;top:".($Y-15)."px;'></div>";
	
		echo "<input type='hidden' id='nodex_".$buildingList[$i]->buildingId."' value='".$nodeItem->nodeX."' />";
		echo "<input type='hidden' id='nodey_".$buildingList[$i]->buildingId."' value='".$nodeItem->nodeY."' />";
		echo "<input type='hidden' id='buildingname_".$buildingList[$i]->buildingId."' value='".$buildingList[$i]->buildingName."' />";
		echo "<input type='hidden' id='buildingintroduce_".$buildingList[$i]->buildingId."' value='".$buildingList[$i]->buildingIntroduce."' />";
		
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
?>