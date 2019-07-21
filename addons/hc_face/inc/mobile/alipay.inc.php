<?php
    defined('IN_IA') or exit('Access Denied');
	require_once IA_ROOT."/addons/hc_face/core/alipay/wappay/service/AlipayTradeService.php";
	require_once IA_ROOT."/addons/hc_face/core/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php";

    global $_GPC, $_W;
    $weid = $_W['uniacid'];
    $type = $_GPC['type'];
	$rid = $_GPC['rid'];
	$uid = $_COOKIE['uid'];
	$refer = urldecode($_GPC['refer']);


    $arr = explode('&',$refer);
    foreach ($arr as $param) {
        $item = explode('=', $param);
        $params[$item[0]] = $item[1];
    }
    $siteroot = $_W['sitescheme'].$_SERVER['HTTP_HOST'];
    if($params['do']=='unlock'){
    	$return_url = $siteroot.'/app/index.php?i='.$_W['uniacid'].'&c=entry&type='.$type.'&rid='.$rid.'&do=unlockreport&m=hc_face';
    }elseif($params['do']=='buy' || $params['do']=='upload' || $params['do']=='report'){
    	$return_url = $siteroot.'/app/index.php?i='.$_W['uniacid'].'&c=entry&rid='.$rid.'&do=report&m=hc_face';
    }else{
    	$return_url = $siteroot.'/app/index.php?i='.$_W['uniacid'].'&c=entry&do=index&m=hc_face';
    }
    $notify_url = $siteroot.'/addons/hc_face/alipay.php';

	$pay = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'pay'.$weid),array('value')),'true');
	$openid = pdo_getcolumn('hcface_users',array('uid'=>$uid),array('openid'));
	if($type=='bg'){
	    $money = $pay['report_money'];
	}else{
	    $money = pdo_getcolumn('hcface_goods',array('weid'=>$weid,'type'=>$type),array('price'));
	}
	$params = array(
	    'weid'      => $weid,
	    'type'      => $type,
	    'uid'       => $uid,
	    'rid'       => $rid,
	    'openid'    => $openid,
	    'trade_no'  => date('YmdHis').rand(1000,9999),
	    'money'     => $money,
	    'createtime'=> time()
	);
	$res = pdo_insert('hcface_order',$params);


	
    $subject = '解锁内容';
    $total_amount = $params['money'];
    $body = '解锁内容';
    $out_trade_no = $params['trade_no'];
    //超时时间
    $timeout_express="1m";

    $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
    $payRequestBuilder->setBody($body);
    $payRequestBuilder->setSubject($subject);
    $payRequestBuilder->setOutTradeNo($out_trade_no);
    $payRequestBuilder->setTotalAmount($total_amount);
    $payRequestBuilder->setTimeExpress($timeout_express);

    $alipay = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'alipay'.$weid),array('value')),'true');
    $config = array(
        'app_id' => $alipay['appid'],
        'merchant_private_key' => $alipay['private_key'],
        'charset' => "UTF-8",
        'sign_type'=>"RSA2",
        'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
        'alipay_public_key' => $alipay['public_key'],
    );


    $payResponse = new AlipayTradeService($config);

    $result=$payResponse->wapPay($payRequestBuilder,$return_url,$notify_url);

    return ;