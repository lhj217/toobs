<?php
 goto lUmNT; ZN8HP: $face = pdo_getcolumn("\x68\143\x66\x61\143\x65\x5f\x72\x65\x70\157\162\x74", array("\x75\151\x64" => $uid, "\x75\156\154\x6f\x63\153" => 1), array("\x63\x6f\x75\156\164\50\151\x64\x29")); goto l4bLh; l4bLh: $num = $hand + $face; goto nq0_b; GkzIr: $uid = $_COOKIE["\x75\151\144"]; goto PotYq; sFsOQ: require_once IA_ROOT . "\x2f\141\144\144\x6f\x6e\163\57\150\x63\137\x66\x61\143\x65\57\x69\x6e\x63\57\155\x6f\x64\x65\154\57\141\x63\143\157\165\156\x74\x2e\x70\150\160"; goto Zff0K; nq0_b: $lock = json_decode(pdo_getcolumn("\x68\143\x66\x61\x63\x65\137\x73\x65\164\164\x69\x6e\x67", array("\x6f\x6e\154\171" => "\154\x6f\x63\x6b" . $weid), array("\166\x61\154\x75\145")), "\164\x72\165\x65"); goto m0Xgv; zxmmZ: $account_api = WeAccount::create(); goto Xu4ko; lUmNT: defined("\111\x4e\x5f\x49\101") or exit("\101\143\x63\145\163\163\x20\x44\x65\156\x69\145\144"); goto sFsOQ; i9xLY: if (!($lock[app] == 1 && strpos($_SERVER["\110\124\124\120\137\125\123\x45\x52\137\101\x47\105\116\124"], "\x4d\x69\x63\162\x6f\115\x65\163\163\145\x6e\147\145\162") !== false)) { goto rGsn_; } goto zxmmZ; vJCJV: if (!($subscribe == 0 && $num == 0)) { goto cL6c2; } goto mzxs9; Wt9KY: $openid = $_COOKIE["\x6f\x70\x65\156\x69\x64"]; goto Ndac7; QzsYd: rGsn_: goto NO6xa; x7iwq: $url = "\x68\x74\164\x70\163\72\x2f\57\141\x70\x69\56\x77\145\151\170\151\x6e\56\161\161\x2e\143\x6f\155\57\x63\147\151\x2d\142\x69\x6e\x2f\165\163\145\x72\x2f\x69\x6e\146\157\x3f\141\143\x63\x65\x73\163\x5f\x74\x6f\153\145\x6e\75" . $access_token . "\x26\157\x70\x65\x6e\x69\144\75" . $openid . "\x26\x6c\x61\156\147\75\172\x68\x5f\x43\116"; goto Fk0al; mzxs9: $wxapp = 1; goto t5OxW; Zff0K: global $_GPC, $_W; goto wNcP6; wNcP6: $weid = $_W["\x75\156\151\141\x63\x69\144"]; goto GkzIr; xMA0P: $subscribe = $res["\163\x75\142\x73\x63\162\x69\x62\x65"]; goto vJCJV; PotYq: $pid = empty($_GPC["\160\x69\x64"]) ? 0 : trim($_GPC["\x70\x69\x64"]); goto tH32c; Aa11n: $account->account(); goto Kkm6b; hiQ5H: Yww7F: goto Wt9KY; tH32c: $account = new Account($pid); goto xNg9z; Xu4ko: $access_token = $account_api->getAccessToken(); goto x7iwq; yHD6j: die; goto hiQ5H; Ndac7: $pay = json_decode(pdo_getcolumn("\150\x63\x66\x61\x63\145\137\x73\x65\164\x74\x69\x6e\147", array("\x6f\x6e\x6c\171" => "\160\x61\x79" . $weid), array("\x76\141\154\165\x65")), "\164\162\x75\x65"); goto pnhqs; Fk0al: $res = ihttp_get($url); goto VWOF3; m0Xgv: $lock["\x71\x72\x63\157\x64\x65"] = tomedia($lock["\161\x72\x63\x6f\x64\x65"]); goto i9xLY; gOlCl: include $this->template("\141\x70\x70\x65\141\154\x2f\154\151\x73\x74"); goto yHD6j; VWOF3: $res = json_decode($res["\143\x6f\156\x74\145\156\164"], true); goto xMA0P; pnhqs: $hand = pdo_getcolumn("\150\x63\146\141\143\145\x5f\x68\141\156\144\x5f\162\145\x70\x6f\162\164", array("\165\151\144" => $uid, "\165\x6e\x6c\157\143\x6b" => 1), array("\143\x6f\165\156\x74\x28\x69\x64\51")); goto ZN8HP; xNg9z: $account->redirect(); goto Aa11n; YsGuh: if (!$account->unseal()) { goto Yww7F; } goto gOlCl; Kkm6b: $forward = $account->share(); goto YsGuh; t5OxW: cL6c2: goto QzsYd; NO6xa: include $this->template("\x75\160\x6c\157\141\144");