<?php
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
	
	//获取客服端数据
	$placeId=safeParam($_REQUEST["placeId"]);
	$actionShown=safeParam($_REQUEST["actionShown"]);
	$showNumber=safeParam($_REQUEST["showNumber"]);
	
	//获取数据库数据
	$actionList=getPlaceActionList($placeId,$actionShown,$showNumber);
	$size=sizeof($actionList);
	if ($size==0){
		if ($actionShown==-1)
			echo "这个地方有点冷，还没有动态哦~";
		else echo "<div class='showActionItem' style='text-align:center;padding-top:5px;padding-bottom:5px;color:#666;'>没有更早的动态了</div>";
	}else{
		$lastId=$actionList[$size-1]->actionId;
		$content="";
		for ($i=0;$i<$size;++$i){
			$user=getUserById($actionList[$i]->actionUserId);
			if ($actionList[$i]->actionType==1){
				$content="关注了这里";
			}else
			if ($actionList[$i]->actionType==2){
				$content="发表了评论：<br/><span style='font-size:14px;'>".$actionList[$i]->actionIntroduce;
			}else
			if ($actionList[$i]->actionType==3){
				$content="对这里有了疑问：<br/><span style='font-size:14px;'>".substr($actionList[$i]->actionIntroduce,strpos($actionList[$i]->actionIntroduce,"]")+1);
			}else
			if ($actionList[$i]->actionType==4){
				$content="在这里发起了活动：<br/><span style='font-size:14px;'>".substr($actionList[$i]->actionIntroduce,strpos($actionList[$i]->actionIntroduce,"]")+1);
			}else
			if ($actionList[$i]->actionType==5){
				$content="参与了活动：<br/><span style='font-size:14px;'>".substr($actionList[$i]->actionIntroduce,strpos($actionList[$i]->actionIntroduce,"：")+3);
			}
			
?>
<div class='showActionItem'>
	<div style='width:45px;float:left;margin-top:5px;margin-left:5px;margin-bottom:5px;'>
		<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=<?php echo $actionList[$i]->actionUserId; ?>' target='_blank'><img src='./php/showImage.php?id=<?php echo $actionList[$i]->actionUserId; ?>' style='max-width:40px;min-width:40px;' /></a>
	</div>
	<div style='width:363px;margin-top:5px;margin-right:5px;margin-bottom:5px;float:left;color:#666;' >
		<?php echo "<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=".$actionList[$i]->actionUserId."' target='_blank'>".$user->userName."</a>"; ?> 于 <?php echo date("Y-m-d H:i",$actionList[$i]->actionTime)."<br/>".$content."</span>"; ?> 
	</div>
	<div class="clear"></div>
</div>
<?php
		}
		//关闭数据库连接
		closeConnection($exec_mysql);
?>
<div id="moreActionBtn" style="text-align:center;">
	<a href="javascript:placeShowMoreAction();" style="color:#189DE1;"><img src="./images/moveDown.png" style="vertical-align:bottom;" /> 更多动态</a>
	<input id="actionShown" type="hidden" value="<?php echo $lastId; ?>" />
</div>
<?php
	}
?>