<?php
	sleep(1);

	require 'config.php';

	$query = mysql_query("SELECT titleid,comment,user,date FROM comment WHERE titleid='{$_POST['titleid']}'  ORDER BY date DESC LIMIT 0,5") or die('SQL 错误!');

	$json = '';

	while (!!$row = mysql_fetch_array($query,MYSQL_ASSOC)) {
		foreach ($row as $key => $value) {
		 	$row[$key] = urlencode(str_replace('\n', "", $value));
		}
		 $json .= urldecode(json_encode($row)).',';
		//print_r($row);
	} 

	echo '['.substr($json, 0, strlen($json) - 1).']';

	mysql_close();
?>