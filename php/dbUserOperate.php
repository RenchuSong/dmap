<?php
	/**用户数据表操作
		添加用户
		修改用户信息
		获取用户信息
		设置用户权限(普通/管理员/超级管理员)
		添加/删除好友
		添加/删除关注地点
		设置用户的状态(未验证、验证、冻结、删除)
		获取朋友Id列表
	*/
	//添加用户：用户名、密码、用户信息、Email、主页
	function addUser($userName,$userPassword,$userInformation,$userEmail,$userWebpage,$userImage) {
		if (!mysql_query("INSERT INTO tb_user (
			userName,
			userPassword,
			userInformation,
			userEmail,
			userWebpage,
			friendList,
			focusPlaceList,
			userImage
		)
		VALUES (
			'$userName',
			'$userPassword',
			'$userInformation',
			'$userEmail',
			'$userWebpage',
			'-|',
			'-|',
			'$userImage'
		)")) {
			return false;
		}
		return true;
	}
	//修改用户：待修改用户Id、用户名、密码、用户信息、Email、主页
	function updateUser($id,$userName,$userPassword,$userInformation,$userEmail,$userWebpage) {
		if (!mysql_query("UPDATE tb_user SET 
			userName = '$userName',
			userPassword = '$userPassword',
			userInformation = '$userInformation',
			userEmail = '$userEmail',
			userWebpage = '$userWebpage'
			where userId='$id'
		")){
			return false;
		}
		return true;
	}
	//获取所有用户基本信息
	function getUserBasicInformationList() {
		$result = mysql_query("SELECT userId,userName,userAuthority,userInformation,userEmail,userWebpage,userStatus FROM tb_user WHERE userStatus!='3' ORDER BY userId desc");
		$userList=array();
		while(($userItem=mysql_fetch_object($result))!=null)
			array_push($userList,$userItem);
		return $userList;
	}
	//获取用户：待提取用户的Id
	function getUserById($id) {
		$result = mysql_query("SELECT userName,userPassword,userAuthority,userInformation,userEmail,userWebpage,friendList,focusPlaceList,userStatus FROM tb_user where (userId='$id')");
		if ($user=mysql_fetch_object($result))
			return $user;
		return null;
	}
	//获取用户：待提取用户的Name
	function getUserByName($userName) {
		$result = mysql_query("SELECT userId,userPassword,userAuthority,userInformation,userEmail,userWebpage,friendList,focusPlaceList,userStatus FROM tb_user where (userName='$userName')");
		if (!(@$user=mysql_fetch_object($result)))
			return null;
		return $user;
	}
	function getUserByEmail($userEmail) {
		$result = mysql_query("SELECT userId FROM tb_user where (userEmail='$userEmail')");
		if (!(@$user=mysql_fetch_object($result)))
			return null;
		return $user;
	}
	//设置用户权限：待设置用户的Id Normal:0 Admin:1 SuperAdmin:2
	function setUserAuthority($id,$authority) {
		if ($authority=="Normal")
			$userAuthority=0;
		elseif($authority=="Admin")
			$userAuthority=1;
		elseif($authority=="SuperAdmin")
			$userAuthority=2;
		else $userAuthority=0;

		if (!mysql_query("UPDATE tb_user SET 
			userAuthority = '$userAuthority'
			where userId='$id'
		")){
			return false;
		}
		return true;
	}
	//添加/删除好友：用户，待操作好友，操作 Add：添加 Delete：删除
	function changeFriend($userId,$friendId,$flag) {
		if ($userId==$friendId) return false;
		$result = mysql_query("SELECT friendList FROM tb_user where (userId='$userId')");
		if (!$user=mysql_fetch_object($result))
			return false;
		$friendList=$user->friendList;
		$strSegment=$friendId."|";
		if ($flag=="Add") {
			if (!strpos($friendList,"|".$strSegment)){
				$friendList.=$strSegment;
				if (!mysql_query("UPDATE tb_user SET 
					friendList = '$friendList'
					where userId='$userId'
				")){
					return false;
				}
			}else return false;
		}
		elseif($flag=="Delete") {
			$pos=strpos($friendList,"|".$strSegment);
			if ($pos>0){
				$friendList=substr_replace($friendList,"",$pos+1,strlen($strSegment));
				if (!mysql_query("UPDATE tb_user SET 
					friendList = '$friendList'
					where userId='$userId'
				")){
					return false;
				}
			}else return false;
		}
		return true;
	}
	//添加好友：user1与user2成为好友
	function addFriend($user1,$user2) {
		return
		changeFriend($user1,$user2,"Add") and
		changeFriend($user2,$user1,"Add");
	}
	//解除好友关系：user1与user2解除好友关系
	function removeFriend($user2,$user1) {
		return 
		changeFriend($user1,$user2,"Delete") and
		changeFriend($user2,$user1,"Delete");
	}
	//判断一个用户是否关注了一个地点：用户名，地点Id
	function ifUserFocusPlace($userName,$placeId){
		$result = mysql_query("SELECT focusPlaceList FROM tb_user where (userName='$userName')");
		if (!$user=mysql_fetch_object($result))
			return false;
		$focusPlaceList=$user->focusPlaceList;
		$strSegment=$placeId."|";
		if (!strpos($focusPlaceList,"|".$strSegment)){
			return false;
		}else return true;
	}
	//添加/删除关注地点：用户，地点，操作 Add：添加 Delete：删除
	function changeFocus($userId,$placeId,$flag) {
		$result = mysql_query("SELECT focusPlaceList FROM tb_user where (userId='$userId')");
		if (!$user=mysql_fetch_object($result))
			return false;
		$focusPlaceList=$user->focusPlaceList;
		$strSegment=$placeId."|";
		if ($flag=="Add") {
			if (!strpos($focusPlaceList,"|".$strSegment)){
				$focusPlaceList.=$strSegment;
				if (!mysql_query("UPDATE tb_user SET 
					focusPlaceList = '$focusPlaceList'
					where userId='$userId'
				")){
					return false;
				}
			}else return false;
			addAction($userId,$placeId,"Focus","");
		}
		elseif($flag=="Delete") {
			$pos=strpos($focusPlaceList,"|".$strSegment);
			if ($pos>0){
				$focusPlaceList=substr_replace($focusPlaceList,"",$pos+1,strlen($strSegment));
				if (!mysql_query("UPDATE tb_user SET 
					focusPlaceList = '$focusPlaceList'
					where userId='$userId'
				")){
					return false;
				}
			}else return false;
		}
		return true;
	}
	//设置用户状态：用户Id，状态 UnVerified:0 Verified:1 Locked:2 Deleted:3
	function setUserStatus($id,$status) {
		if ($status=="UnVerified")
			$userStatus=0;
		elseif($status=="Verified")
			$userStatus=1;
		elseif($status=="Locked")
			$userStatus=2;
		elseif($status=="Deleted")
			$userStatus=2;	
		else $userStatus=0;

		if (!mysql_query("UPDATE tb_user SET 
			userStatus = '$userStatus'
			where userId='$id'
		")){
			return false;
		}
		return true;
	}
	//获取朋友Id列表：用户Id
	function friendIdList($userId) {
		$result = mysql_query("SELECT friendList FROM tb_user where (userId='$userId')");
		if (!$user=mysql_fetch_object($result))
			return false;
		if ($user->friendList!="-|"){
			$list=substr($user->friendList,2,strlen($user->friendList)-3);
			$friendList=explode("|",$list);
			return $friendList;
		}else
			return array();
	}
	//获取关注地点Id列表：用户Id
	function focusPlaceIdList($userId) {
		$result = mysql_query("SELECT focusPlaceList FROM tb_user where (userId='$userId')");
		if (!$user=mysql_fetch_object($result))
			return false;
		if ($user->focusPlaceList!="-|"){
			$list=substr($user->focusPlaceList,2,strlen($user->focusPlaceList)-3);
			$focusPlaceList=explode("|",$list);
			return $focusPlaceList;
		}else
			return array();
	}
?>