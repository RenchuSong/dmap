<html>
<head>
<title>PHPMailer - SMTP (Gmail) basic test</title>
</head>
<body>

<?php

//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Toronto');

require_once('../class.phpmailer.php');
include("../class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

$body             = file_get_contents('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = "smtp.gmail.com"; // SMTP server
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = "587";                   // set the SMTP port for the GMAIL server
$mail->Username   = "jiankunlei@gmail.com";  // GMAIL username
$mail->Password   = "29405832kun";            // GMAIL password

$mail->SetFrom('jiankunlei@gmail.com', 'First Last');

$mail->AddReplyTo("jiankunlei@gmail.com","First Last");

$mail->Subject    = "PHPMailer Test Subject via smtp (Gmail), basic";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

$address = "leijiankun1@126.com";
$mail->AddAddress($address, "John Doe");

$mail->AddAttachment("images/phpmailer.gif");      // attachment
$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>
<?php
//error_reporting(E_ALL);
error_reporting(E_STRICT);
date_default_timezone_set('America/Toronto');
require_once('../class.phpmailer.php');
//include("../class.smtp.php"); //可选,会自动从class.phpmailer.php加载
$mail=new PHPMailer();
$body=file_get_contents('contents.html');
$body=Strtr($body,Array("\\"=>""));//$body= eregi_replace("[\]",'',$body);
$mail->IsSMTP();                            // 告诉程式要使用SMTP
$mail->SMTPDebug  = 2;                        // 开启 SMTP debug 信息 (测试时使用)// 1 = 错误和消息// 2 = 只有消息
$mail->SMTPAuth   = true;                    // 开启 SMTP 验证
$mail->SMTPSecure = "ssl";                    // sets the prefix to the servier
$mail->Host       = "smtp.googlemail.com";        // sets GMAIL as the SMTP server
$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
$mail->Username   = "jiankunlei@gmail.com";        // GMAIL用户名
$mail->Password   = "29405832kun";                // GMAIL密码
$mail->CharSet = "utf-8";        //加入该行代码可以防止信件内容乱码

$mail->SetFrom('jiankunlei@gmail.com','leijiankun');        //发信人邮件地址及用户名
//$mail->AddReplyTo("see7di@gmail.com","张三");    //回复地址及用户名

$subject='這是郵件標題';
$mail->Subject    = "=?UTF-8?B?".base64_encode($subject)."?= ";//使用base64编码是为了防止信件标题乱码

$mail->MsgHTML($body);

$mail->AddAddress("leijiankun1@126.com","a");        //接收者邮件地址及用户名
//附件
//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
    echo "Mailer Error: ".$mail->ErrorInfo;
}else{
    echo "Message sent!";
}
?>
</body>
</html>
