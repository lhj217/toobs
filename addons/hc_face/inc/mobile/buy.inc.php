<?php
    defined('IN_IA') or exit('Access Denied');
    require_once IA_ROOT."/addons/hc_face/inc/model/account.php"; 
    global $_GPC, $_W;
    $weid = $_W['uniacid'];
    $uid  = $_COOKIE['uid'];
    $pid = empty($_GPC['pid'])?0:trim($_GPC['pid']);
    
    $account = new Account($pid);
    $account->redirect();
	$account->account();
    $forward = $account->share();
    if($account->unseal()){
        include $this->template('appeal/list');die;
    }
    $pay = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'pay'.$weid),array('value')),'true');
    $basic = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'basic'.$weid),array('value')),'true');

    $face = pdo_getall('hcface_report', array('weid'=>$weid,'uid'=>$uid,'unlock'=>1,'name !='=>'','isdelete !='=>1), array() , '' , 'id ASC');
    foreach ($face as $key => $val) {
        $face[$key]['cate'] = 'face';
    }
    if($basic['hand']==1){
        $hand = array();
        $res = pdo_getall('hcface_hand_report', array('weid'=>$weid,'uid'=>$uid,'unlock'=>1,'name !='=>'','isdelete !='=>1), array() , '' , 'id ASC');
        if($res){
            $hand = $res;
        }
        foreach ($hand as $key => $val) {
            $hand[$key]['cate'] = 'hand';
        }
        $report = empty($face)?array_merge($hand,$face):array_merge($face,$hand);
    }else{
        $report = $face;
    }
    //echo "<pre>";print_r($report);die;
    $list = pdo_getall('hcface_goods', array('weid'=>$weid), array() , '' , 'id ASC');
    foreach ($list as $key => $val) {
        $list[$key]['thumb'] = tomedia($val['thumb']);
    }

    include $this->template('buy');