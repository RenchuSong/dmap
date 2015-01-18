var addingNode=false;									//是否在增加节点
var addingBuilding=false;								//是否在增加建筑
var deleteNode=false;									//是否在删除节点
var deleteBuilding=false;								//是否在删除建筑
var operatePath=0;										//是否添加路径
var mapOriginWidth=1800;								//地图初始宽度
var mapOriginHeight=1400;								//地图初始高度
var selectNode1=-1,selectNode2=-1;						//路径相关时选择两个节点
var nodeX,nodeY;										//存储节点
var itemId;

/**
*初始化操作标记
*/
function resetFlag(){
	$("#operateMapData").html("");	//清空容器
	addingNode=false;
	addingBuilding=false;
	deleteNode=false;
	deleteBuilding=false;
	operatePath=0;
	selectNode1=-1;
	selectNode2=-1;
	$(".adminOptionActiveButton").attr("class","adminOptionButton");
}

/**
*添加节点初始化
*/
function setAddingNode(){
	resetFlag();
	$("#addNode").attr("class","adminOptionActiveButton");
	addingNode=true;
	showNodes();
	moveControlPanel(1);
}

/**
*删除节点初始化
*/
function setDeleteNode(){
	resetFlag();
	$("#deleteNode").attr("class","adminOptionActiveButton");
	deleteNode=true;
	showNodes();
	showBuildings();
	moveControlPanel(2);
}

/**
*用于ajax向数据库添加节点
*/
function addNode(relativeX,relativeY){
	nodeX=relativeX*100/mapOriginWidth;
	nodeY=relativeY*100/mapOriginHeight;

	$.ajax({
        type: "POST",
        url: "../php/addNode.php",
        cache: false,
		data:  'nodeCampusId='+campusId+'&nodeX='+nodeX+'&nodeY='+nodeY, 
        success: function (content) {
			$("#operateMapData").append("<div id='nodeItem"+content+"' class='nodeItem' style='left:"+(relativeX-3)+"px;top:"+(relativeY-3)+"px;'></div>");
        }
    });
}

/**
*显示所有节点
*/
function showNodes(){
	$.ajax({
        type: "POST",
        url: "../php/showNode.php",
        cache: false,
		data:  'nodeCampusId='+campusId+'&width='+mapOriginWidth+'&height='+mapOriginHeight, 
        success: function (content) {
			$("#operateMapData").append(content);
        }
    });
}

/**
*添加建筑初始化
*/
function setAddingBuilding(){
	resetFlag();
	$("#addBuilding").attr("class","adminOptionActiveButton");
	addingBuilding=true;
	showBuildings();
	moveControlPanel(4);
}

/**
*显示所有建筑
*/
function showBuildings(){
	$.ajax({
        type: "POST",
        url: "../php/showBuilding.php",
        cache: false,
		data:  'nodeCampusId='+campusId+'&width='+mapOriginWidth+'&height='+mapOriginHeight,  
        success: function (content) {
			$("#operateMapData").append(content);
        }
    });
}

/**
*用于ajax向数据库添加建筑
*/
function addBuilding(relativeX,relativeY){
	nodeX=relativeX*100/mapOriginWidth;
	nodeY=relativeY*100/mapOriginHeight;

	$('#maskFrame').fadeTo(50,0.5);
	$('#addBuildingData').fadeIn(50);
}
$(function(){
	$("#submitBuildingData").click(function(){
		if ($("#buildingName").attr("value")=="") alert("建筑名称不能为空");
		else if ($("#buildingFloor").attr("value")=="") alert("建筑层数不能为空");
		else if ($("#buildingIntroduce").attr("value")=="") alert("建筑简介不能为空");
		else {
			var buildingName=$("#buildingName").attr("value");
			var buildingFloor=$("#buildingFloor").attr("value");
			var buildingIntroduce=$("#buildingIntroduce").attr("value");
			
			$.ajax({
				type: "POST",
				url: "../php/addBuilding.php",
				cache: false,
				data:  'nodeCampusId='+campusId+'&buildingName='+buildingName+'&buildingFloor='+buildingFloor+'&buildingIntroduce='+buildingIntroduce+'&nodeX='+nodeX+'&nodeY='+nodeY+"&selectBuilding="+$("#selectBuilding").attr("value"), 
				success: function (content) {
					if (content.indexOf("Error")>0) alert(content);
					else if (content.indexOf("Update")<1)
						$("#operateMapData").append("<div id='buildingItem"+content+"' class='buildingItem' style='left:"+(parseInt(nodeX*mapOriginWidth/100)-15)+"px;top:"+(parseInt(nodeY*mapOriginHeight/100)-20)+"px;' title='"+buildingName+"'></div>");
					else $("#buildingItem"+itemId).attr("title",buildingName);
					$('#maskFrame').fadeOut(50);
					$('#addBuildingData').fadeOut(50);
					$("#buildingName").attr("value","");
					$("#buildingFloor").attr("value","");
					$("#buildingIntroduce").attr("value","");
					$("#selectBuilding").attr("value","");
				}
			});
		}
	});
});

