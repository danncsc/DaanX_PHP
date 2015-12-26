<?php
/*=========================
本程式已完成
include的程式
第一階段的程式
==========================*/
	$ch=curl_init();//curl宣告(第一階段)
	curl_setopt($ch, CURLOPT_URL,"http://ta.taivs.tp.edu.tw/news/news.asp?KEY=$array_unmber[$A]");//網頁來源宣告(第一階段)
	curl_setopt($ch, CURLOPT_HEADER, false);//頁面標籤顯示(第一階段)
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//顯示頭信息？(第一階段)
	$web_data=curl_exec($ch);//取網頁原始碼(第一階段)
	$doc=phpQuery::newDocumentHTML($web_data);//將抓來的資料丟到phpQuery的code(第一階段)
	$do_pq=pq('table[width="100%"]&&[align="center"]',$doc);//取得內容頁面並將不需要的程式碼刪除(第一階段)
	$web_main_top_day=$do_pq->find('td[align="center"]&&[width="13%"]&&[bgcolor="#FF0000"]')->text();//日期
	$web_main_top_title=$do_pq->find('td[align="left"]&&[width="87%"]&&[bgcolor="#FF0000"]')->text();//主題
	$web_main_data=iconv("big5","UTF-8",$do_pq->find('tr[bgcolor="#FFDDBB"]')->find('td[width="87%"]')->html());//內文
	$web_main_where=$do_pq->find('tr[bgcolor="#FCEBC7"]')->find('td[width="87%"]')->text();//資料來源
	$web_main_outside_link=$do_pq->find('tr[bgcolor="#FFFF00"]')->find('td[bgcolor="#FFFFCC"]&&[width="87%"]')->find('a')->html();//參考連結
		if($web_main_outside_link !==""){//當參考連結存在（剛好會和有效日期疊到）時
			$web_main_can_read_time_form=explode("\n"."            ", $do_pq->find('tr')->find('td[bgcolor="#FFFFCC"]&&[width="87%"]')->text());//切割收到的資料（因為後另一資料抓法會重疊到）
			$web_main_can_read_time=$web_main_can_read_time_form[1];//有效日期A情況
		}
		else{//當參考連結不存在時
			$web_main_can_read_time=$do_pq->find('tr')->find('td[bgcolor="#FFFFCC"]&&[width="87%"]')->text();//有效日期B情況
		}
	$web_main_link_sum="";//初始變數
	$web_main_link="";//初始變數
	$web_main_link_from=explode("<br>", iconv("big5","UTF-8",$do_pq->find('td[colspan=2]')->html()));//附件的原始資料（陣列）
		for ($m=0; $m <count($web_main_link_from) ; $m++) { //一陣列數來判斷要抓多少程式
			$Address_frist02=strpos($web_main_link_from[$m],"href=",0);//抓字首
			$Address_end02=strpos($web_main_link_from[$m]," target",0);//抓字尾
			$Address_long02=$Address_end02-$Address_frist02;//抓字首和字尾的差;
			$web_main_link_output=substr($web_main_link_from[$m],$Address_frist02+6,$Address_long02-7);//抓超連結文字
			$web_main_link_sum[]="http://ta.taivs.tp.edu.tw/news/$web_main_link_output"."|||";//附件轉成一陣列
		}
		if (count($web_main_link_sum)>1) {//分析陣列
			for ($x=1; $x < count($web_main_link_sum); $x++) {//忽略第一個空值
				$web_main_link=$web_main_link.$web_main_link_sum[$x];//輸出切割網址
			}
		}
	$web_main_file_from = $do_pq->find('p[align="center"]')->html();//抓取圖片<p></p>+抓圖的html的code
	$web_main_file="";//初始變數
	$Address_frist=strpos($web_main_file_from,"KEY=",0);//抓字首
	$piv=array("jpg","gif","png","jpeg","bmp");//圖形種類
		for ($r=0; $r <5 ; $r++) {//圖形種類判斷
			$Address_end=strpos($web_main_file_from,$piv[$r],0);//抓字尾
				if ($Address_end >0) {
					break;//抓到時
				}
		}
	$Address_long=$Address_end-$Address_frist;//抓字首和字尾的差
	$web_main_file_check_output=substr($web_main_file_from,$Address_end,3);//抓末三字
	$web_main_file_output=substr($web_main_file_from,$Address_frist+10,$Address_long-7);//抓超連結文字
		if($web_main_file_check_output =="jpg"||$web_main_file_check_output =="gif"||$web_main_file_check_output =="png"||$web_main_file_check_output =="jpeg"||$web_main_file_check_output =="bmp"){//當末三字是jpg時（我還沒看過學校資料上有png或gif的文章附件）
			$web_main_file="http://ta.taivs.tp.edu.tw/news/$web_main_file_output";//圖片輸出
		}
