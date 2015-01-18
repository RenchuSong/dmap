var selectBuildingId=-1;								//目前选中的建筑
var selectFloor=1;										//目前选中的楼层

var operateType=1;										//操作类型：1 添加地点；2 删除地点；3 评论管理；4 提问管理；5 活动管理；6 游戏管理；7 地点信息
var placeX=0,placeY=0;									//插入节点的位置
var selectPlaceId=-1;									//选择地点Id

/**
*初始化操作标记
*/
function resetFlag(){
	selectBuildingId=-1;
	selectFloor=1;
}

/**
*添加地点初始化
*/
function setAddingPlace(){
	$(".adminOptionActiveButton").attr("class","adminOptionButton");
	$("#addPlace").attr("class","adminOptionActiveButton");
	operateType=1;
	moveControlPanel(0);
}

/**
*删除地点初始化
*/
function setDeletePlace(){
	$(".adminOptionActiveButton").attr("class","adminOptionButton");
	$("#deletePlace").attr("class","adminOptionActiveButton");
	operateType=2;
	moveControlPanel(1);
}

/**
*管理评论初始化
*/
function setAdminComment(){
	$(".adminOptionActiveButton").attr("class","adminOptionButton");
	$("#adminComment").attr("class","adminOptionActiveButton");
	operateType=3;
	moveControlPanel(2);
}

/**
*管理提问初始化
*/
function setAdminQuestion(){
	$(".adminOptionActiveButton").attr("class","adminOptionButton");
	$("#adminQuestion").attr("class","adminOptionActiveButton");
	operateType=4;
	moveControlPanel(3);
}

/**
*管理活动初始化
*/
function setAdminEvent(){
	$(".adminOptionActiveButton").attr("class","adminOptionButton");
	$("#adminEvent").attr("class","adminOptionActiveButton");
	operateType=5;
	moveControlPanel(4);
}

/**
*管理游戏初始化
*/
function setAdminGame(){
	$(".adminOptionActiveButton").attr("class","adminOptionButton");
	$("#adminGame").attr("class","adminOptionActiveButton");
	operateType=6;
	moveControlPanel(5);
}

/**
*地点信息管理初始化
*/
function setAdminPlaceInfo(){
	$(".adminOptionActiveButton").attr("class","adminOptionButton");
	$("#adminPlaceInfo").attr("class","adminOptionActiveButton");
	operateType=7;
	moveControlPanel(6);	
}

/**
*校区变化
*/
function getCampusName(){
	switch (campusId){
		case 1:return "邯郸校区";break;
		case 2:return "张江校区";break;
		case 3:return "江湾校区";break;
		case 4:return "枫林校区";
	}
}
function changeCampus(){
	campusId=$("#selectCampusId").val();
	selectBuildingId=-1;
	$("#selectFloor").html("");
	$.ajax({
        type: "POST",
        url: "../php/getCampusBuildingSelect.php",
        cache: false,
		data:  'campusId='+campusId, 
        success: function (content) {
			$("#selectBuilding").html(content);
        }
    });
	//$("#uploadFloorImage").html("");
	$("#uploadFloorImage").fadeOut(10);
	$("#operatePlaceData").html("");
	$("#operatePlaceData").attr("style","");
}

/**
*建筑变化
*/
function changeBuilding(){
	selectBuildingId=$("#selectBuildingId").val();
	selectFloor=1;
	if (selectBuildingId==-1)
		$("#selectFloor").html("");
	else{
		$.ajax({
			type: "POST",
			url: "../php/getBuildingFloorSelect.php",
			cache: false,
			data:  'buildingId='+selectBuildingId, 
			success: function (content) {
				$("#selectFloor").html(content);
			}
		});
	}
	//$("#uploadFloorImage").html("上传楼层背景图：<input type='file' id='floorImage' /><input type='submit' value='上传' onclick='javascript:uploadFloorImage();'/>");
	$("#uploadFloorImage").fadeIn();
}
/**
*楼层变化
*/
function changeFloor(){
	$("#operatePlaceData").attr("style","background-image:url('../images/Building/BuildingStruct_"+selectBuildingId+"_"+selectFloor+".jpg');");
	getFloorPlace();
	/**
	*上传楼层文件
	*/
	var btnUpload=$('#upload');  
	var status=$('#status');  
	new AjaxUpload(btnUpload, {  
		action: '../php/uploadFloorImage.php?buildingId='+selectBuildingId+'&floor='+selectFloor,  
		//Name of the file input box  
		name: 'uploadfile',  
		onSubmit: function(file, ext){  
			if (! (ext && /^(jpg)$/.test(ext))){  
				  // check for valid file extension  
				status.text('只能上传jpg文件');  
				return false;  
			}  
			status.text('正在上传...');  
		},  
		onComplete: function(file, response){  
			//On completion clear the status  
			status.text("");  
			//Add uploaded file to list  
			if(response==="success"){  
				alert("上传成功！");
				$("#operatePlaceData").attr("style","");
				$("#operatePlaceData").attr("style","background-image:url('../images/Building/BuildingStruct_"+selectBuildingId+"_"+selectFloor+".jpg');");
			} else{  
				alert("上传失败！"); 
			}  
		}  
	});
}
$(function(){
	$("#selectCampusId").change(function(e){
		changeCampus();
	});
	$("#selectBuildingId").live("change",function(){
		changeBuilding();
		changeFloor();
	});
	$("#selectFloor").live("change",function(){
		var floor=$(this).val();
		if (floor!="")
			selectFloor=floor;
		changeFloor();
	});
});

