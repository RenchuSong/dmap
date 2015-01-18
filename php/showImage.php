<?php   
	header("Content-type:image/bmp");
	@include("./dbBasicOperate.php");
	$connect=getConnection();
	openConnection($connect);
	
    if(isset($_REQUEST['id'])){
		$id = $_REQUEST['id']; 
        $query = "SELECT userImage FROM tb_user WHERE userId=$id";   
        $result = @mysql_query($query);
        $imageData = @mysql_result($result,0, "userImage");   
        echo $imageData; 
	}   
	
	closeConnection($connect);
?> 
