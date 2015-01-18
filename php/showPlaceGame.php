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
	//显示地点游戏
	$gameList=getPlaceGameList(safeParam($_POST["placeId"]));
	$size=sizeof($gameList);
	for ($i=0;$i<$size;++$i){
?>
	<div class="actionItem" id="actionItem<?php echo $gameList[$i]->gameId; ?>">
		<a href="<?php echo $gameList[$i]->gameProgramURL; ?>" target="_blank"><?php echo $gameList[$i]->gameProgramURL; ?></a>
		<div class="clear"></div>
		<a class="deleteAction" href="javascript:deleteGame(<?php echo $gameList[$i]->gameId; ?>)">删除</a>
	</div>
<?php
	}
	if ($size==0) echo "本地点暂无游戏";
	//关闭数据库连接
	closeConnection($exec_mysql);
?>	
<div class="clear"></div>
<span style="line-height:30px;">上传游戏程序：</span>
<div class="clear"></div>
<div id="uploadPlaceGame" style="margin-left:0;margin-top:-5px;">上传</div>
<div id="statusPlaceGame" style="width:100%;height:20px;margin-top:50px;font-size:12px;"></div>
<ul id="files" ></ul>