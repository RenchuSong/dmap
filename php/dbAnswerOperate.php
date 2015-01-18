<?php
	/**回答数据表操作
		添加回答
		获取某问题回答列表
		获取某提问回答Id列表
		删除回复
		删除某问题所有回答
	*/
	//添加回复：回复问题Id，回复内容，回复用户名
	function addAnswer($questionId,$context,$userName) {
		if ($questionId==null || $context==null || getUserByName($userName)==null)
			return false;
		if (!mysql_query("INSERT INTO tb_answer (
			answerQuestionId,
			answerContext,
			answerTime,
			answerUserName
		)
		VALUES (
			'$questionId',
			'$context',
			'".time()."',
			'$userName'
		)")) {
			return false;
		}
		return true;
	}
	//获取某问题回答列表：问题Id
	function getQuestionAnswerList($questionId) {
		$result = mysql_query("SELECT answerId,answerContext,answerTime,answerUserName FROM tb_answer where (answerQuestionId='$questionId') ORDER BY answerId desc");
		$answerList=array();
		while ($answerItem=mysql_fetch_object($result)) {
			array_push($answerList,$answerItem);
		}
		return $answerList;
	}
	//获取某问题回答Id列表：问题Id
	function getQuestionAnswerIdList($questionId) {
		$result = mysql_query("SELECT answerId FROM tb_answer where (answerQuestionId='$questionId')");
		$answerIdList=array();
		while ($answerItem=mysql_fetch_object($result)) {
			array_push($answerIdList,$answerItem->answerId);
		}
		return $answerIdList;
	}
	//删除回答：回答Id
	function removeAnswer($answerId) {
		if (!mysql_query("DELETE FROM tb_answer WHERE answerId='$answerId'"))
			return false;
		return true;
	}
	//删除某问题所有回答：问题Id
	function removeQuestionAnswer($questionId) {
		if (!mysql_query("DELETE FROM tb_answer WHERE answerQuestionId='$questionId'"))
			return false;
		return true;
	}
?>