/**
*修改建筑信息、删除建筑
*/
$(function(){
	$(".buildingItem").live("click",function(){
		itemId=$(this).attr("id").substring(12,255);
		//修改建筑信息
		if (addingBuilding==true){
			$("#selectBuilding").attr("value",itemId);
			$.ajax({
				type: "POST",
				url: "../php/getBuilding.php",
				cache: false,
				data:  'buildingId='+itemId,  
				success: function (content) {
					var contentList=content.split("【ContentSplitItem】");
					$("#buildingName").attr("value",contentList[1]);
					$("#buildingFloor").attr("value",contentList[2]);
					$("#buildingIntroduce").attr("value",contentList[3]);
					$("#operateMapData").mousedown();
				}
			});
			setTimeout("$(\"#placeImageContainer\").html(\"<img src=\'../images/Building/Building_\"+itemId+\".jpg\' style=\'max-width:300px;min-width:300px;\' />\");",2000);
			//上传建筑图片
			var btnUpload=$('#uploadPlaceImage');  
			var status=$('#statusPlaceImage');  
			new AjaxUpload(btnUpload, {  
				action: '../php/uploadBuildingImage.php?buildingId='+itemId,  
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
						$("#placeImageContainer").html("<img src='../images/Building/Building_"+itemId+".jpg' style='max-width:300px;min-width:300px;' />");
					} else{  
						status.text('上传失败'); 
					}  
				}  
			});
		}
		
		//}
		//删除建筑
		if (deleteBuilding==true){
			var item=$(this);
			$.ajax({
				type: "POST",
				url: "../php/deleteBuilding.php",
				cache: false,
				data:  'buildingId='+itemId, 
				success: function (content){
					item.remove();
				}
			});
		}
	});
});

/**
*删除建筑初始化
*/
function setDeleteBuilding(){
	resetFlag();
	$("#deleteBuilding").attr("class","adminOptionActiveButton");
	deleteBuilding=true;
	showBuildings();
	moveControlPanel(5);
}

/**
*取消建筑修改操作
*/
function cancelBuildingOperate() {
	$('#maskFrame').fadeOut(50);
	$('#addBuildingData').fadeOut(50);
	$("#buildingName").attr("value","");
	$("#buildingFloor").attr("value","");
	$("#buildingIntroduce").attr("value","");
	$("#selectBuilding").attr("value","");
}

