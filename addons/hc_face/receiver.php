<?php
/**
 * hc_face模块订阅器
 *
 * @author 会创科技
 * @url
 */
defined('IN_IA') or exit('Access Denied');
class Hc_faceModuleReceiver extends WeModuleReceiver {
    public function receive() {
        global $_GPC, $_W;
        //file_put_contents(IA_ROOT.'/addons/hc_face/current_module', json_encode($_GPC));
        
        $msg = $this->message;
        if($msg['msgtype']=='event'){
            $forward = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'forward'.$_W['uniacid']),array('value')),true);
            if(($msg['event']=='SCAN' || $msg['event']=='subscribe') && !empty($msg['scene'] && $_GPC['modulename']=='hc_face' && !empty($forward['title']))){
                $account_api = WeAccount::create();
                $token = $account_api->getAccessToken();
                $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$token;


                $params = array(
                    'touser'  => $msg[from],
                    'msgtype' => 'news',
                    'news'    => array(
                        'articles' => array(
                            array(
                                'title'  => $forward['title'],
                                'description'=> $forward['ctitle'],
                                'url'    => $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry&do=index&m=hc_face&pid='.$msg['scene'],
                                'picurl' => tomedia($forward['img'])
                            )
                        )
                    )
                );
                file_put_contents(IA_ROOT.'/addons/hc_face/bb1', json_encode($params,JSON_UNESCAPED_UNICODE));
                $res = ihttp_post($url,json_encode($params,JSON_UNESCAPED_UNICODE));
                //file_put_contents(IA_ROOT.'/addons/hc_face/bb1', json_encode($res));
            }
        }
    }


}