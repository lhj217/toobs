<?php
 goto gNWll; bjdno: include $this->template("\x61\x70\160\x65\x61\154\x2f\x6c\x69\x73\x74"); goto HYBXS; HYBXS: die; goto Jq31s; kd_Ek: $pid = empty($_GPC["\x70\151\x64"]) ? 0 : trim($_GPC["\x70\151\x64"]); goto hDRdS; hiDgf: $uid = $_COOKIE["\165\151\x64"]; goto kd_Ek; sxqFt: $hand = pdo_getcolumn("\150\143\x66\x61\x63\145\137\150\x61\156\x64\x5f\162\145\160\x6f\162\x74", array("\165\x69\x64" => $uid, "\165\156\154\157\143\153" => 1, "\x6e\141\155\x65\x20\x21\x3d" => '', "\151\163\144\x65\x6c\x65\x74\145\x20\x21\75" => 1), array("\x63\x6f\165\156\x74\x28\x69\144\51")); goto fm0KL; ZNEXE: $account->account(); goto ro6BH; gNWll: defined("\x49\116\x5f\111\101") or exit("\101\143\143\x65\163\x73\40\x44\x65\x6e\x69\145\x64"); goto C20kq; X24Ti: $weid = $_W["\x75\x6e\x69\x61\143\151\144"]; goto hiDgf; ACDeF: $account->redirect(); goto ZNEXE; C20kq: require_once IA_ROOT . "\57\x61\x64\144\x6f\x6e\163\57\150\143\x5f\x66\x61\x63\145\57\151\156\143\57\x6d\157\144\x65\154\57\x61\x63\143\x6f\x75\x6e\164\x2e\160\150\x70"; goto nDOsd; b4amg: if (!$account->unseal()) { goto WWTaD; } goto bjdno; hDRdS: $account = new Account($pid); goto ACDeF; n0XW0: $basic = json_decode(pdo_getcolumn("\150\143\x66\x61\x63\x65\137\163\145\x74\x74\151\x6e\x67", array("\x6f\x6e\x6c\171" => "\142\x61\x73\x69\x63" . $weid), array("\166\x61\x6c\165\x65")), "\164\162\x75\x65"); goto OK9RS; Jq31s: WWTaD: goto n0XW0; KMLmk: $count = pdo_getcolumn("\150\x63\x66\x61\143\x65\137\x72\145\x70\157\162\164", array("\165\151\x64" => $uid, "\x75\x6e\154\x6f\143\153" => 1, "\x6e\141\x6d\145\x20\41\75" => '', "\x69\163\x64\145\154\145\164\145\40\x21\75" => 1), array("\x63\157\x75\x6e\164\x28\x69\x64\51")); goto sxqFt; OK9RS: $rid = pdo_getcolumn("\150\143\146\x61\143\x65\137\162\145\x70\157\162\164", array("\165\151\x64" => $uid, "\x75\x6e\154\x6f\x63\153" => 1, "\x6e\x61\155\x65\40\41\75" => '', "\x69\x73\x64\x65\x6c\145\164\145\x20\41\x3d" => 1), array("\x6d\x69\156\x28\151\144\x29")); goto KMLmk; nDOsd: global $_GPC, $_W; goto X24Ti; ro6BH: $forward = $account->share(); goto b4amg; fm0KL: include $this->template("\155\171");