<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>显示图片</title>
</head>

<body>
<?php  
     $connect = mysql_connect( "localhost", "root", "111111") or die("Unable to connect to MySQL server");   
     mysql_select_db( "dmap") or die("Unable to select database");
	 mysql_query("SET CHARACTER SET utf8");  
     $result=mysql_query("SELECT * FROM tb_user") or die("Can't Perform Query");  
     while($row=mysql_fetch_object($result)){  
          echo "id=".$row->userId."<br>";
          echo "<img src=\"php\showImage.php?id=".$row->userId."\"><br>"; 
		 // echo $row->Description."   ".$row->Time."<br>";
         }  
 ?> 
</body>
</html>