/**
*获取某层楼的所有地点
*/
function getFloorPlace(){
	$.ajax({
        type: "POST",
        url: "../php/getFloorPlace.php",
        cache: false,
		data:  "buildingId="+selectBuildingId+"&floor="+selectFloor+"&width="+mapShowWidth+"&height="+mapShowHeight, 
        success: function (content) {
			$("#operatePlaceData").html(content);
        }
    });
}

$(function(){
	$("#operatePlaceData").mouseup(function(e){
		/**
		*添加地点
		*/
		if (operateType==1){
			if (selectBuildingId==-1){
				alert("请选择要添加地点的建筑");
				return;
			}else{
				getScrollPosition();
				var operateOffsetX=$("#operateFrame").offset().left;  			//父亲相对于页面处于最左侧时的边距
				var P=e.clientX-operateOffsetX+scrollLeft;
				var operateOffsetY=$("#operateFrame").offset().top;  			//父亲相对于页面处于最左侧时的边距
				var PP=e.clientY-operateOffsetY+scrollTop;
				placeX=P*100/mapShowWidth;
				placeY=PP*100/mapShowHeight;
				$('#maskFrame').fadeTo(50,0.5);
				$('#addBuildingData').fadeIn(50);
			}	
		}
	});
});

/**
*取消增加地点
*/
function cancelAddPlace(){
	$("#placeName").val("");
	$("#placeIntroduce").val("");
	$('#maskFrame').fadeOut(50);
	$('#addBuildingData').fadeOut(50);
}
/**
*取消编辑地点
*/
function  cancelEditPlace(){
	$("#editPlaceName").val("");
	$("#editPlaceIntroduce").val("");
	$('#maskFrame').fadeOut(50);
	$('#editPlaceData').fadeOut(50);	
}

/**
*Ajax增加地点
*/
function addingPlace(){
	var placeName=$("#placeName").val();
	var placeIntroduce=$("#placeIntroduce").val();
	if (placeName=="") alert("地点名称不能为空");
	else if (placeIntroduce=="") alert("地点简介不能为空");
	else{
		$.ajax({
			type: "POST",
			url: "../php/addPlace.php",
			cache: false,
			data:  "campusId="+campusId+"&buildingId="+selectBuildingId
					+"&floor="+selectFloor+"&placeName="+placeName
					+"&placeIntroduce="+placeIntroduce+"&placeX="+placeX+"&placeY="+placeY, 
			success: function (content) {
				$("#operatePlaceData").append(
					"<div id='placeItem"+content.replace(/(^\s*)|(\s*$)/g, "") +"' class='placeItem' style='left:"+parseInt(placeX/100*mapShowWidth-15)
					+"px;top:"+parseInt(placeY/100*mapShowHeight-20)+"px;' title='"+placeName+"'></div>"
				);
				cancelAddPlace();	
			}
		});
	}
}

/**
*操作面板移动
*/
$(function(){
	$("#selectPanel").mouseover(function(){
		$("#selectPanel").animate({top:0},100);
	});
	$("#operatePlaceData").mousemove(function(e){
		getScrollPosition();
		var y=e.clientY-$("#operateFrame").offset().top+scrollTop; 
		if (y>120) $("#selectPanel").animate({top:5-parseInt($("#selectPanel").css("height"))},100);
	});
});

