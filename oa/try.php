<?php function tryer(){include_once("./ss.php");
		$arr = array (  );
		array_push($arr,
		array (  'catid'=>2,  'catname' => 3,  'meta_title' => 5,  ));
		array_push($arr,array (  'catid' => 2,  'catname' => 3,  'meta_title' => 5,  ));
		return json_encode($arr);
	}
	echo tryer();
?>