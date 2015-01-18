/**
*相关常量
*/
var actionShowEachTime=20;											//每次获取的动态条数
var commentShowEachTime=20;											//每次获取的评论条数
var questionShowEachTime=15;										//每次获取的问题个人
var topicShowEachTime=10;											//每次获取的话题个数
var gameShowEachTime=9;												//每次获取的游戏个数

//==================================================================
var nowFloor=1;														//目前所在楼层
var nowPlace=-1;													//目前查看的建筑
var nowFlag;														//当前地点是否已关注
var originTop;														//元素原来的高度
var placeInfo;														//用来生成地点信息
var actionShown=-1;													//已经显示的动态的条目
var selectflag=false;												//仅执行一次的选择
/**
*功能按钮绑定鼠标事件
*/
$(".actionAnchor").live("mouseover",function(){
	if (nowPlace!=-1){
		var item=$(this);
		$(".actionAnchor").stop(true);
		$(".actionAnchor").css("opacity","1");
		item.animate({"opacity":"0.3"},200);
		item.animate({"opacity":"1"},200);
		item.animate({"opacity":"0.3"},200);
		item.animate({"opacity":"1"},200);
	}
});
$(".actionAnchor").live("mouseout",function(){
	if (nowPlace!=-1){
		$(this).stop(true);
		$(this).css("opacity","1");
	}
});
//回复按钮绑定
$(".answerLogo").live("mouseover",function(){
	$(this).animate({"opacity":"0.2"},200);
	$(this).animate({"opacity":"1"},200);
	$(this).animate({"opacity":"0.2"},200);
	$(this).animate({"opacity":"1"},200);	
});
$(".answerLogo").live("mouseout",function(){
	$(this).stop(true);
	$(this).css({"opacity":"1"});	
});


/**
*前往某个建筑的某一层
*/
function gotoBuildingFloor(buildingId,floorId) {
	if (selectflag==true) selectflag=false;else
		setNoActivePlace();
	closeDialog();
	$("#mainright").css("background","black");
	if (floorId<1 || floorId>parseInt($("#thisBuildingFloor").val())) {
		alert("楼层不存在！");
		return;
	}else{
		switch(floorId){
			case 1:$("#showFloor").html("1st");break;
			case 2:$("#showFloor").html("2nd");break;
			case 3:$("#showFloor").html("3rd");break;
			default:$("#showFloor").html(floorId+"th");
		}
		nowFloor=floorId;
		$("#operateFrame").stop(true);
		$("#operateFrame").animate({"opacity":"0"},500);
		var imgStr="<img src='./images/Building/BuildingStruct_"+buildingId+"_"+floorId+".jpg' style='width:800px;height:500px;' />";
		setTimeout('$("#operateFrame").html("'+imgStr+'");loadPlace('+buildingId+','+floorId+');$(".placeItem").css("opacity","0.6");',500);
		$("#operateFrame").animate({"opacity":"1"},500);
	}
}
//上楼
function upStairs(buildingId){
	if (nowFloor<parseInt($("#thisBuildingFloor").val())){
		++nowFloor;
		gotoBuildingFloor(buildingId,nowFloor);
	}
}
//下楼
function downStairs(buildingId){
	if (nowFloor>1){
		--nowFloor;
		gotoBuildingFloor(buildingId,nowFloor);
	}
}
//去某层楼
function selectFloor(event){
	getScrollPosition();
	$("#gotoSomeStair").css({"left":event.clientX+scrollLeft,"top":event.clientY+scrollTop});
	$("#gotoSomeStair").show(500);
}
//选楼按钮绑定爬楼事件
$("#gotoSomeFloor").live("click",function(e){
	selectFloor(e);
});

