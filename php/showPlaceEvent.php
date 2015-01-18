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
	//显示地点话题
	$topicList=getPlaceTopicList(safeParam($_POST["placeId"]));
	$size=sizeof($topicList);
	for ($i=0;$i<$size;++$i){
?>
	<div class="actionItem" id="actionItem<?php echo $topicList[$i]->topicId; ?>">
		<?php echo $topicList[$i]->topicUserName; ?> 发表话题：<?php echo $topicList[$i]->topicContext ?>
		<div class="clear"></div>
		<a class="deleteAction" href="javascript:deleteTopic(<?php echo $topicList[$i]->topicId; ?>)">删除</a>
	</div>
<?php
	}
	if ($size==0) echo "本地点暂无话题";
	//关闭数据库连接
	closeConnection($exec_mysql);
?>	