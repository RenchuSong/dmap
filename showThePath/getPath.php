<?php
	/**
	数据库操作
	*/
	//引入数据库操作程序文件
	@include("../php/dbBasicOperate.php");
	@include("../php/dbBuildingOperate.php");
	
	//获取数据库连接
	$exec_mysql=getConnection();
	//打开数据库连接
	openConnection($exec_mysql);
	//处理校区数据
	$campusId=safeParam($_REQUEST["campusId"]);
	$building1=safeParam($_REQUEST["building1"]);
	$building2=safeParam($_REQUEST["building2"]);
	
	//获取建筑的节点Id
	$buildingNode1=getBuildingNodeId($building1);
	$buildingNode2=getBuildingNodeId($building2);
	//$buildingNode1=$building1;
	//$buildingNode2=$building2;
	
	//打开文件
	$file="./PathResult_".$campusId.".txt";
	$file_pointer = fopen($file, "r"); 
	while (true) {
		$nodeDouble=fscanf($file_pointer, "%s %s \n");
		if ($nodeDouble=="") break;
		list($node1,$node2)=$nodeDouble;
		
		if ((int)$node1==$buildingNode1 && (int)$node2==$buildingNode2){
			$nodeStr=fscanf($file_pointer,"%s \n");
			list($nodeNumber)=$nodeStr;
			$str="";
			for ($j=0;$j<(int)$nodeNumber;++$j)
				$str.="%s %s ";
			$str.="\n";
			
			$path=fscanf($file_pointer, $str);
			echo json_encode($path);
			break;
		}else{
			fgets($file_pointer);
			fgets($file_pointer);
		}
	}
	
	fclose($file_pointer); 
	//关闭数据库连接
	closeConnection($exec_mysql);
?>