<?php
$mod='blank';
include("../shepay/common.php");
if(!isset($_SESSION['authcode'])) {
	$query=file_get_contents('http://auth.ooeecc.cn/api/check.php?url='.$_SERVER['HTTP_HOST'].'&authcode='.$authcode);
	if($query=json_decode($query,true)) {
	if($query['code']==1)$_SESSION['authcode']=true;
	sysmsg($query['msg'],true);
	}
}
$title='官方支付接口配置';
include './shepay_head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
?>

<?php 
if(isset($_POST['submit'])) {
    foreach ($_POST as $x => $value) {
        if($x=='pwd')continue;
        $value=daddslashes($value);
        $DB->query("insert into admin set `x`='{$x}',`j`='{$value}' on duplicate key update `j`='{$value}'");
    }
    $pwd=daddslashes($_POST['pwd']);
    if(!empty($pwd))$DB->query("update `admin` set `j` ='{$pwd}' where `x`='admin_pwd'");
    showmsg('修改成功！',1);
    exit();
}
?>

<div class="card card-primary">	
			<div class="card-header"><h3 class="panel-title">官方接口配置</h3></div>
<div class="card-body">
  <form action="./shepay_gfjk.php?mod=site_n" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-4 control-label">支付宝合作身份者ID:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_alipay_id" value="<?php echo $conf['gfjk_alipay_id']; ?>" class="form-control"><small>* 合作身份者ID，以2088开头的16位纯数字</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">支付宝收款账号:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_alipay_zh" value="<?php echo $conf['gfjk_alipay_zh']; ?>" class="form-control"><small>* 收款支付宝账号</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">支付宝安全检验码:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_alipay_key" value="<?php echo $conf['gfjk_alipay_key']; ?>" class="form-control"><small>* 安全检验码，以数字和字母组成的32位字符</small></div>
	  <hr>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">微信支付APPID:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_wxpay_appid" value="<?php echo $conf['gfjk_wxpay_appid']; ?>" class="form-control"><small>* APPID：绑定支付的APPID（必须配置，开户邮件中可查看）</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">微信支付MCHID:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_wxpay_mchid" value="<?php echo $conf['gfjk_wxpay_mchid']; ?>" class="form-control"><small>* MCHID：商户号（必须配置，开户邮件中可查看）</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">微信支付KEY:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_wxpay_key" value="<?php echo $conf['gfjk_wxpay_key']; ?>" class="form-control"><small>* KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）设置地址：https://pay.weixin.qq.com/index.php/account/api_cert</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">微信支付APPSECRET:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_wxpay_appsecret" value="<?php echo $conf['gfjk_wxpay_appsecret']; ?>" class="form-control"><small>* APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置）获取地址：https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN</small></div>
	  <hr>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">QQ钱包MCHID:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_qpay_mchid" value="<?php echo $conf['gfjk_qpay_mchid']; ?>" class="form-control"><small>* QQ钱包商户号</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">QQ钱包MCHKEY:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_qpay_mchkey" value="<?php echo $conf['gfjk_qpay_mchkey']; ?>" class="form-control"><small>* 于QQ钱包商户平台(http://qpay.qq.com/)获取</small></div>
	  <hr>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">财付通商户号:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_tenpay_id" value="<?php echo $conf['gfjk_tenpay_id']; ?>" class="form-control"><small>* 财付通商户号</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">财付通安全检验码:</label>
	  <div class="col-sm-auto"><input type="text" name="gfjk_tenpay_key" value="<?php echo $conf['gfjk_tenpay_key']; ?>" class="form-control"><small>* 财付通安全检验码</small></div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-auto"><input type="submit" name="submit" value="确定修改" class="btn btn-primary form-control"/>
	 </div>
	</div>
  </form>
</div>
</div>

<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}
</script>

    </div>
  </div>