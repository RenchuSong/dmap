<?php
	date_default_timezone_set ('Asia/Shanghai');
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
	$questionId=safeParam($_REQUEST["questionId"]);
	
	//获取数据库数据
	$question=getQuestionById($questionId);
	if ($question==null) {
		echo "评论不存在";
		exit;
	}
	$user=getUserByName($question->questionUserName);
	$answerList=getQuestionAnswerList($questionId);
	$size=sizeof($answerList);
?>
	<div style='width:45px;float:left;margin-top:5px;margin-left:5px;margin-bottom:5px;'>
		<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=<?php echo $user->userId; ?>' target='_blank'><img src='./php/showImage.php?id=<?php echo $user->userId; ?>' style='max-width:40px;min-width:40px;' /></a>
	</div>
	<div style='width:520px;margin-top:5px;margin-right:5px;margin-bottom:5px;float:left;color:#999;' >
		<a class="answerLogo" href="javascript:showAnswerFrame(<?php echo $questionId; ?>);" style="display:block;float:right;clear:both;position:relative;left:-5px;top:5px;" title="我要回答"><img src="./images/answer.png" /></a>
		<?php echo "<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=".$user->userId."' target='_blank'>".$question->questionUserName."</a>"; ?> 于 <?php echo date("Y-m-d H:i",$question->questionTime)."问了：<br/><span style='font-size:14px;color:#666;'>".$question->questionContext."</span>"; ?> 
		<div class="showAnswerItem" id="answerFrame<?php echo $questionId; ?>" style="display:none;">
			<textarea id="userAnswerContent<?php echo $questionId; ?>" style="margin:10px;width:480px;height:40px;background:white;border:1px solid #ddd;color:#666;font-size:12px;"></textarea>
			<a style="margin-left:10px;margin-bottom:10px;display:block;width:68px;float:left;" href="javascript:userSubmitAnswer(<?php echo $questionId; ?>);" ><img id="submitBtn<?php echo $questionId; ?>" src="./images/submit.png" onmouseover="elementFadeTo('submitBtn<?php echo $questionId; ?>');" onmouseout="elementFadeBack('submitBtn<?php echo $questionId; ?>');" /></a>
			<span id="submitAnswerStatus<?php echo $questionId; ?>" style="width:250px;font-size:12px;color:red;float:left;"></span>
			<div class="clear"></div>
		</div>
		<?php
			for ($i=0;$i<$size;++$i){
				$answerUser=getUserByName($answerList[$i]->answerUserName);
		?>
		<div class="showAnswerItem">
			<div style='width:30px;float:left;margin-top:5px;margin-left:5px;margin-bottom:5px;'>
				<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=<?php echo $answerUser->userId; ?>' target='_blank'><img src='./php/showImage.php?id=<?php echo $answerUser->userId; ?>' style='max-width:25px;min-width:25px;' /></a>
			</div>
			<div style='width:470px;margin-top:5px;margin-bottom:5px;float:left;color:#666;' >
				<?php echo "<a class='linkUserSpace' href='./index.php?topid=userfriends&userId=".$answerUser->userId."' target='_blank'>".$answerList[$i]->answerUserName."</a> 答道：<br/>".$answerList[$i]->answerContext; ?>
			</div>
			<div class="clear"></div>
		</div>
		<?php
			}
		?>
	</div>
	<div class="clear"></div>
<?php
	//关闭数据库连接
	closeConnection($exec_mysql);
?>
