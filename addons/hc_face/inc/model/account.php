<?php

class Account
{
	function __construct($pid){
		$this->pid = $pid;
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') === false){
			$this->browser = 1;
		}else{
			$this->browser = 0;
		}
		
	}	
	public function redirect()
	{
		global $_W;
		$weid = $_W['uniacid'];
		$fenxiao = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'fenxiao'.$_W['uniacid']),array('value')),'true');
		if(empty($fenxiao['domain'])){
			$site = explode('/', $_W['setting']['site']['url']);
			$ym = $site[2];
		}else{
			$ym = $fenxiao['domain'];
		}
  		
		if(!empty($fenxiao['purl'])){
			$purl = explode('/', $fenxiao['purl']);
			$hb = $purl[2];
		}else{
			$hb = $fenxiao['purl'];
		}
  		
		if(!empty($fenxiao['durl'])){
			if($_SERVER['HTTP_HOST']==$ym || $_SERVER['HTTP_HOST']==$hb){
				$durl = explode(';',$fenxiao['durl']);
		        $domain = $durl[rand(0,count($durl)-1)];
		        $request_uri = $_SERVER['REQUEST_URI'];
		        $url = $_W['sitescheme'].$domain.$request_uri;

		        if($domain!=$_SERVER['HTTP_HOST']){
		            header('Location: '.$url);
		        }
			}
	    }
	}

	public function account(){
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		$pid = $this->pid;
		$basic = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'basic'.$weid),array('value')),'true');

		if($this->browser==1 && $basic['wap']==1){
			$openid = $_COOKIE['openid'];
			$uid = $_COOKIE['uid'];
			if(empty($uid)){
				$arr['openid'] = $openid = md5(uniqid());
				$arr['nickname']= uniqid('AI_');
				$arr['avatar'] = '../addons/hc_face/public/avatar.png';
			}
		}else{
			$_W['container'] = 'wechat';
			$fans = mc_oauth_userinfo();
			$arr['openid'] = $openid = $fans['openid'];
	        $arr['nickname']= $fans['nickname'];
	        $arr['gender']   = $fans['sex'];
	        $arr['city']     = $fans['city'];
	        $arr['province'] = $fans['province'];
	        $arr['country']  = $fans['country'];
	        $arr['avatar'] = $fans['avatar'];
	        $arr['unionid']  = $fans['unionid'];
		}

		$self = pdo_get('hcface_users', array('openid'=>$openid));
		if($self['black']==1){
			header('Location: http://we7.senchen.xin');//https://mp.weixin.qq.com/
		}

	    if(empty($self) && !empty($openid)){
	        $arr['weid'] = $_W['uniacid'];
	        $arr['vip']  = 1;
	        $arr['createtime'] = time();
	        $result = pdo_insert('hcface_users', $arr);
	        if (!empty($result)) {
	            $uid = pdo_insertid();
	            setcookie("uid", $uid, time()+1440);
	            setcookie("openid", $openid, time()+1440);

		        $lockdata = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'lock'.$_W['uniacid']),array('value')),'true');
		        if($lockdata['type']==1){
		        	$rid = $_GPC['rid'];
		            $type = $_GPC['type'];
		            if(!empty($rid) && !empty($type)){
		            	$lock = array(
			            	'rid'  => $rid,
			            	'type' => $type,
			            	'uid'  => $uid,
			            	'createtime' => time(),
			            );
			            pdo_insert('hcface_order_unlock',$lock);

			            $num = pdo_getcolumn('hcface_order_unlock',array('rid'=>$rid,'type'=>$type),array('count(id)'));
			            if($num>=$lockdata['num'] && $lockdata['num']>0 && $lockdata['app']==1){
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

			            	if($type=='qg'){
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
						    if($type=='sy'){
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
						    if($type=='sm'){
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
						    if($type=='ys'){
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
			            }
		            }
		        }
	        }
	        //绑定分销
	        if($uid!=$pid){
	        	$fenxiao = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'fenxiao'.$weid),array('value')),'true');
	            $data = array(
	                'pid'=>$pid,
	                'uid'=>$uid,
	                'ctime'=>time()
	            );
	            if($fenxiao['level']>=2){
	            	$ppid = pdo_getcolumn('hcface_users',array('uid'=>$pid),array('pid'));
		            if(!empty($ppid)){
		                $data['ppid'] = $ppid;
		                if($fenxiao['level']==3){
			                $pppid = pdo_getcolumn('hcface_users',array('uid'=>$ppid),array('pid'));
			                if(!empty($pppid)){
			                    $data['pppid'] = $pppid;
			                }
			            }
		            }
	            }
	            
	            pdo_insert('hcface_nexus',$data);
	            pdo_update('hcface_users',array('pid'=>$pid),array('uid'=>$uid));
	        }
	        
	    	if($_GPC['do']=='distribution'){
	    		$url = $_W['sitescheme'].$_SERVER['HTTP_HOST'].'/app/index.php?i='.$_W['uniacid'].'&c=entry&do=index&m=hc_face&pid='.$pid;
	    		header('Location: '.$url);
	    	}
	    }else{
	    	setcookie('uid', $self['uid'], time()+1440);
	    	setcookie("openid", $self['openid'], time()+1440);
		}

	}

	public function share(){
		global $_GPC, $_W;
		$uid = $_COOKIE['uid'];
		$weid = $_W['uniacid'];
		$forward = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'forward'.$_W['uniacid']),array('value')),'true');
		$forward['img']= tomedia($forward['img']);

		$defend = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'defend'.$weid),array('value')),true);
        
		$siteroot = $_W['sitescheme'].$_SERVER['HTTP_HOST'];
		if($_GPC['do']=='distribution' || $_GPC[$defend['action']]=='distribution'){
			if($defend['switch']){
                $forward['link'] = $siteroot."/app/{$defend['entry']}{$_W['uniacid']}.php?{$defend['unique']}={$_W['uniacid']}&{$defend['action']}=distribution&pid=".$uid;
            }else{
            	$forward['link'] = $siteroot.'/app/index.php?i='.$_W['uniacid'].'&c=entry&do=distribution&m=hc_face&pid='.$uid;
            }
		}elseif($_GPC['do']=='unlock' || $_GPC[$defend['action']]=='unlock'){
			if($defend['switch']){
                $forward['link'] = $siteroot."/app/{$defend['entry']}{$_W['uniacid']}.php?{$defend['unique']}={$_W['uniacid']}&{$defend['action']}=index&type=".$_GPC['type'].'&rid='.$_GPC['rid']."&pid=".$uid;
            }else{
            	$forward['link'] = $siteroot.'/app/index.php?i='.$_W['uniacid'].'&c=entry&do=index&m=hc_face&type='.$_GPC['type'].'&rid='.$_GPC['rid'].'&pid='.$uid;
            }
		}else{
			if($defend['switch']){
                $forward['link'] = $siteroot."/app/{$defend['entry']}{$_W['uniacid']}.php?{$defend['unique']}={$_W['uniacid']}&{$defend['action']}=index&pid=".$uid;
            }else{
            	$forward['link'] = $siteroot.'/app/index.php?i='.$_W['uniacid'].'&c=entry&do=index&m=hc_face&pid='.$uid;
            }
		}
		return $forward;
	}

	public function unseal(){
		global $_GPC, $_W;
		$weid  = $_W['uniacid'];
		$basic = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'basic'.$weid),array('value')),'true');

		if($basic['art']==1){
			return true;
		}else{
			return false;
		}
	}
}