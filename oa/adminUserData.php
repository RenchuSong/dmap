<?php
	/**用户身份验证
	*/
	include("../php/userVerify.php");
	if (!userIsAdmin()) {
		header("Location: ./adminLogin.php"); 
		exit;
	}
?>
<!DOCTYPE html PUBLIC
"-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="Content-Language" content="zh-cn" />
		<link rel="stylesheet" type="text/css" href="../css/admin.css" />
		<link rel="stylesheet" type="text/css" href="../css/adminDialog.css" />
		<script type="text/javascript" src="../js/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="../js/admin.js"></script>
		<script type="text/javascript" src="../js/adminUserData.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#adminUserData").attr("class","activeNaviButtom");
				showUser();
			});
		</script>
		<title>DMap后台管理-用户数据管理</title>
	</head>
	<body>
		<div id="mainFrame">
			<div id="naviFrame">
				<?php include_once("./navigation.php"); ?>
			</div>
			<div id="functionFrame">
				<a class="adminOptionActiveButton" href="javascript:void(0);">管理用户</a>
				<div id="optionFrame">
					<div id="optionFramePage">
						<div class="eachOptionPage">
							　　可将用户设为管理员，管理员拥有后台管理的权限<br/>
							　　被锁定用户将无法登陆，除非解决自身问题后向管理员申请解除锁定并获通过<br/>
							　　删除用户是不可逆的，请慎重处理
						</div>
					</div>
				</div>
			</div>
			<div id="operateFrame">
				<div id="operateUserData">
				</div>
			</div>
		</div>
	</body>
</html>