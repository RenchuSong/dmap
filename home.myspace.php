<?php
     if(!isset($_SESSION['dmapUser'])){
		 echo "<script> window.location='index.php';</script>";
		 }
	 else {
?>
<div id="main-myspace">
    <!--div id="myspace-mainlink">
		<a href="index.php?topid=userspots">My Spots</a><br>
        <a href="index.php?topid=userinfo">My Info</a><br> 
        <a href="index.php?topid=userfriends">My Friends</a>
    </div-->
	<div id="myspace-mainlink">
		<ul style="list-style:none; padding:0;margin-top:-10px;">
           <li class="<?php if ($_GET['topid']=="userinfo" || $_GET['topid']=="edituserinfo" || $_GET['topid']=="userfriends") echo "link-item";else echo "link-item-active"; ?>"><img height="20" src="images/mySpots.png" id="mySpotsImage" style="float:left;"><a id="link_userspots" href="index.php?topid=userspots" style="display:block;width:140px;float:left;">MY SPOTS</a></li>
           <li class="<?php if ($_GET['topid']=="userinfo" || $_GET['topid']=="edituserinfo") echo "link-item-active";else echo "link-item"; ?>"><img height="20" src="images/myInfo.png" id="myInfoImage" style="float:left;"><a id="link_userinfo" href="index.php?topid=userinfo" style="display:block;width:140px;float:left;">MY INFORMATION</a></li>
           <li class="<?php if ($_GET['topid']=="userfriends") echo "link-item-active";else echo "link-item"; ?>"><img height="20" src="images/myFriends.png" id="myFriendsImage" style="float:left;"><a id="link_userfriends" href="index.php?topid=userfriends" style="display:block;width:140px;float:left;">MY FRIENDS</a></li>
        </ul>
    </div>
    <script language="javascript">$('#link_'+'<?php echo $_GET['topid']; ?>').removeClass().addClass("linkHover");</script>
    <div id="myspace-detail" style="background:#f2f2f2; float:left; position:relative; width:758px;min-height:420px; padding:10px;">
    <?php 
	switch($_GET['topid']){
		 case 'userinfo'    : myspace_getMyInfo();    break;
		 case 'userspots'   : myspace_getMySpots();   break;
		 case 'userfriends' : myspace_getMyFriends(); break;
		 case 'edituserinfo': myspace_editUserInfo(); break;	
		 default: myspace_getMySpots();
		 }
	?>
    </div>
</div>
<script language="javascript">


</script>
<?php
	 }
	 //显示myinfo 的html
     function myspace_getMyInfo(){
		 ?>
         <script language="javascript">
		     var JSON = getUserByName('<?php echo $_SESSION['dmapUser']; ?>');
			 var userInfo = eval('('+JSON+')');
			 var userHtml = '<div id="userInfo-detail">' 
			              + '<h2 style="margin-bottom:7px;">My Information <a id="edit-userinfo" href="index.php?topid=edituserinfo"><img src="./images/edit.png" style="vertical-align:bottom;" />Edit</a></h2>'
						  + '<div class="userInfoItem"><div class="aInfoItem">My Username：</div><?php echo $_SESSION['dmapUser']; ?></div>'			            
			              + '<div class="clear"></div><div class="userInfoItem"><div class="aInfoItem">My Email：</div>'+userInfo.userEmail+'</div>'
						  + '<div class="clear"></div><div class="userInfoItem"><div class="aInfoItem">My Homepage：</div>'+userInfo.userWebpage+'</div>'
						  + '<div class="clear"></div><div class="userInfoItem"><div class="aInfoItem">Introduce Myself：</div></div><div class="userInfoItem" style="padding-top:5px;width:300px;float:left;padding:0;">'+userInfo.userInformation;
				if (userInfo.userInformation=="") userHtml+="You'd Better Say Something <br/>About Yourself <br/>In Order To Make More Friends.";
				userHtml +=	'</div>'
			              + '</div>'
						  + '<div id="userInfo-image">'
						  + '<img style="width:210px;" src="php/showImage.php?id='+userInfo.userId+'">'
						  + '</div>';
			 document.write(userHtml);
         </script>
		 <?php
		 }
	 function myspace_editUserInfo(){
		 ?>
         <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
	     <script type="text/javascript" src="js/ckeditor-api.js"></script>
         <script language="javascript">
		     var JSON = getUserByName('<?php echo $_SESSION['dmapUser']; ?>');
			 var userInfo = eval('('+JSON+')');
			 //alert(JSON);
			 var userHtml = '<div id="userInfo-detail" style="font-size:16px;color:#666;line-height:30px;">' 
			              + '<form id="editform" method="post" action="./php/servicetest.php" onsubmit="return checkEditInfo();">'
						  + '<input type="hidden" name="action" value="updateuserinfo">'
			              + '　My Username： <?php echo $_SESSION['dmapUser']; ?><br/>'
			              //+ '<label for="edit-userName">　My Username：</label>'
						  //+ '<input id="edit-userName" name="edit-userName" value=>'
			              + '　　　My Email： '+userInfo.userEmail+'<br/>'
						  + '&nbsp;<span style="font-size:20px;">&nbsp;</span><label for="edit-userWebpage">My Homepage：</label>'
						   + '<input id="edit-userWebpage" name="edit-userWebpage" value="'+userInfo.userWebpage+'"><br/>'
						  + '<label for="editor1">Introduce Myself：</label><span id="edit-submit-info"></span><br/>'
						  + '<textarea  id="editor1" name="ckeditor_content"></textarea>'
						  + '<a class="operateUserBtn" href="javascript:submitChangeUserInfo();" style="float:left;display:block;width:68px;margin-top:5px;"><img src="./images/submit.png" /></a>'
			              + '<a class="operateUserBtn" href="./index.php?topid=userinfo" style="float:left;margin-left:10px;display:block;width:27px;margin-top:5px;" title="取消编辑"><img src="./images/logout.jpg" style="width:27px;height:27px;" /></a>'
						  + '<span id="changeUserInfoStatus"></span>'
						  + '</form><div class="clear"></div></div>'
						  + '<div id="userInfo-image">'
						  //+ '<a id="edit-userinfo" href="index.php?topid=edituserinfo">edit</a><br>'
						  + '<img style="width:200px;" src="./php/showImage.php?id='+userInfo.userId+'" />'
						  + '</div>';
			 document.write(userHtml);
			 var editor = CKEDITOR.replace( 'editor1',{
				 width:520,
				 height:200
				} );
			 SetContents(userInfo.userInformation);
			 var editSuccess = false;

			 function checkEditInfo(){
				 editSuccess = false;
				 if(editSuccess==false){
					 $('#edit-submit-info').removeClass().html("信息修改有误或为进行任何修改，不能提交。").addClass("wrong");
					 return false;
					 }
				 }
         </script>
		 <?php
		 }
	 //显示my spots 的html
	 function myspace_getMySpots(){
		 ?>
         <script language="javascript">
			document.write("<h2 style='margin-bottom:7px;'>My Spots</h2><div id='userSpaceActionContainer'></div>");
			globalActionIdList=eval("("+getJson("userId=<?php echo $_SESSION["dmapUserId"] ?>","./php/actionIdList.php")+")");
			userSpaceActionShown=0;
			showNextActions();
			//alert(getJson("userId=<?php echo $_SESSION["dmapUserId"] ?>","./php/actionIdList.php"));
			/*var len=actionIdList.length;
			for (var i=0;i<len;++i){
				var actionItem=eval("("+getJson("actionId="+actionIdList[i],"./php/getActionJson.php")+")");
				alert(actionItem.actionType);
			}*/
		 </script>
		 <?php
		 }
	//显示my friends 的html
	function myspace_getMyFriends(){
		if (!isset($_GET["userId"])){
	?>
			<h2 style="margin-bottom:7px;">My Friends</h2>
			<script language="javascript">
				document.write(getJson("userId=<?php echo $_SESSION["dmapUserId"] ?>","./php/showUserFriends.php"));
			</script>
	<?php
		}else{
			if ($_GET["userId"]==$_SESSION["dmapUserId"]){
	?>
	<script language="javascript">
		window.location="./index.php?topid=userinfo";
	</script>
	<?php
			}else{
	?>
		<h2 style="margin-bottom:7px;">His/Her Space <a id="return-friendList" href="index.php?topid=userfriends"><img src="./images/back.png" style="vertical-align:bottom;" /> Return to Friendlist</a></h2>
		<div id="userSpacePhotoDiv">
			<img src="./php/showImage.php?id=<?php echo $_GET["userId"] ?>" style="max-width:160px;min-width:160px;" />
			<script>
				document.write(getJson("userId=<?php echo $_GET["userId"]; ?>","./php/getFriendOperate.php"));
			</script>
		</div>
		<div id="someUserInfo">
			<script language="javascript">
				var JSON = getUserById(<?php echo $_GET["userId"]; ?>);
				if (JSON!=""){
					var userInfo = eval('('+JSON+')');
					var userHtml='<div class="aInfoItem">His/Her Name：</div>'+userInfo.userName+'<div class="clear" style="height:5px;"></div>'
								+'<div class="aInfoItem">Email：</div>'+userInfo.userEmail+'<div class="clear" style="height:5px;"></div>';
					if (userInfo.userWebpage!="http://") 
						userHtml+='<div class="aInfoItem">Homepage：</div>'+userInfo.userWebpage+'<div class="clear" style="height:5px;"></div>';
					userHtml+='<div class="aInfoItem">About Him/Herself：</div>'
					if (userInfo.userInformation=="")
						userHtml+="He/She Hasn't Said Anything About Him/Herself.";
					else userHtml+="<div style='width:350px;float:left;'>"+userInfo.userInformation+"</div>";
					document.write(userHtml);
				}else document.write("该用户不存在");
			</script>
		</div>
		<div class="clear"></div>
        <div id="userFocusPlaceAndFriends" style="float:left;position:relative;margin-top:10px; height:auto;">
            <div id="focusPlaceTitle" style="margin-top:20px;font-size:14px; font-weight:bold;color:#666;"></div>
            <script language="javascript"> 
                ///***获取关注地点列表***///				
				var json = getJson('userId='+'<?php echo $_GET["userId"]; ?>','./php/getFocusPlaceAction.php');
				var focusPlaceIdArray = eval('('+json+')');
				var focusPlaceNum=focusPlaceIdArray.length;
				if(json!='[]'){
					$('#focusPlaceTitle').html('TA 关注了以下地点');
					document.write('<div id="focusPlaceImage" style=" float:left; width:100%;  height:90px;overflow:hidden;padding:5px; "></div><span id="movePlaceImage" ><a class="linkUserSpace" style="margin-left:12px;"  href="javascript:showMorePlaceImage()">For more</a></span><div class="clear"></div>');
					for(var i=0;i<focusPlaceIdArray.length;i++){
						$('#focusPlaceImage').append('<div style="float:left; list-style:none; width:100px; margin-left:7px; margin-bottom:10px; ">'+getJson('placeId='+focusPlaceIdArray[i],'./php/loadFocusPlaceImage.php')+'</div>');					
						}
					}
				else{
					$('#focusPlaceTitle').html('TA 还没有关注任何地点哦');
					$('#focusPlaceImage','#movePlaceImage').hide();
					}
				if(focusPlaceNum<=7){
					$('#movePlaceImage').hide();
					}	
			function showMorePlaceImage(){
				var height = parseInt($('#focusPlaceImage').css('height'));
				$('#focusPlaceImage').css({height:height+90});				
				if(((height+100)/90)*7>focusPlaceNum){
					$('#movePlaceImage').empty().html('<a class="linkUserSpace" style="margin-left:12px;"  href="javascript:showLessPlaceImage()">For less</a>');
					return;
					}
				}
			function showLessPlaceImage(){
				var height = parseInt($('#focusPlaceImage').css('height'));
				$('#focusPlaceImage').css({height:height-90});
				if((height-90)<110){
					$('#movePlaceImage').empty().html('<a class="linkUserSpace" style="margin-left:12px;"  href="javascript:showMorePlaceImage()">For more</a>');
					return;
					}		
				}	
			///***获取好友列表***///
			json = getJson('userId='+'<?php echo $_GET["userId"]; ?>','./php/getFriendsList.php');
			var friendsNum = 0;
			document.write('<div id="userFriendsTitle" style="margin-top:20px;font-size:14px; font-weight:bold;color:#666;"></div>');
			if(json!='[]'){
				$('#userFriendsTitle').html('TA 的好友有');
				document.write('<div id="friendsImage" style=" float:left; width:100%;  height:90px;overflow:hidden;padding:5px; "></div><span id="moveFriendsImage" ><a class="linkUserSpace" style="margin-left:12px;"  href="javascript:showMoreFriendsImage()">For more</a></span><div class="clear"></div>');
				var friends = eval('('+json+')');
				friendsNum = friends.Id.length;
				if(friendsNum<=7) $('#moveFriendsImage').empty().hide();	
					for(var i=0;i<friends.Id.length;i++){
					$('#friendsImage').append('<div style="width:94px;height:90px;margin-bottom:5px;float:left; border:1px #ccc solid; margin-left:7px; overflow:hidden;"><a href="index.php?topid=userfriends&userId='+friends.Id[i]+'"><img  width="90" title="'+friends.Title[i]+'" src="php/showImage.php?id='+friends.Id[i]+'" style="padding:2px;"></a></div>');
					} 
				}
            else{
				$('#userFriendsTitle').html('TA 还没有好友哦！');
				$('#moveFriendsImage','#friendsImage').empty().hide();
				} 
						
			function showMoreFriendsImage(){
			    var height = parseInt($('#friendsImage').css('height'));
				$('#friendsImage').animate({height:height+97},200);				
				if(((height+100)/97)*7>friendsNum){
					$('#moveFriendsImage').empty().html('<a class="linkUserSpace" style="margin-left:12px;" href="javascript:showLessFriendsImage()">For less</a>');
					return;
					}			
			}
			function showLessFriendsImage(){
			    var height = parseInt($('#friendsImage').css('height'));
				$('#friendsImage').animate({height:height-97},200);
				if((height-97)<110){
					$('#moveFriendsImage').html('<a class="linkUserSpace" style="margin-left:12px;" href="javascript:showMoreFriendsImage()">For more</a>');
					return;
					}	
			}
            </script>
         
        </div>		
	<?php
			}
		}
	}
 ?>