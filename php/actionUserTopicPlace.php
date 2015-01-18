<?php
	session_start();
	if (!isset($_SESSION["dmapUser"])){
		echo "只有登录用户才能使用DMap社交功能哦~";
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
	//数据库操作
	$topic=getTopic(safeParam($_REQUEST["topicId"]));
	if ($topic!=null){
	$place=getPlaceById($topic->topicPlaceId);
	$user=getUserByName($topic->topicUserName);
?>
<div class='showTopicItem' style="background:#fcfcfc;min-height:50px;">
	<div style='width:45px;float:left;margin-top:5px;margin-left:5px;margin-bottom:5px;'>
		<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=<?php echo $user->userId; ?>' target='_blank'><img src='./php/showImage.php?id=<?php echo $user->userId; ?>' style='max-width:40px;min-width:40px;' /></a>
	</div>
	<div style='width:460px;margin-top:5px;margin-right:5px;margin-bottom:5px;float:left;color:#666;' >
		<a class="answerLogo" href="javascript:showTopicDetail(<?php echo $_REQUEST["topicId"]; ?>);" style="display:block;float:right;clear:both;position:relative;left:10px;top:5px;" title="看看活动详情"><img src="./images/exchange.png" /></a>
		<?php
			$userList=$topic->joinUserList;
			$userId=$_SESSION["dmapUserId"];
			if (strpos($userList,"|".$userId."|")>0) $joinOrNot=false;else $joinOrNot=true;
		?>
		<div id="joinOrNot<?php echo $_REQUEST["topicId"]; ?>" style="display:block;float:right;clear:both;position:relative;left:55px;top:-19px;width:24px;height:24px;">
			<?php
				if ($joinOrNot){
			?>
			<a class="answerLogo" href="javascript:joinTopic(<?php echo $_REQUEST["topicId"]; ?>,1);" title="我要参加" style="display:block;" ><img src="./images/join.png" /></a>
			<?php
				}else{
			?>
			<a class="answerLogo" href="javascript:joinTopic(<?php echo $_REQUEST["topicId"]; ?>,0);" title="我不去了" style="display:block;" ><img src="./images/dontjoin.png" /></a>
			<?php
				}
			?>
		</div>
		
		<?php echo "<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=".$user->userId."' target='_blank'>".$topic->topicUserName."</a>"; ?> 于 <?php echo date("Y-m-d H:i",$topic->topicTime)." 发布了活动：<br/><span style='font-size:14px;color:#666;'>".$topic->topicTitle."</span>"; ?> 
		<div style="color:red" id="joinStatus<?php echo $_REQUEST["topicId"]; ?>"></div>
		<div id="topicInfomation<?php echo $_REQUEST["topicId"]; ?>" style="color:#666;display:none;">
			<?php 
				echo $topic->topicContext; 
				$joinUserList=explode("|",$topic->joinUserList);
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
?>