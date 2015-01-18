    <div id="mainleft">
	<?php if(((isset($_GET['topid'])&& $_GET['topid']=='home')||!isset($_GET['topid'])) && !isset($_GET['buildingid']) && !isset($_GET['placeid'])){ ?>
		<div id="main-search">
		<?php
			if ((isset($_SESSION['dmapUserAuthority'])) &&  ($_SESSION['dmapUserAuthority']!="0")){
		?>
			<div id="acourse" style="padding:0;"><a href="./oa/adminMapData.php">后台管理</a></div>
		<?php
			}
		?>
        <label for="searchstr">I Wanna Find</label><br>
        <input id="searchstr" type="text" style="height:15px;width:80px;" onfocus="searchfocus();">
        <input type="image" id="searchid" src="images/search.png" onclick="gosearch();"  style="vertical-align:bottom;height:25px;margin-left:3px;" 
        onmouseover="elementFadeTo('searchid');" onmouseout="elementFadeBack('searchid');">
		<div style="color:red;font-size:12px;line-height:14px;" id="searchBuildingError"></div>
		<div class="clear" style="margin-top:5px;"></div>
        <label for="school">Other Maps</label><br>
        <select id="school" selected="benbu" onchange="loadCampusMap();" style="width:85px;height:20px;color:#189DE1;">
            <option value="1">邯郸本部</option>
            <option value="2">张江校区</option>
            <option value="3">江湾校区</option>
            <option value="4">枫林校区</option>
        </select><br>
		<input type="image" id="showThePath" src="./images/showThePath.png" onclick="showThePath();"  style="vertical-align:bottom;height:25px;margin-top:10px;" 
        onmouseover="elementFadeTo('showThePath');" onmouseout="elementFadeBack('showThePath');" />
		<span id="showThePathStatus" style="color:red;font-size:12px;"></span>
        <div id="acourse" style="margin-top:0;"><a href=" http://map.fudan.edu.cn/src/paike/index.php" target="_blank">教室上课情况查询</a></div>
        </div>
	<div id="destinationinfo" >
		<h2 style="font-size:15px;">Destination Info</h2><div class="clear" style="height:5px;"></div>
		<div id="destinationInfoContainer" style="width:100%;height:100px;margin-bottom:-20px;overflow:hidden;">
			<div id="imageGallery" style="position:relative;height:100px;width:auto;left:0;top:0;">
			</div>
		</div>
		<div class="mapMove" style="float:left;position:relative;background-image: url('./images/moveLeft.png'); left: 0; top: -40px;  background-repeat:no-repeat; " onclick="javascript:prevDestinationImage();"></div>
		<div class="mapMove" style="float:left;position:relative;background-image: url('./images/moveRight.png'); left: 85px; top: -40px;  background-repeat:no-repeat; " onclick="javascript:nextDestinationImage();"></div>
		<div class="clear" ></div>
		<input type="image" id="forMoreImage" src="./images/forMoreDetails.png" onclick="gotoBuildingDetail();"  style="vertical-align:bottom;height:25px;margin-top:3px;" 
        onmouseover="elementFadeTo('forMoreImage');" onmouseout="elementFadeBack('forMoreImage');">
	</div>
	<?php } ?>
	
	<?php
		if (isset($_GET['buildingid'])){
	?>
	<div id="buildingInside">
		<h2 style="font-size:16px;">In the Building</h2><div class="clear" style="height:5px;"></div>
		<?php
			if (isset($_GET['floor'])) $nowFloor=$_GET['floor'];else $nowFloor=1;
		?>
		<script language="javascript">
			nowFloor=<?php echo $nowFloor; ?>;
		</script>
		<?php @require_once("./php/showBuildingLogo.php"); ?>
		<div style="font-size:16px;color:#333;font-family:Bradley Hand ITC,Kristen ITC,sans-serif;">I am now on the <span id="showFloor" style="color:blue;font-weight:bold;"><?php 
			echo $nowFloor;
			switch ($nowFloor){
				case 1:echo "st";break;
				case 2:echo "nd";break;
				case 3:echo "rd";break;
				default:echo "th";
			}
		?></span> floor</div>
		<input type="image" id="downStairs" src="./images/downStairs.png" onclick="downStairs(<?php echo $_GET['buildingid']; ?>);" style="width:35px;height:40px;float:left;margin-top:5px;" 
        onmouseover="elementFadeTo('downStairs');" onmouseout="elementFadeBack('downStairs');" title="下楼" />
		<input type="image" id="upStairs" src="./images/upStairs.png" onclick="upStairs(<?php echo $_GET['buildingid']; ?>);" style="width:35px;height:40px;float:left;margin-left:10px;margin-top:5px;" 
        onmouseover="elementFadeTo('upStairs');" onmouseout="elementFadeBack('upStairs');" title="上楼" />
		<input type="image" id="gotoSomeFloor" src="./images/gotoSomeFloor.png" style="width:35px;height:40px;float:left;margin-left:10px;margin-top:5px;" 
        onmouseover="elementFadeTo('gotoSomeFloor');" onmouseout="elementFadeBack('gotoSomeFloor');" title="去某层楼" />
		
		<input type="image" id="backtoMainMap" src="./images/backtoMainMap.png" onclick="javascript:window.location='./index.php'"  style="vertical-align:bottom;height:25px;margin-top:3px;" 
        onmouseover="elementFadeTo('backtoMainMap');" onmouseout="elementFadeBack('backtoMainMap');" />
		<div id="buildingInfo" style="display:none;"></div>
		<div id="gotoSomeStair" style="display:none;background:white;float:left;width:100px;max-height:100px;overflow:auto;padding:5px;border:1px solid #999;position:absolute;left:100px;top:10px;z-index:10000;"></div>
		<script language="javascript">
			$("#buildingInfo").html(getJson("buildingId=<?php echo $_GET["buildingid"]; ?>","./php/homeBuildingInfo.php"));
			for (var i=1;i<=parseInt($("#thisBuildingFloor").val());++i){
				$("#gotoSomeStair").append("<a style='cursor:pointer;display:block;width:80px;height:25px;color:#189DE1;'  href='javascript:gotoBuildingFloor(<?php echo $_REQUEST["buildingid"] ?>,"+i+");hideFloor();'><img src='./images/floorLogo.png' style='width:20px;height:20px;vertical-align:bottom;' /> 去第"+i+"层</a>");
			}
		</script>
	</div>
	<?php
		}
	?>
	
    <?php if(((isset($_GET['topid'])&& $_GET['topid']=='home')||!isset($_GET['topid'])) && !isset($_GET['buildingid'])) {showNews();} ?>
    
	<?php
		if (isset($_GET['buildingid'])){
	?>
    <div id="main-operate">
        <div class="actionItem">
			<a class="actionAnchor" href="javascript:showPlaceComment();"><img src="./images/commentLogo.png" style="width:20px;height:25px;vertical-align:bottom;" /> Comments</a>
		</div>
		<div class="actionItem">
			<a class="actionAnchor" href="javascript:showPlaceQuestion();"><img src="./images/questionLogo.png" style="width:20px;height:25px;vertical-align:bottom;" /> Questions</a>
		</div>
	    <div class="actionItem">
			<a class="actionAnchor" href="javascript:showPlaceTopic();"><img src="./images/topicLogo.png" style="width:20px;height:25px;vertical-align:bottom;" /> Activities</a>
		</div>
		<div class="actionItem">
			<a class="actionAnchor" href="javascript:showPlaceGame();"><img src="./images/gameLogo.png" style="width:20px;height:25px;vertical-align:bottom;" /> Have Fun</a>
		</div>	
    </div>
	<?php } ?>
    </div>
    
