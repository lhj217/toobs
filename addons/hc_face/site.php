<?php
/**
 * hc_face模块微站定义
 *
 * @author 会创科技
 * @url 
 */
defined('IN_IA') or exit('Access Denied');
require_once IA_ROOT."/addons/hc_face/inc/model/functions.php"; 
class Hc_faceModuleSite extends WeModuleSite {


	public function doWebSet() {
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		if($_GPC['act']=='submit'){
			$data = array(
				'basic'   => json_encode($_GPC['basic']),
				'baidu'   => json_encode($_GPC['baidu']),
				'pay'     => json_encode($_GPC['pay']),
				'forward' => json_encode($_GPC['forward']),
				'fenxiao' => json_encode($_GPC['fenxiao']),
				'cash'    => json_encode($_GPC['cash']),
				'alipay'  => json_encode($_GPC['alipay']),
				'lock'    => json_encode($_GPC['lock']),
				'msg'     => json_encode($_GPC['msg']),
				'defend'  => json_encode($_GPC['defend']),
				'nav'     => json_encode($_GPC['nav']),
			);
			foreach ($data as $key => $val) {
				pdo_insert('hcface_setting',array('weid'=>$weid,'only'=>$key.$weid,'title'=>$key,'value'=>$val),'true');
			}
			$dir = IA_ROOT.'/addons/hc_face/cert/';
			if(!file_exists($dir)){
	            mkdir($dir);
	            chmod($dir,0777);
	        }
			if(!empty($_GPC['apiclient_cert'])){
				file_put_contents($dir.'apiclient_cert_'.$weid.'.pem',$_GPC['apiclient_cert']);
			}
			if(!empty($_GPC['apiclient_key'])){
				file_put_contents($dir.'apiclient_key_'.$weid.'.pem',$_GPC['apiclient_key']);
			}

			message('保存成功','referer','info');
		}else{
			$res = pdo_getall('hcface_setting',array('weid'=>$weid));
			foreach($res as $key => $val) {
				$set[$val['title']] = json_decode($val['value'],true);
			}
			if(empty($set[fenxiao][grade][0][grade])){
				$set[fenxiao][grade][0][grade] = '会员';
			}
			if(empty($set[fenxiao][grade][1][grade])){
				$set[fenxiao][grade][1][grade] = '代理';
			}
			if(empty($set[fenxiao][grade][2][grade])){
				$set[fenxiao][grade][2][grade] = '合伙人';
			}
			
			if(empty($set[fenxiao][grade][1][money])){
				$set[fenxiao][grade][1][money] = '9.9';
			}
			if(empty($set[fenxiao][grade][2][money])){
				$set[fenxiao][grade][2][money] = '19.9';
			}
			if(!is_array($set[fenxiao][commission][0])){
				unset($set[fenxiao][commission][0]);
				$set[fenxiao][commission][0][commission1] = '10';
				$set[fenxiao][commission][0][commission2] = '8';
				$set[fenxiao][commission][0][commission3] = '5';
			}

			if(!is_array($set[fenxiao][commission][1])){
				unset($set[fenxiao][commission][1]);
				$set[fenxiao][commission][1][commission1] = '15';
				$set[fenxiao][commission][1][commission2] = '10';
				$set[fenxiao][commission][1][commission3] = '8';
			}

			if(!is_array($set[fenxiao][commission][2])){
				unset($set[fenxiao][commission][2]);
				$set[fenxiao][commission][2][commission1] = '20';
				$set[fenxiao][commission][2][commission2] = '15';
				$set[fenxiao][commission][2][commission3] = '10';
			}

			if(!is_array($set[fenxiao][bgimg]) || empty($set[fenxiao][bgimg])){
				$set[fenxiao][bgimg] = array(
		            '../addons/hc_face/public/share1.jpg',
		            '../addons/hc_face/public/share2.jpg',
		            '../addons/hc_face/public/share3.jpg',
		        );
			}
			if(empty($set[fenxiao][grade][1][pic])){
				$set[fenxiao][grade][1][pic] = '../addons/hc_face/public/fuck_1.png';
			}
			if(empty($set[fenxiao][grade][2][pic])){
				$set[fenxiao][grade][2][pic] = '../addons/hc_face/public/fuck_2.png';
			}
			if(empty($set[fenxiao][recimg])){
				$set[fenxiao][recimg] = '../addons/hc_face/public/recommend.png';
			}

			if(empty($set[defend][entry])){
				$set[defend][entry] = 'f';
			}
			if(empty($set[defend][unique])){
				$set[defend][unique] = 'u';
			}
			if(empty($set[defend][action])){
				$set[defend][action] = 'a';
			}

			if(empty($set[nav][left_text])){
				$set[nav][left_text] = '查看更多';
			}
			if(empty($set[nav][left_icon])){
				$set[nav][left_icon] = '../addons/hc_face/public/index.png';
			}
			if(empty($set[nav][right_text])){
				$set[nav][right_text] = '购买报告';
			}
			if(empty($set[nav][right_icon])){
				$set[nav][right_icon] = '../addons/hc_face/public/my.png';
			}
			//echo "<pre>";print_R($set);die;
			
			include $this->template('web/setting');
		}
	}
	public function doWebRoute() {
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		$switch = trim($_GPC['switch']);
		$unique = trim($_GPC['unique']);
		$action = trim($_GPC['action']);
		$entry  = trim($_GPC['entry']);

		$isset = pdo_get('hcface_setting',array('only'=>'defend'.$weid));
		$data = json_encode(array(
			'switch' => $switch,
			'entry'  => $entry,
			'unique' => $unique,
			'action' => $action
		));
		if(empty($isset)){
			pdo_insert('hcface_setting',array('weid'=>$weid,'only'=>'defend'.$weid,'title'=>'defend','value'=>$data));
		}else{
			pdo_update('hcface_setting',array('value'=>$data),array('only'=>'defend'.$weid));
		}
		$dir = IA_ROOT."/app/";
		if(!file_exists($dir)){
            mkdir($dir,0777,true);
        }

		$files = $entry.$weid.'.php';
		if(file_exists($files)){
			@unlink($files);
		}	
		$fname = fopen(IA_ROOT."/app/".$files, "w");
		$txt = '<?php 
require "../framework/bootstrap.inc.php";
define("IN_MOBILE", true);
$_GPC["i"] = $_GPC["'.$unique.'"];
$_W["container"] = "wechat";
require IA_ROOT."/app/common/bootstrap.app.inc.php";
load()->app("common");
load()->app("template");
$op = $_GPC["'.$action.'"];
if (empty($op)) $op = "index";
$method = "doMobile".$op;
$site = WeUtility::createModuleSite("hc_face");
if(!is_error($site)) {
	$site->$method($op);
}';
		fwrite($fname, $txt);
		fclose($fname);
		exit(json_encode(array('code'=>1,'msg'=>'生成成功')));
	}


