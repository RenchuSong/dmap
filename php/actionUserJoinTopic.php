<?php
	/*
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("./dbOperate.php");
	//获取数据库连接
	$exec_mysql=getConnection();
	//打开数据库连接
	openConnection($exec_mysql);
	//数据库操作
	$topic=getTopic(safeParam($_REQUEST["topicId"]));
	if ($topic!=null){
	$place=getPlaceById($topic->topicPlaceId);
	$user=getUserById(safeParam($_REQUEST["userId"]));
?>
<div class="showTopicItem" style="background:#fcfcfc;min-height:50px;">
	<div style="width:45px;float:left;margin-top:5px;margin-left:5px;margin-bottom:5px;">
		<a class="linkUserSpace" href="./index.php?topid=userfriends&userId=<?php echo $_REQUEST["userId"]; ?>" target="_blank"><img src="./php/showImage.php?id=<?php echo $_REQUEST["userId"]; ?>" style="max-width:40px;min-width:40px;"></a>
	</div>
	<div style="width:363px;margin-top:5px;margin-right:5px;margin-bottom:5px;float:left;color:#666;">
		<a class="linkUserSpace" href="./index.php?topid=userfriends&userId=<?php echo $_REQUEST["userId"]; ?>" target="_blank" style="opacity: 1; "><?php echo $user->userName; ?></a> 参与了在 <a class="linkUserSpace" href="./index.php?buildingid=<?php echo $place->placeBuildingId; ?>&floor=<?php echo $place->placeFloor; ?>&placeid=<?php echo isset($_REQUEST["placeId"]) ? $_REQUEST["placeId"] : ''; ?>" target="_blank"><?php echo $place->placeName; ?></a> 的活动：<br/>
		<span style='font-size:14px;color:#666;'><?php echo $topic->topicTitle; ?></span>
	</div>
	<div class="clear"></div>
</div>
<?php
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
?>