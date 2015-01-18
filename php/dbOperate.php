<?php
	@include("./dbBasicOperate.php");
	
	/**用户数据表操作
		添加用户
		修改用户信息
		获取用户信息
		设置用户权限(普通/管理员/超级管理员)
		添加/删除好友
		添加/删除关注地点
		设置用户的状态(未验证、验证、冻结、删除)
		获取朋友Id列表
	*/
	@include("./dbUserOperate.php");
	
	/**建筑数据表操作
		添加建筑
		修改建筑信息
		获取建筑信息
		删除一幢建筑
	*/
	@include("./dbBuildingOperate.php");
	
	/**节点数据表操作
		添加节点
		修改节点
		根据Id获取节点
		获取某校区所有节点Id列表
		删除节点
		添加连接路径
	*/
	@include("./dbNodeOperate.php");
	
	/**地点数据表操作
		添加地点
		修改地点信息
		获取地点信息
		获取某建筑物的某层的所有地点
		获取某建筑物的某层的所有地点Id列表
		删除一个地点
		删除某幢建筑所有地点
		精确查询某个地点
		模糊查询地点列表
	*/
	@include("./dbPlaceOperate.php");
	
	/**游戏数据表操作
		添加游戏
		修改游戏信息
		获取游戏
		获取某地点游戏列表
		删除游戏
		删除某地点游戏
	*/
	@include("./dbGameOperate.php");
	
	/**评论数据表操作
		添加评论
		获取某地点评论
		删除评论
		删除某地点评论
	*/
	@include("./dbCommentOperate.php");
	
	/**提问数据表操作
		添加提问
		获取某地点提问列表
		获取某地点提问Id列表
		删除提问
		删除某地点所有提问
	*/
	@include("./dbQuestionOperate.php");
	
	/**回答数据表操作
		添加回答
		获取某问题回答列表
		获取某提问回答Id列表
		删除回复
		删除某问题所有回答
	*/
	@include("./dbAnswerOperate.php");
	
	/**话题数据表操作
		添加话题
		修改话题
		获取某话题
		获取某地点话题列表
		删除话题
		删除某地点话题
		关注话题
	*/
	@include("./dbTopicOperate.php");
	
	/**动态数据表操作
		添加动态
		获取某用户的所有动态
		获取某地点的所有动态
	*/
	@include("./dbActionOperate.php");
	
	/**新闻操作
		添加新闻
		获取新闻
		修改新闻
		删除新闻
	*/
	@include("./dbNewsOperate.php");
?>