/**
*载入建筑某层的地点
*/
function loadPlace(buildingId,floorId){
	//$("#operateFrame").append(getJson("buildingId="+buildingId+"&floor="+floorId+"&width="+mapShowWidth+"&height="+mapShowHeight,"./php/userGetFloorPlace.php"));
	$.ajax({
		type:'POST',
		url:"./php/userGetFloorPlace.php",
		data:"buildingId="+buildingId+"&floor="+floorId+"&width="+mapShowWidth+"&height="+mapShowHeight,
		async:false,
		cache: false,
		success:function(responseData){
			$("#operateFrame").append(responseData);
			if (nowPlace!=-1){
				//alert(nowPlace);
				selectPlace($("#placeItem"+nowPlace));
			}
		}
	});
}
//隐藏选择楼层
function hideFloor(){
	$("#gotoSomeStair").hide(500);
}
//建筑的鼠标事件
$(".placeItem").live("mouseover",function(){
	for (var i=0;i<100;++i){
		$(this).animate({"opacity":"0"},400);
		$(this).animate({"opacity":"1"},400);
	}
});
$(".placeItem").live("mouseout",function(){
	$(this).stop(true);
	$(this).animate({"opacity":"0.6"},200);
});
//选择某个地点
function selectPlace(obj){
	closeDialog();
	actionShown=-1;
	if (nowPlace!=-1){
		$("#placeItem"+nowPlace).stop(true);
		$("#placeItem"+nowPlace).css({"top":originTop});
		$("#placeItem"+nowPlace).css({"opacity":"0.6"});
	}
	obj.stop(true);
	obj.animate({"opacity":"1"},100);
	
	$(".placeSelected").attr("class","placeItem");
	var itemId=obj.attr("id").substring(9,255);
	nowPlace=itemId;
	//setActivePlace(itemId);
	$("#placeItem"+itemId).attr("class","placeSelected");
	originTop=parseInt(obj.css("top"));
	var delta=20;
	for (var i=0;i<10;++i){
		obj.animate({"top":originTop-delta},120);
		obj.animate({"top":originTop},120);
		delta/=1.5;
	}
	//setTimeout("showPlaceInfo("+itemId+")",2000);
	showPlaceInfo(itemId);
}
$(".placeItem").live("click",function(){
	selectPlace($(this));
});
$(".placeSelected").live("click",function(){
	selectPlace($(this));
});

/**
*设置当前没有选中地点
*/
function setNoActivePlace(){
	nowPlace=-1;
	
	$(".actionAnchor").css("opacity","0.4");
	$(".actionAnchor").css("cursor","default");
	$(".actionAnchor").css("color","#ccc");	
}
/**
*设置当前选中地点
*/
function setActivePlace(placeId){
	nowPlace=placeId;
	nowFlag=$("#placeFocus_"+nowPlace).val();
	$(".actionAnchor").animate({"opacity":"1"},200);
	$(".actionAnchor").css("cursor","pointer");
	$(".actionAnchor").css("color","#189de1");	
	$("#main-operate").css({"background-color":"#189de1"});	
	$("#main-operate").css({"background-color":"#fcfcfc"});	
	
}

/**
*显示地点信息
*/
function showPlaceInfo(placeId){
	placeInfo=	'<div style="margin-top:-20px;"><h2>Place Infomation</h2></div>';
	placeInfo+=	"<div id='placeInfoContent' style='overflow:auto;height:370px;'>";
	placeInfo+=		'<div class="placeInfoItem" >这里是：</div>';
	placeInfo+=		'<div class="placeInfoItemContent" >位于 '+$("#thisBuildingName").val()+' '+nowFloor+'层的 '+$("#placeName_"+placeId).val()+'</div>';
	placeInfo+=		'<div class="clear"></div>';
	placeInfo+=		'<div class="placeInfoItem" >关于这里：</div>';
	placeInfo+=		'<div class="placeInfoItemContent" >'+$("#placeIntroduce_"+placeId).val()+'</div>';
	placeInfo+=		'<div class="clear"></div>';
	placeInfo+=		'<div class="placeInfoItem" >这里有：</div>';
	placeInfo+=		'<div class="placeInfoItemContent" >'+getJson("placeId="+placeId,"./php/homePlaceImage.php")+'</div>';
	placeInfo+=		'<div class="clear"></div>';
	placeInfo+=		'<div class="placeInfoItem" style="margin-top:30px;" >我想要：</div>';
	placeInfo+=		'<div class="placeInfoItemContent" style="height:60px;" >';
	if ($("#placeFocus_"+placeId).val()==0)
	placeInfo+=			'<a class="placeInfoOperate" href="javascript:focusThePlace();"><img id="focusLL" class="placeInfoOperate" src="./images/focus.png" title="关注这里" style="margin-right:10px;vertical-align:top;" /></a>';
	else
	placeInfo+=			'<a class="placeInfoOperate" href="javascript:focusThePlace();"><img id="focusLL" class="placeInfoOperate" src="./images/cancelfocus.png" title="取消对这里的关注" style="margin-right:10px;vertical-align:top;" /></a>';
	placeInfo+=			'<a class="placeInfoOperate" href="javascript:showPlaceComment();"><img class="placeInfoOperate" src="./images/comment.png" title="对这里评论"  style="margin-right:10px;vertical-align:top;" /></a>';
	placeInfo+=			'<a class="placeInfoOperate" href="javascript:showPlaceQuestion();"><img class="placeInfoOperate" src="./images/question.png" title="我有疑问"  style="margin-right:10px;vertical-align:top;" /></a>';
	placeInfo+=			'<a class="placeInfoOperate" href="javascript:showPlaceTopic();"><img class="placeInfoOperate" src="./images/topic.png" title="看看这里的活动" style="margin-right:10px;vertical-align:top;" /></a>';
	placeInfo+=			'<a class="placeInfoOperate" href="javascript:showPlaceGame();"><img class="placeInfoOperate" src="./images/game.png" title="玩游戏" style="margin-right:10px;vertical-align:top;" /></a>';	
	placeInfo+=		'</div>';
	placeInfo+=		'<div class="clear"></div>';
	placeInfo+=		'<div class="placeInfoItem" >这里发生了：</div>';
	actionShown=-1;
	var actionContent=getJson("placeId="+placeId+"&actionShown="+actionShown+"&showNumber="+actionShowEachTime,
								"./php/getPlaceAction.php");
	placeInfo+=		'<div class="placeInfoItemContent" id="placeIntroduceAction" >'+actionContent+'</div>';
	placeInfo+=		'<div class="clear"></div>';
	placeInfo+=		"</div>";
	//getJson("placeId="+placeId,"./php/homePlaceInfo.php")
	setTimeout("showDialog(placeInfo,400,600);",2000);
	setTimeout("setActivePlace("+nowPlace+");",3000);
}
//显示地点的更多动态
function placeShowMoreAction(){
	actionShown=$("#actionShown").val();
	$("#moreActionBtn").remove();
	var actionContent=getJson("placeId="+nowPlace+"&actionShown="+actionShown+"&showNumber="+actionShowEachTime,
								"./php/getPlaceAction.php");
	$("#placeIntroduceAction").append(actionContent);
}
//展示图片
function showLargeImage(imgUrl){
	var content="<img src="+imgUrl+" style='max-height:460px;min-height:460px;margin-top:10px;' />";
	showImageDialog(content);
}
//对建筑操作Logo的鼠标事件
$(".placeInfoOperate").live("mouseover",function(){
	$(this).stop(true);
	$(this).animate({"width":60,"height":60},200);
});
$(".placeInfoOperate").live("mouseout",function(){
	$(this).stop(true);
	$(this).animate({"width":48,"height":48},200);
});

