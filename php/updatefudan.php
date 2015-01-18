<?php
     if($_POST['action']=="updatemarker") updateFudanMarker(); 
	 function updateFudanMarker(){
		 @$latlng = $_POST['latlng'];
		 @$id = $_POST['id'];
		 //UPDATE  `gmap`.`tb_fudan` SET  `name` =  '毛主席像' WHERE  `tb_fudan`.`id` =1;
		 $conn=mysql_connect('localhost','root','');
	     mysql_select_db('gmap');
	     mysql_query("SET CHARACTER SET utf8");
	     if(mysql_query("UPDATE `tb_fudan` SET  `latlng` =  '$latlng' WHERE  `id` =$id")){
			 echo "success";
			 }
		 else echo "fail";
	     mysql_close();
		 }
?>