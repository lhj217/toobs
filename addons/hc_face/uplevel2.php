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

    $ordersn = trim($_POST['order_no']);
    $params = array(
        'transaction_id'=> $_POST['order_no'],
        'paytime'		=> time(),
        'status'		=> 1
    );
    pdo_update('hcface_upgrade',$params,array('trade_no'=>$ordersn));

    $upgrade = pdo_get('hcface_upgrade',array('trade_no'=>$ordersn));


    pdo_update('hcface_users',array('level'=>$upgrade['level']),array('openid'=>$upgrade['openid']));


    //分销开始
    $openid = $upgrade['openid'];
    $trade_no = $ordersn;
    $total_fee = $upgrade['price'];

    $weid = pdo_getcolumn('hcface_users',array('openid'=>$openid),array('weid'));
    $fenxiao = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'fenxiao'.$weid),array('value')),'true');
    
    $userInfo = pdo_get('hcface_users',array('openid'=>$openid),array('pid','uid'));
    $level_one_uid = $userInfo['pid'];
    if($fenxiao['uplevel']>0 && !empty($level_one_uid)){
        $level_one_info = pdo_get('hcface_users',array('uid'=>$level_one_uid),array('pid','level'));
        $level_one = $level_one_info['level'];
        $level_one_com = array(
            'weid'       => $weid,
            'user_id'    => $level_one_uid,
            'sub_id'     => $userInfo['uid'],
            'trade_no'   => $trade_no,
            'price'      => $total_fee,
            'rate'       => $fenxiao['upcommission'][$level_one-1]['commission1'],
            'profit'     => round($total_fee*$fenxiao['upcommission'][$level_one-1]['commission1']/100,2),
            'level'      => $level_one,
            'sort'       => 1,
            'createtime' => time()
        );
        pdo_insert('hcface_commission',$level_one_com);
    }
    $level_two_uid = $level_one_info['pid'];
    if($fenxiao['uplevel']>1 && !empty($level_two_uid)){
        $level_two_info = pdo_get('hcface_users',array('uid'=>$level_two_uid),array('pid','level'));
        $level_two = $level_two_info['level'];
        $level_two_com = array(
            'weid'       => $weid,
            'user_id'    => $level_two_uid,
            'sub_id'     => $userInfo['uid'],
            'trade_no'   => $trade_no,
            'price'      => $total_fee,
            'rate'       => $fenxiao['upcommission'][$level_two-1]['commission2'],
            'profit'     => round($total_fee*$fenxiao['upcommission'][$level_two-1]['commission2']/100,2),
            'level'      => $level_two,
            'sort'       => 2,
            'createtime' => time()
        );
        pdo_insert('hcface_commission',$level_two_com);
    }
    $level_thr_uid = $level_two_info['pid'];
    if($fenxiao['uplevel']>2 && !empty($level_thr_uid)){
        $level_thr_info = pdo_get('hcface_users',array('uid'=>$level_thr_uid),array('level'));
        $level_thr = $level_thr_info['level'];
        $level_thr_com = array(
            'weid'       => $weid,
            'user_id'    => $level_thr_uid,
            'sub_id'     => $userInfo['uid'],
            'trade_no'   => $trade_no,
            'price'      => $total_fee,
            'rate'       => $fenxiao['upcommission'][$level_thr-1]['commission3'],
            'profit'     => round($total_fee*$fenxiao['upcommission'][$level_thr-1]['commission3']/100,2),
            'level'      => $level_thr,
            'sort'       => 3,
            'createtime' => time()
        );
        pdo_insert('hcface_commission',$level_thr_com);
    }

    
    echo 'success';
    return ;
}
