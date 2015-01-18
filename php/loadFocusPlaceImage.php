<?php 
    
	/**
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("./dbOperate.php");
	//获取数据库连接
	@$exec_mysql=getConnection();
	//打开数据库连接
	@openConnection($exec_mysql);
	
	@$placeId=$_POST["placeId"];
	$placeInfo = getPlaceById($placeId);
	
	$dir="./images/Building/";
	$handle = opendir('.'.$dir);
	$loadOne=0;
	while (false !== ($file = readdir($handle))) {
		if($loadOne>0)break;
		if($file != '.' && $file !== '..') 
			if (strpos($file,"PlaceIntroduce_".$placeId."_")===0){
				$cur_path = $dir.$file;
				echo "<a href='./index.php?buildingid=$placeInfo->placeBuildingId&floor=$placeInfo->placeFloor&placeid=$placeId' target='_blank'><img src='$cur_path' style='width:90px;height:80px; border:1px #ccc solid; padding:2px;' title='$placeInfo->placeName'/></a>";
				$loadOne++;
			}
	}
	if($loadOne==0){
		echo "<a href='./index.php?buildingid=$placeInfo->placeBuildingId&floor=$placeInfo->placeFloor&placeid=$placeId'  target='_blank'><img src='images/Building/noPhoto.jpg' style='width:90px;height:80px;border:1px #ccc solid; padding:2px;'  title='$placeInfo->placeName' /></a>";
		}
	//关闭数据库连接
    closeConnection($exec_mysql);
?>