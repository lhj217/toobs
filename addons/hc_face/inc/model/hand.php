<?php
Class Hand{
	function getText($score,$field){
		global $_W;
		$basic = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'basic'.$_W['uniacid']),array('value')),'true');
		
		$url = 'http://jx.1fanggou.com/hand.php';

		if (isset($_SERVER['SERVER_NAME'])) {
	        $client_ip = gethostbyname($_SERVER['SERVER_NAME']);
	    } else {
	        if (isset($_SERVER)) {
	            if (isset($_SERVER['SERVER_ADDR'])) {
	                $client_ip = $_SERVER['SERVER_ADDR'];
	            } elseif (isset($_SERVER['LOCAL_ADDR'])) {
	                $client_ip = $_SERVER['LOCAL_ADDR'];
	            }
	        } else {
	            $client_ip = getenv('SERVER_ADDR');
	        }
	    }
		
	    $params = array(
	        'appid' => $basic['appid'],
	        'appkey'=> $basic['appkey'],
	        'client_ip'=>$client_ip,
	        'weid'  => $_W['uniacid'],
	        'score' => $score,
	        'field' => $field,
	        'nonstr'=> TIMESTAMP
	    );
	    $params['sign'] = md5($basic['appid'].$basic['appkey'].$params['nonstr']);


	    $res = ihttp_post($url,$params);
		return json_decode($res[content],true);
	}
	
}