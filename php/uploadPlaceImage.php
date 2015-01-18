<?php
	$uploaddir = '../images/Building/';  
	$file = $uploaddir . "PlaceIntroduce_".$_REQUEST['placeId']."_".time()."_".rand(100000,200000).".jpg";   
	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file)) {  
		echo "success";  
	} else {  
		echo "error";  
	}
?>