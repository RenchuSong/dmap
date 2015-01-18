<div class="naviItem"></div>
<div class="naviItem"><a class="naviButton" id="adminMapData" href="./adminMapData.php" target="_self">地图管理</a></div>
<div class="naviItem"><a class="naviButton" id="adminPlaceData" href="./adminPlaceData.php" target="_self">地点管理</a></div>
<div class="naviItem"><a class="naviButton" id="adminNewsData" href="./adminNewsData.php" target="_self">新闻管理</a></div>
<div class="naviItem"><a class="naviButton" id="adminUserData" href="./adminUserData.php" target="_self">用户管理</a></div>
<div class="naviItem"></div>
<div class="naviItem"></div>
<div class="naviItem" style="width:100px;">
	<a id="logoutButton" href="javascript:adminLogout();" style="color:rgb(0,72,145);font-weight:bold;display:block;width:103px;height:40px;background:url('../images/logout.jpg');background-position:30px 5px;background-repeat:no-repeat;position:relative;left:0;top:10px;text-align:right;line-height:40px;">注销</a>
</div>
<script>
	$(document).ready(function () {
		$("#logoutButton").css("opacity","0.6");
	});
	$("#logoutButton").hover(function() {
		$(this).css("opacity","1.0");
	});
	$("#logoutButton").mouseout(function() {
		$(this).css("opacity","0.6");
	});
</script>