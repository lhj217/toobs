<?php 
defined("IN_IA") or exit("Access Denied");
require_once IA_ROOT . "/addons/hc_face/inc/model/account.php";
require_once IA_ROOT . "/addons/hc_face/core/phpqrcode/qrlib.php";
global $_GPC, $_W;
$pid = empty($_GPC["pid"]) ? 0 : trim($_GPC["pid"]);
$account = new Account($pid);
$account->redirect();
$account->account();
$forward = $account->share();
$weid = $_W["uniacid"];
$uid = $_COOKIE["uid"];
$rid = $_GPC["rid"];
$pay = json_decode(pdo_getcolumn("hcface_setting", array("only" => "pay" . $weid), array("value")), "true");
$basic = json_decode(pdo_getcolumn("hcface_setting", array("only" => "basic" . $weid), array("value")), "true");
$nav = json_decode(pdo_getcolumn("hcface_setting", array("only" => "nav" . $weid), array("value")), "true");
$report = pdo_get("hcface_report", array("id" => $rid));
$avatar = pdo_get("hcface_avatar", array("id" => $report["aid"]));
$loop = array("avatar" => $_W["siteroot"] . $avatar["avatar"], "name" => $report["name"], "face" => array("top" => json_decode($report["top"], true), "eyebrow" => json_decode($report["eyebrow"], true), "eye" => json_decode($report["eye"], true), "mouse" => json_decode($report["mouse"], true), "nose" => json_decode($report["nose"], true)), "summary" => $report["summary"], "score" => $report["score"], "score_detail" => json_decode($report["score_detail"], true), "eye" => array("eye" => json_decode($report["eye"], true), "desc" => $report["eye_desc"], "pos" => $avatar["eye"]), "mouse" => array("mouse" => json_decode($report["mouse"], true), "desc" => $report["mouse_desc"], "pos" => $avatar["mouse"]), "nose" => array("nose" => json_decode($report["nose"], true), "desc" => $report["nose_desc"], "pos" => $avatar["nose"]), "five" => array("five1" => $report["five1"], "rate1" => $report["five1_rate"], "five2" => $report["five2"], "rate2" => $report["five2_rate"], "desc" => $report["five_desc"]), "emotion" => $report["emotion"], "cause" => $report["cause"]);
$name = $report["name"];
$list = pdo_getall("hcface_goods", array("weid" => $weid), array(), '', "id ASC");
foreach ($list as $key => $val) {
    $list[$key]["ctitle"] = str_replace("#name#", $name, $val["ctitle"]);
    $list[$key]["thumb"] = tomedia($val["thumb"]);
}
$fenxiao = json_decode(pdo_getcolumn("hcface_setting", array("only" => "fenxiao" . $weid), array("value")), "true");
$defend = json_decode(pdo_getcolumn("hcface_setting", array("only" => "defend" . $weid), array("value")), true);
if (!empty($fenxiao["purl"])) {
    if ($defend["switch"]) {
        $url = $fenxiao["purl"] . "/app/{$defend["entry"]}{$_W["uniacid"]}.php?{$defend["unique"]}={$_W["uniacid"]}&{$defend["action"]}={$p1}&pid={$uid}";
    } else {
        $url = $fenxiao["purl"] . "/app/index.php?i=" . $_W["uniacid"] . "&c=entry&do=index&m=hc_face&pid=" . $uid;
    }
} else {
    if ($defend["switch"]) {
        $url = $_W["siteroot"] . "app/{$defend["entry"]}{$_W["uniacid"]}.php?{$defend["unique"]}={$_W["uniacid"]}&{$defend["action"]}={$p1}&pid={$uid}";
    } else {
        $url = $_W["siteroot"] . "app/index.php?i=" . $_W["uniacid"] . "&c=entry&do=index&m=hc_face&pid=" . $uid;
    }
}
$path = IA_ROOT . "/addons/hc_face/qrcode/" . $uid . ".png";
$dir = IA_ROOT . "/addons/hc_face/qrcode/";
if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}
if (empty($fenxiao["qr"])) {
    QRcode::png($url, $path);
} else {
    $account_api = WeAccount::create();
    $token = $account_api->getAccessToken();
    $url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=" . $token;
    $params = array("expire_seconds" => 604800, "action_name" => "QR_STR_SCENE", "action_info" => array("scene" => array("scene_str" => $uid)));
    $res = ihttp_post($url, json_encode($params));
    $con = json_decode($res['content'], true);
    file_put_contents($path, file_get_contents("https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . UrlEncode($con["ticket"])));
}
$qrcode = tomedia("/addons/hc_face/qrcode/" . $uid . ".png") . "?" . time();
 $this->template("report");
?>