<?php
	/**地点数据表操作
		添加地点
		修改地点信息
		以Id获取地点
		获取某建筑物的某层的所有地点
		获取某建筑物的某层的所有地点Id列表
		删除一个地点
		删除某幢建筑所有地点
		精确查询某个地点
		模糊查询地点列表
	*/
	//添加地点：地点名称，地点所在校园，地点所在建筑，地点所在楼层，地点坐标，地点简介
	function addPlace($placeName,$placeCampusId,$placeBuildingId,$placeFloor,$placeX,$placeY,$placeIntroduce) {
		if (!addNode(($placeCampusId+100000),$placeX,$placeY)) return false;
		$placeNodeId=mysql_insert_id();
		if (!mysql_query("INSERT INTO tb_place (
			placeName,
			placeCampusId,
			placeBuildingId,
			placeFloor,
			placeIntroduce,
			placeNodeId
		)
		VALUES (
			'$placeName',
			'$placeCampusId',
			'$placeBuildingId',
			'$placeFloor',
			'$placeIntroduce',
			'$placeNodeId'
		)")) {
			return false;
		}
		return true;
	}
	//修改地点信息：地点Id，地点名称，地点简介
	function updatePlace($placeId,$placeName,$placeIntroduce) {
		if (!mysql_query("UPDATE tb_place SET 
			placeName='$placeName',
			placeIntroduce='$placeIntroduce'
			where placeId='$placeId'
		")){
			return false;
		}
		return true;
	}
	//以Id获取地点：地点Id
	function getPlaceById($placeId) {
		$result = mysql_query("SELECT placeName,placeCampusId,placeBuildingId,placeFloor,placeIntroduce,placeNodeId FROM tb_place where (placeId='$placeId')");
		if (!$place=mysql_fetch_object($result))
			return null;
		return $place;
	}
	//获取某建筑物的某层的所有地点：建筑Id，楼层
	function getFloorPlaceList($buildingId,$buildingFloor) {
		$result = mysql_query("SELECT placeId,placeName,placeIntroduce,placeNodeId FROM tb_place where placeBuildingId='$buildingId' and placeFloor='$buildingFloor'");
		$placeList=array();
		while ($placeItem=mysql_fetch_object($result)) {
			array_push($placeList,$placeItem);
		}
		return $placeList;
	}
	//获取某建筑物的某层的所有地点Id列表：建筑Id，楼层
	function getFloorPlaceIdList($buildingId,$buildingFloor) {
		$result = mysql_query("SELECT placeId FROM tb_place where placeBuildingId='$buildingId' and placeFloor='$buildingFloor'");
		$placeList=array();
		while ($placeItem=mysql_fetch_object($result)) {
			array_push($placeList,$placeItem->placeId);
		}
		return $placeList;
	}
	//删除一个地点：地点Id
	function removePlace($placeId) {
		$place=getPlaceById($placeId);
		if ($place==null) return true;
		elseif (!removeNode($place->placeNodeId)) return false;
		elseif (!removePlaceGame($placeId)) return false;
		elseif (!removePlaceComment($placeId)) return false;
		elseif (!removePlaceQuestion($placeId)) return false;
		elseif (!removePlaceTopic($placeId)) return false;
		elseif (!mysql_query("DELETE FROM tb_place WHERE placeId='$placeId'"))
			return false;
		return true;
	}
	//删除某幢建筑所有地点：建筑Id
	function removeBuildingPlace($buildingId) {
		$building=getBuildingById($buildingId);
		if ($building==null) return true;
		else
		for ($i=1;$i<=$building->buildingFloorNumber;++$i) {
			$buildingList=getFloorPlaceIdList($buildingId,$i);
			$size=sizeof($buildingList);
			for ($j=0;$j<$size;++$j)
				if (!removePlace($buildingList[$j]))
					return false;
		}
		return true;
	}
	//精确查询某个地点：校区Id，建筑Id，楼层，地点名称
	function searchPlacePrecisely($campusId,$buildingId,$buildingFloor,$placeName) {
		$where="placeCampusId='$campusId'";
		if ($buildingId!=null) $where.=" and placeBuildingId='$buildingId'";
		if ($buildingFloor!=null) $where.=" and placeFloor='$buildingFloor'";
		$where.=" and placeName='$placeName'";
		$result = mysql_query("SELECT placeId,placeName,placeCampusId,placeBuildingId,placeFloor,placeIntroduce,placeNodeId FROM tb_place where $where");
		if (!$place=mysql_fetch_object($result))
			return null;
		return $place;
	}
	//模糊查询地点列表：校区Id，建筑Id，楼层，地点名称
	function searchPlace($campusId,$buildingId,$buildingFloor,$placeName) {
		$where="placeCampusId='$campusId'";
		if ($buildingId!=null) $where.=" and placeBuildingId='$buildingId'";
		if ($buildingFloor!=null) $where.=" and placeFloor='$buildingFloor'";
		$where.=" and placeName LIKE '%$placeName%'";
		$result = mysql_query("SELECT placeId,placeName,placeCampusId,placeBuildingId,placeFloor,placeIntroduce,placeNodeId FROM tb_place where $where");
		$placeList=array();
		while ($placeItem=mysql_fetch_object($result)) {
			array_push($placeList,$placeItem);
		}
		return $placeList;
	}
?>