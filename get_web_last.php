<?php
/*=========================
本程式已完成
include的程式
==========================*/
	$sum=0;//設定記數初始值
	$read_data=0;//設定記數初始值
	$read_SQL=mysql_query("SELECT * FROM stu_sgin");//尋找資料表
	$row_id_01 = mysql_fetch_row($read_SQL);//搜索列
	echo "上次的最後資料:".$row_id_01[0]."\n";
	$number=$row_id_01[0]+1;//取得第一個列的值（id）即上次搜索到的最終資料+1
	$array_unmber="";//設定紀錄用的陣列變數
		for ($i=$number; $i <$number+20 ; $i++) { //將＄i設為上次搜索到的最終資料 並以每二十個資料為一循環
			$hear=get_headers("http://ta.taivs.tp.edu.tw/news/news.asp?KEY=$i");//取得網站標頭（＄i為上次搜尋到的數字累加）
			$text=implode("", array_intersect(str_split($hear[5]), array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9)));//選取網站標頭的大小（$hear[5]） 並取得其大小（KB）
			$read_text=$number+20-$i-1;//當迴圈執行完 但數字未跑完時 迴圈增值的判定
			if($text>400&&$read_text>0){//當其大小 大於400KB 且迴圈未跑完時的判定
				$array_unmber[]=$i;//將（存在的）資料 存入$array_unmber的陣列中
			}
			elseif($text>400&&$read_text==0){//當其大小 大於400KB 且迴圈已跑完時的判定
				$array_unmber[]=$i;//將（存在的）資料 存入$array_unmber的陣列中
				$number=$number+20;//迴圈增值
			}

		}
	echo "已取得最新ID"."\n";
	if($array_unmber !=""){//當$array_unmber存在時
		$last_number=max($array_unmber);//將陣列中最大值取出
		mysql_query(" UPDATE stu_sgin SET id='$last_number'") ;//寫回SQL
		echo "本次搜尋的最後資料:".$last_number."\n";
		$read_data=1;
	}
	else{
		$read_data=0;
		echo "本次搜尋的最後資料:".$row_id_01[0]."\n";
	}
	
?>
