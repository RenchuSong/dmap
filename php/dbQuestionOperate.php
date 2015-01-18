<?php
	/**提问数据表操作
		添加提问
		获取某地点提问列表
		获取某地点提问Id列表
		删除提问
		删除某地点所有提问
	*/
	//添加提问：提问地点，提问内容，提问用户名
	function addQuestion($placeId,$context,$userName) {
		$user=getUserByName($userName);
		if (getPlaceById($placeId)==null || $context==null || $user==null)
			return false;
		if (!mysql_query("INSERT INTO tb_question (
			questionPlaceId,
			questionContext,
			questionTime,
			questionUserName
		)
		VALUES (
			'$placeId',
			'$context',
			'".time()."',
			'$userName'
		)")) {
			return false;
		}
		$insId=recentInsertId();
		addAction($user->userId,$placeId,"Question","[$insId]".$context);
		return true;
	}
	//获取某个评论
	function getQuestionById($questionId) {
		$result = mysql_query("SELECT questionId,questionContext,questionTime,questionUserName FROM tb_question where questionId='$questionId'");
		if ($question=mysql_fetch_object($result)) {
			return $question;
		}else
		return null;
	}
	
	//获取某地点提问列表：地点Id
	function getPlaceQuestionList($placeId) {
		$result = mysql_query("SELECT questionId,questionContext,questionTime,questionUserName FROM tb_question where (questionPlaceId='$placeId') ORDER BY questionId desc");
		$questionList=array();
		while ($questionItem=mysql_fetch_object($result)) {
			array_push($questionList,$questionItem);
		}
		return $questionList;
	}
	//获取某地点提问Id列表：地点Id
	function getPlaceQuestionIdList($placeId) {
		$result = mysql_query("SELECT questionId FROM tb_question WHERE (questionPlaceId='$placeId') ORDER BY questionId desc");
		$questionIdList=array();
		while ($questionItem=mysql_fetch_object($result)) {
			array_push($questionIdList,$questionItem->questionId);
		}
		return $questionIdList;
	}
	//删除提问：提问Id
	function removeQuestion($questionId) {
		if (!removeQuestionAnswer($questionId))
			return false;
		elseif (!mysql_query("DELETE FROM tb_question WHERE questionId='$questionId'"))
			return false;
		return true;
	}
	//删除某地点所有评论：地点Id
	function removePlaceQuestion($placeId) {
		$questionIdList=getPlaceQuestionIdList($placeId);
		$size=sizeof($questionIdList);
		for ($i=0;$i<$size;++$i)
			if (!removeQuestionAnswer($questionIdList[$i]))
				return false;
		if (!mysql_query("DELETE FROM tb_question WHERE questionPlaceId='$placeId'"))
			return false;
		return true;
	}
?>