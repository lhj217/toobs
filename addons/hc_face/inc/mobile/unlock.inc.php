<?php
 goto vIL2y; ZJeg0: include $this->template("\x61\160\x70\145\x61\x6c\x2f\154\151\x73\x74"); goto UK8MX; RJO6e: if (empty($info)) { goto UP08u; } goto whrDL; DUOOg: $account->account(); goto JFE3Q; PYQv1: $lock = json_decode(pdo_getcolumn("\150\143\146\141\x63\145\x5f\163\145\164\164\151\x6e\x67", array("\157\x6e\x6c\x79" => "\x6c\x6f\x63\x6b" . $weid), array("\x76\x61\154\x75\145")), "\x74\x72\165\145"); goto Sfj6V; Xrtq3: UP08u: goto bjYXs; MAvL1: $account->redirect(); goto DUOOg; UK8MX: die; goto ZbzLm; nLYDT: global $_GPC, $_W; goto fb3iY; fb3iY: $weid = $_W["\x75\156\x69\141\143\151\144"]; goto w88N1; JFE3Q: $forward = $account->share(); goto abnHG; lrdgV: $info["\144\145\163\x63"] = htmlspecialchars_decode($info["\144\145\x73\x63"]); goto Xrtq3; bw33z: $pay = json_decode(pdo_getcolumn("\x68\143\146\x61\143\145\137\163\x65\x74\164\151\x6e\147", array("\157\x6e\154\171" => "\160\141\171" . $weid), array("\x76\141\154\x75\145")), "\x74\x72\165\145"); goto PYQv1; vIL2y: defined("\x49\116\x5f\x49\101") or exit("\101\143\x63\145\x73\x73\40\104\145\x6e\151\x65\144"); goto ckcQY; ZbzLm: GxADQ: goto bw33z; abnHG: if (!$account->unseal()) { goto GxADQ; } goto ZJeg0; ckcQY: require_once IA_ROOT . "\57\141\144\x64\157\156\163\x2f\x68\x63\x5f\x66\x61\x63\x65\57\151\156\x63\57\x6d\157\x64\x65\154\57\x61\x63\x63\157\165\x6e\164\56\x70\x68\160"; goto nLYDT; w88N1: $type = $_GPC["\164\171\x70\x65"]; goto dVoyQ; dVoyQ: $rid = $_GPC["\162\x69\x64"]; goto eVUzS; whrDL: $info["\163\165\x62"] = json_decode($info["\x73\165\x62"], true); goto lrdgV; eVUzS: $pid = empty($_GPC["\x70\151\x64"]) ? 0 : trim($_GPC["\x70\x69\144"]); goto cTE0U; Sfj6V: $info = pdo_get("\x68\143\x66\141\x63\145\x5f\x67\x6f\157\x64\x73", array("\167\x65\x69\x64" => $weid, "\x74\x79\x70\x65" => $type)); goto RJO6e; cTE0U: $account = new Account($pid); goto MAvL1; bjYXs: include $this->template("\x75\156\154\x6f\x63\x6b");