<?php
	/**游戏数据表操作
		添加游戏
		修改游戏信息
		获取游戏
		获取某地点游戏列表
		删除游戏
		删除某地点游戏
	*/
	//添加游戏：游戏所在地点，游戏地址
	function addGame($placeId,$url) {
		if (!mysql_query("INSERT INTO tb_game (
			gamePlaceId,
			gameProgramURL
		)
		VALUES (
			'$placeId',
			'$url'
		)")) {
			return false;
		}
		return true;
	}
	//修改游戏信息：游戏地址
	function updateGame($gameId,$newURL) {
		if (!mysql_query("UPDATE tb_game SET 
			gameProgramURL = '$newURL'
			where gameId='$gameId'
		")){
			return false;
		}
		return true;
	}
	//获取游戏：游戏Id
	function getGame($gameId) {
		$result = mysql_query("SELECT gamePlaceId,gameProgramURL FROM tb_game where (gameId='$gameId')");
		if (!$game=mysql_fetch_object($result))
			return null;
		return $game;
	}
	//获取某地点游戏列表：地点Id
	function getPlaceGameList($placeId) {
		$result = mysql_query("SELECT gameId,gameProgramURL FROM tb_game where (gamePlaceId='$placeId')");
		$gameList=array();
		while ($gameItem=mysql_fetch_object($result)) {
			array_push($gameList,$gameItem);
		}
		return $gameList;
	}
	//删除游戏：游戏Id
	function removeGame($gameId) {
		if (!mysql_query("DELETE FROM tb_game WHERE gameId='$gameId'"))
			return false;
		return true;
	}
	//删除某地点游戏：地点Id
	function removePlaceGame($placeId) {
		if (!mysql_query("DELETE FROM tb_game WHERE gamePlaceId='$placeId'"))
			return false;
		return true;
	}
?>