/**
*关注这里
*/
function focusThePlace(){
	if (nowPlace!=-1){
		var result=getJson("placeId="+nowPlace+"&flag="+(1-nowFlag),"./php/homeFocusPlace.php");
		if (result!="success") alert(result);else{
			$("#placeFocus_"+nowPlace).val(1-nowFlag);
			if (nowFlag){
				$("#focusLL").attr("src","./images/cancelfocus.png");
				$("#focusLL").attr("title","取消对这里的关注");
			}else{
				$("#focusLL").attr("src","./images/focus.png");
				$("#focusLL").attr("title","关注这里");
			}
			nowFlag=1-nowFlag;
		}
	}
}

/**
*显示地点评论
*/
function showPlaceComment(){
	if (nowPlace!=-1){
		$("#dialog").stop(true);
		closeDialog();
		showDialog(getJson("placeId="+nowPlace,"./php/getPlaceComment.php"),400,600);
	}
}
//用户提交评论
function userSubmitComment(){
	var comment=$("#userCommentContent").val();
	if (comment==""){
		$("#submitCommentStatus").html("内容不能为空");
	}else{
		$("#submitCommentStatus").html("");
		var result=getJson("placeId="+nowPlace+"&comment="+comment,"./php/userSubmitComment.php");
		if (result.indexOf("success")>0)
			$("#dialog-content").html(getJson("placeId="+nowPlace,"./php/getPlaceComment.php"));
		else $("#submitCommentStatus").html(result);
	}
}

