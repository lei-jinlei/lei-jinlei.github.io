<?php

	require_once(sphinxapi.php);
	$keyword = '熊猫';
	$cl = new SphinxClient();
	$cl->SetServer('127.0.0.1', 9312);  // 链接sphinx服务
	$cl->SetConnectTimeout( 3 );		// 设置连接超时时间
	$cl->SetArrayResult( true );		// 以数组的方式返回检索结果
	$cl->SetMatchMode( SPH_MATCH_ANY );	// 设置匹配模式
	$cl->SetLimits(0,1000);				// 获取、显示1000条结果
	
	$index_name = 'product';
	$res = $cl->query($keyword, $index_name);
	
	// 从$res中获得检索后的主键id信息
	if(!empty($res['matches'])){
		$ids = array();
		foreach($res['matches'] as $v){
			$ids[] = $v['id'];
		}
		
		$ids = implode(',', $ids);
	}else{
		$ids = '';
	}
	
	$products = "select * from product where id in $ids";
	
	if(!empty($res['matches'])){
		$ginfo = array(); // 接受高亮处理后的商品信息
		foreach($products as $k => $v){
			// 给数据关键字设置高亮显示
			$row = $cl->buildExcerpts($v, $index_name, $keyword, array(
				'before_match'	=> '<span style="color:red;">',
				'after_match'	=> '</span>'
			));
			$ginfo[$k]['product_id'] = $row[0];
			//......
			
		}
		$info = $ginfo;
	}
	
	var_dump($info);
	