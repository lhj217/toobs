<?php
 goto fOezt; R8BnA: UcQk_: goto WCT8O; wy4JD: pdo_update("\150\143\x66\x61\143\145\x5f\162\x65\160\157\162\x74", array("\x75\x6e\x6c\x6f\143\153" => 1), array("\151\x64" => $rid)); goto bjXoK; II7Vx: $account->account(); goto m4bXW; mcG45: $uid = $_COOKIE["\x75\151\x64"]; goto pjG2x; fJMgp: $uid = pdo_getcolumn("\150\x63\x66\141\143\145\x5f\x75\x73\x65\162\163", array("\157\x70\145\156\x69\x64" => $_W["\157\x70\x65\156\x69\x64"]), array("\x75\151\x64")); goto lniqp; EKd41: goto UcQk_; goto sJbCT; rvTqL: if (!empty($rid)) { goto kCn8H; } goto jS_FF; m4bXW: $forward = $account->share(); goto A0pPb; hHlVH: $weid = $_W["\x75\156\x69\141\143\151\144"]; goto mcG45; lniqp: lbV1b: goto TlwnU; bjXoK: $url = $_W["\x73\x69\x74\x65\163\143\150\x65\x6d\145"] . $_SERVER["\x48\124\x54\120\137\110\117\x53\x54"] . "\57\x61\160\160\x2f\x69\156\144\x65\170\56\160\150\x70\77\x69\75" . $weid . "\x26\143\75\x65\156\164\162\x79\46\x72\151\144\x3d" . $rid . "\46\x64\x6f\75\x72\145\x70\x6f\162\x74\46\155\x3d\150\x63\137\146\x61\x63\x65"; goto R8BnA; aaIYJ: global $_GPC, $_W; goto hHlVH; fOezt: defined("\111\x4e\137\111\x41") or exit("\x41\143\143\x65\x73\163\40\104\x65\x6e\x69\x65\144"); goto vR4u6; vR4u6: require_once IA_ROOT . "\57\x61\x64\x64\157\x6e\163\x2f\x68\x63\x5f\146\141\143\145\57\151\156\x63\x2f\155\157\144\145\154\57\141\x63\x63\157\x75\156\164\x2e\160\x68\x70"; goto aaIYJ; jS_FF: $url = $_W["\163\151\x74\x65\x73\x63\x68\x65\x6d\x65"] . $_SERVER["\x48\x54\124\120\137\x48\x4f\x53\x54"] . "\57\x61\x70\160\57\x69\x6e\144\145\x78\56\160\150\x70\77\x69\x3d" . $weid . "\46\x63\75\x65\156\164\x72\171\x26\x64\157\x3d\151\x6e\144\x65\170\46\x6d\x3d\x68\x63\137\146\x61\143\x65"; goto EKd41; WiH_t: $account->redirect(); goto II7Vx; sJbCT: kCn8H: goto wy4JD; XA0p5: $account = new Account($pid); goto WiH_t; pjG2x: if ($uid) { goto lbV1b; } goto fJMgp; TlwnU: $pid = empty($_GPC["\160\151\x64"]) ? 0 : trim($_GPC["\160\x69\x64"]); goto XA0p5; A0pPb: $rid = pdo_getcolumn("\150\143\146\x61\x63\145\137\x72\x65\x70\x6f\162\164", array("\x75\151\144" => $uid, "\156\141\155\145\x20\41\x3d" => ''), array("\155\x69\156\50\151\144\51")); goto rvTqL; WCT8O: header("\114\157\143\141\164\x69\x6f\156\72\x20" . $url);