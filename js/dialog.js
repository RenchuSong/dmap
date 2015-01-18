// JavaScript Document
/*
 * 显示灰色 jQuery 遮罩层，弹出对话框
 * Dhtml:在弹出的对话框中要显示的html
 * Dheight:对话框高度
 * Dwidth:对话框宽度
 */
function showDialog(Dhtml,Dheight,Dwidth) {
	$('#dialog').stop(true);
	$('#fullbg').stop(true);
    var bh = $("body").height();
    var bw = $("body").width();
	var dh = document.documentElement.clientHeight;
    $("#fullbg").css({
        height:dh,
        width:bw,
        display:"block"
    });
	$('#dialog-content').html(Dhtml);
	$('#dialog').css({
		height:Dheight,
		width:Dwidth
		});
    $("#dialog").show(300);
}

/**
*显示没有遮罩的对话框
*/
function showDialogWithoutMask(Dhtml,Dheight,Dwidth) {
    var bh = $("body").height();
    var bw = $("body").width();
	var dh = document.documentElement.clientHeight;
	$('#dialog-content').html(Dhtml);
	$('#dialog').css({
		height:Dheight+'px',
		width:Dwidth+'px'
		});
    $("#dialog").show(300);
}

/**
*显示图片展示
*/
function showImageDialog(Dhtml) {
    var bh = $("body").height();
    var bw = $("body").width();
	var dh = document.documentElement.clientWidth;
    $("#fullbgImage").css({
        height:dh,
        width:bw,
        display:"block"
    });
	$('#dialog-contentImage').html(Dhtml);
	$('#dialogImage').css({"left":parseInt((dh-parseInt($('#dialogImage').css("width")))/1.7)});
	/*$('#dialogImage').css({
		height:Dheight+'px',
		width:Dwidth+'px'
		});*/
    $("#dialogImage").show(300);
}
//关闭图片展示
function closeImageDialog() {
	$('#dialog-contentImage').empty(); //清除对话框里的html
	$("#fullbgImage").hide(300);
    $("#dialogImage").hide(300);  //隐藏对话框
}

//关闭灰色 jQuery 遮罩
function closeDialog() {
	$('#dialog').stop(true);
	$('#fullbg').stop(true);	
	$('#dialog-content').empty(); //清除对话框里的html
	//setTimeout('$("#fullbg").hide()',200);
	$("#fullbg").hide(300);
    $("#dialog").hide();  //隐藏对话框
}