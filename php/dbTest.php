<?php
	@include("./dbOperate.php");
	$exec_mysql=getConnection();
	openConnection($exec_mysql);
	//echo addUser("US3ER","1211","fsdfdsfds","s@sina.com","");
	/*echo addBuilding("Zhangjiang","软件楼2","3","软件学院专属用楼");
	echo addBuilding("Zhangjiang","第二教学楼2","4","张江唯一教学楼");
	echo addBuilding("Handan","光华楼2","30","中国高校第一高楼，复旦标志");
	echo addBuilding("Zhangjiang","张食2","3","张江食堂，三层为张娱");
	*/
	//echo updateBuilding(2,"二教",6,"Zhangjiang Fudan");
	//$ans=getBuildingByName("光华楼");
	//echo $ans->buildingId." ".$ans->buildingCampusId." ".$ans->buildingFloorNumber." ".$ans->buildingIntroduce;
	//echo removeBuildingByName("张食2");
	//echo updateNode(2,10,2);
	//addNode(1,4);
	//addNode(5,2);
	//addNode(0,0);
	//echo addDoublePath(1,2);
	//echo addDoublePath(2,3);
	//echo addDoublePath(3,4);
	//$ans=getLinkNodeList(1);
	//for ($i=0;$i<sizeof($ans);++$i)
	//	echo $ans[$i]." ";
	//echo isolateNode(3);
	//
	//closeConnection();
	//print_r(getFloorPlaceIdList(3,1));
	//echo print_r(getPlaceById(6));
	//echo removePlace(6);
	//echo updatePlace(3,"3109","复旦");
	//removeBuildingById(3);
	//echo removeBuildingById(3);
	//print_r(searchPlace(1,null,2,"教室"));
	//echo addBuilding
	//echo removeBuildingPlace(3);
	/*echo addPlace("2104教室",1,2,1,123,34,"2104 Fudan Classroom");
	echo addPlace("3204教室",1,3,2,123,34,"2104 Fudan Classroom");
	echo addPlace("3308教室",1,3,3,123,34,"2104 Fudan Classroom");
	echo addPlace("2308教室",1,2,3,123,34,"2104 Fudan Classroom");
	*/
	/*echo addBuilding(1,"Software Building",3,"Soft");
	echo addPlace("Test1",1,12,1,10,10,"Test Classroom");
	echo addPlace("Test2",1,12,1,10,10,"Test Classroom");
	echo addPlace("Test3",1,12,3,10,10,"Test Classroom");
	echo addGame(12,"./Games/src1.php");
	echo addGame(12,"./Games/src1_2.php");
	echo addGame(13,"./Games/src2.php");
	echo addGame(14,"./Games/src3.php");
	echo addGame(14,"./Games/src3_2.php");
	*/
	
	
	/*******************
	echo addComment(safeParam(13),safeParam("测试的评论"),safeParam("srcylq"));
	echo addComment(safeParam(13),safeParam("测试的评论2"),safeParam("songrenchu1314"));
	
	echo addQuestion(13,"测试的提问","test");
	echo addTopic(13,"测试话题标题","测试话题内容","srcylq");
	echo changeFocus(15,13,"Add");
	echo changeFocus(17,13,"Add");
	*******************/
	//echo addAnswer(10,"Because YLQ","songrenchu1314");
	//echo addAnswer(10,"Because YL","test");
	//echo addAnswer(10,"Because LQ","srcylq");
	//echo addAnswer(12,"Because SRCYLQ","songrenchu1314");
	
	//echo removeQuestion();
	//echo addAnswer(2,"Because YLQ","USER");
	//echo addAnswer(2,"Because YLQ2","USER");
	//echo addAnswer(3,"Because YLQ2324","USER");
	//echo addAnswer(4,"Because YLQ23","USER");
	//echo removePlaceQuestion(2);
	//echo addTopic(11,"8 topic","Go to Beijing","USER");
	//echo updateTopic(2,"dsfsdf","return Shanghai");
	//echo changeTopicJoin(13,1,"Add");
	//echo changeTopicJoin(1,2,"Delete");
	//echo addTopic(11,"Test Topic","11111111111111","USER");
	//echo changeTopicJoin(4,10,"Add");
	//echo addAction(2,8,"Focus","");
	//print_r(getPlaceActionList(11));
	closeConnection($exec_mysql);
	
?>