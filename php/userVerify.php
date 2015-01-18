<?php
	session_start();
	function userIsAdmin() {
		if ((!isset($_SESSION['dmapUserAuthority'])) ||  ($_SESSION['dmapUserAuthority']=="0")) return false;
		return true;
	}
?>