<?php
/**
* 	都潮汇系统微信官方接口配置文件
*/
include_once '../common.php';
define('SHWX_ID',$conf['gfjk_wxpay_appid']);
define('SHWX_PID',$conf['gfjk_wxpay_mchid']);
define('SHWX_KEY',$conf['gfjk_wxpay_key']);
define('SHWX_APP',$conf['gfjk_wxpay_appsecret']);
class WxPayConfig
{
	const APPID = SHWX_ID;
	const MCHID = SHWX_PID;
	const KEY = SHWX_KEY;
	const APPSECRET = SHWX_APP;
	const CURL_PROXY_HOST = "0.0.0.0";//"10.152.18.220";
	const CURL_PROXY_PORT = 0;//8080;
	const REPORT_LEVENL = 1;
}