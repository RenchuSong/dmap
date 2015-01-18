<?php
	/**节点数据表操作
		添加节点
		修改节点
		根据Id获取节点
		获取某校区所有节点Id列表
		删除节点
		添加连接路径
		取出一个节点关联的所有节点的Id列表
	*/
	//添加节点：横坐标、纵坐标
	function addNode($nodeCampusId,$nodeX,$nodeY) {
		if (!mysql_query("INSERT INTO tb_node (
			nodeCampusId,
			nodeX,
			nodeY,
			linkNodeList
		)
		VALUES (
			'$nodeCampusId',
			'$nodeX',
			'$nodeY',
			'-|'
		)")) {
			return false;
		}
		return true;
	}
	//修改节点：横坐标，纵坐标
	function updateNode($nodeId,$nodeX,$nodeY) {
		if (!mysql_query("UPDATE tb_node SET 
			nodeX='$nodeX',
			nodeY='$nodeY'
			where nodeId='$nodeId'
		")){
			return false;
		}
		return true;
	}
	//获取某个节点：节点Id
	function getNodeById($nodeId) {
		$result = mysql_query("SELECT nodeCampusId,nodeX,nodeY,linkNodeList FROM tb_node where (nodeId='$nodeId')");
		if (!$node=mysql_fetch_object($result))
			return null;
		return $node;
	}
	//获取某校区所有节点Id列表
	function getCampusNodeIdList($campusId) {
		$result = mysql_query("SELECT nodeId FROM tb_node where (nodeCampusId='$campusId')");
		$nodeList=array();
		while ($itemNode=mysql_fetch_object($result)) {
			array_push($nodeList,$itemNode->nodeId);
		}
		return $nodeList;
	}
	//删除节点：节点Id
	function removeNode($nodeId) {
		if (!isolateNode($nodeId)) return false;
		if (!mysql_query("DELETE FROM tb_node WHERE nodeId='$nodeId'"))
			return false;
		return true;
	}
	//添加/删除节点单向路径：第一个点Id，第二个点Id，操作 Add:添加 Delete:删除
	function changeSinglePath($node1,$node2,$flag) {
		if ($node1==$node2) return false;
		$result = mysql_query("SELECT linkNodeList FROM tb_node where (nodeId='$node1')");
		if (!$node=mysql_fetch_object($result))
			return false;
		$linkNodeList=$node->linkNodeList;
		$strSegment=$node2."|";
		if ($flag=="Add") {
			if (!strpos($linkNodeList,"|".$strSegment)){
				$linkNodeList.=$strSegment;
				if (!mysql_query("UPDATE tb_node SET 
					linkNodeList = '$linkNodeList'
					where nodeId='$node1'
				")){
					return false;
				}
			}else return false;
		}
		elseif($flag=="Delete") {
			$pos=strpos($linkNodeList,"|".$strSegment);
			if ($pos>0){
				$linkNodeList=substr_replace($linkNodeList,"",$pos+1,strlen($strSegment));
				if (!mysql_query("UPDATE tb_node SET 
					linkNodeList = '$linkNodeList'
					where nodeId='$node1'
				")){
					return false;
				}
			}else return false;
		}
		return true;
	}
	//添加两点之间的双向路径：节点1,节点2
	function addDoublePath($node1,$node2) {
		return
		changeSinglePath($node1,$node2,"Add") and
		changeSinglePath($node2,$node1,"Add");
	}
	//删除两点之间的双向路径：节点1,节点2
	function removeDoublePath($node1,$node2) {
		return
		changeSinglePath($node1,$node2,"Delete") and
		changeSinglePath($node2,$node1,"Delete");
	}
	//孤立化一个点：节点Id
	function isolateNode($nodeId) {
		$linkList=getLinkNodeList($nodeId);
		if ($linkList==null) return true;
		$size=sizeof($linkList);
		for ($i=0;$i<$size;++$i)
			if (!removeDoublePath($nodeId,$linkList[$i]))
				return false;
		return true;
	}
	//取出某个节点的关联节点Id列表
	function getLinkNodeList($nodeId) {
		$result = mysql_query("SELECT linkNodeList FROM tb_node where (nodeId='$nodeId')");
		if (!$node=mysql_fetch_object($result))
			return false;
		if ($node->linkNodeList!="-|") {
			$linkNodeList=substr($node->linkNodeList,2,strlen($node->linkNodeList)-3);
			$linkList=explode("|",$linkNodeList);
			return $linkList;
		}else return null;
	}
?>