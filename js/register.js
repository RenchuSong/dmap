// JavaScript Document
var info_tip=new Array();
info_tip[0]='请输入长度在4到20的字符串！';
info_tip[1]='请设置您的密码，长度区间为[6,20]！';
info_tip[2]='请再次输入您设置的密码！';
info_tip[3]='请输入您的注册邮箱，以便联系和找回密码！';

var registerSuccess=new Array(4);
for(var i=0;i<4;i++) registerSuccess[i]=false;

function showRegisterInfo(info){
	switch(info){
		case 0: //账号信息
		        var info_name=$('#info_name');
				info_name.removeClass();
		        info_name.html(info_tip[0]);
				info_name.addClass("right");
				break;
		case 1:
		        var info_pwd=$('#info_pwd');
				info_pwd.removeClass();
		        info_pwd.html(info_tip[1]);
				info_pwd.addClass("right");
		        break;
		case 2:
		        var info_pwd_again=$('#info_pwd_again');
				info_pwd_again.removeClass();
				info_pwd_again.html(info_tip[2]);
				info_pwd_again.addClass("right");
		        break;
		case 3:
		        var info_email=$('#info_email');
				info_email.removeClass();
		        info_email.html(info_tip[3]);
				info_email.addClass("right");
				break;
		default:break;
		}
		
	}
function checkUserName() {
    registerSuccess[0]=false;
    var username = $('#R-username').val();
    var info = $('#info_name');
	info.removeClass();
    if (username == '') {
        info.html("<samp>不能为空</samp>");
		info.addClass("wrong");
        return false;
    }
    //判断用户名字符长度
    if (username.length > 20 || username.length < 4) {
        info.html('<samp >请确保用户名长度在4到20个字符之间</samp>');
		info.addClass("wrong");
        return false;
    }
    if(username.indexOf(' ')>=0){  
        info.html('<samp >确保用户名由数字、字母、中文组成</samp>');
		info.addClass("wrong");
        return false;
     }
    //判断用户名字符第一位是否是数字
    if (!isNaN(username.charAt(0))) {
        info.html('<samp >请确保用户名第一位不能为数字</samp>');
		info.addClass("wrong");
        return false;
    }
    //判断用户名由数字、字母、中文组成
    var regex = /^(\w|[\u4E00-\u9FA5])*$/;
    if (!regex.test(username)) {
        info.html('<samp >请确保用户名由数字、字母、中文组成</samp>');
		info.addClass("wrong");
        return false;
    }
    if(checkUsernameCount(username)==false){
		info.html('抱歉，此用户名已被注册，请重新输入');
		info.addClass("wrong");
		return false;
		}
    info.html("恭喜，此用户名可用");
	info.addClass("right");
	registerSuccess[0]=true;
    return true;
}
/* 
 * 描述：检测用户是否已经被注册，注册了返回false，否则返回true
 */
function checkUsernameCount(Username){
	var URL='php/servicetest.php';
	var request='UserName='+Username+'&action=checkusernamecount';
    var checkResult = eval('('+getJson(request,URL)+')');
	if(checkResult.isExist=='N') return true;
	else return false;
	}

function checkPassword() {
	registerSuccess[1]=false;
    var p = $('#R-password').val();
    var info = $('#info_pwd');
	info.removeClass();
    if(p==""){
		info.html('<samp>不能为空</samp>'); 
		info.addClass("wrong");
		return false;
		}
    if (p.length < 6 || p.length > 20) {
        info.html('<samp >请确保密码长度在6到16个字符之间</samp>');
		info.addClass("wrong");
        return false;
    } else {
        info.html('密码输入正确');
		info.addClass("right");
		registerSuccess[1]=true;
        return true;
    }
}
function checkPassword_again(){
	registerSuccess[2]=false;
	var pwd_again=$('#R-password-again').val();
	var pwd_original=$('#R-password').val();
	var info=$('#info_pwd_again');
	info.removeClass();
	if(pwd_again!=pwd_original){
		info.html('<samp>两次输入密码不一致</samp>');
		info.addClass("wrong");
		}
	else{
		if(pwd_again!='')
		{
			info.html('<samp>输入正确</samp>');
			info.addClass("right");
			registerSuccess[2]=true;
			}
		else {
			info.html('<samp>不能为空</samp>');
			info.addClass("wrong");
			registerSuccess[2]=false;
			}
		}
	}
//检测邮箱是否格式正确并未被注册
function checkEmail() {
	registerSuccess[3]=false;
    var email = $('#R-mail').val();
    var info = $('#info_email');
    info.removeClass();
    if(email==""){
		info.html('<samp >不能为空</samp>'); 
		info.addClass("wrong"); 
		return false;
		}
    if (!/^[\w-]+[\.]*[\w-]+[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(email)) {
       info.html('<samp >Email格式有误</samp>');
       info.addClass("wrong");
       return false;
    } else {
	   if(checkEmailCount(email)==false)
	   {
		   info.html('<samp>抱歉，此邮箱已被注册，请重新填写</samp>');
		   info.addClass("wrong");
		   registerSuccess[3]=false;
		   return false;
		   }
	   else{
           info.html("<samp>恭喜，邮箱可用</samp>"); 
	       info.addClass("right"); 
		   registerSuccess[3]=true;
		   return  true;
	   }
    }
}
//检测用户输入邮箱是否已被注册
function checkEmailCount(email){
	var URL='php/servicetest.php';
	var Request = 'email='+email+'&action=checkemailcount';
	var checkResult = eval('('+getJson(Request,URL)+')');
	if(checkResult.isExist=='N') return true;
	else return false; 
	}
function checkRegInfo(){
	var info=$('#info-submit');
	info.empty();
	for(var i=0;i<4;i++)
	if(registerSuccess[i]!=true){
		if(i<4){
		   info.removeClass();
		   info.html('<samp>输入有误，请检查您的注册信息或者重新填写</samp>');
		   info.addClass("wrong");
		   return false;
		   }
		}
	if(codeSuccess==false){
		   info.removeClass();
		   info.html('<samp>输入有误，请检查您的注册信息或者重新填写</samp>');
		   info.addClass("wrong");
		   return false;
	       }
	return true;
	}
//注册用户
function registerUser(){
	if(checkRegInfo()==false) return false;
	var regInfo='action=register&'+$('#register-form').serialize();
	var URL='php/servicetest.php';
	var registerResult = eval('('+getJson(regInfo,URL)+')');
	if(registerResult.success=='Y') alert('success');
	else alert('fail');
	}
function toggleRegisterOptionalInfo(){
	$('#registerOptionalInfo').slideToggle(500,function(){}); //0.5s
	}
function refresh_code(){
	document.getElementById("imgcode").src="php/createCode.php?a="+Math.random();
    }
var codeSuccess=false;
function check_code(){
	codeSuccess=false;
	var URL = "php/servicetest.php";
	var Request = 'action=checkcode&code='+$('#R-code').val();
	var CheckResult = eval('('+getJson(Request,URL)+')');
	var info = $('#info-code');
	if(CheckResult.verifycode=='Y'){
		info.removeClass();
		info.html('验证码输入正确');
		info.addClass("right");
		codeSuccess=true;
		}
	else{
		info.removeClass();
		info.html('验证码输入错误');
		info.addClass("wrong");	
		codeSuccess=false;
		refresh_code();
		}
	}