/**
*两点之间画线
*/
function drawLine(x1,y1,x2,y2){
	var minX=x1,maxX=x2;
	if (minX>maxX){
		minX+=maxX;
		maxX=minX-maxX;
		minX-=maxX;
	}
	var minY=y1,maxY=y2;
	if (minY>maxY){
		minY+=maxY;
		maxY=minY-maxY;
		minY-=maxY;
	}
	
	if (x1==x2)
		$("#operateMapData").append(
			"<div class='linePixel' style='width:3px;height:"
			+(maxY-minY)+"px;background:url(\"../images/nodeRoad/90.png\");left:"
			+minX+"px;top:"+minY+"px;'></div>"
		);
	else
	if (y1==y2)
		$("#operateMapData").append(
			"<div class='linePixel' style='width:"+(maxX-minX)
			+"px;height:3px;background:url(\"../images/nodeRoad/0.png\");left:"
			+minX+"px;top:"+minY+"px;'></div>"
		);
	else{
		if ((x1-x2)*(y1-y2)>0){
			var angle=Math.round((Math.atan((maxY-minY)/(maxX-minX))/PI*180));
			$("#operateMapData").append(
				"<div class='linePixel' style='width:"+(maxX-minX+2)
				+"px;height:"+(maxY-minY+2)+"px;background:url(\"../images/nodeRoad/"+angle
				+".png\");left:"+minX+"px;top:"+minY+"px;'></div>"
			);
		}else{
			var angle=Math.round((Math.atan((maxY-minY)/(maxX-minX))/PI*180));
			$("#operateMapData").append(
				"<div class='linePixel' style='width:"+(maxX-minX+2)
				+"px;height:"+(maxY-minY+2)+"px;background:url(\"../images/nodeRoad/_"+angle
				+".png\");background-position:0 "+(maxY-minY-150)
				+"px;left:"+minX+"px;top:"+minY+"px;'></div>"
			);
		}
	}
}

/**
*用于ajax向数据库添加路径
*/
function editPath(x1,y1,x2,y2){
	setTimeout('$("#addPathSelectNode1Id").attr("value","");',200);
	setTimeout('$("#addPathSelectNode1X").attr("value","");',200);
	setTimeout('$("#addPathSelectNode1Y").attr("value","");',200);
	setTimeout('$("#addPathSelectNode2Id").attr("value","");',200);
	setTimeout('$("#addPathSelectNode2X").attr("value","");',200);
	setTimeout('$("#addPathSelectNode2Y").attr("value","");',200);
	
	if (x1-x2>150 || y1-y2>150 || x2-x1>150 || y2-y1>150) {
		alert("对不起，不能将相距甚远的两点相连！");
		selectNode1=selectNode2=-1;
		return;
	}
	var requestUrl;
	if (operatePath==1) requestUrl="../php/addPath.php";
	if (operatePath==2) requestUrl="../php/deletePath.php";
	
	$.ajax({
        type: "POST",
        url: requestUrl,
        cache: false,
		data:  'node1='+selectNode1+'&node2='+selectNode2, 
        success: function (content) {
			if (operatePath==1){
				drawLine(Math.round(x1),Math.round(y1),Math.round(x2),Math.round(y2));
			}else if (operatePath==2){
				$("#operateMapData").html("");	//清空容器
				showNodes();
				showPaths();
			}
			selectNode1=selectNode2=-1;
        }
    });
}

/**
*显示所有路线
*/
function showPaths(){
	$.ajax({
		type: "POST",
		url: "../php/showPath.php",
		cache: false,
		data: 'nodeCampusId='+campusId+'&width='+mapOriginWidth+'&height='+mapOriginHeight, 
		success: function (content) {
			var nodeList=content.split("|");
			var edgeNumber=(nodeList.length-1)/4;
			for (var i=0;i<edgeNumber;++i){
				drawLine(Math.round(nodeList[i*4+1]),Math.round(nodeList[i*4+2]),Math.round(nodeList[i*4+3]),Math.round(nodeList[i*4+4]));
			}
		}
	});
}

/**
*添加路径初始化
*/
function setAddingPath(){
	resetFlag();
	$("#addPath").attr("class","adminOptionActiveButton");
	operatePath=1;
	showPaths();
	showNodes();
	showBuildings();
	moveControlPanel(3);
}

/**
*删除路径初始化
*/
function setDeletePath(){
	resetFlag();
	$("#deletePath").attr("class","adminOptionActiveButton");
	operatePath=2;
	showNodes();
	showPaths();
	showBuildings();
	moveControlPanel(3);
}

