<?php
	$dir="./images/Building/";
	$placeId=$_POST["placeId"];
	$handle = opendir(".".$dir);
	$flag=0;
	while (false !== ($file = readdir($handle))) {
		if($file != '.' && $file !== '..') 
			if (strpos($file,"PlaceIntroduce_".$placeId."_")===0){
				$cur_path = $dir.$file;
				echo "<a href='javascript:showLargeImage(\"$cur_path\");'><img src='$cur_path' style='max-width:120px;min-width:120px;margin-right:20px;margin-bottom:5px;' /></a>";
				++$flag;
				if($flag % 3 ==0) echo "<div class='clear'></div>";
			}
	}
	if (!$flag) echo "<img src='./images/Building/noPhoto.jpg' style='max-width:120px;min-width:120px;' />";
?>