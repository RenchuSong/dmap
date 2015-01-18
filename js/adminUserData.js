/**
*显示用户列表
*/
function showUser(){
	$.ajax({
        type: "POST",
        url: "../php/showUser.php",
        cache: false,
        success: function (content) {
			$("#operateUserData").html(content);
        }
    });
}

/**
*显示用户列表
*/
function showUser(){
	$.ajax({
        type: "POST",
        url: "../php/showUser.php",
        cache: false,
        success: function (content) {
			$("#operateUserData").html(content);
        }
    });
}

/**
*设置用户权限
*/
function setUserAuthority(userId,userAuthority){
	$.ajax({
        type: "POST",
        url: "../php/setUserAuthority.php",
        cache: false,
		data: "userId="+userId+"&userAuthority="+userAuthority,
        success: function (content) {
			$("#userItem"+userId).html(content);
        }
    });
}

/**
*设置用户状态
*/
function setUserStatus(userId,userStatus){
	$.ajax({
        type: "POST",
        url: "../php/setUserStatus.php",
        cache: false,
		data: "userId="+userId+"&userStatus="+userStatus,
        success: function (content) {
			if (userStatus=="Deleted") $("#userItem"+userId).remove();
			$("#userItem"+userId).html(content);
        }
    });
}

/**
*控制用户列表的拖动行为
*/
$(function(){
	$("#operateUserData").mousedown(function(e){			//鼠标按下
		var minY=mapShowHeight-parseInt($("#operateUserData").css("height")),maxY=0;		
	
		getScrollPosition();

		var operateOffsetY=$("#operateFrame").offset().top;  			//父亲相对于页面处于最左侧时的边距
		var mapOffsetY=parseInt($("#operateUserData").css("top"));		//Map相对于父亲元素的偏移
		var PP=e.clientY-operateOffsetY+scrollTop;
		
		$(document).mousemove(function(e){				//鼠标拖动
			$("#operateUserData").css("cursor","move");
			var PP2=e.clientY-operateOffsetY+scrollTop;
			var divY=PP2-PP+mapOffsetY;

			if (divY>=minY && divY<=maxY)					//在合理范围内，允许移动
				$("#operateUserData").css({"top":divY});
			else if (divY<minY)
				$("#operateUserData").css({"top":minY});
			else if (divY>maxY)
				$("#operateUserData").css({"top":maxY});

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
