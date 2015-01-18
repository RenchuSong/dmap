<?php
	/**动态数据表操作
		添加动态
		获取某用户的所有动态
		获取某地点的所有动态
	*/
	//添加动态：动态用户Id，动态地点Id，动态类型，动态内容
	function addAction($userId,$placeId,$actionDiscribe,$actionIntroduce) {
		if (getPlaceById($placeId)==null || $actionDiscribe==null || getUserById($userId)==null)
			return false;
		if ($actionDiscribe=="Focus")
			$actionType=1;
		elseif ($actionDiscribe=="Comment")
			$actionType=2;
		elseif ($actionDiscribe=="Question")
			$actionType=3;
		elseif ($actionDiscribe=="Topic")
			$actionType=4;
		elseif ($actionDiscribe=="Join")
			$actionType=5;
		if (!mysql_query("INSERT INTO tb_action (
			actionUserId,
			actionPlaceId,
			actionType,
			actionIntroduce,
			actionTime
		)
		VALUES (
			'$userId',
			'$placeId',
			'$actionType',
			'$actionIntroduce',
			'".time()."'
		)")) {
			return false;
		}
		return true;
	}
	//获取某条动态
	function getActionById($actionId){
		$result = mysql_query("SELECT actionUserId,actionPlaceId,actionType,actionIntroduce,actionTime FROM tb_action where actionId='$actionId'");
		if (!($actionItem=mysql_fetch_object($result))) {
			return null;
		}
		return $actionItem;
	}
	
	//获取某用户所有动态Id列表：用户Id
	function getUserActionIdList($userId) {
		$result = mysql_query("SELECT actionId FROM tb_action where actionUserId='$userId' order by actionId desc");
		$actionList=array();
		while ($actionItem=mysql_fetch_object($result)) {
			array_push($actionList,$actionItem->actionId);
		}
		return $actionList;
	}
	
	//获取某用户所有动态：用户Id, start=-1表示获取全部
	function getUserActionList($userId,$startId,$number) {
		if ($number>-1) $offset=" limit $number";
			else $offset="";
		if ($startId>-1) $stt=" and actionId<'$startId'";
			else $stt="";
		$result = mysql_query("SELECT actionId,actionUserId,actionType,actionIntroduce,actionTime FROM tb_action where actionUserId='$userId' $stt order by actionId desc".$offset);
		$actionList=array();
		while ($actionItem=mysql_fetch_object($result)) {
			array_push($actionList,$actionItem);
		}
		return $actionList;
	}
	
	//获取某地点所有动态Id列表：地点Id
	function getPlaceActionIdList($placeId) {
		$result = mysql_query("SELECT actionId FROM tb_action where actionPlaceId='$placeId' order by actionId desc");
		$actionList=array();
		while ($actionItem=mysql_fetch_object($result)) {
			array_push($actionList,$actionItem->actionId);
		}
		return $actionList;
	}
	
	//获取某地点所有动态：用户Id, start=-1表示获取全部
	function getPlaceActionList($placeId,$startId,$number) {
		if ($number>-1) $offset=" limit $number";
			else $offset="";
		if ($startId>-1) $stt=" and actionId<'$startId'";
			else $stt="";
		$result = mysql_query("SELECT actionId,actionUserId,actionType,actionIntroduce,actionTime FROM tb_action where actionPlaceId='$placeId' $stt order by actionId desc".$offset);
		$actionList=array();
		while ($actionItem=mysql_fetch_object($result)) {
			array_push($actionList,$actionItem);
		}
		return $actionList;
	}
?>