<div id="mainright">
		<div id="operateFrame" style="border:0px;">
		<?php if (((isset($_GET['topid'])&& $_GET['topid']=='home')||!isset($_GET['topid'])) && !isset($_GET['buildingid']) && !isset($_GET['placeid'])) { ?>	
			<img id="mapImage" src="./images/HandanCampus.jpg" style="width:1800px;height:1400px;" />
			<div id="operateMapData">
			</div>
			<div id="scaleChange">
				<div id="mapZoomIn" class="mapControlItem" onclick="javascript:zoomInMap();"></div>
				<div id="mapZoom">
					<div class="mapMove" style="background:url('./images/moveUp.png');background-repeat:no-repeat;left:11px;top:25px;" onclick="javascript:moveMap(1);"></div>
					<div class="mapMove" style="background:url('./images/moveDown.png');background-repeat:no-repeat;left:11px;top:65px;" onclick="javascript:moveMap(2);"></div>
					<div class="mapMove" style="background:url('./images/moveLeft.png');background-repeat:no-repeat;left:1px;top:46px;" onclick="javascript:moveMap(3);"></div>
					<div class="mapMove" style="background:url('./images/moveRight.png');background-repeat:no-repeat;left:21px;top:46px;" onclick="javascript:moveMap(4);"></div>
				</div>
				<div id="mapZoomOut" class="mapControlItem" onclick="javascript:zoomOutMap();"></div>
			</div>
		<script>
			$("#mapZoomIn").css("opacity","0.6");
			$("#mapZoomOut").css("opacity","0.6");
			$(".mapMove").css("opacity","0.6");
			$(function(){
				$("#mapZoomIn").live("mouseover",function(){
					$(this).fadeTo(200,1);
				});
				$("#mapZoomIn").live("mouseout",function(){
					$(this).fadeTo(200,0.6);
				});
				$("#mapZoomOut").live("mouseover",function(){
					$(this).fadeTo(200,1);
				});
				$("#mapZoomOut").live("mouseout",function(){
					$(this).fadeTo(200,0.6);
				});
				$(".mapMove").live("mouseover",function(){
					$(this).fadeTo(200,1);
				});
				$(".mapMove").live("mouseout",function(){
					$(this).fadeTo(200,0.6);
				});
			});
			loadCampusBuilding("./");
			$(".buildingItem").css("opacity","0");
			$(".buildingItem2").css("opacity","0");
			$("#operateMapData").append(
				'<div id="buildingInfo"><div id="buildingInfoClose" onclick="javascript:$(\'#buildingInfo\').css({\'opacity\':\'0\',\'left\':10000});$(\'#destinationinfo\').hide(500);"></div><div id="buildingImageLogoInInfo"></div><div id="buildingInfoContainer"></div></div>'
			);
			$("#buildingInfo").css("opacity","0");
		</script>	
		<?php } ?>
		</div>
</div>
<?php 
	if (isset($_GET['buildingid'])){ 
		if (!isset($_GET['placeid'])){
?>
<script language="javascript">
	setNoActivePlace();
</script>
<?php
		}else{
?>
<script language="javascript">
	nowPlace=<?php echo $_GET['placeid']; ?>;
	//setActivePlace(<?php echo $_GET['placeid']; ?>);
</script>
<?php
		}
?>
<script language="javascript">
	gotoBuildingFloor(<?php echo $_GET['buildingid'].",".$nowFloor; ?>);
</script>
<?php
	}
?>