/*=========================
本程式已完成
include的程式
第二階段的程式
==========================*/
	$http = array('http://ta.taivs.tp.edu.tw/news/news.asp?SearchRole=%BC%D0%C3D&SearchWord=&SearchWay=%BE%C7%A5%CD%A8%C6%B0%C8&board=1','http://ta.taivs.tp.edu.tw/news/news.asp?SearchRole=%BC%D0%C3D&SearchWord=&SearchWay=%AC%A1%B0%CA%A7%D6%B3%F8&board=1','http://ta.taivs.tp.edu.tw/news/news.asp?SearchWay=%C4v%C1%C9&board=1','http://ta.taivs.tp.edu.tw/news/news.asp?SearchWay=%BAa%C5A%BA%5D&board=1','http://ta.taivs.tp.edu.tw/news/news.asp?SearchWay=%BC%FA%BE%C7%AA%F7%A4%BD%A7i&board=1','http://ta.taivs.tp.edu.tw/news/news.asp?SearchRole=%BC%D0%C3D&SearchWord=&SearchWay=%B5%F9%A5U%B8%C9%A7U%B4%EE%A7K&board=1','http://ta.taivs.tp.edu.tw/news/news.asp?SearchRole=%BC%D0%C3D&SearchWord=&SearchWay=%B7s%BE%C7%B4%C1%AD%AB%ADn%A4%BD%A7i&board=1');//抓取的網頁陣列表(第二階段)
		for ($n=0; $n <count($http) ; $n++) { //抓取網頁取網頁的陣列迴圈
		$ch_stu_text=curl_init();//curl宣告(第二階段)
		curl_setopt($ch_stu_text, CURLOPT_URL,"$http[$n]");//網頁來源宣告(第二階段)
		curl_setopt($ch_stu_text, CURLOPT_HEADER, false);//頁面標籤顯示(第二階段)
		curl_setopt($ch_stu_text, CURLOPT_RETURNTRANSFER, true);//顯示頭信息？(第二階段)
		$web_stu_text_data=curl_exec($ch_stu_text);//取網頁原始碼(第二階段)
		$stu_text_doc=phpQuery::newDocumentHTML($web_stu_text_data);//將抓來的資料丟到phpQuery的code(第二階段)
		$cut_stu_text=explode("\n", pq('table[border="1"]',$stu_text_doc)->find('tr[bgcolor]')->find('a')->text());//取得標題的文字
			for ($o=0; $o<count($cut_stu_text) ; $o++) { //搜尋該頁面資料數以執行迴圈
					if ($n<2&&substr($web_main_top_title,4,40)==substr($cut_stu_text[$o],0,40)) {//當資料內容相同且對應輸出資料庫的網頁陣列數＄n＝0,1
						mysql_query("INSERT INTO stu_main_stu_affairs (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫
					}
					else if ($n<4&&substr($web_main_top_title,4,40)==substr($cut_stu_text[$o],0,40)) {//當資料內容相同且對應輸出資料庫的網頁陣列數＄n＝2,3
						mysql_query("INSERT INTO stu_main_stu_race (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫
					}
					else if($n<6&&substr($web_main_top_title,4,40)==substr($cut_stu_text[$o],0,40)) {//當資料內容相同且對應輸出資料庫的網頁陣列數＄n＝4,5
						mysql_query("INSERT INTO stu_main_stu_help (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫
					}
					else if ($n==6&&substr($web_main_top_title,4,40)==substr($cut_stu_text[$o],0,40)) {//當資料內容相同且對應輸出資料庫的網頁陣列數＄n＝7
						mysql_query("INSERT INTO stu_main_this_term (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫
					}
			}
	curl_close($ch_stu_text);//結束php_curl
	}
	mysql_query("INSERT INTO stu_main_this_week (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫（總數據）
	curl_close($ch);//結束php_curl(第一階段)
?>
