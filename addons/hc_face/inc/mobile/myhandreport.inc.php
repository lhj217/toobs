<?php
 goto BW1lP; tq5s1: GvCye: goto hBvhF; EdM6H: AnnPs: goto yARE0; KxAMp: if (!$account->unseal()) { goto SS74m; } goto x69BS; yARE0: $id = $_GPC["\151\x64"]; goto WhHk1; HD3DJ: $account->account(); goto KxAMp; C2YSX: $weid = $_W["\x75\156\x69\x61\143\x69\144"]; goto a2LYc; xWBTQ: foreach ($list as $key => $val) { $list[$key]["\141\166\141\164\141\x72"] = $_W["\x73\x69\164\x65\162\x6f\157\164"] . pdo_getcolumn("\150\x63\146\x61\x63\145\x5f\x61\x76\x61\164\x61\x72", array("\x69\x64" => $val["\141\x69\144"]), array("\141\166\141\164\x61\x72")); qdkmF: } goto tq5s1; hBvhF: include $this->template("\x6d\171\150\x61\156\x64\x72\x65\160\157\x72\164"); goto RCFIl; WhHk1: pdo_update("\x68\x63\146\141\143\x65\x5f\150\x61\x6e\x64\x5f\x72\145\160\x6f\162\x74", array("\151\x73\x64\x65\x6c\x65\164\x65" => 1), array("\x69\x64" => $id)); goto g7Ix0; IE5MW: $list = pdo_getall("\150\x63\x66\x61\x63\x65\137\150\141\156\144\137\162\145\x70\x6f\x72\164", array("\x75\151\x64" => $uid, "\x75\x6e\x6c\157\x63\153" => 1, "\x6e\x61\155\x65\40\41\x3d" => '', "\x69\x73\x64\145\x6c\x65\x74\145\40\41\x3d" => 1), array("\x69\144", "\x61\x69\x64", "\x6e\141\155\x65"), "\143\x72\x65\x61\x74\x65\x74\x69\x6d\x65\40\x44\x45\x53\x43"); goto xWBTQ; foB9h: if ($_GPC["\141\x63\x74"] == "\144\x65\x6c") { goto AnnPs; } goto IE5MW; a2LYc: $uid = $_COOKIE["\165\151\x64"]; goto Q0xjI; BW1lP: defined("\x49\x4e\x5f\111\101") or exit("\x41\x63\143\145\x73\x73\40\104\x65\x6e\x69\x65\144"); goto kZVnK; oz1vI: $forward = $account->share(); goto foB9h; RCFIl: goto Dqcq2; goto EdM6H; Q0xjI: $pid = empty($_GPC["\160\x69\x64"]) ? 0 : trim($_GPC["\160\x69\x64"]); goto kmNCp; PzqAS: SS74m: goto oz1vI; xYM6N: die; goto PzqAS; kmNCp: $account = new Account($pid); goto R0xls; g7Ix0: exit(json_encode(array("\143\157\x64\x65" => 1, "\x6d\163\147" => "\xe5\x88\240\xe9\x99\244\xe6\210\x90\xe5\212\x9f"))); goto G9Fgm; kZVnK: require_once IA_ROOT . "\x2f\141\144\x64\x6f\x6e\163\57\150\x63\x5f\x66\x61\143\x65\x2f\x69\156\x63\x2f\155\x6f\144\145\154\x2f\141\143\143\157\x75\156\x74\56\160\x68\x70"; goto UuA6v; R0xls: $account->redirect(); goto HD3DJ; x69BS: include $this->template("\x61\160\x70\145\141\154\57\154\x69\x73\x74"); goto xYM6N; UuA6v: global $_GPC, $_W; goto C2YSX; G9Fgm: Dqcq2: