<?php
/*=========================
本程式已完成
include的程式
第一階段的程式
==========================*/
	$ch=curl_init();//curl宣告(第一階段)
	curl_setopt($ch, CURLOPT_URL,"http://ta.taivs.tp.edu.tw/news/news.asp?PageNo=1&board=1&KEY=$array_unmber[$A]");//網頁來源宣告(第一階段)
	curl_setopt($ch, CURLOPT_HEADER, false);//頁面標籤顯示(第一階段)
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//顯示頭信息？(第一階段)
	$web_data=curl_exec($ch);//取網頁原始碼(第一階段)
	$doc=phpQuery::newDocumentHTML($web_data);//將抓來的資料丟到phpQuery的code(第一階段)
	$do_pq=pq('table[width="100%"]&&[align="center"]',$doc);//取得內容頁面並將不需要的程式碼刪除(第一階段)
	$web_main_top_day=$do_pq->find('td[align="center"]&&[width="13%"]&&[bgcolor="#FF0000"]')->text();//日期
	    if($web_main_top_day ==""){
            $web_mian_top_day="日期錯誤";
            echo "有公告日期錯誤";
        }
    $web_main_top_title=str_replace('"','\"',$do_pq->find('td[align="left"]&&[width="87%"]&&[bgcolor="#FF0000"]')->text());//主題
	$serach=$do_pq->find('td[align="left"]&&[width="87%"]&&[bgcolor="#FF0000"]')->text();//搜尋資料用
	$web_main_data=iconv("big5","UTF-8",$do_pq->find('tr[bgcolor="#FFDDBB"]')->find('td[width="87%"]')->html());//內文
	$web_main_where=$do_pq->find('tr[bgcolor="#FCEBC7"]')->find('td[width="87%"]')->text();//資料來源
        if($web_main_where ==""){
            $web_main_where="？未知來源";
            echo "有未知來源公告";
        }
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
	$web_main_link_from=explode("<br>", iconv("big5","UTF-8",$do_pq->find('td[colspan=2]')->html()));//附件的原始資料html（陣列）
	$web_main_link_text=explode("\n",$do_pq->find('td[colspan=2]')->find('a')->text());//附件的原始資料text（陣列）
		for ($m=1; $m <count($web_main_link_from) ; $m++) { //一陣列數來判斷要抓多少程式
			$Address_frist02=strpos($web_main_link_from[$m],"href=",0);//抓字首
			$Address_end02=strpos($web_main_link_from[$m]," target",0);//抓字尾
			$Address_long02=$Address_end02-$Address_frist02;//抓字首和字尾的差;
			$web_main_link_output=substr($web_main_link_from[$m],$Address_frist02+6,$Address_long02-7);//抓超連結文字
			$web_main_link_sum[]=$web_main_link_text[$m-1]."///"."http://ta.taivs.tp.edu.tw/news/$web_main_link_output"."|||";//附件轉成一陣列
		}
		if ($web_main_link_text[0] !="") {//分析陣列
			for ($x=0; $x < count($web_main_link_sum); $x++) {//忽略第一個空值
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
			$web_main_file=str_replace('"','',"http://ta.taivs.tp.edu.tw/news/$web_main_file_output");//圖片輸出
		}
/*=========================
本程式已完成
include的程式
第二階段的程式
==========================*/
		$http=urlencode(iconv("UTF-8","Big5",trim($serach)));//先轉big5再轉url
		$ch_stu_text=curl_init();//curl宣告(第二階段)
		curl_setopt($ch_stu_text, CURLOPT_URL,"http://ta.taivs.tp.edu.tw/news/news.asp?SearchWay=no0&board=1&SearchWord=$http");//網頁來源宣告(第二階段)
		curl_setopt($ch_stu_text, CURLOPT_HEADER, false);//頁面標籤顯示(第二階段)
		curl_setopt($ch_stu_text, CURLOPT_RETURNTRANSFER, true);//顯示頭信息？(第二階段)
		$web_stu_text_data=curl_exec($ch_stu_text);//取網頁原始碼(第二階段)
		$stu_text_doc=phpQuery::newDocumentHTML($web_stu_text_data);//將抓來的資料丟到phpQuery的code(第二階段)
		$cut_stu_text=explode("\n", str_replace('"','\"', pq('table[border="1"]',$stu_text_doc)->find('tr[bgcolor]')->find('a')->text()));//取得標題的文字
		$caseB=explode("　",pq('tr[bgcolor="#FFE0C0"]')->find('td[width="10%"]&&[align="center"]')->text());
			if ($caseB[0]=="學生事務"||$caseB[0]=="活動快報"||$caseB[0]=="升學資訊") {//分類
				mysql_query("INSERT INTO stu_main_stu_affairs (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫
			}
			else if($caseB[0]=="榮譽榜"||$caseB[0]=="競賽"){//分類
				mysql_query("INSERT INTO stu_main_stu_race (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫

			}
			else if($caseB[0]=="註冊補助減免"||$caseB[0]=="獎學金公告"){//分類
				mysql_query("INSERT INTO stu_main_stu_help (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫
			}
			else if($caseB[0]=="新學期重要公告"){//分類
				mysql_query("INSERT INTO stu_main_this_term (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫
			}

		curl_close($ch_stu_text);//結束php_curl
		mysql_query("INSERT INTO stu_main_this_week (web_id,web_main_top_day,web_main_top_title,web_main_data,web_main_where,web_main_outside_link,web_main_can_read_time,web_main_link,web_main_file) VALUES ('$array_unmber[$A]','$web_main_top_day','$web_main_top_title','$web_main_data','$web_main_where','$web_main_outside_link','$web_main_can_read_time','$web_main_link','$web_main_file') ") ;//寫入資料庫（總數據）
		echo  "第".$A."筆資料庫寫入完成"."\n";

		curl_close($ch);//結束php_curl(第一階段)
?>
