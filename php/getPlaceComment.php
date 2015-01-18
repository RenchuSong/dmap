<?php
	date_default_timezone_set ('Asia/Shanghai');
?>
<div style="margin-top:-20px;"><h2>Place Comments</h2><a href="javascript:showPlaceInfo(<?php echo $_REQUEST["placeId"]; ?>);" style="font-size:14px;font-weight:bold;display:block;margin-top:5px;text-decoration:none;"><img src="./images/moveLeft.png" style="vertical-align:bottom;" /> Back to Place Infomation</a></div>
	<div id='placeInfoContent' style='overflow:auto;height:350px;'>
		<div class='showCommentItem' style="margin-top:10px;height:140px;">
			<textarea id="userCommentContent" style="margin:10px;width:550px;height:80px;background:white;border:1px solid #ddd;color:#666;font-size:16px;">#我想对这里说：</textarea>
			<a style="margin-left:10px;margin-bottom:10px;display:block;width:68px;float:left;" href="javascript:userSubmitComment();" ><img id="submitBtn" src="./images/submit.png" onmouseover="elementFadeTo('submitBtn');" onmouseout="elementFadeBack('submitBtn');" /></a>
			<span id="submitCommentStatus" style="width:300px;font-size:12px;color:red;float:left;"></span>
		</div>
	<div class='clear' style="margin-top:-18px;"></div><?php
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
	$placeId=@safeParam($_REQUEST["placeId"]);
	
	//获取数据库数据
	$commentList=@getPlaceCommentList($placeId);
	$size=@sizeof($commentList);
	if ($size==0){
		echo "<div style='color:#666;font-size:14px;padding:10px;'>没人发表对这里的看法，那么你来做第一人吧~</div>";
	}else{
		for ($i=0;$i<$size;++$i){
			$user=@getUserByName($commentList[$i]->commentUserName);?>
<div class='showCommentItem'>
	<div style='width:45px;float:left;margin-top:5px;margin-left:5px;margin-bottom:5px;'>
		<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=<?php echo $user->userId; ?>' target='_blank'><img src='./php/showImage.php?id=<?php echo $user->userId; ?>' style='max-width:40px;min-width:40px;' /></a>
	</div>
	<div style='width:520px;margin-top:5px;margin-right:5px;margin-bottom:5px;float:left;color:#999;' >
		<?php echo "<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=".$user->userId."' target='_blank'>".@$commentList[$i]->commentUserName."</a>"; ?> 于 <?php echo date("Y-m-d H:i",@$commentList[$i]->commentTime)."说道：<br/><span style='font-size:14px;color:#666;'>".$commentList[$i]->commentContext."</span>"; ?> 
	</div>
	<div class="clear"></div>
</div>
<?php
		}
		//关闭数据库连接
		closeConnection($exec_mysql);
	}
?>
	</div>
</div>