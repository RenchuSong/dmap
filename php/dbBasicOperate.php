<?php
	/**数据库连接
		服务器，用户名，密码
	*/
	function getConnection() {
		return @mysql_connect("localhost","root","111111");
	}
	function openConnection($exec_mysql) {
		mysql_select_db("dmap", $exec_mysql);
		mysql_query("SET CHARACTER SET utf8");
	}
	function closeConnection($exec_mysql) {
		mysql_close($exec_mysql);
	}
	
	/**参数安全化
		数据
	*/
	function safeParam($str) {
		return htmlspecialchars($str,ENT_QUOTES,"UTF-8");
	}
		
	/**返回最新的插入数据库的Id
	*/
	function recentInsertId() {
		return mysql_insert_id();
	}
	
?>