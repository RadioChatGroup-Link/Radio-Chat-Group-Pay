<?php
$mod='blank';
include("../shepay/common.php");
$title='后台地址修改';
include './shepay_head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
exit("<script language='javascript'>alert('都潮汇系统V8.3.0版本后，请勿修改后台路径，否则后果自负！');history.go(-1);</script>");