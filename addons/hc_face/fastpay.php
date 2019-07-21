<?php
define('IN_MOBILE', true);
require '../../framework/bootstrap.inc.php';
if (!function_exists('get_openid')) {
    require IA_ROOT."/addons/hc_face/fastpay/Fast_Cofig.php";
}
$weid = $_POST['me_param'];
$pay = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'pay'.$weid),array('value')),'true');

define("FAST_APPKEY", $pay['appkey']);//你的appkey
define("SECRET_KEY", $pay['secretkey']);//你的秘钥

$sign=$_POST['sign'];//获取签名
$check_sign=notify_sign($_POST);
if($sign!=$check_sign){
  exit("签名失效");
//签名计算请查看怎么计算签名,或者下载我们的SDK查看
}
if ($_POST['status'] == 'y') {
    
    $trade_no  = trim($_POST['order_no']);
    $total_fee = $_POST['total_fee'];
    $transaction_id = $_POST['order_no'];
    $openid    = $_POST['uid'];
    $params = array(
        'money'          => $total_fee,
        'status'         => 1,
        'transaction_id' => $transaction_id,
        'paytime'        => time()
    );
    pdo_update('hcface_order',$params,array('trade_no'=>$trade_no));
    $order = pdo_get('hcface_order',array('trade_no'=>$trade_no));

    //$weid = $order['weid'];
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
        pdo_insert('hcface_commission',$level_one_com);
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
        pdo_insert('hcface_commission',$level_two_com);
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
        pdo_insert('hcface_commission',$level_thr_com);
    }


    echo 'success';
    return ;
}
