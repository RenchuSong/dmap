<?php
	/**建筑数据表操作
		添加建筑
		修改建筑信息
		获取某校区所有建筑
		获取建筑信息
		删除一幢建筑
	*/
	//添加建筑：所在校区 Handan:1 Zhangjiang:2 Jiangwan:3 Fenglin:4，建筑名，建筑层数，建筑介绍
	function addBuilding($campusId,$buildingName,$floorNumber,$buildingIntroduce,$buildingX,$buildingY) {	
		if (!addNode($campusId,$buildingX,$buildingY)) return false;
		$buildingNodeId=mysql_insert_id();
		if (!mysql_query("INSERT INTO tb_building (
			buildingName,
			buildingCampusId,
			buildingFloorNumber,
			buildingIntroduce,
			buildingNodeId
		)
		VALUES (
			'$buildingName',
			'$campusId',
			'$floorNumber',
			'$buildingIntroduce',
			'$buildingNodeId'
		)")) {
			return false;
		}
		return true;
	}
	//修改建筑信息：建筑名，建筑层数，建筑介绍
	function updateBuilding($buildingId,$buildingName,$floorNumber,$buildingIntroduce) {
		if (!mysql_query("UPDATE tb_building SET 
			buildingName = '$buildingName',
			buildingFloorNumber = '$floorNumber',
			buildingIntroduce = '$buildingIntroduce'
			where buildingId='$buildingId'
		")){
			return false;
		}
		return true;
	}
	//获取某校区所有建筑：校区名
	function getCampusBuilding($campusId) {
		$result = mysql_query("SELECT buildingId,buildingName,buildingFloorNumber,buildingIntroduce FROM tb_building where (buildingCampusId='$campusId')");
		$arrAnswer=array();
		while ($itemBuilding=mysql_fetch_object($result)) {
			array_push($arrAnswer,$itemBuilding);
		}
		return $arrAnswer;
	}
	//获取建筑节点：建筑Id
	function getBuildingNodeId($buildingId) {
		$result = mysql_query("SELECT buildingNodeId FROM tb_building where (buildingId='$buildingId')");
		if (!$building=mysql_fetch_object($result))
			return null;
		return $building->buildingNodeId;
	}
	//获取建筑信息：建筑Id
	function getBuildingById($buildingId) {
		$result = mysql_query("SELECT buildingName,buildingCampusId,buildingFloorNumber,buildingIntroduce FROM tb_building where (buildingId='$buildingId')");
		if (!$building=mysql_fetch_object($result))
			return null;
		return $building;
	}
	//获取建筑信息：建筑名称
	function getBuildingByName($buildingName) {
		$result = mysql_query("SELECT buildingId,buildingCampusId,buildingFloorNumber,buildingIntroduce FROM tb_building where (buildingName='$buildingName')");
		if (!$building=mysql_fetch_object($result))
			return null;
		return $building;
	}
	//模糊查找建筑：建筑名称
	function getBuildingByNameDim($buildingName) {
		$result = mysql_query("SELECT buildingId,buildingCampusId,buildingFloorNumber,buildingIntroduce FROM tb_building where buildingName LIKE '%$buildingName%'");
		$buildingList=array();
		while ($buildingItem=mysql_fetch_object($result)){
			array_push($buildingList,$buildingItem);
		}
		return $buildingList;
	}
	//获取关联节点
	function getBuildingRelateNodeId($buildingId) {
		$result = mysql_query("SELECT buildingNodeId FROM tb_building where (buildingId='$buildingId')");
		if (!$building=mysql_fetch_object($result))
			return null;
		return $building->buildingNodeId;
	}
	//删除建筑：建筑Id
	function removeBuildingById($buildingId) {
		if (!removeNode(getBuildingRelateNodeId($buildingId)))
			return false;
		elseif (!removeBuildingPlace($buildingId))
			return false;
		elseif (!mysql_query("DELETE FROM tb_building WHERE buildingId='$buildingId'"))
			return false;
		return true;
	}
	//删除建筑：建筑名称
	function removeBuildingByName($buildingName) {
		$building=getBuildingByName($buildingName);
		if (!removeNode(getBuildingRelateNodeId($building->buildingId)))
			return false;
		elseif ($building==null) return true;
		elseif (!removeBuildingPlace($building->buildingId))
			return false;
		elseif (!mysql_query("DELETE FROM tb_building WHERE buildingName='$buildingName'"))
			return false;
		return true;
	}
	
?>