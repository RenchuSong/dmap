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
	//显示用户列表
	$userList=getUserBasicInformationList();
	$size=sizeof($userList);
	for ($i=0;$i<$size;++$i) {
?>
	<div class="userItem" id="userItem<?php echo $userList[$i]->userId; ?>">
		<p>用户名：<?php echo $userList[$i]->userName; ?></p>
		<p>邮　箱：<?php echo $userList[$i]->userEmail; ?></p>
		<p>主　页：<?php echo $userList[$i]->userWebpage; ?></p>
		<div><?php echo $userList[$i]->userInformation ?></div>
		<?php if ($userList[$i]->userAuthority==1){ ?>
		<div style="width:80px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserAuthority(<?php echo $userList[$i]->userId; ?>,'Normal');" style="width:80px;">撤销管理员</a></div>
		<?php }if ($userList[$i]->userAuthority==0){ ?>
		<div style="width:60px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserAuthority(<?php echo $userList[$i]->userId; ?>,'Admin');">管理员</a></div>
		<?php } ?>
		<div class="clear" style="height:0;"></div>
		<?php if ($userList[$i]->userStatus!=0){ ?>
		<div style="width:50px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserStatus(<?php echo $userList[$i]->userId; ?>,'UnVerified');">未验证</a></div>
		<?php } if ($userList[$i]->userStatus!=1){ ?>
		<div style="width:50px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserStatus(<?php echo $userList[$i]->userId; ?>,'Verified');">已验证</a></div>
		<?php } if ($userList[$i]->userStatus!=2){ ?>
		<div style="width:50px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserStatus(<?php echo $userList[$i]->userId; ?>,'Locked');">锁定</a></div>
		<?php } if ($userList[$i]->userStatus!=3){ ?>
		<div style="width:50px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserStatus(<?php echo $userList[$i]->userId; ?>,'Deleted');">删除</a></div>
		<?php } ?>
	</div>
<?php
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
?>