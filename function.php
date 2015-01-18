<script language="javascript">
function getDestinationInfo(){
	var destination = $('#searchstr').val();
	var action ='action=getDestinationInfo&searchstr='+destination+"&campusId="+campusId;
	return getJson(action,"./php/servicetest.php");
	}
//id 为显示的地方 dinfo为目的地信息（JSON）
function showDestinationInfo(desinfo){
	$("#searchBuildingError").html("");
	$(".buildingItem2").animate({"opacity":"0"},100);
	var newRes=eval("("+desinfo+")");
	if (newRes.length>5) {
		$("#searchBuildingError").html("结果过多，请优化查询条件");
	}
	else{
		for (var i=0;i<newRes.length;++i){
			$("#buildingItem_Find_"+newRes[i]).animate({"opacity":"1"},200);
		}
		if (newRes.length>0){
			$("#searchBuildingError").html("<a href='javascript:$(\".buildingItem2\").animate({\"opacity\":\"0\"},100);$(\"#searchBuildingError\").html(\"\");'>清除查询标记</a>");
			zoomOutMap();setTimeout("zoomOutMap();",170);
		}else $("#searchBuildingError").html("没有找到相关建筑");
	}
}

//----显示登录对话框----//
function showLoginDialog(){
	var loginorout=$('#topmenu-login').html();
	//alert(loginorout);
	if(loginorout=='Login'){
		var testhtml = '<?php getLoginHtml(); ?>';
	    showDialog(testhtml,250,250);
		}
	else{
		$('#topmenu-login').html('Login');
	    var URL = "php/servicetest.php";
		var Request = "action=unsetUserSession";
		getJson(Request,URL);
		location.reload(true);
		}
	}
//----显示注册对话框-----//
function showResiterDialog(){
	closeDialog();
	var Rhtml = '<?php getRegisterHtml(); ?>';
	showDialog(Rhtml,400,400);
	}
//登录处理
function login(){
	var URL = 'php/servicetest.php';
	var Request = 'action=login&'+'username='+$('#login-username').val()+'&password='+$('#login-password').val();
	var Result = eval('('+getJson(Request,URL)+')');
	var logininfo = $('#login-info');
	if(Result.loginResult=='A'){
			window.location="./oa/adminMapData.php";
		}
	else if(Result.loginResult=='N'){
		logininfo.removeClass().html('用户名或密码错误').addClass("wrong");
		}
	else{
	    closeDialog();
		location.reload(true); //刷新页面
		}
	}
//忘记密码处理
function forgetpassword(){
	//alert("forget password");
	closeDialog();
	}
//---- 新闻 --------//
var newsurl = "php/servicetest.php";  
function getLatestNews(){
	var request = 'action=getLatestNews';
	var latestnews=getJson(request,newsurl);
	return latestnews;
	}
function getNewsById(newsId){
	var request = 'action=getNewsById&newsId='+newsId;
	return getJson(request,newsurl);
	}
//显示新闻的具体信息
function showNewsDetail(newsId){
	var aNewsJson=getNewsById(newsId);
	var aNews=eval('('+aNewsJson+')');
	var aNewsHtml='<h2 style="margin-top:-18px;">Latest News</h2>'
	             +'<div class="news-detail">'
				 +"<div style='font-size:18px;color:#666;padding-top:10px;padding-left:5px;'><img src='./images/news.png' style='vertical-align:bottom;' /> "+aNews.newsTitle+"</div>"
				 +"<div style='font-size:14px;color:#999;padding-top:10px;padding-left:10px;'>&nbsp;<img src='./images/rss.png' style='vertical-align:middle;' />&nbsp;&nbsp;发布时间："+aNews.newsTime+"</div>"
		         +"<div style='font-size:16px;color:#666;padding:10px;'>"+aNews.newsContext+"</div>"
		         +'</div>';
	showDialog(aNewsHtml,400,500);
	}
