<?php

class Attr
{
	function __construct($pid){
		$this->pid = $pid;
	}
	
	public function share(){
		global $_GPC, $_W;
		$forward = json_decode(pdo_getcolumn('hcface_setting',array('only'=>'forward'.$_W['uniacid']),array('value')),'true');
		$forward['img']= tomedia($forward['img']);
		$forward['link'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&pid='.$_GPC['uid'];
		return $forward;
	}
}