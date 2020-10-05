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
$title='支付接口通道配置';
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
<div class="card-header"><h3 class="panel-title">支付接口通道配置</h3></div>
<div class="card-body">
  <form action="./shepay_tdset.php?mod=site_n" method="post" class="form-horizontal" role="form">
  
		<div class="form-group">
	  <label class="col-sm-4 control-label">支付宝:</label>
	  <div class="col-sm-auto"><select class="form-control" name="alipay_mode" default="<?php echo $conf['alipay_mode']?>"><option value="0">关闭</option><option value="1">官方</option><option value="2">易支付</option><option value="3">码支付</option></select></div>
	</div>
         <div id="wx_close_info" style="<?php echo $conf['alipay_mode'] == 0 ? "" : "display: none;";?>">
         <div class="form-group">
	  <label class="col-sm-4 control-label">支付宝通道关闭提示:</label>
	  <div class="col-sm-auto">
   <textarea name="alipay_offtxt" rows="5" class="form-control"><?php echo $conf['alipay_offtxt']; ?></textarea>
  </div></div></div>
		<div class="form-group">
	  <label class="col-sm-4 control-label">微信支付:</label>
	  <div class="col-sm-auto"><select class="form-control" name="wxpay_mode" default="<?php echo $conf['wxpay_mode']?>"><option value="0">关闭</option><option value="1">官方</option><option value="2">易支付</option><option value="3">码支付</option></select></div>
	</div>
         <div id="wx_close_info" style="<?php echo $conf['wxpay_mode'] == 0 ? "" : "display: none;";?>">
         <div class="form-group">
	  <label class="col-sm-4 control-label">微信通道关闭提示:</label>
	  <div class="col-sm-auto">
   <textarea name="wxpay_offtxt" rows="5" class="form-control"><?php echo $conf['wxpay_offtxt']; ?></textarea>
  </div></div></div>
			<div class="form-group">
	  <label class="col-sm-4 control-label">QQ钱包:</label>
	  <div class="col-sm-auto"><select class="form-control" name="qqpay_mode" default="<?php echo $conf['qqpay_mode']?>"><option value="0">关闭</option><option value="1">官方</option><option value="2">易支付</option><option value="3">码支付</option></select></div>
	</div>
         <div id="wx_close_info" style="<?php echo $conf['qqpay_mode'] == 0 ? "" : "display: none;";?>">
         <div class="form-group">
	  <label class="col-sm-4 control-label">QQ钱包通道关闭提示:</label>
	  <div class="col-sm-auto">
   <textarea name="qqpay_offtxt" rows="5" class="form-control"><?php echo $conf['qqpay_offtxt']; ?></textarea>
  </div></div></div>
				<div class="form-group">
	  <label class="col-sm-4 control-label">财付通:</label>
	  <div class="col-sm-auto"><select class="form-control" name="tenpay_mode" default="<?php echo $conf['tenpay_mode']?>"><option value="0">关闭</option><option value="1">官方</option><option value="2">易支付</option><option value="3">码支付</option></select></div>
	</div>
         <div id="wx_close_info" style="<?php echo $conf['tenpay_mode'] == 0 ? "" : "display: none;";?>">
         <div class="form-group">
	  <label class="col-sm-4 control-label">财付通通道关闭提示:</label>
	  <div class="col-sm-auto">
   <textarea name="tenpay_offtxt" rows="5" class="form-control"><?php echo $conf['tenpay_offtxt']; ?></textarea>
  </div></div></div>
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