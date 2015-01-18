<div style="margin-top:-20px;"><h2>Let's Have Fun!</h2><a href="javascript:showPlaceInfo(<?php echo $_REQUEST["placeId"]; ?>);" style="font-size:14px;font-weight:bold;display:block;margin-top:5px;text-decoration:none;"><img src="./images/moveLeft.png" style="vertical-align:bottom;" /> Back to Place Infomation</a></div>
<div class="clear" style="margin-top:-18px;"></div>
<?php
	/**
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("./dbOperate.php");
	//获取数据库连接
	@$exec_mysql=getConnection();
	//打开数据库连接
	@openConnection($exec_mysql);
	
	//获取客服端数据
	$placeId=safeParam($_REQUEST["placeId"]);
	
	//获取数据库数据，随机显示该地点的一个游戏
	$gameList=@getPlaceGameList($placeId);
	$size=@sizeof($gameList);
	if ($size==0) echo "<div style='font-size:16px;color:#189de1;padding:10px;'>此地点暂时还没有游戏哦~</div>";else{
		$show=rand(0,$size-1);
		$path=$gameList[$show]->gameProgramURL;
		mb_convert_encoding($path,"utf-8","gb2312");
		@include($path);
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
?>