//---  用户 -----//
function getUserByName(UserName){
	var request = 'action=getUserByName&UserName='+UserName;
	var url = 'php/servicetest.php';
	return getJson(request,url);
}
function getUserById(UserId){
	var request = 'action=getUserById&UserId='+UserId;
	var url = 'php/servicetest.php';
	return getJson(request,url);
}
</script>
<?php 
function showNews(){
	echo '<div id="main-news"><h2>News</h2><div class="clear" style="height:5px;"></div>';
	?>
    <script language="javascript">
	var newsJson=getLatestNews();
	var news=eval('('+newsJson+')');
    var newsHtml='';
	for(var i=0;i<news.length;i++){
		var newsTitle=news[i].newsTitle;
		if (newsTitle.length>7) newsTitle=newsTitle.substring(0,6)+"…";
		newsHtml+='<a style="line-height:20px;font-size:14px;" href="javascript:showNewsDetail('+news[i].newsId+');" title="'+news[i].newsTitle+'"><img src="./images/newsTitleIcon.gif" style="width:18px;height:18px;vertical-align:bottom;margin-right:5px;" />'+newsTitle+"</a><br>";
		if (i==news.length-1)
			newsHtml+="<span style='line-height:20px;font-size:12px;color:#999;padding-bottom:2px;'><img src='./images/newsTimeIcon.gif' style='width:18px;height:18px;vertical-align:bottom;margin-right:5px;' />"+news[i].newsTime+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><div class="clear" style="height:5px;"></div>';
		else newsHtml+="<span style='line-height:20px;font-size:12px;color:#999;border-bottom:1px solid #ccc;padding-bottom:2px;'><img src='./images/newsTimeIcon.gif' style='width:18px;height:18px;vertical-align:bottom;margin-right:5px;' />"+news[i].newsTime+'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><div class="clear" style="height:5px;"></div>';
		}
	document.write(newsHtml);
    </script>
	<?php
	echo '</div>';
	}
function showDestinationInfo(){
	$destinationhtml='<div id="destinationinfo" style="border:1px red solid;">'
	                .'<b>destination info</b><br>'
					.'<script language="javascript">showDestinationInfo();</script>'
					.'</div>';
	echo $destinationhtml;
	}
function addDialog(){ 
    $dialoghtml  = '<div id="fullbg"></div><div id="dialog">';
	$dialogclose = '<div id="dialog-close">'
	              .'<input  type="image" onClick="closeDialog();" src="images/dialog_close.png"></div>';
	$dialoghtml.= $dialogclose.'<div id="dialog-content"></div></div>';
	echo $dialoghtml;
     }
function addImageDialog(){ 
    $dialoghtml  = '<div id="fullbgImage"></div><div id="dialogImage">';
	$dialogclose = '<div id="dialog-closeImage">'
	              .'<input  type="image" onClick="closeImageDialog();" src="images/dialog_close.png"></div>';
	$dialoghtml.= $dialogclose.'<div id="dialog-contentImage"></div></div>';
	echo $dialoghtml;
     }
function getLoginHtml(){
	$loginhtml='<div id="login">';
	$loginhtml.='<h2>Login</h2>'
	           .'<label for="login-username">Username:</label><br>'
			   .'<input id="login-username" type="text"><br>'
			   .'<label for="login-password">Password</label><br>'
			   .'<input id="login-password" type="password"><br>'
			   .'<label for="R-code">Code：</label>'
		       .'<img id="imgcode" src="php/createCode.php" alt="验证码" /><a href="javascript:refresh_code()">看不清？换一张</a><br>'
		       .'<input id="R-code" onblur="check_code();"><span id="info-code"></span><br>'
			   .'<input type="button" onclick="login();" value="Login"><br>'
			   .'<span id="login-info"></span><br>'
			   .'<a href="#" onclick="showResiterDialog();">Create a new account.</a><br>';
			   //.'<a href="#" onclick="forgetpassword();">Forget your password.</a>';
	$loginhtml.='</div>';
	echo $loginhtml;
	}
