<?php
	$uploaddir = '../images/Building/';  
	$file = $uploaddir . "BuildingStruct_".$_REQUEST['buildingId']."_".$_REQUEST['floor'].".jpg";   
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {  
		echo "success";  
	} else {  
		echo "error";  
	}
?>