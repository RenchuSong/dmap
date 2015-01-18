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
		<script type="text/javascript" src="../js/adminMapData.js"></script>
		<script type="text/javascript" src="../js/ajaxupload.3.5.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#adminMapData").attr("class","activeNaviButtom");
				setAddingNode();
			});
		</script>
		<title>DMap后台管理-地图数据管理</title>
	</head>
	<body>
		<div id="mainFrame">
			<div id="naviFrame">
				<?php include_once("./navigation.php"); ?>
			</div>
			<div id="functionFrame">
				<a id="addNode" class="adminOptionButton" href="javascript:setAddingNode();">添加节点</a>
				<a id="deleteNode" class="adminOptionButton" href="javascript:setDeleteNode();">删除节点</a>
				<a id="addPath" class="adminOptionButton" href="javascript:setAddingPath();">添加路径</a>
				<a id="deletePath" class="adminOptionButton" href="javascript:setDeletePath();">删除路径</a>
				<a id="addBuilding" class="adminOptionButton" href="javascript:setAddingBuilding();">添加建筑</a>
				<a id="deleteBuilding" class="adminOptionButton" href="javascript:setDeleteBuilding();">删除建筑</a>
				<a id="deleteBuilding" class="adminOptionButton" href="../showThePath/updatePathResult.php?campusId=1" target="_blank">更新路径</a>
				<div id="optionFrame">
					<div id="optionFramePage">
						<div class="eachOptionPage"></div>
						<div class="eachOptionPage">
							　　在要添加节点的位置单击鼠标，即可在点击处添加节点
						</div>
						<div class="eachOptionPage">
							　　在地图上单击要删除的节点，可将选中的节点删除
						</div>
						<div class="eachOptionPage">
							　　在地图上依次点击两个节点<br/><br/>
							<div style="width:94px;height:122px;background:#ccc;padding-top:20px;padding-left:6px;">
							端点1：<input type="text" id="addPathSelectNode1Id" disabled="disabled" class="nodeId" /><br/>
							X:<input type="text" id="addPathSelectNode1X" disabled="disabled" class="nodeCoordinate" />
							Y:<input type="text" id="addPathSelectNode1Y" disabled="disabled" class="nodeCoordinate" /><br/><br/>
							端点2：<input type="text" id="addPathSelectNode2Id" disabled="disabled" class="nodeId" /><br/>
							X:<input type="text" id="addPathSelectNode2X" disabled="disabled" class="nodeCoordinate" />
							Y:<input type="text" id="addPathSelectNode2Y" disabled="disabled" class="nodeCoordinate" />
							</div>
						</div>
						<div class="eachOptionPage">
							　　在要添加建筑的位置单击鼠标<br/>
							　　如果要修改建筑信息，请点击建筑图标
						</div>
						<div class="eachOptionPage">　　在地图上单击要删除的建筑，可将选中的建筑删除</div>
					</div>
				</div>
			</div>
			<div id="operateFrame">
				<div id="operateMapData">
				</div>
			</div>
		</div>
		<div id="maskFrame"></div>
		<div id="addBuildingData" class="adminDialog" style="height:400px;">
			<div class="dialogItem">建筑名称：</div><div class="dialogItemValue"><input type="text" class="adminDialogText" id="buildingName" value="" /></div>
			<div class="clear"></div>
			<div class="dialogItem">建筑层数：</div><div class="dialogItemValue"><input type="text" class="adminDialogText" id="buildingFloor" value="" /></div>
			<div class="clear"></div>
			<div class="dialogItem">建筑简介：</div><div class="dialogItemValue"><textarea class="adminDialogTextArea" id="buildingIntroduce"></textarea></div>
			<div class="clear"></div>
			<div class="dialogItem">建筑图片：<br/>
				<div id="uploadPlaceImage" style="margin-left:25px;margin-top:10px;">上传</div><div id="statusPlaceImage" style="width:100%;height:20px;margin-top:50px;font-size:12px;"></div><ul id="files" ></ul>
			</div>
			<div class="dialogItemValue" id="placeImageContainer" style="overflow:auto;height:120px;"></div>
			<input type="hidden" id="selectBuilding" value="" />
			<div class="dialogItem">&nbsp;</div>
			<div class="naviItem"><a id="submitBuildingData" class="adminDialogButton"  >提交</a></div>
			<div class="naviItem"><a class="adminDialogButton" href="javascript:cancelBuildingOperate();">取消</a></div>
		</div>
	</body>
</html>