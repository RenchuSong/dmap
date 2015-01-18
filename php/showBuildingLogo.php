<?php
	$fileStr="./images/Building/Building_".$_REQUEST["buildingid"].".jpg";
	$tmpStr=$fileStr;
	if (isset($_REQUEST["front"]) && ($_REQUEST["front"]=="1")) $tmpStr=".".$tmpStr;
	if (!is_file($tmpStr)) $fileStr="./images/Building/noPhoto.jpg";
	if (isset($_REQUEST["width"])) $wd=$_REQUEST["width"];else $wd=125;
?>
<img src="<?php echo $fileStr; ?>" style="max-width:<?php echo $wd; ?>px;min-width:<?php echo $wd; ?>px;" alt="建筑图片" />
