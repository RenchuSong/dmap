<?php
	/**
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("./dbOperate.php");
	//获取数据库连接
	$exec_mysql=getConnection();
	//打开数据库连接
	openConnection($exec_mysql);
	//数据库操作
	$user=getUserById(safeParam($_REQUEST["userId"]));
	$place=getPlaceById(safeParam($_REQUEST["placeId"]));
	$time=date("Y-m-d H:i",$_REQUEST["time"]);
?>
<div class="showCommentItem" style="background:#fcfcfc;min-height:50px;">
	<div style="width:45px;float:left;margin-top:5px;margin-left:5px;margin-bottom:5px;">
		<a class="linkUserSpace" href="./index.php?topid=userfriends&userId=<?php echo $_REQUEST["userId"]; ?>" target="_blank"><img src="./php/showImage.php?id=<?php echo $_REQUEST["userId"]; ?>" style="max-width:40px;min-width:40px;"></a>
	</div>
	<div style="width:363px;margin-top:5px;margin-right:5px;margin-bottom:5px;float:left;color:#666;">
		<a class="linkUserSpace" href="./index.php?topid=userfriends&userId=<?php echo $_REQUEST["userId"]; ?>" target="_blank" style="opacity: 1; "><?php echo $user->userName; ?></a> 于 <?php echo $time; ?> 关注了地点：<br/><a class="linkUserSpace" href="./index.php?buildingid=<?php echo $place->placeBuildingId; ?>&floor=<?php echo $place->placeFloor; ?>&placeid=<?php echo $_REQUEST["placeId"]; ?>" target="_blank"><span style="font-size:14px;"><?php echo $place->placeName; ?></a></span> 
	</div>
	<div class="clear"></div>
</div>
<?php
	//关闭数据库连接
	closeConnection($exec_mysql);
?>