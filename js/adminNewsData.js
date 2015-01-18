var selectNews=-1;											//选中的新闻

/**
*初始化标记
*/
function resetFlag(){
	selectNews=-1;	
	$("#newsTitle").val("");
	$("#newsContext").val("");
	$(".adminOptionActiveButton").attr("class","adminOptionButton");
}

function resetPanel(){
	moveControlPanel(1);
	$("#editNews").attr("class","adminOptionActiveButton");
}

/**
*设置修改新闻
*/
function setEditNews(){
	resetFlag();
	resetPanel();
	$.ajax({
        type: "POST",
        url: "../php/showNews.php",
        cache: false,
        success: function (content) {
			$("#operateNewsData").html(content);
        }
    });
}

/**
*设置添加新闻
*/
function setAddingNews(){
	resetFlag();
	moveControlPanel(2);
	$("#addNews").attr("class","adminOptionActiveButton");
	$('#maskFrame').fadeTo(50,0.5);
	$('#addNewsData').fadeIn(50);	
}

/**
*删除新闻
*/
function deleteNews(newsId){
	$.ajax({
        type: "POST",
        url: "../php/deleteNews.php",
        cache: false,
		data: "newsId="+newsId,
        success: function (content) {
			setEditNews();
        }
    });
}

/**
*修改新闻
*/
function editNews(newsId){
	selectNews=newsId;
	$("#newsTitle").val($("#newsTitle"+newsId).html());
	$("#newsContext").val($("#newsContext"+newsId).html());
	$('#maskFrame').fadeTo(50,0.5);
	$('#addNewsData').fadeIn(50);
}
function submitNews(){
	var requestStr="";
	if ($("#newsTitle").val()=="") alert("新闻标题不能空");
	else if ($("#newsContext").val()=="") alert("新闻内容不能空");
	else{
		if (selectNews!=-1)
			requestStr="newsId="+selectNews+"&";
		$.ajax({
			type: "POST",
			url: "../php/adminNews.php",
			cache: false,
			data: requestStr+"newsTitle="+$("#newsTitle").val()+"&newsContext="+$("#newsContext").val(),
			success: function (content) {
				setEditNews();
				$('#maskFrame').fadeOut(50);
				$('#addNewsData').fadeOut(50);
			}
		});
	}
}

/**
*取消新闻操作
*/
function cancelNewsOperate() {
	$('#maskFrame').fadeOut(50);
	$('#addNewsData').fadeOut(50);
	resetFlag();
	resetPanel();
}

/**
*控制新闻列表的拖动行为
*/
$(function(){
	$("#operateNewsData").mousedown(function(e){			//鼠标按下
		var minY=mapShowHeight-parseInt($("#operateNewsData").css("height")),maxY=0;		
	
		getScrollPosition();

		var operateOffsetY=$("#operateFrame").offset().top;  			//父亲相对于页面处于最左侧时的边距
		var mapOffsetY=parseInt($("#operateNewsData").css("top"));		//Map相对于父亲元素的偏移
		var PP=e.clientY-operateOffsetY+scrollTop;
		
		$(document).mousemove(function(e){				//鼠标拖动
			$("#operateNewsData").css("cursor","move");
			var PP2=e.clientY-operateOffsetY+scrollTop;
			var divY=PP2-PP+mapOffsetY;

			if (divY>=minY && divY<=maxY)					//在合理范围内，允许移动
				$("#operateNewsData").css({"top":divY});
			else if (divY<minY)
				$("#operateNewsData").css({"top":minY});
			else if (divY>maxY)
				$("#operateNewsData").css({"top":maxY});
					
			//防止拖动中选中
			if(window.getSelection){ 
				window.getSelection().removeAllRanges();
			}else if(document.selection){ 
				if(document.selection.empty) {
					document.selection.empty();			//IE
				}
				else {									//Opera
					document.selection = null;
				}
			} 
		});
		
		$(document).mouseup(function(e){				//在鼠标释放时
			getScrollPosition();
			$(document).unbind("mousemove");
			$(document).unbind("mouseup");
		});
	});
	
});
