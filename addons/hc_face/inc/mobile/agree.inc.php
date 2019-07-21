<?php
    defined('IN_IA') or exit('Access Denied');
    require_once IA_ROOT."/addons/hc_face/inc/model/account.php"; 
    global $_GPC, $_W;
    $weid = $_W['uniacid'];
    $uid = $_COOKIE['uid'];
    $pid = empty($_GPC['pid'])?0:trim($_GPC['pid']);
    $account = new Account($pid);
    $account->redirect();
    $account->account();
    $forward = $account->share();
    if($account->unseal()){
        include $this->template('appeal/list');die;
    }
    $basic = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'basic'.$weid),array('value')),'true');

    $content = htmlspecialchars_decode($basic['explain']);
    //echo "<pre>";print_r($info);die;
    include $this->template('agree');