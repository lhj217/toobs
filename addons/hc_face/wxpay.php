<?php
define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';

$postStr = file_get_contents("php://input"); // 这里拿到微信返回的数据结果
libxml_disable_entity_loader(true);
$xmlstring = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
$res = json_decode(json_encode($xmlstring),true);
 file_put_contents(IA_ROOT."/addons/hc_face/log",json_encode($xmlstring));

/*$xmlstring = '{"appid":"wx257a3917e740795f","bank_type":"CFT","cash_fee":"10","fee_type":"CNY","is_subscribe":"Y","mch_id":"1481324482","nonce_str":"jznqc5PP890YhtepQ9ZEYFdmBobddHsW","openid":"oEuMd0oNUWhf1dNHMBV0_GGCByXQ","out_trade_no":"201903041803173259","result_code":"SUCCESS","return_code":"SUCCESS","sign":"219408D7E9AB67D86D6A14BE36E62834","time_end":"20190304180320","total_fee":"10","trade_type":"JSAPI","transaction_id":"4200000247201903041322981636"}';
$res = json_decode($xmlstring,true);*/


if ($res['return_code'] == 'SUCCESS' && $res['return_code'] == 'SUCCESS') {
    $trade_no  = trim($res['out_trade_no']);
    $total_fee = $res['total_fee']/100;
    $transaction_id = $res['transaction_id'];
    $openid    = $res['openid'];
    $order = pdo_get('hcface_order',array('trade_no'=>$trade_no));
    $params = array(
        'money'          => $total_fee,
        'status'         => 1,
        'transaction_id' => $transaction_id,
        'paytime'        => time()
    );
    pdo_update('hcface_order',$params,array('trade_no'=>$trade_no));

    $weid = $order['weid'];
    $rid = $order['rid'];
    //处理解锁数据 开始
    if($order['type']=='bg'){
        pdo_update('hcface_report',array('unlock'=>1),array('id'=>$rid));
    }elseif($order['type']=='hd'){
        pdo_update('hcface_hand_report',array('unlock'=>1),array('id'=>$rid));
    }

    $basic = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'basic'.$weid),array('value')),'true');
    $url = 'http://jx.1fanggou.com/ai.php';
    $url2 = 'http://jx.1fanggou.com/hand.php';
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
    if($order['type']=='bz'){
        $params = array(
            'appid' => $basic['appid'],
            'appkey'=> $basic['appkey'],
            'client_ip'=>$client_ip,
            'weid'  => $weid,
            'type' => '鼻子',
            'nonstr'=> TIMESTAMP
        );
        $params['sign'] = md5($basic['appid'].$basic['appkey'].$params['nonstr']);
        $res = ihttp_post($url,$params);
        $nose = json_decode($res[content],true);
        pdo_update('hcface_report',array('nose_desc'=>$nose[data][content]),array('id'=>$rid));
    }
    if($order['type']=='qg'){
        $params = array(
            'appid' => $basic['appid'],
            'appkey'=> $basic['appkey'],
            'client_ip'=>$client_ip,
            'weid'  => $weid,
            'type' => '情感',
            'nonstr'=> TIMESTAMP
        );
        $params['sign'] = md5($basic['appid'].$basic['appkey'].$params['nonstr']);
        $res = ihttp_post($url,$params);
        $emotion = json_decode($res[content],true);
        pdo_update('hcface_report',array('emotion'=>$emotion[data][content]),array('id'=>$rid));
    }
    if($order['type']=='sy'){
        $params = array(
            'appid' => $basic['appid'],
            'appkey'=> $basic['appkey'],
            'client_ip'=>$client_ip,
            'weid'  => $weid,
            'type' => '事业',
            'nonstr'=> TIMESTAMP
        );
        $params['sign'] = md5($basic['appid'].$basic['appkey'].$params['nonstr']);
        $res = ihttp_post($url,$params);
        $cause = json_decode($res[content],true);
        pdo_update('hcface_report',array('cause'=>$cause[data][content]),array('id'=>$rid));
    }
    if($order['type']=='sm'){
        $score = pdo_getcolumn('hcface_hand_report',array('id'=>$rid),array('score'));
        $params = array(
            'appid' => $basic['appid'],
            'appkey'=> $basic['appkey'],
            'client_ip'=>$client_ip,
            'weid'  => $weid,
            'score' => $score,
            'field' => 'shengming',
            'nonstr'=> TIMESTAMP
        );
        $params['sign'] = md5($basic['appid'].$basic['appkey'].$params['nonstr']);
        $res = ihttp_post($url2,$params);
        $content = json_decode($res[content],true);
        pdo_update('hcface_hand_report',array('shengming'=>$content[data]),array('id'=>$rid));
    }
    if($order['type']=='ys'){
        $score = pdo_getcolumn('hcface_hand_report',array('id'=>$rid),array('score'));
        $params = array(
            'appid' => $basic['appid'],
            'appkey'=> $basic['appkey'],
            'client_ip'=>$client_ip,
            'weid'  => $weid,
            'score' => $score,
            'field' => 'yunshi',
            'nonstr'=> TIMESTAMP
        );
        $params['sign'] = md5($basic['appid'].$basic['appkey'].$params['nonstr']);
        $res = ihttp_post($url2,$params);
        $content = json_decode($res[content],true);
        pdo_update('hcface_hand_report',array('yunshi'=>$content[data]),array('id'=>$rid));
    }

    
    //分销开始
    $weid = pdo_getcolumn('hcface_users',array('openid'=>$openid),array('weid'));
    $fenxiao = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'fenxiao'.$weid),array('value')),'true');
    
    $userInfo = pdo_get('hcface_users',array('openid'=>$openid),array('pid','uid'));
    $level_one_uid = $userInfo['pid'];
    if($fenxiao['level']>0 && !empty($level_one_uid)){
        $level_one_info = pdo_get('hcface_users',array('uid'=>$level_one_uid),array('pid','level'));
        $level_one = $level_one_info['level'];
        $level_one_com = array(
            'weid'       => $weid,
            'user_id'    => $level_one_uid,
            'sub_id'     => $userInfo['uid'],
            'trade_no'   => $trade_no,
            'price'      => $total_fee,
            'rate'       => $fenxiao['commission'][$level_one-1]['commission1'],
            'profit'     => round($total_fee*$fenxiao['commission'][$level_one-1]['commission1']/100,2),
            'level'      => $level_one,
            'sort'       => 1,
            'createtime' => time()
        );
        $lel1 = pdo_get('hcface_commission',array('user_id'=>$level_one_uid,'sub_id'=>$userInfo['uid'],'trade_no'=>$trade_no));
        if(empty($lel1)){
        	pdo_insert('hcface_commission',$level_one_com);
        }
        
    }
    $level_two_uid = $level_one_info['pid'];
    if($fenxiao['level']>1 && !empty($level_two_uid)){
        $level_two_info = pdo_get('hcface_users',array('uid'=>$level_two_uid),array('pid','level'));
        $level_two = $level_two_info['level'];
        $level_two_com = array(
            'weid'       => $weid,
            'user_id'    => $level_two_uid,
            'sub_id'     => $userInfo['uid'],
            'trade_no'   => $trade_no,
            'price'      => $total_fee,
            'rate'       => $fenxiao['commission'][$level_two-1]['commission2'],
            'profit'     => round($total_fee*$fenxiao['commission'][$level_two-1]['commission2']/100,2),
            'level'      => $level_two,
            'sort'       => 2,
            'createtime' => time()
        );
        $lel2 = pdo_get('hcface_commission',array('user_id'=>$level_two_uid,'sub_id'=>$userInfo['uid'],'trade_no'=>$trade_no));
        if(empty($lel2)){
        	pdo_insert('hcface_commission',$level_two_com);
        }
    }
    $level_thr_uid = $level_two_info['pid'];
    if($fenxiao['level']>2 && !empty($level_thr_uid)){
        $level_thr_info = pdo_get('hcface_users',array('uid'=>$level_thr_uid),array('level'));
        $level_thr = $level_thr_info['level'];
        $level_thr_com = array(
            'weid'       => $weid,
            'user_id'    => $level_thr_uid,
            'sub_id'     => $userInfo['uid'],
            'trade_no'   => $trade_no,
            'price'      => $total_fee,
            'rate'       => $fenxiao['commission'][$level_thr-1]['commission3'],
            'profit'     => round($total_fee*$fenxiao['commission'][$level_thr-1]['commission3']/100,2),
            'level'      => $level_thr,
            'sort'       => 3,
            'createtime' => time()
        );
        $lel3 = pdo_get('hcface_commission',array('user_id'=>$level_thr_uid,'sub_id'=>$userInfo['uid'],'trade_no'=>$trade_no));
        if(empty($lel3)){
       	 pdo_insert('hcface_commission',$level_thr_com);
        }
    }

    echo 'success';
    return ;
}
