<?php
/*=========================
本程式已完成
Daan-X的主程式
==========================*/
	$time_start_all = microtime(true);
	$mysql_sign=mysql_connect("localhost","DaanX","1234");//登入SQL(請改密碼)
	$mysql_check=mysql_select_db("DaanX",$mysql_sign);//選擇資料厙
	mysql_query("SET NAMES utf8");//資料庫編碼設定
    echo "已登入資料庫.\n";
	include"phpQuery-onefile.php";//引入phpQuery的code
	$time_start_id= microtime(true);
	include"get_web_last.php";//引入資料表"紀錄的陣列變數"
	$time_end_id= microtime(true);
	$time_id=$time_end_id-$time_start_id;
	echo "取得最新ID的執行時間:".$time_id."\n";
		if ($read_data==1) {
			$time_start_main= microtime(true);
			for ($A=0; $A <count($array_unmber) ; $A++) {//當有新資料時 計算陣列數並執行迴圈
				include"get_web_main.php";//引入"寫入資料庫的頁面內容"
			$time_end_main= microtime(true);
			$time_main=$time_end_main-$time_start_main;
			}
		}
		else{
			echo  "無新資料寫入資料庫"."\n";
		}
	mysql_close($mysql_sign);//登出SQL
	$time_end_all = microtime(true);
	$time_all = $time_end_all - $time_start_all;
	echo "總程式執行時間:".$time_all."\n";
?>
