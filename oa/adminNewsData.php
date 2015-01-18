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
		<script type="text/javascript" src="../js/adminNewsData.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#adminNewsData").attr("class","activeNaviButtom");
				setEditNews();
			});
		</script>
		<title>DMap后台管理-新闻数据管理</title>
	</head>
	<body>
		<div id="mainFrame">
			<div id="naviFrame">
				<?php include_once("./navigation.php"); ?>
			</div>
			<div id="functionFrame">
				<a id="editNews" class="adminOptionButton" href="javascript:setEditNews();">管理新闻</a>
				<a id="addNews" class="adminOptionButton" href="javascript:setAddingNews();">发布新闻</a>
				<div id="optionFrame">
					<div id="optionFramePage">
						<div class="eachOptionPage"></div>
						<div class="eachOptionPage">
							　　选择要管理的新闻条目，对新闻进行修改、删除
						</div>
						<div class="eachOptionPage">
							　　输入新闻的标题、内容，点击发布即可发布新闻
						</div>
					</div>
				</div>
			</div>
			<div id="operateFrame">
				<div id="operateNewsData">
				</div>
			</div>
		</div>
		<div id="maskFrame"></div>
		<div id="addNewsData" class="adminDialog">
			<div class="dialogItem">新闻标题</div><div class="dialogItemValue"><input type="text" class="adminDialogText" id="newsTitle" value="" /></div>
			<div class="clear"></div>
			<div class="dialogItem">新闻内容</div><div class="dialogItemValue"><textarea class="adminDialogTextArea" id="newsContext"></textarea></div>
			<div class="clear"></div>
			<input type="hidden" id="selectBuilding" value="" />
			<div class="dialogItem">&nbsp;</div>
			<div class="naviItem"><a class="adminDialogButton" href="javascript:submitNews();">提交</a></div>
			<div class="naviItem"><a class="adminDialogButton" href="javascript:cancelNewsOperate();">取消</a></div>
		</div>
	</body>
</html>