function getUserInfo(){
	if(isset($_SESSION['dmapUser'])){
		echo '<div id="userImage"><img style="margin-top:6px;" height="40" width="40" src="php/showImage.php?id='.$_SESSION["dmapUserId"].'" 
		     title="'.$_SESSION["dmapUser"].'"></div>';
		echo '<div id="userName">'.$_SESSION['dmapUser'].'</div>';
		}
	}
function getRegisterHtml(){
	$Rhtml='<h2>Register</h2>';
	$Rhtml.='<div id="register" name="register" style="height:340px; overflow:auto;"><form id="register-form" method="post" action="php/servicetest.php" enctype="multipart/form-data" onsubmit="if(!checkRegInfo())return false;">'
	       .'<label for="R-username">您的账号：</label><br>'
		   .'<input id="R-username" name="R-username" type="text" onfocus="showRegisterInfo(0);" onblur="checkUserName();">'
		   .'<span id="info_name"></span><br>'
		   .'<label for="R-password">您的密码： </label><br>'
		   .'<input id="R-password" name="R-password" type="password" onfocus="showRegisterInfo(1);" onblur="checkPassword();">'
		   .'<span id="info_pwd"></span><br>'
		   .'<label for="R-password-again">重新填写您的密码：</label><br>'
		   .'<input id="R-password-again" name="R-password-again" type="password" onfocus="showRegisterInfo(2);" onblur="checkPassword_again();">'
		   .'<span id="info_pwd_again"></span><br>'
		   .'<label for="R-mail">您的注册邮箱：</label><br>'
		   .'<input id="R-mail" name="R-mail" type="text" onfocus="showRegisterInfo(3);" onblur="checkEmail();">'
		   .'<span id="info_email"></span><br>'
		   //.'性别：<input name="R-sex" type="radio" value="1" checked="checked" />男'
		   //.'<input type="radio" name="R-sex" value="2" />女<br>'
		   .'<label for="R-image">请选择您的头像：</label>'
		   .'<input type="file" id="R-image" name="R-image"><br>'
		   .'<a href="#" onclick="toggleRegisterOptionalInfo();" title="点击可展开">选填信息</a><br>'
		   .'<div id="registerOptionalInfo" style="display:none;">'
		   .'<label for="R-information">自我介绍：</label><br>'
		   .'<textarea type="text" id="R-information" name="R-information" id="R-information"></textarea><br>'
		   .'<label for="R-webpage">个人主页：</label><br>'
		   .'<input id="R-webpage" name="R-webpage" value="http://"><br>'
		   .'</div>'
		   .'<label for="R-code">请输入验证码：</label>'
		   .'<img id="imgcode" src="php/createCode.php" alt="验证码" /><a href="javascript:refresh_code()">看不清？换一张</a><br>'
		   .'<input id="R-code" onblur="check_code();"><span id="info-code"></span><br>'
		  // .'<input id="R-submit" type="button" value="提交" onclick="registerUser();">'
		   .'<input type="submit" value="提交">'
		   .'<input type="hidden" name="action" value="register">'
		   .'<input type="reset" value="重置"><br>'
		   .'<span id="info-submit"></span>';
	$Rhtml.='</form></div>';
	echo $Rhtml;
	}
function registerDone(){
	if(isset($_SESSION['dmapregister'])){
		if($_SESSION['dmapregister']=="") return;
		?>
        <script language="javascript">
		var donehtml = '<div id="registerDone"><h2>Register Successfully</h2>'
		             + '您已经成功注册了dmap网站。<br>'
					 + '您的注册信息已经发送至您的注册邮箱: <?php echo $_SESSION['dmapregistermail']; ?>'+'<br>'
					 + '请<a href="javascript:showLoginDialog()">登录</a>，谢谢！<br>'
					 + '</div>';
		showDialog(donehtml,200,200);
        </script>
        <?php
		$_SESSION['dmapregister']="";
		}
	
	}

?>