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
	//显示地点评论
	$questionList=getPlaceQuestionList(safeParam($_POST["placeId"]));
	$size=sizeof($questionList);
	for ($i=0;$i<$size;++$i){
?>
	<div class="actionItem" id="actionItem<?php echo $questionList[$i]->questionId; ?>">
		<?php echo $questionList[$i]->questionUserName; ?> 有疑问：<?php echo $questionList[$i]->questionContext ?>
		<div class="clear"></div>
		<a class="deleteAction" href="javascript:deleteQuestion(<?php echo $questionList[$i]->questionId; ?>)">删除</a>
	</div>
<?php
	}
	if ($size==0) echo "本地点暂无提问";
	//关闭数据库连接
	closeConnection($exec_mysql);
?>	