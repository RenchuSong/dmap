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
	//获取看是否有同名建筑
	if (trim($_POST["selectBuilding"]=="")){
		$building=getBuildingByName(trim($_POST["buildingName"]));
		if ($building!=null) {
				echo " Error:您不能添加相同名字的建筑！";
			closeConnection($exec_mysql);
			exit;
		}
	}
	if ($_POST["selectBuilding"]!=""){
		$building=getBuildingById(($_POST["selectBuilding"]));
		if ($building!=null){
			echo "_Update";
			echo $_POST["buildingName"];
			updateBuilding(($_POST["selectBuilding"]),trim($_POST["buildingName"]),trim($_POST["buildingFloor"]),trim($_POST["buildingIntroduce"]));
		}
	}else{
		//添加节点
		addBuilding(($_POST["nodeCampusId"]),
					($_POST["buildingName"]),($_POST["buildingFloor"]),($_POST["buildingIntroduce"]),
					($_POST["nodeX"]),($_POST["nodeY"]));
		//返回插入节点编号
		echo recentInsertId();
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
?>	