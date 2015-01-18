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
	//获取地点列表
	$placeList=getFloorPlaceList(safeParam($_POST["buildingId"]),safeParam($_POST["floor"]));
	$size=sizeof($placeList);
	for ($i=0;$i<$size;++$i) {
		$nodeItem=getNodeById($placeList[$i]->placeNodeId);
		$X=round($_POST["width"]*$nodeItem->nodeX/100);
		$Y=round($_POST["height"]*$nodeItem->nodeY/100);
		echo "<div id='placeItem".$placeList[$i]->placeId."' class='placeItem' style='left:".($X-15)."px;top:".($Y-20)."px;' title='".$placeList[$i]->placeName."'></div>";
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
?>