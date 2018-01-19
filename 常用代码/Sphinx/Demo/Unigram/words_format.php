<?php

	/**
	Last edit 2012-8-11
	Copyrigh@ www.4ji.cn
	**/
	ini_set('max_execution_time','6000');


	$buffer=ini_get('output_buffering');
	if($buffer)ob_end_flush();

	echo '处理新词库...
	';
	flush();
	$filename = "words.txt";
	$handle = fopen ($filename, "r");
	$content = fread ($handle, filesize ($filename));

	fclose ($handle);

	$content=trim($content);
	$arr1 = explode( "\r\n" ,$content );
	
	$arr1=array_flip(array_flip($arr1));
	foreach($arr1 as $key=>$value){
	$value=dealchinese($value);
	if(!empty($value)){
	$arr1[$key] = $value;
	}
	else{
	unset($arr1[$key]);
	}

	}

	echo '处理原来词库...
	';flush();
	$filename2 = "unigram.txt";
	$handle2 = fopen ($filename2, "r");
	$content2 = fread ($handle2, filesize ($filename2));
	fclose ($handle2);
	$content2=dealchinese($content2,"\r\n");
	$arr2 = explode( "\r\n" ,$content2 );
	echo '删除相同词条...
	';flush();

	$word_arr = array_merge($arr1, $arr2);
	// $array_diff=array_diff($arr2, $arr1);
	$array_diff = array_unique($word_arr);


	echo '格式化词库...
	';flush();
	$words='';
	foreach($array_diff as $k=>$word){
	$words.=$word."\t1\r\nx:1\r\n";
	}
	//echo $words;
	file_put_contents('words_new.txt',$words,FILE_APPEND);
	echo 'done!';

	function dealChinese($str,$join=''){
	preg_match_all('/[\x{4e00}-\x{9fff}]+/u', $str, $matches); //将中文字符全部匹配出来
	$str = join($join, $matches[0]); //从匹配结果中重新组合
	return $str;
	}
?>