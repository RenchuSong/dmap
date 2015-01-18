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
		<meta http-equiv="expires" content="0" /> 
		<link rel="stylesheet" type="text/css" href="../css/admin.css" />
		<link rel="stylesheet" type="text/css" href="../css/adminDialog.css" />
		<script type="text/javascript" src="../js/jquery-1.6.4.min.js"></script>
		<script type="text/javascript" src="../js/admin.js"></script>
		<script type="text/javascript" src="../js/adminPlaceData.js"></script>
		<script type="text/javascript" src="../js/ajaxupload.3.5.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				$("#adminPlaceData").attr("class","activeNaviButtom");
				$("#selectPanel").css("opacity","0.9");
				setAddingPlace();
				changeCampus();
			});
		</script>
		<title>DMap后台管理-地点管理</title>
	</head>
	<body>
		<div id="mainFrame">
			<div id="naviFrame">
				<?php include_once("./navigation.php"); ?>
			</div>
			<div id="functionFrame">
				<a id="addPlace" class="adminOptionButton" href="javascript:setAddingPlace();">添加地点</a>
				<a id="deletePlace" class="adminOptionButton" href="javascript:setDeletePlace();">删除地点</a>
				<a id="adminComment" class="adminOptionButton" href="javascript:setAdminComment();">评论管理</a>
				<a id="adminQuestion" class="adminOptionButton" href="javascript:setAdminQuestion();">提问管理</a>
				<a id="adminEvent" class="adminOptionButton" href="javascript:setAdminEvent();">活动管理</a>
				<a id="adminGame" class="adminOptionButton" href="javascript:setAdminGame();">游戏管理</a>
				<a id="adminPlaceInfo" class="adminOptionButton" href="javascript:setAdminPlaceInfo();">地点信息</a>
				<div id="optionFrame">
					<div id="optionFramePage">
						<div class="eachOptionPage">
							　　选择校区、建筑和楼层，在要添加地点的位置单击鼠标，即可在点击处添加地点
						</div>
						<div class="eachOptionPage">
							　　选择校区、建筑和楼层，在要删除的建筑上单击鼠标，即可删除该地点
						</div>
						<div class="eachOptionPage">
							　　在要添加地点的位置单击鼠标，即可进行评论管理
						</div>
						<div class="eachOptionPage">
							　　在要添加地点的位置单击鼠标，即可进行提问管理
						</div>
						<div class="eachOptionPage">
							　　在要添加地点的位置单击鼠标，即可进行活动管理
						</div>
						<div class="eachOptionPage">
							　　在要添加地点的位置单击鼠标，即可进行游戏管理
						</div>
						<div class="eachOptionPage">
							　　单击要编辑信息的地点，即可进行地点信息管理
						</div>
					</div>
				</div>
			</div>
			<div id="operateFrame">
				<div id="selectPanel">
					<div id="selectCampus" class="placeAdminNavi">
						<select id="selectCampusId">
						  <option value ="1">邯郸</option>
						  <option value ="2">张江</option>
						  <option value="3">江湾</option>
						  <option value="4">枫林</option>
						</select>
					</div>
					<div id="selectBuilding" class="placeAdminNavi"></div>
					<div id="selectFloor" class="placeAdminNavi"></div>
					<div id="uploadFloorImage">
						<!-- Upload Button-->  
						<span style="float:left;line-height:20px;padding-left:10px;">上传楼层背景图：</span><div id="upload" >上传</div><span id="status" ></span>  
						<!--List Files-->  
						<ul id="files" ></ul>  
					</div>
				</div>
				<div id="operatePlaceData">
				</div>
			</div>
		</div>
		<div id="maskFrame"></div>
		<div id="addBuildingData" class="adminDialog">
			<div class="dialogItem">地点名称：</div><div class="dialogItemValue"><input type="text" class="adminDialogText" id="placeName" value="" /></div>
			<div class="clear"></div>
			<div class="dialogItem">地点简介：</div><div class="dialogItemValue"><textarea class="adminDialogTextArea" id="placeIntroduce"></textarea></div>
			<div class="clear"></div>
			<div class="dialogItem">&nbsp;</div>
			<div class="naviItem"><a id="submitBuildingData" class="adminDialogButton" href="javascript:addingPlace();" >提交</a></div>
			<div class="naviItem"><a class="adminDialogButton" href="javascript:cancelAddPlace();">取消</a></div>
		</div>
		<div id="editPlaceData" class="adminDialog">
			<div class="dialogItem">地点名称：</div><div class="dialogItemValue"><input type="text" class="adminDialogText" id="editPlaceName" value="" /></div>
			<div class="clear"></div>
			<div class="dialogItem">地点简介：</div><div class="dialogItemValue"><textarea class="adminDialogTextArea" id="editPlaceIntroduce"></textarea></div>
			<div class="clear"></div>
			<div class="dialogItem">地点图片：<br/>
				<div id="uploadPlaceImage" style="margin-left:25px;margin-top:10px;">上传</div><div id="statusPlaceImage" style="width:100%;height:20px;margin-top:50px;font-size:12px;"></div><ul id="files" ></ul>
			</div>
			<div class="dialogItemValue" id="placeImageContainer" style="overflow:auto;height:120px;"></div>
			<div class="clear"></div>
			<div class="dialogItem">&nbsp;</div>
			<div class="naviItem"><a id="submitBuildingData" class="adminDialogButton" href="javascript:submitEditPlace();" >提交</a></div>
			<div class="naviItem"><a class="adminDialogButton" href="javascript:cancelEditPlace();">取消</a></div>
		</div>
		<div id="showPlaceActionData" class="adminDialog">
			<div id="actionContainer" style="width:600px;height:320px;overflow:auto;"></div>
			<div class="naviItem"></div><div class="naviItem"></div>
			<div class="naviItem"><a class="adminDialogButton" href="javascript:closePlaceAction();">关闭窗口</a></div>		
		</div>
	</body>
</html>