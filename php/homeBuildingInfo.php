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
	//获取建筑
	$building=getBuildingById(safeParam($_REQUEST["buildingId"]));
	//关闭数据库连接
	closeConnection($exec_mysql);
?>
<input type="hidden" id="thisBuildingName" value="<?php echo $building->buildingName; ?>" />
<input type="hidden" id="thisBuildingFloor" value="<?php echo $building->buildingFloorNumber; ?>" />
<input type="hidden" id="thisBuildingIntroduce" value="<?php echo $building->buildingIntroduce; ?>" />