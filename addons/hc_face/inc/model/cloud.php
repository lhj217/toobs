<?php
Class Cloud{
	function getText($type){
		global $_W;
		$basic = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'basic'.$_W['uniacid']),array('value')),'true');
		
		$url = 'http://jx.1fanggou.com/ai.php';
	    $params = array(
	        'appid' => $basic['appid'],
	        'appkey'=> $basic['appkey'],
	        'type' => $type
	    );
	    $params['sign'] = md5($basic['appid'].$basic['appkey'].$params['nonstr']);
        logging_run("Cloud" . json_encode($GLOBALS['_W']));
	    $res = ihttp_post($url,$params);
		return json_decode($res[content],true);
	}
	
}