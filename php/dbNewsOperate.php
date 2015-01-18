<?php
	/**新闻操作
		添加新闻
		获取新闻
		修改新闻
		删除新闻
	*/
	//添加新闻：新闻标题，新闻内容
	function addNews($newsTitle,$newsContext) {
		if (!mysql_query("INSERT INTO tb_news (
			newsTitle,
			newsContext,
			newsTime
		)
		VALUES (
			'$newsTitle',
			'$newsContext',
			'".time()."'
		)")) {
			return false;
		}
		return true;
	}
	//获取新闻：新闻Id
	function getNewsByid($newsId) {
		$result = mysql_query("SELECT newsTitle,newsContext,newsTime FROM tb_news where (newsId='$newsId')");
		if (!$news=mysql_fetch_object($result))
			return null;
		return $news;
	}
	//分页获取新闻：页码，每页显示个数
	function getPageNews($page,$showEachPage) {
		if ($page<1) $page=1;
		$offset=($page-1)*$showEachPage;
		$result = mysql_query("SELECT newsId,newsTitle,newsContext,newsTime FROM tb_news ORDER BY newsTime desc limit $offset,$showEachPage");
		$newsList=array();
		while ($newsItem=mysql_fetch_object($result)) {
			array_push($newsList,$newsItem);
		}
		return $newsList;
	}
	//修改新闻：新闻Id，新闻标题，新闻内容
	function updateNews($newsId,$newsTitle,$newsContext) {
		if (!mysql_query("UPDATE tb_news SET 
			newsTitle = '$newsTitle',
			newsContext = '$newsContext'
			where newsId='$newsId'
		")){
			return false;
		}
		return true;
	}
	//删除新闻：新闻Id
	function removeNews($newsId) {
		if (!mysql_query("DELETE FROM tb_news WHERE newsId='$newsId'"))
			return false;
		return true;
	}
?>