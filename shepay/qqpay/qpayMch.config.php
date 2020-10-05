<?php
/**
* 	都潮汇系统QQ官方接口配置文件
*/
include_once '../common.php';
define('SHQQ_ID',$conf['gfjk_qpay_mchid']);
define('SHQQ_KEY',$conf['gfjk_qpay_mchkey']);
class QpayMchConf
{
	const MCH_ID = SHQQ_ID;
	const MCH_KEY = SHQQ_KEY;
}