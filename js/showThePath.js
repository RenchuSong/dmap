//显示路径
function showThePath(){
	if (lastBuilding==-1 || nowBuilding==-1) {
		$("#showThePathStatus").html("请先选择路径节点");
	}else{
		clearPath();
		showPathNow=true;
		$("#showThePathStatus").html("<a href='javascript:clearPath();'>清除路径</a>");
		var pathNodeList=eval("("+getJson("campusId="+campusId+"&building1="+lastBuilding+"&building2="+nowBuilding,"./showThePath/getPath.php")+")");
		var nodeNumber=pathNodeList.length/2;
		for (var i=0;i<nodeNumber-1;++i){
			drawThePath(pathNodeList[i*2],pathNodeList[i*2+1],pathNodeList[i*2+2],pathNodeList[i*2+3]);
		}
	}
}

//清除路径·
function clearPath(){
	$(".linePixel").remove();
	$("#showThePathStatus").html("");
	showPathNow=false;
}

/**
*两点之间画线
*/
function drawThePath(percentX1,percentY1,percentX2,percentY2){
	var x1=parseInt(mapNowWidth*percentX1/100);
	var x2=parseInt(mapNowWidth*percentX2/100);
	var y1=parseInt(mapNowHeight*percentY1/100);
	var y2=parseInt(mapNowHeight*percentY2/100);
	
	var deltaX=x2-x1;
	var deltaY=y2-y1;
	if (Math.abs(deltaX)>Math.abs(deltaY)){
		var i=parseInt(Math.abs(deltaX/150))+1;
		for (var j=0;j<i;++j){
			//$("#showThePathStatus").append(parseInt(x1+j*deltaX/i)+" "+parseInt(y1+j*deltaY/i)+" "+parseInt(x1+(j+1)*deltaX/i)+" "+parseInt(y1+(j+1)*deltaY/i));
			drawLine(parseInt(x1+j*deltaX/i),parseInt(y1+j*deltaY/i),parseInt(x1+(j+1)*deltaX/i),parseInt(y1+(j+1)*deltaY/i));
		}
	}else{
		var i=parseInt(Math.abs(deltaY/150))+1;
		for (var j=0;j<i;++j){
			//$("#showThePathStatus").append(parseInt(x1+j*deltaX/i)+" "+parseInt(y1+j*deltaY/i)+" "+parseInt(x1+(j+1)*deltaX/i)+" "+parseInt(y1+(j+1)*deltaY/i));
			drawLine(parseInt(x1+j*deltaX/i),parseInt(y1+j*deltaY/i),parseInt(x1+(j+1)*deltaX/i),parseInt(y1+(j+1)*deltaY/i));
		}
	}
}
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
			+(maxY-minY)+"px;background:url(\"./images/nodeRoad/90.png\");left:"
			+minX+"px;top:"+minY+"px;'></div>"
		);
	else
	if (y1==y2)
		$("#operateMapData").append(
			"<div class='linePixel' style='width:"+(maxX-minX)
			+"px;height:3px;background:url(\"./images/nodeRoad/0.png\");left:"
			+minX+"px;top:"+minY+"px;'></div>"
		);
	else{
		if ((x1-x2)*(y1-y2)>0){
			var angle=Math.round((Math.atan((maxY-minY)/(maxX-minX))/PI*180));
			$("#operateMapData").append(
				"<div class='linePixel' style='width:"+(maxX-minX+2)
				+"px;height:"+(maxY-minY+2)+"px;background:url(\"./images/nodeRoad/"+angle
				+".png\");left:"+minX+"px;top:"+minY+"px;'></div>"
			);
		}else{
			var angle=Math.round((Math.atan((maxY-minY)/(maxX-minX))/PI*180));
			$("#operateMapData").append(
				"<div class='linePixel' style='width:"+(maxX-minX+2)
				+"px;height:"+(maxY-minY+2)+"px;background:url(\"./images/nodeRoad/_"+angle
				+".png\");background-position:0 "+(maxY-minY-150)
				+"px;left:"+minX+"px;top:"+minY+"px;'></div>"
			);
		}
	}
}