	public function doWebBanner() {
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 30;

        $list = pdo_getslice('hcface_banner',array('weid'=>$weid),array($pageindex, $pagesize),$total,array(),'','id desc');
        $page = pagination($total, $pageindex, $pagesize);
		include $this->template('web/banner');
	}
	public function doWebBanner_post(){
		global $_GPC, $_W;
		if($_GPC['act']=='add'){
			$data = array(
				'weid'       => $_W['uniacid'],
				'title'      => $_GPC['title'],
				'banner'     => $_GPC['banner'],
				'link'   => $_GPC['link'],
				'displayorder' => $_GPC['displayorder'],
				'status'     => $_GPC['status'],
				'createtime' => time()
			);
			pdo_insert('hcface_banner',$data);
			message('操作成功',$this->createWebUrl('banner'),'success');
		}elseif($_GPC['act']=='edit'){
			$data = array(
				'weid'       => $_W['uniacid'],
				'title'      => $_GPC['title'],
				'banner'     => $_GPC['banner'],
				'link'   => $_GPC['link'],
				'displayorder' => $_GPC['displayorder'],
				'status'     => $_GPC['status'],
			);
			pdo_update('hcface_banner',$data,array('id'=>$_GPC['id']));
			message('操作成功',$this->createWebUrl('banner'),'success');
		}elseif($_GPC['act']=='del'){
			pdo_delete('hcface_banner',array('id'=>$_GPC['id']));
			message('操作成功',$this->createWebUrl('banner'),'success');
		}elseif($_GPC['act']=='init'){
			$data = array(
				'weid'       => $_W['uniacid'],
				'banner'     => '../addons/hc_face/template/mobile/images/banner.png',
				'displayorder' => 1,
				'status'     => 0,
			);
			pdo_insert('hcface_banner',$data);
			$data = array(
				'weid'       => $_W['uniacid'],
				'banner'     => '../addons/hc_face/template/mobile/images/banner1.png',
				'displayorder' => 1,
				'status'     => 0,
			);
			pdo_insert('hcface_banner',$data);
			message('操作成功',$this->createWebUrl('banner'),'success');
		}else{
			if(!empty($_GPC['id'])){
				$info = pdo_get('hcface_banner',array('id'=>$_GPC['id']));
			}
			include $this->template('web/banner_post');
		}
	}
	/**
	 * 用户管理
	 * @return [type] [description]
	 */
	public function doWebUsers() {
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $keyword = $_GPC['keyword'];
        if(!empty($keyword)){
        	$where['weid'] = $weid;
        	$where['nickname like'] = '%'.$_GPC['keyword'].'%';
        }else{
        	$where['weid'] = $weid;
        }
        $level = $_GPC['level'];
        if(!empty($level)){
        	$where['level'] = $level;
        }
        $black = $_GPC['black'];
        if(!empty($black)){
        	$where['black'] = $black;
        }else{
        	$where['black'] = 0;
        }


        $users = pdo_getslice('hcface_users',$where,array($pageindex, $pagesize),$total,array(),'','createtime desc');
        foreach ($users as $key => $val) {
        	$users[$key]['parent'] = pdo_get('hcface_users',array('uid'=>$val['pid']));
        }
        //echo "<pre>";print_r($users);
        $page = pagination($total, $pageindex, $pagesize);

        $fenxiao = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'fenxiao'.$weid),array('value')),'true');
        //echo "<pre>";print_r($fenxiao['grade']);
        foreach ($fenxiao['grade'] as $key => $val) {
        	$fx[$key+1] = $val['grade'];
        	$fxs[$key]['id'] = $key+1;
        	$fxs[$key]['name'] = $val['grade'];
        }
        $today = pdo_getcolumn('hcface_users',array('weid'=>$weid,'createtime >'=>strtotime(date('Ymd'))),array('COUNT(uid)'));
        $today = empty($today)?0:$today;
        $all   = pdo_getcolumn('hcface_users',array('weid'=>$weid),array('COUNT(uid)'));
        $all = empty($all)?0:$all;


		include $this->template('web/users');
	}
	/**
	 * 用户操作
	 * @return [type] [description]
	 */
	public function doWebUserdo() {
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		if($_GPC['act']=='del'){
			pdo_delete('hcface_users',array('uid'=>$_GPC['uid']));
			message('操作成功',$this->createWebUrl('users'),'success');
		}elseif($_GPC['act']=='changelevel'){
			pdo_update('hcface_users',array('level'=>$_GPC['level']),array('uid'=>$_GPC['id']));
			message('操作成功',$this->createWebUrl('users'),'success');
		}elseif($_GPC['act']=='black'){
			pdo_update('hcface_users',array('black'=>$_GPC['b']),array('uid'=>$_GPC['id']));
			message('操作成功',$this->createWebUrl('users'),'success');
		}elseif($_GPC['act']=='chongzhi'){
			$money = pdo_getcolumn('hcface_users',array('uid'=>$_GPC['id']),array('money'));
			pdo_update('hcface_users',array('money'=>$money+$_GPC['money']),array('uid'=>$_GPC['id']));
			message('操作成功',$this->createWebUrl('users'),'success');
		}elseif($_GPC['act']=='mobile'){
        	$face = pdo_getall('hcface_report',array('uid'=>$_GPC['uid'],'unlock'=>1,'tel !='=>''),array('tel'));
        	$hand = pdo_getall('hcface_hand_report',array('uid'=>$_GPC['uid'],'unlock'=>1,'tel !='=>''),array('tel'));
        	$mobile = empty($face)?array_merge($hand,$face):array_merge($face,$hand);
        	foreach ($mobile as $key => $val) {
        		$tel[$val['tel']] = $val['tel'];
        	}
        	exit(json_encode($tel));
		}elseif($_GPC['act']=='team'){
			$uid   = $_GPC['uid'];
	        $level = $_GPC['level'];
	        $p = $_GPC['p'];
	        $l = $_GPC['l'];
	        $k = $_GPC['k'];
	        $pageindex = max(1, intval($_GPC['page']));
	        $pagesize = 10;

	        if($level==1){
	            $where['pid'] = $uid;
	        }elseif($level==2){
	            $where['ppid'] = $uid;
	        }elseif($level==3){
	            $where['pppid'] = $uid;
	        }else{
	        	$level=1;
	        	$where['pid'] = $uid;
	        }

	        $nickname = pdo_getcolumn('hcface_users',array('uid'=>$uid),array('nickname'));

	        $list = pdo_getslice('hcface_nexus',$where,array($pageindex, $pagesize),$total,array('uid','ctime'),'','ctime desc');
	        foreach ($list as $key => $val) {
	            $list[$key]['user'] = pdo_get('hcface_users',array('uid'=>$val['uid']));
	        }
	        // echo "<pre>";pdo_debug();die;
	        $page = pagination($total, $pageindex, $pagesize);
			include $this->template('web/team');
		}elseif($_GPC['act']=='commission'){
			$uid  = $_GPC['uid'];
	        $level = $_GPC['level'];
	        if(empty($level)){
	        	$level = 1;
	        }
	        $p = $_GPC['p'];
	        $l = $_GPC['l'];
	        $k = $_GPC['k'];
	        $pageindex = max(1, intval($_GPC['page']));
	        $pagesize = 10;
	        $nickname = pdo_getcolumn('hcface_users',array('uid'=>$uid),array('nickname'));
	        $list = pdo_getslice('hcface_commission',array('user_id'=>$uid,'sort'=>$level),array($pageindex, $pagesize),$total,array(),'','createtime desc');
	        foreach ($list as $key => $val) {
	            $list[$key]['user'] = pdo_get('hcface_users',array('uid'=>$val['sub_id']));
	        }
	        //echo "<pre>";print_r($list);
	        $page = pagination($total, $pageindex, $pagesize);
	        include $this->template('web/commission');
		}else{
			$info = pdo_get('hcface_users',array('uid'=>$_GPC['uid']));

	        $fenxiao = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'fenxiao'.$weid),array('value')),'true');
	        //echo "<pre>";print_r($fenxiao['grade']);
	        foreach ($fenxiao['grade'] as $key => $val) {
	        	$fx[$key]['id'] = $key+1;
	        	$fx[$key]['name'] = $val['grade'];
	        }
			include $this->template('web/users_post');
		}
	}
	/**
	 * 商品管理
	 * @return [type] [description]
	 */
	public function doWebGoods() {
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 20;
        $keyword = $_GPC['keyword'];
        if(!empty($keyword)){
        	$where['title like'] = '%'.$keyword.'%';
        }
        $where['weid'] = $weid;
        $list = pdo_getslice('hcface_goods',$where,array($pageindex, $pagesize),$total,array(),'','id desc');

        foreach ($list as $key => $val) {
        	$list[$key]['thumb'] = tomedia($val['thumb']);
        }
        $page = pagination($total, $pageindex, $pagesize);
		include $this->template('web/goods');
	}
	/**
	 * 商品操作
	 * @return [type] [description]
	 */
	public function doWebGoods_post(){
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		if($_GPC['act']=='add'){
			$data = array(
				'weid'  => $weid,
				'title' => $_GPC['title'],
				'ctitle'=> $_GPC['ctitle'],
				'desc'  => $_GPC['desc'],
				'sub'   => json_encode(explode("\r\n", trim($_GPC['sub']))),
				'price' => $_GPC['price'],
				'oprice' => $_GPC['oprice'],
				'discount' => $_GPC['discount'],
				'thumb' => $_GPC['thumb'],
				'sales' => $_GPC['sales']
			);
			//echo "<pre>";print_r($data);die;
			pdo_insert('hcface_goods',$data);
			message('操作成功',$this->createWebUrl('goods'),'success');
		}elseif($_GPC['act']=='edit'){
			$data = array(
				'weid'  => $weid,
				'title' => $_GPC['title'],
				'ctitle'=> $_GPC['ctitle'],
				'desc'  => $_GPC['desc'],
				'sub'   => json_encode(explode("\r\n", trim($_GPC['sub']))),
				'price' => $_GPC['price'],
				'oprice' => $_GPC['oprice'],
				'discount' => $_GPC['discount'],
				'thumb' => $_GPC['thumb'],
				'sales' => $_GPC['sales']
			);
			pdo_update('hcface_goods',$data,array('id'=>$_GPC['id']));
			message('操作成功',$this->createWebUrl('goods'),'success');
		}elseif($_GPC['act']=='init'){
			$data = array(
				array(
					'weid' => $weid,
					'title'=>'鼻相解读',
					'price'=> 2,
					'type' => 'bz'
				),
				array(
					'weid' => $weid,
					'title'=>'事业运程报告',
					'ctitle'=>'面相上看#name#的事业运和财运怎么样？是否适合创业？应该选择哪一类工作？',
					'desc' => '&lt;p&gt;事业是好是坏全部隐藏在额头里，能否永远屹立不倒财运亨通则看鼻子，对工作的持续性和精力还看嘴唇&lt;/p&gt;&lt;p&gt;…&lt;/p&gt;&lt;p&gt;面相上看你的事业运和财运怎么样？是否适合创业？应该选择哪一类工作？面相可以告诉你！&lt;/p&gt;',
					'sub'  => '["\u4e8b\u4e1a\u8fd0\u7a0b\u603b\u8ff0","\u4e8b\u4e1a\u53d8\u52a8\u5e74\u7eaa","\u4e8b\u4e1a\u62e9\u4e1a\u5efa\u8bae"]',
					'price'=> 19.8,
					'oprice'=> 39.8,
					'discount'=> 20,
					'sales'=> '12301',
					'type' => 'sy'
				),
				array(
					'weid' => $weid,
					'title'=>'情感运程报告',
					'ctitle'=>'眉眼、嘴巴都隐藏着一个人的爱情密码。什么时候能遇上正缘？与伴侣能不能相伴永久？面相可以告诉你 …',
					'desc' => '&lt;p&gt;眉眼、嘴巴都隐藏着一个人的爱情密码。什么时候能遇上正缘？与伴侣能不能相伴永久？面相可以告诉你…&lt;/p&gt;',
					'sub'  => '["\u611f\u60c5\u8fd0\u7a0b\u603b\u8ff0","\u60c5\u611f\u53d8\u52a8\u5e74\u7eaa","\u9002\u5408\u53e6\u4e00\u534a\u63cf\u8ff0"]',
					'price'=> 19.8,
					'oprice'=> 39.8,
					'discount'=> 20,
					'sales'=> '18532',
					'type' => 'qg'
				)
			);
			foreach ($data as $key => $val) {
				pdo_insert('hcface_goods',$val);
			}
			message('操作成功',$this->createWebUrl('goods'),'success');
		}elseif($_GPC['act']=='init1'){
			$data = array(
				array(
					'weid' => $weid,
					'title'=>'生命线解读',
					'ctitle'=>'生命线透漏着我们生命品质的好坏和生命活力的有无。',
					'price'=> 19.8,
					'oprice'=> 39.8,
					'discount'=> 20,
					'sales'=> '18515',
					'type' => 'sm'
				),
				array(
					'weid' => $weid,
					'title'=>'一生运势',
					'ctitle'=>'中指为五指中心，象征着命运之厚薄，暗藏一生运势。',
					'price'=> 19.8,
					'oprice'=> 39.8,
					'discount'=> 20,
					'sales'=> '16538',
					'type' => 'ys'
				)
			);
			foreach ($data as $key => $val) {
				pdo_insert('hcface_goods',$val);
			}
			message('操作成功',$this->createWebUrl('goods'),'success');
		}elseif($_GPC['act']=='del'){
			pdo_delete('hcface_goods',array('id'=>$_GPC['id']));
			message('操作成功',$this->createWebUrl('goods'),'success');
		}elseif($_GPC['act']=='moredel'){
			foreach(explode(',',$_GPC['ids']) as $key=>$val){
				pdo_delete('hcface_goods',array('id'=>$val));
			}
			message('操作成功',$this->createWebUrl('goods'),'success');
		}else{
			if(!empty($_GPC['id'])){
				$info = pdo_get('hcface_goods',array('id'=>$_GPC['id']));
				if(!empty($info['sub'])){
					$subs = json_decode($info['sub'],true);
					foreach ($subs as $key => $val) {
						if($key==count($subs)-1){
							$sub .= $val;
						}else{
							$sub .= $val."\n";
						}
					}
					$info['sub'] = $sub;
				}
			}
			include $this->template('web/goods_post');
		}
	}
		/**
	 * 解锁记录
	 * @return [type] [description]
	 */
	public function doWebOrder() {
		global $_GPC, $_W;
		$weid = $_W['uniacid'];

		$keywordtype = $_GPC['keywordtype'];
		$keyword  = $_GPC['keyword'];
		if(!empty($keyword)){
			$where['uid'] = pdo_getcolumn('hcface_users',array('nickname like'=>'%'.$keyword.'%'),array('uid'));
		}

		$status   = $_GPC['status'];
		if($status==1){
			$where['status'] = 1;
		}elseif($status==2){
			$where['status'] = 0;
		}
        $where['weid'] = $weid;


		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 20;
    
        $list = pdo_getslice('hcface_order',$where,array($pageindex, $pagesize),$total,array(),'','createtime desc');

        foreach ($list as $key => $val) {
        	$user = pdo_get('hcface_users',array('uid'=>$val['uid']),array('avatar','nickname'));
        	$list[$key]['avatar'] = $user['avatar'];
        	$list[$key]['nickname'] = $user['nickname'];
        	unset($user);
        	$goods = pdo_get('hcface_goods',array('id'=>$val['gid']));
        	$list[$key]['goodsthumb'] = tomedia($goods['thumb']);
        	$list[$key]['model'] = $goods['model'];
        	unset($goods);
        }
        $page = pagination($total, $pageindex, $pagesize);

        $today = pdo_getcolumn('hcface_order',array('status'=>1,'weid'=>$weid,'createtime >'=>strtotime(date('Ymd'))),array('SUM(money)'));
        $today = empty($today)?0:$today;
        $all   = pdo_getcolumn('hcface_order',array('status'=>1,'weid'=>$weid),array('SUM(money)'));
        $all = empty($all)?0:$all;
		include $this->template('web/order');
	}


		/**
	 * 升级列表
	 * @return [type] [description]
	 */
	public function doWebUpgrade() {
		global $_GPC, $_W;
		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $weid = $_W['uniacid'];
        $where['weid'] = $weid;
        $list = pdo_getslice('hcface_upgrade',$where,array($pageindex, $pagesize),$total,array(),'','createtime desc');
        foreach ($list as $key => $val) {
        	$user = pdo_get('hcface_users',array('uid'=>$val['uid']),array('avatar','nickname'));
        	$list[$key]['avatar'] = $user['avatar'];
        	$list[$key]['nickname'] = $user['nickname'];
        	unset($user);
        }

        $page = pagination($total, $pageindex, $pagesize);

        $today = pdo_getcolumn('hcface_upgrade',array('status'=>1,'weid'=>$weid,'createtime >'=>strtotime(date('Ymd'))),array('SUM(price)'));
		$today = empty($today)?0:$today;
        $all   = pdo_getcolumn('hcface_upgrade',array('status'=>1,'weid'=>$weid),array('SUM(price)'));
        $all = empty($all)?0:$all;

		include $this->template('web/upgrade');
	}
	/**
	 * 提现审核列表
	 * @return [type] [description]
	 */
	public function doWebCash() {
		global $_GPC, $_W;
		$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 10;
        $weid = $_W['uniacid'];
        $where['weid'] = $weid;
        $list = pdo_getslice('hcface_cash',$where,array($pageindex, $pagesize),$total,array(),'','createtime desc');
        foreach ($list as $key => $val) {
        	$user = pdo_get('hcface_users',array('uid'=>$val['uid']),array('avatar','nickname','receipt_code'));
        	$list[$key]['avatar'] = $user['avatar'];
        	$list[$key]['nickname'] = $user['nickname'];
        	$list[$key]['receipt_code'] = $user['receipt_code'];
        	unset($user);
        }

        $page = pagination($total, $pageindex, $pagesize);

		$wait = pdo_getcolumn('hcface_commission',array('weid'=>$weid,'status'=>0,'freeze'=>0),array('SUM(profit)'));
		$wait = empty($wait)?0:$wait;
		$send = pdo_getcolumn('hcface_cash',array('weid'=>$weid,'status'=>0),array('SUM(money)-SUM(fee)'));
		$send = empty($send)?0:$send;
		$alr = pdo_getcolumn('hcface_cash',array('weid'=>$weid,'status'=>1),array('SUM(money)-SUM(fee)'));
		$alr = empty($alr)?0:$alr;

		include $this->template('web/cash');
	}
	/**
	 * 系统审核提现
	 * @return [type] [description]
	 */
	public function doWebSyscash(){
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		$id = $_GPC['id'];
		$type = $_GPC['type'];

		
		$cash = pdo_get('hcface_cash',array('id'=>$id));
        $uid = $cash['uid'];
		$where = array(
            'user_id'=>$uid,
            'status'=>0,
            'freeze'=>1,
        );
		if($type==1){
	        
	        $openid = pdo_getcolumn('hcface_users',array('uid'=>$uid),array('openid'));

	        $conf = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'basic'.$weid),array('value')),'true');
	        $money = $cash['money']-$cash['fee'];
	        $res = $this->cash($openid,$money,$cash['transid'],$conf['title']);
	        if($res['result_code'] == 'FAIL'){
	            message($res['err_code_des'],'','error');
	        }else{
	            pdo_update('hcface_cash',array('status'=>1),array('id'=>$id));
                pdo_update('hcface_commission',array('freeze'=>0,'status'=>1),$where);
	            message('提现成功','','success');
	        }
	    }elseif($type==2){
	    	pdo_update('hcface_cash',array('status'=>2),array('id'=>$id));
	    	pdo_update('hcface_commission',array('freeze'=>0),$where);
	    	message('拒绝成功','','success');
	    }elseif($type==3){
	    	pdo_update('hcface_cash',array('status'=>1),array('id'=>$id));
	    	pdo_update('hcface_commission',array('freeze'=>0,'status'=>1),$where);
	    	message('发放成功','','success');
	    }
	}
	public function doWebCash_detail(){
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
    	$pageindex = max(1, intval($_GPC['page']));
        $pagesize = 20;
        $where['weid'] = $weid;
        $where['status'] = 0;
        $where['freeze'] = 0;
        $list = pdo_getslice('hcface_commission',$where,array($pageindex, $pagesize),$total,array(),'','createtime desc');
        foreach ($list as $key => $val) {
        	$user = pdo_get('hcface_users',array('uid'=>$val['user_id']),array('avatar','nickname'));
        	$list[$key]['avatar'] = $user['avatar'];
        	$list[$key]['nickname'] = $user['nickname'];
        	unset($user);
        }
        $page = pagination($total, $pageindex, $pagesize);

		include $this->template('web/cash_detail');   
	}


	public function cash($openid,$money,$transid,$wxappname){
        global $_W;
        $weid = $_W['uniacid'];
        load()->model('payment');
        load()->model('account');
        $setting = uni_setting($_W['uniacid'], array('payment'));
        $mch_appid = $_W['account']['key'];
        $signkey = $setting['payment']['wechat']['signkey'];
        $mchid  = $setting['payment']['wechat']['mchid'];
        $model = new HcfkModel();
        $pars = array();
        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $pars['mch_appid'] = $mch_appid;
        $pars['mchid'] = $mchid;
        $pars['nonce_str'] = random(32);
        $pars['partner_trade_no'] = $transid;
        $pars['openid'] = $openid;
        $pars['check_name'] = 'NO_CHECK';
        $pars['amount'] = intval($money * 100);
        $pars['desc'] = $wxappname."余额提现";
        $pars['spbill_create_ip'] = $model->get_client_ip();
        $pars['sign'] = $model->getSign($pars,$signkey);
        $xml = $model->array2xml($pars);
        $cert = array(
            'CURLOPT_SSLCERT' => IA_ROOT ."/addons/hc_face/cert/apiclient_cert_".$weid.".pem",
            'CURLOPT_SSLKEY'  => IA_ROOT ."/addons/hc_face/cert/apiclient_key_".$weid.".pem",
        );
        $resp = ihttp_request($url, $xml, $cert);
        return $model->xmlstr_to_array($resp['content']);
    }


	public function getMobileUrl($p1='',$p2='',$p3=''){
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		
		$defend = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'defend'.$weid),array('value')),true);
		if($defend['switch']){
			if(is_array($p2)){
				$pars = '';
				foreach ($p2 as $k => $v) {
					$pars .= '&'.$k.'='.$v;
				}
			}
			
			$url = "./{$defend['entry']}{$_W['uniacid']}.php?{$defend['unique']}={$_W['uniacid']}&{$defend['action']}={$p1}{$pars}";
		}else{
			if(empty($p2)&&empty($p3))
				$url = $this->createMobileUrl($p1);
			elseif(!empty($p2)&&empty($p3))
				$url = $this->createMobileUrl($p1,$p2);
			else
				$url = $this->createMobileUrl($p1,$p2,$p3);
		}
		return $url;
	}
	public function doWebClearRepeatCommissionLog() {
		
		global $_GPC, $_W;
		$weid = $_W['uniacid'];
		$list = pdo_fetchall('SELECT * FROM ims_hcface_commission WHERE 1=1 group by user_id,sub_id,trade_no having count(*)>1',array());
		foreach ($list as $key => $val) {
			$list1 = pdo_getall('hcface_commission',array('user_id'=>$val['user_id'],'sub_id'=>$val['sub_id'],'trade_no'=>$val['trade_no']));
			foreach ($list1 as $k => $v) {
				if($k>=1){
					pdo_delete('hcface_commission',array('id'=>$v['id']));
				}
			}
			unset($list1);
		}
		
		echo 'clear repeat data success';
	}
}