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
	//设置用户权限
	setUserAuthority(safeParam($_POST["userId"]),safeParam($_POST["userAuthority"]));
	$userItem=getUserById(safeParam($_POST["userId"]));
?>
	<p>用户名：<?php echo $userItem->userName; ?></p>
	<p>邮　箱：<?php echo $userItem->userEmail; ?></p>
	<p>主　页：<?php echo $userItem->userWebpage; ?></p>
	<div><?php echo $userItem->userInformation ?></div>
	<?php if ($userItem->userAuthority==1){ ?>
	<div style="width:80px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserAuthority(<?php echo safeParam($_POST["userId"]); ?>,'Normal');" style="width:80px;">撤销管理员</a></div>
	<?php }if ($userItem->userAuthority==0){ ?>
	<div style="width:60px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserAuthority(<?php echo safeParam($_POST["userId"]); ?>,'Admin');">管理员</a></div>
	<?php } ?>
	<div class="clear" style="height:0;"></div>
	<?php if ($userItem->userStatus!=0){ ?>
	<div style="width:50px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserStatus(<?php echo safeParam($_POST["userId"]); ?>,'UnVerified');">未验证</a></div>
	<?php } if ($userItem->userStatus!=1){ ?>
	<div style="width:50px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserStatus(<?php echo safeParam($_POST["userId"]); ?>,'Verified');">已验证</a></div>
	<?php } if ($userItem->userStatus!=2){ ?>
	<div style="width:50px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserStatus(<?php echo safeParam($_POST["userId"]); ?>,'Locked');">锁定</a></div>
	<?php } if ($userItem->userStatus!=3){ ?>
	<div style="width:50px;height:25px;float:left;"><a class="adminDialogButton" href="javascript:setUserStatus(<?php echo safeParam($_POST["userId"]); ?>,'Deleted');">删除</a></div>
	<?php } ?>
<?php
	//关闭数据库连接
	closeConnection($exec_mysql);
?>