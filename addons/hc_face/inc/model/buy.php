<?php
class Buy
{
	function __construct($id,$link,$uid){
		$this->id = $id;
		$this->link = $link;
		$this->uid = $uid;
	}	
	function getRandChar($length){
        $str = null;
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        for ($i = 0; $i < $length; $i ++) {
            $str .= $strPol[rand(0, $max)]; // rand($min,$max)生成介于min和max两个数之间的一个随机整数
        }
        return $str;
    }
	function getparams($link,$char = ''){
        if(empty($char)){
            return array('data'=>$link,'code'=>1,'message'=>'参数获取成功');
        }
        $url = API_URL.'/api/index/getParams';
        $pars = array(
            'shorturl' => urlencode($link),
            'char'     => $char
        );
        $res = ihttp_post($url,$pars);
        return json_decode($res['content'],true);
    }

    function getprice($id){
        global $_W;
        $weid = $_W['uniacid'];
        $goods = pdo_get('hcsup_goods',array('id'=>$id));
        $basic = json_decode(pdo_getcolumn('hcsup_setting',array('only'=>'basic'.$weid),array('value')),'true');
        if($goods['price_type']==0 && !empty($basic['price'])){
            return round($goods['cost_price'] * ($basic['price']/100 +1),2);
        }else{
            return $goods['unit_price'];
        }
    }
	public function buy()
	{
		global $_W;
		$weid = $_W['uniacid'];
		$id = $this->id;
		$link = $this->link;
		$uid = $this->uid;
		$goods = pdo_get('hcsup_goods',array('id'=>$id));
        $users = pdo_get('hcsup_users',array('uid'=>$uid));
        $basic = json_decode(pdo_getcolumn('hcsup_setting',array('only'=>'basic'.$weid),array('value')),'true');

        if($goods['cateid']==1){
        	$type=2;
        }else{
        	$type=1;
        }
        if($type==1){
            if(!empty($goods['params'])){
                $cat1 = explode(',',$goods['params']);

                if (is_array($cat1)) {

                    //获取参数
                    $result = $this->getparams($link,1);
                    if($result['code']==0){
                        return json_encode($result);
                    }else{
                        $ass = $result['data'];
                    }
                    foreach ($cat1 as $k => $v) {
                        $w = explode(':',$v);
                        if(empty($w[1])){
                            $account = $link;
                            $orderinfo = '';
                        }else{
                            if($k==0){
                                $account = $ass[$w[1]]; 
                            }else{
                                $orderinfo .= $w[0].'='.$ass[$w[1]].';'; 
                            }
                        }
                        unset($w);                    
                    }
                }
            }else{
                $account = $link;
                $orderinfo = '';
            }
            
            $params = array(
                'appid'  => $basic['appid'],
                'nonstr' => $this->getRandChar(32),
                'sign'   => '',
                'kid'    => $id,
                'type'   => 0,
                'uniacid'=> $weid,
                'nickname' => $users['nickname'],
                'openid'   => $users['openid'],
                'title'    => $goods['title'],
                'price'    => $this->getprice($id),
                'ProductID'       => $goods['original_id'],
                'TargetAccount'   => $account,
                'BuyAmount'       => 1,
                'ManualOrderInfo' => $orderinfo,
                'Comment'         => $link,
                'CustomerIP'      => CLIENT_IP,
            );
        }else if($type==2){
            $params = array(
                'appid'  => $basic['appid'],
                'nonstr' => $this->getRandChar(32),
                'sign'   => '',
                'kid'    => $id,
                'type'   => 1,
                'uniacid'=> $weid,
                'nickname' => $users['nickname'],
                'openid'   => $users['openid'],
                'title'    => $goods['title'],
                'price'    => $this->getprice($id),
                'ProductID'  => $goods['original_id'],
                'CustomerIP' => CLIENT_IP,
            );
        }
        $params['sign'] = md5($basic['appid'].$basic['appkey'].$params['nonstr']);

        $payurl = API_URL.'/api/index/goBuy';
        $res = ihttp_post($payurl,$params);
        return $res['content'];
	}

}