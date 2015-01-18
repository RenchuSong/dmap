var campusId=1;											//校区Id：1:Handan  2:Zhangjiang  3:Jiangwan  4:Fenglin
var mapShowWidth=800;									//地图展示区宽
var mapShowHeight=500;									//地图展示区高
var PI=3.14159265359;
var scrollLeft=0,scrollTop=0;							//滚动条位置

/**
*移动控制面板
*/
function moveControlPanel(x) {
	$("#optionFramePage").animate({left: -100*x},400);
}

/**
*获取滚动条位置
*/
function getScrollPosition(){
	scrollLeft=0,scrollTop=0;
	if((document.body) && (document.body.scrollLeft)){
		scrollLeft = document.body.scrollLeft;
	}else if((document.documentElement) && (document.documentElement.scrollLeft)){
		scrollLeft = document.documentElement.scrollLeft;
	}
	if((document.body) && (document.body.scrollTop)){
		scrollTop = document.body.scrollTop;
	}else if((document.documentElement) && (document.documentElement.scrollTop)){
		scrollTop = document.documentElement.scrollTop;
	}
}

//封装Ajax
function getJson(RequestData,URL){
	var reJson;
	$.ajax({
		type:'POST',
		url:URL,
		data:RequestData,
		async:false,
		cache: false,
		success:function(responseData){
			reJson=responseData;
		}
	});
	return reJson;	
}

//管理员登录
function adminLogin(){
	var URL = '../php/servicetest.php';
	var Request = 'action=login&'+'username='+$('#adminName').val()+'&password='+$('#adminPassword').val();
	var Result = eval('('+getJson(Request,URL)+')');
	var logininfo = $('#login-info');
	
	if(Result.loginResult=='N'){
		alert("登录失败");
	}
	else{
		window.location="../oa/adminMapData.php";
	}
}
//管理员登出
function adminLogout(){
	var URL = "../php/servicetest.php";
	var Request = "action=unsetUserSession";
	getJson(Request,URL);
	window.location="../oa/adminLogin.php";
}