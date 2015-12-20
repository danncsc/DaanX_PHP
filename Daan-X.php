<?php
/*=========================
本程式已完成
Daan-X的主程式
==========================*/
	$time_start = microtime(true);
	$mysql_sign=mysql_connect("localhost","DaanX","ffMmQ2Nze2VNsHEn");//登入SQL
	$mysql_check=mysql_select_db("DaanX",$mysql_sign);//選擇資料厙
	mysql_query("SET NAMES utf8");//資料庫編碼設定
	include"phpQuery-onefile.php";//引入phpQuery的code
	include"get_web_last.php";//引入資料表"紀錄的陣列變數"
		if ($read_data==1) {
			for ($A=0; $A <count($array_unmber) ; $A++) {//當有新資料時 計算陣列數並執行迴圈
				include"get_web_main.php";//引入"寫入資料庫的頁面內容"
			}
		}
	mysql_close($mysql_sign);//登出SQL
	$time_end = microtime(true);
	$time = $time_end - $time_start;
	echo $time;
?>
