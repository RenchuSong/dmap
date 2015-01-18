<?php
	/**用户身份验证
	*/
	@include("./userVerify.php");
	if (!userIsAdmin()) {
		echo "非管理员禁止数据库操作";
		exit;
	}
	date_default_timezone_set ('Asia/Shanghai');
	/**
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("./dbOperate.php");
	//获取数据库连接
	$exec_mysql=getConnection();
	//打开数据库连接
	openConnection($exec_mysql);
	//显示新闻
	$newsList=getPageNews(1,10000);
	$size=sizeof($newsList);
	for ($i=0;$i<$size;++$i) {
?>
	<div class="newsItem">
		<h3 id="newsTitle<?php echo $newsList[$i]->newsId; ?>"><?php echo $newsList[$i]->newsTitle ?></h3>
		<p>发布于 <?php echo date("Y-m-d H:i:s",$newsList[$i]->newsTime); ?></p>
		<div id="newsContext<?php echo $newsList[$i]->newsId; ?>"><?php echo $newsList[$i]->newsContext ?></div>
		<div style="width:60px;float:left;"><a class="adminDialogButton" href="javascript:editNews(<?php echo $newsList[$i]->newsId; ?>);">编辑</a></div>
		<div style="width:60px;float:left;"><a class="adminDialogButton" href="javascript:deleteNews(<?php echo $newsList[$i]->newsId; ?>);">删除</a></div>
	</div>
<?php
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
?>