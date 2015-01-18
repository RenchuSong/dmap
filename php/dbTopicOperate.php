<?php
	/**话题数据表操作
		添加话题
		修改话题
		获取某话题
		获取某地点话题列表
		删除话题
		删除某地点话题
		关注/取消关注话题
	*/
	//添加话题：地点Id，话题主题，话题内容，发起人Id
	function addTopic($placeId,$topicTitle,$topicContext,$topicUserName) {
		$user=getUserByName($topicUserName);
		if (getPlaceById($placeId)==null || $topicTitle==null || $topicContext==null || $user==null)
			return false;

		if (!mysql_query("INSERT INTO tb_topic (
			topicPlaceId,
			topicTitle,
			topicContext,
			topicTime,
			topicUserName,
			joinUserList
		)
		VALUES (
			'$placeId',
			'$topicTitle',
			'$topicContext',
			'".time()."',
			'$topicUserName',
			'-|'
		)")) {
			echo mysql_error();
			return false;
		}
		$newId=recentInsertId();
		addAction($user->userId,$placeId,"Topic","[$newId]".$topicTitle);
		return true;
	}
	//修改话题：话题Id，话题主题，话题内容
	function updateTopic($topicId,$topicTitle,$topicContext) {
		if (!mysql_query("UPDATE tb_topic SET 
			topicTitle = '$topicTitle',
			topicContext = '$topicContext'
			where topicId='$topicId'
		")){
			return false;
		}
		return true;
	}
	//获取某话题：话题Id
	function getTopic($topicId) {
		$result = mysql_query("SELECT topicPlaceId,topicTitle,topicContext,topicTime,topicUserName,joinUserList FROM tb_topic where (topicId='$topicId')");
		if (!$topic=mysql_fetch_object($result))
			return null;
		return $topic;
	}
	//获取某地话题列表：地点Id
	function getPlaceTopicList($placeId) {
		$result = mysql_query("SELECT topicId,topicTitle,topicContext,topicTime,topicUserName,joinUserList FROM tb_topic where (topicPlaceId='$placeId') order by topicId desc");
		$topicList=array();
		while ($topicItem=mysql_fetch_object($result)) {
			array_push($topicList,$topicItem);
		}
		return $topicList;
	}
	//删除话题：话题Id
	function removeTopic($topicId) {
		if (!mysql_query("DELETE FROM tb_topic WHERE topicId='$topicId'"))
			return false;
		return true;
	}
	//删除某地点话题：地点Id
	function removePlaceTopic($placeId) {
		if (!mysql_query("DELETE FROM tb_topic WHERE topicPlaceId='$placeId'"))
			return false;
		return true;
	}

	//关注/取消关注话题
	function changeTopicJoin($userId,$topicId,$flag) {
		$result = mysql_query("SELECT topicTitle,topicPlaceId,joinUserList FROM tb_topic where (topicId='$topicId')");
		if (!$topic=mysql_fetch_object($result))
			return false;
		$joinUserList=$topic->joinUserList;
		$strSegment=$userId."|";
		if ($flag=="Add") {
			if (!strpos($joinUserList,"|".$strSegment)){
				$joinUserList.=$strSegment;
				if (!mysql_query("UPDATE tb_topic SET 
					joinUserList = '$joinUserList'
					where topicId='$topicId'
				")){
					return false;
				}
			}else return false;
			addAction($userId,$topic->topicPlaceId,"Join","[$topicId]话题：".$topic->topicTitle);
		}
		elseif($flag=="Delete") {
			$pos=strpos($joinUserList,"|".$strSegment);
			if ($pos>0){
				$joinUserList=substr_replace($joinUserList,"",$pos+1,strlen($strSegment));
				if (!mysql_query("UPDATE tb_topic SET 
					joinUserList = '$joinUserList'
					where topicId='$topicId'
				")){
					return false;
				}
			}else return false;
		}
		return true;
	}
?>