/**
*地点点击
*/
$(".placeItem").live("click",function(){
	selectPlaceId=$(this).attr("id").substring(9,255);
	if (operateType==2){
		//删除地点
		deletePlace($(this));
	}
	else if (operateType==7){
		//编辑地点
		editPlace($(this));
		var btnUpload=$('#uploadPlaceImage');  
		var status=$('#statusPlaceImage');  
		new AjaxUpload(btnUpload, {  
			action: '../php/uploadPlaceImage.php?placeId='+selectPlaceId,  
			//Name of the file input box  
			name: 'uploadfile',  
			onSubmit: function(file, ext){  
				if (! (ext && /^(jpg|bmp|png|gif)$/.test(ext))){  
					  // check for valid file extension  
					status.text('只能上传jpg、bmp、png、gif文件');  
					return false;  
				}  
				status.text('正在上传...');  
			},  
			onComplete: function(file, response){  
				//On completion clear the status  
				status.text("");  
				//Add uploaded file to list  
				if(response==="success"){  
					loadPlaceImage();
				} else{  
					status.text('上传失败'); 
				}  
			}  
		});
	}
	else if (operateType==3){
		$('#maskFrame').fadeTo(50,0.5);
		$('#showPlaceActionData').fadeIn(50);
		$.ajax({
			type: "POST",
			url: "../php/showPlaceComment.php",
			cache: false,
			data:  "placeId="+selectPlaceId, 
			success: function (content) {
				$(actionContainer).html(content);
			}
		});
	}
	else if (operateType==4){
		$('#maskFrame').fadeTo(50,0.5);
		$('#showPlaceActionData').fadeIn(50);
		$.ajax({
			type: "POST",
			url: "../php/showPlaceQuestion.php",
			cache: false,
			data:  "placeId="+selectPlaceId, 
			success: function (content) {
				$(actionContainer).html(content);
			}
		});
	}
	else if (operateType==5){
		$('#maskFrame').fadeTo(50,0.5);
		$('#showPlaceActionData').fadeIn(50);
		$.ajax({
			type: "POST",
			url: "../php/showPlaceEvent.php",
			cache: false,
			data:  "placeId="+selectPlaceId, 
			success: function (content) {
				$(actionContainer).html(content);
			}
		});
	}
	else if (operateType==6){
		$('#maskFrame').fadeTo(50,0.5);
		$('#showPlaceActionData').fadeIn(50);
		$.ajax({
			type: "POST",
			url: "../php/showPlaceGame.php",
			cache: false,
			data:  "placeId="+selectPlaceId, 
			success: function (content) {
				$(actionContainer).html(content);
				var btnUpload=$('#uploadPlaceGame');  
				var status=$('#statusPlaceGame');  
				new AjaxUpload(btnUpload, {  
					action: '../php/uploadPlaceGame.php?placeId='+selectPlaceId,  
					//Name of the file input box  
					name: 'uploadfile',  
					onSubmit: function(file, ext){  
						status.text('正在上传...');  
					},  
					onComplete: function(file, response){  
						//On completion clear the status  
						status.text("");  
						//Add uploaded file to list  
						if(response==="success"){  
							$("#placeItem"+selectPlaceId).click();
						} else{  
							alert(response);
							status.text('上传失败'); 
						}  
					}  
				});
			}
		});
	}
	
	//$("#operatePlaceData").unbind("mouseup");
});

/**
*删除地点
*/
function deletePlace(obj){
	$.ajax({
        type: "POST",
        url: "../php/deletePlace.php",
        cache: false,
		data:  "placeId="+selectPlaceId, 
        success: function (content) {
			if (content.indexOf("Error")>0) alert(content);else
				obj.remove();
        }
    });
}

/**
*编辑地点
*/
//载入地点图片
function loadPlaceImage(){
	$.ajax({
        type: "POST",
        url: "../php/loadPlaceImage.php",
        cache: false,
		data:  "placeId="+selectPlaceId, 
        success: function (content) {
			$("#placeImageContainer").html(content);
        }
    });
}
//载入地点信息
function loadPlaceInfo(){
	$.ajax({
        type: "POST",
        url: "../php/loadPlaceInfo.php",
        cache: false,
		dataType: "json",
		data:  "placeId="+selectPlaceId, 
        success: function (content) {
			$("#editPlaceName").val(content.placeName);
			$("#editPlaceIntroduce").val(content.placeIntroduce);
        }
    });
}
//编辑地点
function editPlace(obj){
	$('#maskFrame').fadeTo(50,0.5);
	$('#editPlaceData').fadeIn(50);	
	loadPlaceImage();
	loadPlaceInfo();
}
//提交地点修改信息
function submitEditPlace(){
	$.ajax({
        type: "POST",
        url: "../php/editPlace.php",
        cache: false,
		data:  "placeId="+selectPlaceId+"&placeName="+$("#editPlaceName").val()+"&placeIntroduce="+$("#editPlaceIntroduce").val(), 
        success: function (content) {
			cancelEditPlace();
			getFloorPlace();
        }
    });	
}
//关闭地点动态
function closePlaceAction(){
	$('#maskFrame').fadeOut(50);
	$('#showPlaceActionData').fadeOut(50);
}

/**
*删除评论
*/
function deleteComment(id){
	$.ajax({
        type: "POST",
        url: "../php/deleteComment.php",
        cache: false,
		data:  "commentId="+id, 
        success: function (content) {
			if (content.indexOf("Error")>0) alert(content);
			else $("#actionItem"+id).remove();
        }
    });	
}

/**
*删除评论
*/
function deleteQuestion(id){
	$.ajax({
        type: "POST",
        url: "../php/deleteQuestion.php",
        cache: false,
		data:  "questionId="+id, 
        success: function (content) {
			if (content.indexOf("Error")>0) alert(content);
			else $("#actionItem"+id).remove();
        }
    });	
}

/**
*删除话题
*/
function deleteTopic(id){
	$.ajax({
        type: "POST",
        url: "../php/deleteTopic.php",
        cache: false,
		data:  "topicId="+id, 
        success: function (content) {
			if (content.indexOf("Error")>0) alert(content);
			else $("#actionItem"+id).remove();
        }
    });	
}

/**
*删除游戏
*/
function deleteGame(id){
	$.ajax({
        type: "POST",
        url: "../php/deleteGame.php",
        cache: false,
		data:  "gameId="+id, 
        success: function (content) {
			if (content.indexOf("Error")>0) alert(content);
			else $("#actionItem"+id).remove();
        }
    });	
}