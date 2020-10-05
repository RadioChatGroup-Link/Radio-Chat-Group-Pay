<?php
$is_defend=true;
require '../shepay/common.php';
@header('Content-Type: text/html; charset=UTF-8');
$trade_no=daddslashes($_GET['trade_no']);
$sitename=base64_decode(daddslashes($_GET['sitename']));
$row=$DB->query("SELECT * FROM pay_order WHERE trade_no='{$trade_no}' limit 1")->fetch();
if(!$row)sysmsg('该订单号不存在，请返回来源地重新发起请求！');
if($conf['web_is']==2)sysmsg($conf['web_offtext']);
if($conf['pay_is']==1)sysmsg($conf['pay_offtext']);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="pay.m6e6.cn,<?php echo $conf['web_name']?>,都潮汇-会支付会生活" name="description"/>
    <meta name="author" content="m6e6.cn" />
    <title><?php echo $conf['syt_name']?> | 收银台</title>
    <link href="//shepay.ayunx.com/user/css/app.min.css" rel="stylesheet" type="text/css">
</head>
<body class="authentication-bg">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <span><font color="white" size="5"><b><?php echo $conf['syt_name']?></b></font></span>
                        </div>
                        <div class="card-body">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">请选择一种支付方式完成支付￥<?php echo $row['money']?>元</h4>
                            </div>
                            <div class="form-group mb-3">
                                    <label>这里是收银台哦~</label>
                                    <input class="form-control" type="text" value="商品名称：<?php echo $row['name']?>" disabled="">
                                    <input class="form-control" type="text" value="创建时间：<?php echo $row['addtime']?>" disabled="">
                                    <input class="form-control" type="text" value="交易订单号：<?php echo $row['trade_no']?>" disabled="">
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked required>
                                        <label class="custom-control-label" for="checkbox-signin">确认订单信息无误，开始支付</a></label>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <a href="/submit2.php?type=alipay&trade_no=<?php echo $trade_no?>"><button class="btn btn-primary"><img src="//shepay.ayunx.com/assets/icon/alipay.ico" width="25px">支付宝</button></a> <a href="/submit2.php?type=qqpay&trade_no=<?php echo $trade_no?>"><button class="btn btn-primary"><img src="//shepay.ayunx.com/assets/icon/qqpay.ico" width="25px">QQ钱包</button></a><br/><br/><a href="/submit2.php?type=wxpay&trade_no=<?php echo $trade_no?>"><button class="btn btn-primary"><img src="//shepay.ayunx.com/assets/icon/wechat.ico" width="25px">微信支付</button></a> <a href="/submit2.php?type=tenpay&trade_no=<?php echo $trade_no?>"><button class="btn btn-primary"><img src="//shepay.ayunx.com/assets/icon/tenpay.ico" width="25px">财付通</button></a>
                                </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <footer class="footer footer-alt" style="text-transform: uppercase;">
        Copyright &copy; 2016-<?=date('Y')?>
    </footer>
    <!-- App js -->
    <script src="//shepay.ayunx.com/admin/js/app.min.js"></script>
</body>
</html>