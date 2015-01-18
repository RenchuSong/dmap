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
	//选择某校区所有建筑
	$buildingList=getCampusBuilding(safeParam($_POST["campusId"]));
	//生成select
	$size=sizeof($buildingList);
	echo "<select id='selectBuildingId'>";
	echo "<option value='-1'>请选择建筑</option>";
	for ($i=0;$i<$size;++$i){
		echo "<option value='".$buildingList[$i]->buildingId."'>".$buildingList[$i]->buildingName."</option>";
	}
	echo "</select>";
	//关闭数据库连接
	closeConnection($exec_mysql);
?>