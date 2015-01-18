<?php
	session_start();
	/**用户身份验证
	*/
	if (!isset($_SESSION["dmapUser"])) {
		echo "非登录用户禁止访问别人的好友哦~";
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
	
	//获取客户端数据
	$userId=safeParam($_REQUEST["userId"]);
	
	$friendList=friendIdList($userId);
	$size=sizeof($friendList);
	if ($size==0){
		echo "<div style='font-size:16px;color:#666;'>你还没有好友哦~去校园地图里到处逛逛吧，会发现感兴趣的人的哦~</div>";
	}else
	for ($i=$size-1;$i>=0;--$i){
		$friend=getUserById($friendList[$i]);
?>
	<div class="friendItem" onclick="javascript:gotoUser(<?php echo $friendList[$i]; ?>);">
		<div class="friendPhoto">
			<img src="./php/showImage.php?id=<?php echo $friendList[$i]; ?>" style="max-width:60px;min-width:60px;" />
		</div>
		<div class="friendInfo">
			<?php echo "<div class='friendName'>".$friend->userName."</div>"; ?>
			<?php echo "<div class='friendEmail'>".$friend->userEmail."</div>"; ?>
			<?php 
				if ($friend->userWebpage!="http://")
					echo "<div class='friendWebpage'>".$friend->userWebpage."</div>";
			?>
			<div class="friendIntroduce">
			<?php if ($friend->userInformation=="") echo "This Friend is Lazy, And Hasn't Said Anything About Him/Herself.";
				else {
					$introduce=strip_tags($friend->userInformation,'<style><p><br>');
					echo $introduce;
				}
			?>
			</div>
		</div>
	</div>
<?php
	}
	
	//关闭数据库连接
	closeConnection($exec_mysql);
?>