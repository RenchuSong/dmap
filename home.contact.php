	<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	<script type="text/javascript" src="js/ckeditor-api.js"></script>
    <script language="javascript">
	function AjaxSubmit(){
		var editorValue=GetContents();
	    var article=encodeURI(editorValue);
		
		var article1=(escape(editorValue));
		var article2=(encodeURIComponent(editorValue));
		articleData+=article2;
		//alert(getJson(articleData,"service/ckeditor_service.php"));
		alert(article2);
		}
    </script>
    <style>
	.contactlabel{ float:left; position:relative; width:150px; font-size:12px; color:#189de1; font-weight:bold;
	font-family:Arial, Helvetica, sans-serif;text-align:right; padding:0 10px 0 10px;}
	</style>
    <div id="contact" style="text-align:left; padding:20px; border:1px #FFF solid; background-color:#fcfcfc;">
    <h2 style="margin-bottom:10px;">Contact Us</h2>
    
        <input name="action" value="contact" type="hidden">
        <div class="contactlabel"><label for="contact_userName">Your Name: </label></div>
        <input style="width:400px;" id="contact_userName" name="contact_userName" type="text">
        <span id="contact_name_info"></span><br>
        
        <div class="contactlabel"><label for="contact_userEmail">Your E-mail address: </label></div>
        <input style="width:400px;" id="contact_userEmail" name="contact_userEmail" type="text">
        <span id="contact_email_info"></span><br>
        
        <div class="contactlabel"><label for="contact_subject">Subject: </label></div>
        <input style="width:400px;" id="contact_subject" name="contact_subject" type="text">
        <span id="contact_subject_info"></span><br>
        <span id="contact_submit_info"></span><br>
        <script language="javascript">
		var checkContactSuccess=new Array(3);
		for(i=0;i<3;i++){
			checkContactSuccess[i]=false;
			}
			
		$('#contact_userName').blur(function(){
			checkContactSuccess[0]=false;
			if($('#contact_userName').val()==""){
				$('#contact_name_info').removeClass().html('请输入您在发送邮件时要显示的名字').addClass("wrong");
				}
			else {
				$('#contact_name_info').removeClass().html('');
				checkContactSuccess[0]=true;
				}
			});
		$('#contact_userEmail').blur(function(){
			checkContactSuccess[1]=false;
			if($('#contact_userEmail').val()==""){
				$('#contact_email_info').removeClass().html('请输入您的邮件地址').addClass("wrong");
				return  false;
				}
			else{
				var Email = $('#contact_userEmail').val();
				if (!/^[\w-]+[\.]*[\w-]+[@][\w\-]{1,}([.]([\w\-]{1,})){1,3}$/.test(Email)){
					$('#contact_email_info').removeClass().html('对不起，您输入的email地址格式有误').addClass("wrong");
					return false;
					}
				}
			$('#contact_email_info').removeClass().html('');
			checkContactSuccess[1]=true;
			});
        $('#contact_subject').blur(function(){
			checkContactSuccess[2]=false;
			if($('#contact_subject').val()==""){
				$('#contact_subject_info').removeClass().html('请输入您要发送的邮件主题').addClass("wrong");
				}
			else{
				checkContactSuccess[2]=true;
				$('#contact_subject_info').removeClass().html('');
				}
			});
		function checkContactInfo(){
			for(i=0;i<3;i++){
				if(checkContactSuccess[i]!=true){
					$('#contact_submit_info').removeClass().html('对不起，您填写的信息不全或有误，请核查。').addClass("wrong");
					return false;
					}
				}
			var editorValue=GetContents();
			if(editorValue==""){
				$('#contact_submit_info').removeClass().html('请填写您的邮件内容。').addClass("wrong");
				return false;
				}
			return true;
			}
			function sendContactMail1(){
		    if(checkContactInfo()){
			    var name = $('#contact_userName').val();
				var email = $('#contact_userEmail').val();
				var subject = $('#contact_subject').val(); 
				var content = encodeURIComponent(GetContents());
				var request = 'action=contact&name='+name+'&email='+email+'&subject='+subject+'&content='+content;
				var url = './php/servicetest.php';
				var result = getJson(request,url);
				if(result=="success"){
				    $('#sendResult').removeClass().html('您的邮件已成功发送，我们将尽快给你满意的答复！谢谢！').css("color","black");
					$('#contact_userName').val("");
					$('#contact_userEmail').val("");
					$('#contact_subject').val("");
                    SetContents("");					
				}
				else{
				    $('#sendResult').html('对不起，您的邮件发送失败！').css("color","red");
				}
				return;
			}
			else {
			$('#sendResult').html('对不起，您的填写有误，请详细检查！').css("color","red");
			return false;
			}
		}
        </script>
		<div style="float:left;width:170px;height:100px;"></div>
		<div style="float:left;">
			<textarea  id="editor1" name="ckeditor_content"></textarea>
		</div>
		<div class="clear"></div>
		<script type="text/javascript">
		
		//<![CDATA[
			// Replace the <textarea id="editor1"> with an CKEditor instance.
			var editor = CKEDITOR.replace( 'editor1',{width:600,height:200
				} );
		//]]>
		</script>

		<div id="eButtons" style="margin-left:160px;">
			<!--<input onclick="InsertHTML();" type="button" value="Insert HTML" />-->
			<!--<input onclick="SetContents();" type="button" value="Set Editor Contents" /> -->
			<!--<input onclick="alert(GetContents());" type="button" value="Get Editor Contents (XHTML)" />
            <input type="button" value="Ajax Submit" onclick="AjaxSubmit();">
            -->
            <p style="padding:10px; margin:0px;">
                <input id="contact_submit" type="image" src="./images/submit.png" value="Submit" 
                onclick="javascript:sendContactMail1();" onmouseover="elementFadeTo('contact_submit');" onmouseout="elementFadeBack('contact_submit');">
            </p>
			<span id="sendResult"></span><br/>
		</div>
		<!--script>//CKEDITOR.instances.content.insertHtml("<img src='./images/backtoMainMap.png'>");
			alert(CKEDITOR.instances);
		</script-->
</div>