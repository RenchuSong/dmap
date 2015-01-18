<?php
	$uploaddir = '../images/Building/';  
	$file = $uploaddir . "Building_".$_REQUEST['buildingId'].".jpg";   
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {  
		echo "success";  
	} else {  
		echo "error";  
	}
?>