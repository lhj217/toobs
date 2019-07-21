<?php
    defined('IN_IA') or exit('Access Denied');
	require_once IA_ROOT."/addons/hc_face/core/alipay/wappay/service/AlipayTradeService.php";
	require_once IA_ROOT."/addons/hc_face/core/alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php";

    global $_GPC, $_W;
    $weid = $_W['uniacid'];
	$uid = $_COOKIE['uid'];
    $level = $_GPC['level'];
    $type  = $_GPC['type'];

    $siteroot = $_W['sitescheme'].$_SERVER['HTTP_HOST'];
    $return_url = $siteroot.'/app/index.php?i='.$_W['uniacid'].'&c=entry&do=upgrade&type='.$type.'&m=hc_face';

    $notify_url = $siteroot.'/addons/hc_face/uplevel3.php';

    $trade_no = date('YmdHis').rand(1000,9999);
    $openid = pdo_getcolumn('hcface_users',array('uid'=>$uid),array('openid'));

    $fenxiao = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'fenxiao'.$weid),array('value')),'true');



    $pay = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'pay'.$weid),array('value')),'true');

    //echo "<pre>";print_r($fenxiao);die;
    if($level==1){
        if(empty($fenxiao[grade][1][money])){
            $fee =  '9.9';
        }else{
            $fee = $fenxiao[grade][1][money];
        }
        if(empty($fenxiao[grade][1][grade])){
            $title = '代理';
        }else{
            $title = $fenxiao[grade][1][grade];
        }
    }

    if($level==2){
        if(empty($fenxiao[grade][2][money])){
            $fee =  '19.9';
        }else{
            $fee = $fenxiao[grade][2][money];
        }
        if(empty($fenxiao[grade][2][grade])){
            $title = '合伙人';
        }else{
            $title = $fenxiao[grade][2][grade];
        }
    }

    $params = array(
        'weid'  => $weid,
        'title' => $title,
        'trade_no' => $trade_no,
        'uid'   => $uid,
        'openid'=> $openid,
        'price' => $fee,
        'level' => $level+1,
        'createtime' => time()
    );
    $res = pdo_insert('hcface_upgrade',$params);
	
    $subject = '升级'.$title;
    $total_amount = $params['price'];
    $body = '升级'.$title;
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