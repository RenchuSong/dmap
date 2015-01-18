var campusId=1;											//校区Id：1:Handan  2:Zhangjiang  3:Jiangwan  4:Fenglin
var mapShowWidth=800;									//地图展示区宽
var mapShowHeight=500;									//地图展示区高
var PI=3.14159265359;
var scrollLeft=0,scrollTop=0;							//滚动条位置

var mapOriginWidth=2700;								//地图初始宽度
var mapOriginHeight=2100;								//地图初始高度
var mapNowWidth=mapOriginWidth*2/3;						//地图当前宽度
var mapNowHeight=mapOriginHeight*2/3;					//地图当前高度
var maxX,maxY,minX,minY;								//地图的坐标上下界
var lastBuilding=-1,nowBuilding=-1;						//显示路径用的上一个建筑和这个建筑
var galleryLeft=0;
var showPathNow=false;									//显示路径

/**
*主页面控制地图拖动
*/
$(function(){
	$("#operateMapData").dblclick(function(){
		zoomInMap();setTimeout("zoomInMap();",170);
	});
	$("#operateMapData").mouseover(function(){
		/**
		*按键控制地图移动
		*/
		$(document).keyup(function (e) {
			if (document.activeElement.id=="") {
				var key = e.which;
				if (key==37) moveMap(3);
				if (key==38) moveMap(1);
				if (key==39) moveMap(4);
				if (key==40) moveMap(2);
			}
		});
	});
	$("#operateMapData").mouseout(function(){
		$(document).unbind("keyup");
	});
	
	$("#operateMapData").mousedown(function(e){			//鼠标按下
		minX=mapShowWidth-mapNowWidth;maxX=0;
		minY=mapShowHeight-mapNowHeight;maxY=0;		
		var isAddingNode=false;							//标记是否在加点
		var isAddingBuilding=false;						//标记是否在加建筑
		var $theDiv=$("#operateMapData"); 				//要拖动的DIV对象
		
		getScrollPosition();

		var operateOffsetX=$("#operateFrame").offset().left;  			//父亲相对于页面处于最左侧时的边距
		var mapOffsetX=parseInt($("#operateMapData").css("left"));		//Map相对于父亲元素的偏移
		var P=e.clientX-operateOffsetX+scrollLeft;
		var operateOffsetY=$("#operateFrame").offset().top;  			//父亲相对于页面处于最左侧时的边距
		var mapOffsetY=parseInt($("#operateMapData").css("top"));		//Map相对于父亲元素的偏移
		var PP=e.clientY-operateOffsetY+scrollTop;
		
		$(document).mousemove(function(e){				//鼠标拖动
			
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
			$("#mapImage").css({"left":$theDiv.css("left")});
			$("#mapImage").css({"top":$theDiv.css("top")});
			
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
			getScrollPosition();

			var relativeX=P-mapOffsetX;
			var relativeY=PP-mapOffsetY;
			
			$(document).unbind("mousemove");
			$(document).unbind("mouseup");
		});
	});
});

//重新计算偏移量
function reCalcuOffset(oldValue,newValue,oldOffset,vsbValue){
	var newOffset=parseInt(-((vsbValue/2-oldOffset)/oldValue*newValue-vsbValue/2));
	if (newOffset>0) newOffset=0;
	else if (vsbValue-newOffset>newValue) newOffset=vsbValue-newValue;
	return newOffset;
}

/**
*放大地图
*/
function zoomInMap(){
	$('#buildingInfo').css('opacity','0');
	$("#destinationinfo").hide(500);
	var nowWidth=mapNowWidth;
	var nowHeight=mapNowHeight;
	if (mapNowWidth<=mapOriginWidth*0.6){
		mapNowWidth=parseInt(mapNowWidth/0.6);
		mapNowHeight=parseInt(mapNowHeight/0.6);
	}else{
		mapNowWidth=mapOriginWidth;
		mapNowHeight=mapOriginHeight;
	}
	var newTop=reCalcuOffset(nowHeight,mapNowHeight,parseInt($("#operateMapData").css("top")),mapShowHeight);
	var newLeft=reCalcuOffset(nowWidth,mapNowWidth,parseInt($("#operateMapData").css("left")),mapShowWidth);
	relocateBuilding();
	$("#operateMapData").animate({"width":mapNowWidth,"height":mapNowHeight,"top":newTop,"left":newLeft},200);
	$("#mapImage").animate({"width":mapNowWidth,"height":mapNowHeight,"top":newTop,"left":newLeft},200);
	if (showPathNow){
		clearPath();
		showThePath();
	}else clearPath();
}

/**
*缩小地图
*/
function zoomOutMap(){	
	$('#buildingInfo').css('opacity','0');
	$("#destinationinfo").hide(500);
	var nowWidth=mapNowWidth;
	var nowHeight=mapNowHeight;
	if (mapNowWidth*0.6>=mapShowWidth && mapNowWidth*0.6>=mapShowWidth){
		mapNowWidth=parseInt(mapNowWidth*0.6);
		mapNowHeight=parseInt(mapNowHeight*0.6);
	}else{
		mapNowWidth=mapShowWidth;
		mapNowHeight=parseInt(mapOriginHeight/mapOriginWidth*mapNowWidth);
		if (mapNowHeight<mapShowHeight){
			mapNowHeight=mapShowHeight;
			mapNowWidth=parseInt(mapOriginWidth/mapOriginHeight*mapNowHeight);
		}
	}
	var newTop=reCalcuOffset(nowHeight,mapNowHeight,parseInt($("#operateMapData").css("top")),mapShowHeight);
	var newLeft=reCalcuOffset(nowWidth,mapNowWidth,parseInt($("#operateMapData").css("left")),mapShowWidth);
	relocateBuilding();
	$("#operateMapData").animate({"width":mapNowWidth,"height":mapNowHeight,"top":newTop,"left":newLeft},200);
	$("#mapImage").animate({"width":mapNowWidth,"height":mapNowHeight,"top":newTop,"left":newLeft},200);
	if (showPathNow){
		clearPath();
		showThePath();
	}else clearPath();
}

