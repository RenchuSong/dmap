<?php
	/**
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("./dbOperate.php");
	//获取数据库连接
	$exec_mysql=getConnection();
	//打开数据库连接
	openConnection($exec_mysql);
	//遍历图片
	$dir="../images/Building/";
	$handle = opendir($dir);
	$pathArr=array();
	while (false !== ($file = readdir($handle))) {
		if($file != '.' && $file !== '..') 
			if (strpos($file,"PlaceIntroduce_")===0){
				array_push($pathArr,$file);
			}
	}
	//查找建筑中的地点
	$building=getBuildingById(safeParam($_POST["buildingId"]));
	$sizer=sizeof($pathArr);
	$imgNum=0;
	for ($i=0;$i<$building->buildingFloorNumber;++$i){
		$placeList=getFloorPlaceIdList(safeParam($_POST["buildingId"]),$i);
		$size=sizeof($placeList);
		for ($j=0;$j<$size;++$j){
			for ($k=0;$k<$sizer;++$k)
				if (strpos($pathArr[$k],"PlaceIntroduce_".$placeList[$j]."_")===0){
					echo "<a href='./index.php?buildingid=".$_POST["buildingId"]."&floor=".$i."&placeid=".$placeList[$j]."' target='_self' title='这是哪里啊？去看看'><img src='./images/Building/".$pathArr[$k]."' style='width:125px;height:100px;float:left;' /></a>";
					++$imgNum;
				}
		}
	}
	//关闭数据库连接
	closeConnection($exec_mysql);
	if ($imgNum==0){
		++$imgNum;
		echo "<img src='./images/Building/noPhoto.jpg' style='width:125px;height:100px;float:left;' />";
	}
?>
<script language="javascript">
	$("#imageGallery").css({"width":<?php echo $imgNum*125; ?>});
</script>