/**
*显示地点提问
*/
function getQuestionDialog(){
	var content= '<div style="margin-top:-20px;"><h2>Place Questions</h2><a href="javascript:showPlaceInfo('+nowPlace+');" style="font-size:14px;font-weight:bold;display:block;margin-top:5px;text-decoration:none;"><img src="./images/moveLeft.png" style="vertical-align:bottom;" /> Back to Place Infomation</a></div>'
				+"<div id='placeInfoContent' style='overflow:auto;height:350px;'>"
				+	"<div class='showQuestionItem' style='margin-top:10px;height:140px;'>"
				+		'<textarea id="userQuestionContent" style="margin:10px;width:550px;height:80px;background:white;border:1px solid #ddd;color:#666;font-size:16px;">#我想问问：</textarea>'
				+		'<a style="margin-left:10px;margin-bottom:10px;display:block;width:68px;float:left;" href="javascript:userSubmitQuestion();" ><img id="submitBtn" src="./images/submit.png" onmouseover="elementFadeTo(\'submitBtn\');" onmouseout="elementFadeBack(\'submitBtn\');" /></a>'
				+		'<span id="submitQuestionStatus" style="width:300px;font-size:12px;color:red;float:left;"></span>'
				+	"</div>";
	var questionList=eval("("+getJson("placeId="+nowPlace,"./php/getPlaceQuestionIdList.php")+")");
	if (questionList.length==0) content+="<div style='color:#666;font-size:14px;padding:10px;'>有疑问就快说出来吧，有能力也帮帮别人吧~</div>";
	else{
		for (var i=0;i<questionList.length;++i)
			content+="<div class='showQuestionItem' id='questionItem"+questionList[i]+"'>"
					 +getJson("questionId="+questionList[i],"./php/getQuestionAndItsAnswer.php")
					 +"</div>";
	}
	content+="</div>";
	return content;
}
function showPlaceQuestion(){
	if (nowPlace!=-1){
		$("#dialog").stop(true);
		closeDialog();
		showDialog(getQuestionDialog(),400,600);
	}
}
//用户提交问题
function userSubmitQuestion(){
	var question=$("#userQuestionContent").val();
	if (question==""){
		$("#submitQuestionStatus").html("内容不能为空");
	}else{
		$("#submitQuestionStatus").html("");
		var result=getJson("placeId="+nowPlace+"&question="+question,"./php/userSubmitQuestion.php");
		if (result.indexOf("success")>0)
			$("#dialog-content").html(getQuestionDialog());
		else $("#submitQuestionStatus").html(result);
	}
}
//用户提交回答
function userSubmitAnswer(questionId){
	var answer=$("#userAnswerContent"+questionId).val();
	if (answer==""){
		$("#submitAnswerStatus"+questionId).html("内容不能为空");
	}else{
		$("#submitAnswerStatus"+questionId).html("");
		var result=getJson("questionId="+questionId+"&answer="+answer,"./php/userSubmitAnswer.php");
		if (result.indexOf("success")>0)
			$("#questionItem"+questionId).html(getJson("questionId="+questionId,"./php/getQuestionAndItsAnswer.php"));
		else $("#submitAnswerStatus"+questionId).html(result);
	}
}
//显示回复框
function showAnswerFrame(id){
	$('#answerFrame'+id).slideToggle(200);
}

/**
*显示地点活动
*/
function showPlaceTopic(){
	if (nowPlace!=-1){
		$("#dialog").stop(true);
		closeDialog();
		showDialog(getJson("placeId="+nowPlace,"./php/getPlaceTopic.php"),430,600);
	}
}
//用户提交话题
function userSubmitTopic(){
	var title=$("#userTopicTitle").val();
	var introduce=$("#userTopicIntroduce").val();
	var topictime=$("#userTopicTime").val();
	var organizer=$("#userTopicOrganizer").val();
	var notice=$("#userTopicNotice").val();
	if (title=="") $("#submitTopicStatus").html("活动名称不能为空");else
	if (introduce=="") $("#submitTopicStatus").html("活动简介不能为空");else{
		var result=getJson("placeId="+nowPlace+"&title="+title+"&introduce="+introduce+"&topictime="+topictime+"&organizer="+organizer+"&notice="+notice,"./php/userSubmitTopic.php");
		if (result.indexOf("success")>0)
			$("#dialog-content").html(getJson("placeId="+nowPlace,"./php/getPlaceTopic.php"));
		else $("#submitTopicStatus").html(result);
	}
}
//显示扩展信息
function showTopicExtend(){
	$('#topicExtendInfomation').slideToggle();
}
//查看活动详情
function showTopicDetail(id){
	$("#topicInfomation"+id).slideToggle(200);
}
//参加活动
function joinTopic(id,flag){
	var response=getJson("topicId="+id+"&flag="+flag,"./php/userJoinTopic.php");
	if (response.indexOf("success")>0){
		if (flag==1){
			$("#joinOrNot"+id).html('<a class="answerLogo" href="javascript:joinTopic('+id+',0);" title="我不去了" style="display:block;" ><img src="./images/dontjoin.png" /></a>');
		}else{
			$("#joinOrNot"+id).html('<a class="answerLogo" href="javascript:joinTopic('+id+',1);" title="我要参加" style="display:block;" ><img src="./images/join.png" /></a>');
		}
	}else $("#joinStatus"+id).html(response);
}

/**
*显示地点游戏
*/
function showPlaceGame(){
	if (nowPlace!=-1){
		$("#dialog").stop(true);
		closeDialog();
		showDialog(getJson("placeId="+nowPlace,"./php/getPlaceGame.php"),450,700);
	}
}