/**
*上下左右移动地图
*/
function moveMap(dir){
	minX=mapShowWidth-mapNowWidth;
	minY=mapShowHeight-mapNowHeight;
	var nowTop=parseInt($("#operateMapData").css("top"));
	var nowLeft=parseInt($("#operateMapData").css("left"));
	if (dir==2){
		nowTop-=80;
		if (nowTop<minY) nowTop=minY;
	}else
	if (dir==1){
		nowTop+=80;
		if (nowTop>0) nowTop=0;
	}else
	if (dir==4){
		nowLeft-=80;
		if (nowLeft<minX) nowLeft=minX;
	}else
	if (dir==3){
		nowLeft+=80;
		if (nowLeft>0) nowLeft=0;
	}
	$("#operateMapData").animate({"top":nowTop,"left":nowLeft},200);
	$("#mapImage").animate({"top":nowTop,"left":nowLeft},200);
}

/**
*载入校区建筑
*/
function loadCampusBuilding(rltPath){
	var reqStr="campusId="+campusId+"&width="+mapNowWidth+"&height="+mapNowHeight;
	$("#operateMapData").html(getJson(reqStr,rltPath+"php/mapCampusBuilding.php"));
}

//重新定位校区建筑
function relocateBuilding(){
	var obj=$('.buildingItem').each(function(){
		var thisObj=$(this);
		var itemId=thisObj.attr("id").substring(12,255);
		var nodeX=$("#nodex_"+itemId).val();
		var nodeY=$("#nodey_"+itemId).val();
		thisObj.css({"top":parseInt(nodeY/100*mapNowHeight)-15,"left":parseInt(nodeX/100*mapNowWidth)-30});
		$("#buildingItem_Find_"+itemId).css({"top":parseInt(nodeY/100*mapNowHeight)-15,"left":parseInt(nodeX/100*mapNowWidth)-30});
	});
}
//显示建筑图标
function showBuildingIcon(id){
	$("#buildingItem"+id).animate({"opacity":"1"},200);
	//$("#tempDiver").html($("#buildingname_"+id).val());
	//$("#tempDiver").animate({"opacity":"1"},100);
}
//显示建筑名
function showBuildingName(event){
	//alert(event.clientX);
	getScrollPosition();
	$("#tempDiver").css({"left":parseInt(event.clientX+scrollLeft+20)});
	$("#tempDiver").css({"top":parseInt(event.clientY+scrollTop+10)});
	//alert($("#tempDiver").css("left"));
}
//隐藏建筑图标
function hideBuildingIcon(id){
	$("#buildingItem"+id).animate({"opacity":"0"},200);
	$("#tempDiver").animate({"opacity":"0"},100);
}
//绑定黄色框子浮动显示建筑名称事件
/*$(".buildingItem").live("mousemove",function(e){
	showBuildingName(e);
});*/

/**
*点击建筑图标显示细节
*/
$(function(){
	$(".buildingItem").click(function(e){
		var item=$(this);
		var itemId=$(this).attr("id").substring(12,255);
		$("#buildingImageLogoInInfo").html(getJson("buildingid="+itemId+"&width=50&front=1","./php/showBuildingLogo.php"));
		$("#buildingInfoContainer").html("建筑名："+$("#buildingname_"+itemId).val()+"<br/>"+"建筑信息："+$("#buildingintroduce_"+itemId).val());
		$("#buildingInfoContainer").append("<br/><a href='./index.php?buildingid="+itemId+"' target='_self' style='float:right;margin-top:5px;'>For More Details…</a>");
		$("#buildingInfo").css({"top":parseInt(item.css("top"))-50,"left":parseInt(item.css("left"))+45,"opacity":"1"});
		showBuildingInfo(itemId);
		lastBuilding=nowBuilding;
		nowBuilding=itemId;
		$("#destinationinfo").show(500);
	});
});
//显示左侧的destination info
function showBuildingInfo(id){
	var reqStr="buildingId="+id;
	$("#imageGallery").html(getJson(reqStr,"./php/showBuildingInfo.php"));
	galleryLeft=0;
	$("#imageGallery").css("left",0);
}
function prevDestinationImage(){
	if (galleryLeft<0) galleryLeft+=125;
	else galleryLeft=0;
	$("#imageGallery").animate({"left":galleryLeft},500);
}
function nextDestinationImage(){
	if (galleryLeft>125-parseInt($("#imageGallery").css("width")))
		galleryLeft-=125;
	else galleryLeft=125-parseInt($("#imageGallery").css("width"))
	$("#imageGallery").animate({"left":galleryLeft},500);
}
//显示建筑详细信息
function gotoBuildingDetail(){
	window.location="./index.php?buildingid="+nowBuilding;
}