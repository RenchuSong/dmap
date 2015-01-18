// JavaScript Document
var serviceurl="php/servicetest.php";
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
				//alert(reJson);
				}
			});
	return reJson;	
	}

function searchfocus(){
	if($('#searchstr').val()=="不能为空"){$('#searchstr').val('');}
	}
function gosearch(){
	var getstr=$('#searchstr').val();
	if(getstr==''){$('#searchstr').val("不能为空");return false;}
	//alert("go search for "+getstr);
	var info = getDestinationInfo();
	//alert(info);
	showDestinationInfo(info);
	}
function gomap(){
	var getmapstr=$('#school').val();
	//campusId=getmapstr;
	alert("Under Construction");
	}
function loadCampusMap(){
	var getmapstr=$('#school').val();
	//campusId=getmapstr;
	alert("Under Construction");
	}
function searchCourses(){
	alert("search for courses");
	}
function elementFadeBack(id){$('#'+id).stop(true);$('#'+id).fadeTo(500,1.0);}
function elementFadeTo(id){$('#'+id).stop(true);$('#'+id).fadeTo(500,0.7);}

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