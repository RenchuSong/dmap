var globalActionIdList;															//全局保存当前用户的动态Id列表
var userSpaceActionShown=0;														//已经显示出来的动态条数
var userspaceShowActionEachTime=10;												//用户空间每次显示动态数目
/**
*编辑资料按钮绑定鼠标事件
*/
$("#edit-userinfo,#return-friendList,#dialog-close,#moreActions,.linkUserSpace").live("mouseover",function(){
	$(this).stop(true);
	$(this).animate({"opacity":"0.2"},200);
	$(this).animate({"opacity":"1"},200);
	$(this).animate({"opacity":"0.2"},200);
	$(this).animate({"opacity":"1"},200);
});

$(".operateUserBtn").live("mouseover",function(){
	$(this).stop(true);
	$(this).animate({"opacity":"0.2"},200);
	$(this).animate({"opacity":"1"},200);
});

/**
*提交用户信息修改
*/
function submitChangeUserInfo(){
	var webpage=$("#edit-userWebpage").val();
	var content=encodeURIComponent(GetContents());
	var result=getJson("webpage="+webpage+"&introduce="+content,"./php/submitChangeUserInfo.php");
	if (result.indexOf("success")>0){
		window.location="./index.php?topid=userinfo";
	}else changeUserInfoStatus.html(result);
}

/**
*前往某用户的信息页面
*/
function gotoUser(uId){
	window.location="./index.php?topid=userfriends&userId="+uId;
}

/**
*修改好友情况
*/
function opFriend(uId,flag){
	var result=getJson("userId="+uId+"&flag="+flag,"./php/operateFriend.php");
	if (result.indexOf("success")>0)
		window.location="./index.php?topid=userfriends&userId="+uId;
	else alert(result);
}

/**
*显示接下来的动态
*/
function showNextActions(){
	if (globalActionIdList.length==0){
		$("#userSpaceActionContainer").append(
			"<div class='showCommentItem' style='text-align:center;padding-top:5px;padding-bottom:5px;color:#666;font-size:14px;'>你还没有动态哦~关注地点，那里的动态不再错过~添加好友，看看他们干了什么~</div>"
		);
	}else
	if (userSpaceActionShown==globalActionIdList.length){
		$("#moreActionBtn").remove();
		$("#userSpaceActionContainer").append(
			"<div class='showCommentItem' style='text-align:center;padding-top:5px;padding-bottom:5px;color:#666;'>没有更早的动态了</div>"
		);
	}else{
		for (var i=0;i<userspaceShowActionEachTime && userSpaceActionShown<globalActionIdList.length;++i,++userSpaceActionShown){
			var actionItem=eval("("+getJson("actionId="+globalActionIdList[userSpaceActionShown],"./php/getActionJson.php")+")");
			//alert(actionItem.actionType);
			switch(actionItem.actionType){
				case "1":showFocusAction(actionItem);break;
				case "2":showCommentAction(actionItem);break;
				case "3":showQuestionAction(actionItem);break;
				case "4":showTopicAction(actionItem);break;
				case "5":showJoinAction(actionItem);break;
				default:break;
			}
		}
		$("#moreActionBtn").remove();
		$("#userSpaceActionContainer").append(
			'<div id="moreActionBtn" style="text-align:center;">'
				+'<a id="moreActions" href="javascript:showNextActions();" style="color:#189DE1;"><img src="./images/moveDown.png" style="vertical-align:bottom;"> 更多动态</a>'
				+'<input id="actionShown" type="hidden" value="66">'
			+'</div>'
		);
	}
}
//显示动态：某人关注了某地
function showFocusAction(actionItem){
	$("#userSpaceActionContainer").append(getJson("userId="+actionItem.actionUserId+"&placeId="+actionItem.actionPlaceId+"&time="+actionItem.actionTime,"./php/actionUserFocusPlace.php"));
}
//显示动态：某人评论了某地
function showCommentAction(actionItem){
	$("#userSpaceActionContainer").append(getJson("comment="+actionItem.actionIntroduce+"&userId="+actionItem.actionUserId+"&placeId="+actionItem.actionPlaceId+"&time="+actionItem.actionTime,"./php/actionUserCommentPlace.php"));
}
//显示动态：某人在某地提问
function showQuestionAction(actionItem){
	$("#userSpaceActionContainer").append('<div id="showQuestionItem'+globalActionIdList[userSpaceActionShown]+'" class="showQuestionItem" style="background:#fcfcfc;min-height:50px;">'+getJson("actionId="+globalActionIdList[userSpaceActionShown]+"&questionId="+actionItem.actionIntroduce.substring(1,actionItem.actionIntroduce.indexOf("]"))+"&placeId="+actionItem.actionPlaceId,"./php/actionUserQuestionPlace.php")+'</div>');
}//提交答案
function userspaceSubmitAnswer(actionId,questionId,placeId){
	var answer=$("#userAnswerContent"+questionId).val();
	if (answer==""){
		$("#userspaceSubmitAnswerStatus"+questionId).html("内容不能为空");
	}else{
		$("#userspaceSubmitAnswerStatus"+questionId).html("");
		var result=getJson("questionId="+questionId+"&answer="+answer,"./php/userSubmitAnswer.php");
		if (result.indexOf("success")>0)
			$("#showQuestionItem"+actionId).html(getJson("actionId="+actionId+"&questionId="+questionId+"&placeId="+placeId,"./php/actionUserQuestionPlace.php"));
		else $("#userspaceSubmitAnswerStatus"+questionId).html(result);
	}
}
//显示动态：某人在某地发布活动
function showTopicAction(actionItem){
	$("#userSpaceActionContainer").append(getJson("topicId="+actionItem.actionIntroduce.substring(1,actionItem.actionIntroduce.indexOf("]")),"./php/actionUserTopicPlace.php"));
}

//显示动态：某人在参加某活动
function showJoinAction(actionItem){
	$("#userSpaceActionContainer").append(getJson("userId="+actionItem.actionUserId+"&topicId="+actionItem.actionIntroduce.substring(1,actionItem.actionIntroduce.indexOf("]")),"./php/actionUserJoinTopic.php"));
}