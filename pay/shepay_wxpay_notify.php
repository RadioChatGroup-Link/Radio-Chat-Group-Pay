<?php 
require_once('../shepay/common.php');
require_once(SYSTEM_ROOT."epay/yzf_wxpay.php");
require_once(SYSTEM_ROOT."epay/epay_notify.class.php");
//����ó�֪ͨ��֤���
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();
if($verify_result) {//��֤�ɹ�
	//�̻�������
	$out_trade_no = $_GET['out_trade_no'];
	//֧�������׺�
	$trade_no = $_GET['trade_no'];
	//����״̬
	$trade_status = $_GET['trade_status'];
    if ($_GET['trade_status'] == 'TRADE_SUCCESS' && $srow['status']==0) {
		//������ɺ�֧����ϵͳ���͸ý���״̬֪ͨ
		$srow=$DB->query("SELECT * FROM pay_order WHERE trade_no='{$out_trade_no}' limit 1")->fetch();
		if($srow['status']==0){
			$DB->query("update `pay_order` set `status` ='1',`endtime` ='$date' where `trade_no`='$out_trade_no'");
			$addmoney=round($srow['money']*$conf['money_rate']/100,2);
			$DB->query("update pay_user set money=money+{$addmoney} where id='{$srow['pid']}'");
			$url=creat_callback($srow);
			curl_get($url['notify']);
			proxy_get($url['notify']);
		}
    }
	echo "success";
}
else {
    //��֤ʧ��
    echo "fail";
}
?>