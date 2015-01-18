<?php
	/**评论数据表操作
		添加评论
		获取某地点评论
		删除评论
		删除某地点评论
	*/
	//添加评论：评论地点，评论内容，评论用户名
	function addComment($placeId,$context,$userName) {
		$user=getUserByName($userName);
		if (getPlaceById($placeId)==null || $context==null || $user==null)
			return false;
		if (!mysql_query("INSERT INTO tb_comment (
			commentPlaceId,
			commentContext,
			commentUserName,
			commentTime
		)
		VALUES (
			'$placeId',
			'$context',
			'$userName',
			'".time()."'
		)")) {
			return false;
		}
		addAction($user->userId,$placeId,"Comment",$context);
		return true;
	}
	//获取某地点评论：地点Id
	function getPlaceCommentList($placeId) {
		$result = mysql_query("SELECT commentId,commentContext,commentUserName,commentTime FROM tb_comment where (commentPlaceId='$placeId') order by commentId desc");
		$commentList=array();
		while ($commentItem=mysql_fetch_object($result)) {
			array_push($commentList,$commentItem);
		}
		return $commentList;
	}
	//删除评论：评论Id
	function removeComment($commentId) {
		if (!mysql_query("DELETE FROM tb_comment WHERE commentId='$commentId'"))
			return false;
		return true;
	}
	//删除某地点评论：地点Id
	function removePlaceComment($placeId) {
		if (!mysql_query("DELETE FROM tb_comment WHERE commentPlaceId='$placeId'"))
			return false;
		return true;
	}
?>