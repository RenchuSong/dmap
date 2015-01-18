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
	//选择建筑
	$building=getBuildingById(safeParam($_POST["buildingId"]));
	//生成select
	echo "<select id='selectFloor'>";
	for ($i=1;$i<=$building->buildingFloorNumber;++$i){
		echo "<option value='$i'>".$i."层</option>";
	}
	echo "</select>";
	//关闭数据库连接
	closeConnection($exec_mysql);
?>