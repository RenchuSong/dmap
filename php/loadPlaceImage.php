<?php
	/**用户身份验证
	*/
	@include("./userVerify.php");
	if (!userIsAdmin()) {
		echo "非管理员禁止数据库操作";
		exit;
	}
	
	$dir="../images/Building/";
	$placeId=$_POST["placeId"];
	$handle = opendir($dir);
	while (false !== ($file = readdir($handle))) {
		if($file != '.' && $file !== '..') 
			if (strpos($file,"PlaceIntroduce_".$placeId."_")===0){
				$cur_path = $dir.$file;
				echo "<img src='$cur_path' style='width:90px;height:80px;' />";
			}
	}
?>