/**
*控制地图的拖动行为
*/
$(function(){
	$("#operateMapData").mousedown(function(e){			//鼠标按下
		$("#placeImageContainer").html("");
		$("#operateMapData").css("cursor","move");
		var minX=mapShowWidth-mapOriginWidth,maxX=0;
		var minY=mapShowHeight-mapOriginHeight,maxY=0;		
		var isAddingNode=false;							//标记是否在加点
		var isAddingBuilding=false;						//标记是否在加建筑
		var $theDiv=$(this);  							//要拖动的DIV对象
		
		getScrollPosition();

		var operateOffsetX=$("#operateFrame").offset().left;  			//父亲相对于页面处于最左侧时的边距
		var mapOffsetX=parseInt($("#operateMapData").css("left"));		//Map相对于父亲元素的偏移
		var P=e.clientX-operateOffsetX+scrollLeft;
		var operateOffsetY=$("#operateFrame").offset().top;  			//父亲相对于页面处于最左侧时的边距
		var mapOffsetY=parseInt($("#operateMapData").css("top"));		//Map相对于父亲元素的偏移
		var PP=e.clientY-operateOffsetY+scrollTop;
		
		$(document).mousemove(function(e){				//鼠标拖动
			if (addingNode==true){
				addingNode=false;						//不让加节点
				isAddingNode=true;
			}
			if (addingBuilding==true){
				addingBuilding=false;					//不让加建筑
				isAddingBuilding=true;
			}
			$("#operateMapData").css("cursor","move");
			var P2=e.clientX-operateOffsetX+scrollLeft;
			var divX=P2-P+mapOffsetX;
			var PP2=e.clientY-operateOffsetY+scrollTop;
			var divY=PP2-PP+mapOffsetY;
			
			if (divX>minX && divX<maxX)					//在合理范围内，允许移动
				$theDiv.css({"left":divX});
			else if (divX<=minX) $theDiv.css({"left":minX+1});
			else if (divX>=maxX) $theDiv.css({"left":maxX-1});
			
			if (divY>minY && divY<maxY)					//在合理范围内，允许移动
				$theDiv.css({"top":divY});
			else if (divY<=minY) $theDiv.css({"top":minY+1});
			else if (divY>=maxY) $theDiv.css({"top":maxY-1});
			
			//防止拖动中选中
			if(document.selection){						//IE ,Opera
				if(document.selection.empty) {
					document.selection.empty();			//IE
				}
				else {									//Opera
					document.selection = null;
				}
			}
			else if(window.getSelection){				//FF,Safari
				window.getSelection().removeAllRanges();
			}
		});
		
		$(document).mouseup(function(e){				//在鼠标释放时
			$("#operateMapData").css("cursor","default");
			getScrollPosition();

			var relativeX=P-mapOffsetX;
			var relativeY=PP-mapOffsetY;
			
			$(document).unbind("mousemove");
			$(document).unbind("mouseup");
			if (isAddingNode==true) addingNode=true;
			else if (addingNode==true) {
				addNode(relativeX,relativeY);
			}
			if (isAddingBuilding==true) addingBuilding=true;
			else if (addingBuilding==true) {
				addBuilding(relativeX,relativeY);
			}
		});
	});
	
	$(".nodeItem").live("click",function(){
		var item=$(this);
		//删除节点
		if (deleteNode==true){
			$.ajax({
				type: "POST",
				url: "../php/deleteNode.php",
				cache: false,
				data:  'nodeId='+$(this).attr("id").substring(8,255), 
				success: function (content){
					item.remove();
				}
			});
		}
		//添加路径
		if (operatePath>0){
			if (selectNode1==-1){
				selectNode1=item.attr("id").substring(8,255);
				$("#addPathSelectNode1Id").attr("value",selectNode1);
				$("#addPathSelectNode1X").attr("value",parseInt(item.css("left"))+3);
				$("#addPathSelectNode1Y").attr("value",parseInt(item.css("top"))+3);
			}else{
				selectNode2=item.attr("id").substring(8,255);
				$("#addPathSelectNode2Id").attr("value",selectNode2);
				$("#addPathSelectNode2X").attr("value",parseInt(item.css("left"))+3);
				$("#addPathSelectNode2Y").attr("value",parseInt(item.css("top"))+3);
				editPath($("#addPathSelectNode1X").attr("value"),$("#addPathSelectNode1Y").attr("value"),
						$("#addPathSelectNode2X").attr("value"),$("#addPathSelectNode2Y").attr("value")
				);
			}
		}
	});
});
