<?php
	session_start();
	date_default_timezone_set ('Asia/Shanghai');
?>
<div style="margin-top:-20px;"><h2>Place Activities</h2><a href="javascript:showPlaceInfo(<?php echo $_REQUEST["placeId"]; ?>);" style="font-size:14px;font-weight:bold;display:block;margin-top:5px;text-decoration:none;"><img src="./images/moveLeft.png" style="vertical-align:bottom;" /> Back to Place Infomation</a></div>
	<div id='placeInfoContent' style='overflow:auto;height:380px;'>
		<span style="font-size:16px;font-family:Bradley Hand ITC,Kristen ITC,sans-serif;font-weight:bold;line-height:30px;">I Wanna Organize An Avtivity Here:</span>
		<div class='showTopicItem' style="height:auto;">
			<div style="width:50px;float:left;margin:10px;margin-bottom:0;font-size:12px;color:#666;">活动名称</div><input id="userTopicTitle" type="text" style="margin-top:10px;width:485px;border:1px solid #ddd;color:#666;font-size:16px;" />
			<div class="clear"></div>
			<div style="width:50px;float:left;margin:10px;font-size:12px;color:#666;">活动简介</div><textarea id="userTopicIntroduce" style="float:left;margin:10px;margin-left:0;width:485px;height:80px;background:white;border:1px solid #ddd;color:#666;font-size:16px;"></textarea>
			<div class="clear"></div>
			<div id="topicExtendInfomation" style="padding-bottom:10px;display:none;">
				<div style="width:50px;float:left;margin:10px;margin-top:0;font-size:12px;color:#666;">活动时间</div><input id="userTopicTime" type="text" style="margin-bottom:10px;width:485px;border:1px solid #ddd;color:#666;font-size:16px;" />
				<div class="clear"></div>
				<div style="width:50px;float:left;margin:10px;margin-top:0;font-size:12px;color:#666;">主办单位</div><input id="userTopicOrganizer" type="text" style="margin-bottom:10px;width:485px;border:1px solid #ddd;color:#666;font-size:16px;" />
				<div class="clear"></div>
				<div style="width:50px;float:left;margin:10px;margin-top:0;font-size:12px;color:#666;">注意事项</div><textarea id="userTopicNotice" style="float:left;margin:0;width:485px;height:80px;background:white;border:1px solid #ddd;color:#666;font-size:16px;"></textarea>
				<div class="clear"></div>
			</div>
			<a style="margin-left:36px;margin-bottom:10px;display:block;width:24px;float:left;" href="javascript:showTopicExtend();" title="显示/隐藏扩展信息" ><img id="exchangeBtn" src="./images/exchange.png" onmouseover="elementFadeTo('exchangeBtn');" onmouseout="elementFadeBack('exchangeBtn');" /></a>
			<a style="margin-left:10px;margin-bottom:10px;display:block;width:68px;float:left;" href="javascript:userSubmitTopic();" ><img id="submitBtn" src="./images/submit.png" onmouseover="elementFadeTo('submitBtn');" onmouseout="elementFadeBack('submitBtn');" /></a>
			<span id="submitTopicStatus" style="width:300px;font-size:12px;color:red;float:left;"></span>
			<div class="clear"></div>
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
	$topicList=@getPlaceTopicList($placeId);
	$size=@sizeof($topicList);
	if ($size==0){
		echo "<div style='color:#666;font-size:14px;padding:10px;'>没人在这个地方搞活动么？你来搞一个吧~</div>";
	}else{
		for ($i=0;$i<$size;++$i){
			$user=@getUserByName($topicList[$i]->topicUserName);?>
<div class='showTopicItem'>
	<div style='width:45px;float:left;margin-top:5px;margin-left:5px;margin-bottom:5px;'>
		<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=<?php echo $user->userId; ?>' target='_blank'><img src='./php/showImage.php?id=<?php echo $user->userId; ?>' style='max-width:40px;min-width:40px;' /></a>
	</div>
	<div style='width:460px;margin-top:5px;margin-right:5px;margin-bottom:5px;float:left;color:#999;' >
		<a class="answerLogo" href="javascript:showTopicDetail(<?php echo $topicList[$i]->topicId; ?>);" style="display:block;float:right;clear:both;position:relative;left:10px;top:5px;" title="看看活动详情"><img src="./images/exchange.png" /></a>
		<?php
			$userList=$topicList[$i]->joinUserList;
			
			if (!isset($_SESSION["dmapUserId"])) $joinOrNot=true;else{
				$userId=$_SESSION["dmapUserId"];
				if (strpos($userList,"|".$userId."|")>0) $joinOrNot=false;else $joinOrNot=true;
			}
			//
			//
		?>
		<div id="joinOrNot<?php echo $topicList[$i]->topicId; ?>" style="display:block;float:right;clear:both;position:relative;left:55px;top:-19px;width:24px;height:24px;">
			<?php
				if ($joinOrNot){
			?>
			<a class="answerLogo" href="javascript:joinTopic(<?php echo $topicList[$i]->topicId; ?>,1);" title="我要参加" style="display:block;" ><img src="./images/join.png" /></a>
			<?php
				}else{
			?>
			<a class="answerLogo" href="javascript:joinTopic(<?php echo $topicList[$i]->topicId; ?>,0);" title="我不去了" style="display:block;" ><img src="./images/dontjoin.png" /></a>
			<?php
				}
			?>
		</div>
		
		<?php echo "<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=".$user->userId."' target='_blank'>".$topicList[$i]->topicUserName."</a>"; ?> 于 <?php echo date("Y-m-d H:i",$topicList[$i]->topicTime)." 发布了活动：<br/><span style='font-size:14px;color:#666;'>".$topicList[$i]->topicTitle."</span>"; ?> 
		<div style="color:red" id="joinStatus<?php echo $topicList[$i]->topicId; ?>"></div>
		<div id="topicInfomation<?php echo $topicList[$i]->topicId; ?>" style="color:#666;display:none;">
			<?php 
				echo $topicList[$i]->topicContext; 
				$joinUserList=explode("|",$topicList[$i]->joinUserList);
				//echo sizeof($topicList[$i]->joinUserList);
				$userSize=sizeof($joinUserList);
			?>
			<b>参与用户：</b>目前已经有<?php echo $userSize-2; ?>人参加<br/><br/>
			<div class="clear"></div>
			<?php 
				if ($userSize>2){
			?>
			<b>最近加入：</b>
			<div style="width:100%;margin-top:5px;height:52px;">
			<?php
				for ($j=$userSize-2;$j>$userSize-12 && $j>0;--$j){
					$userItem=getUserById($joinUserList[$j]);
			?>
				<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=<?php echo $joinUserList[$j]; ?>' target='_blank'><img src="./php/showImage.php?id=<?php echo $joinUserList[$j]; ?>" style="width:42px;height:42px;margin-right:2px;vertical-align:top;float:left;" title="<?php echo $userItem->userName; ?>" /></a>
			<?php
				}
			?>
			</div>
			<?php
			}
			?>
		</div>
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