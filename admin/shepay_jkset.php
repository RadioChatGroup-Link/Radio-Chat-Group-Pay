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
$title='系统监控配置';
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
	<div class="card-header"><h3 class="panel-title">系统监控配置</h3></div>
<div class="card-body">
  <form action="./shepay_jkset.php?mod=site_n" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-4 control-label">监控识别码配置:</label>
	  <div class="col-sm-auto"><input type="text" name="cron_key" value="<?php echo $conf['cron_key']; ?>" class="form-control" required/><small>* 为防止恶意监控，都潮汇系统V5.2.0以后的版本中添加了配置监控识别码功能，请在上方配置框中自定义输入一串“字母+数字”的结合并保存，刷新页面即可看到完整监控地址。</small></div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-auto"><input type="submit" name="submit" value="确定修改" class="btn btn-primary form-control"/>
	 </div>
	</div>
  </form>
</div>
</div>
            <div class="card card-primary">	
			<div class="card-header">
                <h3 class="panel-title">系统监控说明</h3>
                </div>
               <div class="card-body"> 
                <center>
<h4>余额监控地址：
http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/cron.php?key=<?php echo $conf['cron_key']; ?><br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/cron.php?key=<?php echo $conf['cron_key']; ?>" class="btn btn-xs btn-info">点击执行</a></a></h4><hr>
<h4>结算监控地址：
http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/cron.php?key=<?php echo $conf['cron_key']; ?>&do=settle<br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/cron.php?key=<?php echo $conf['cron_key']; ?>&do=settle" class="btn btn-xs btn-info">点击执行</a></a></h4><hr>
<b><font color="red">温馨提示：如需开启第四方易支付接口自动补单监控，请在监控前修改“/shepay/cron/”目录对应文件中的提示部分（即接口地址、商户ID、商户密钥），不修改监控无效！</font></b><hr>
<h4>QQ自动补单监控：
http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/budan_qqpay.php?key=<?php echo $conf['cron_key']; ?><br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/budan_qqpay.php?key=<?php echo $conf['cron_key']; ?>" class="btn btn-xs btn-info">点击执行</a></a></h4>
<h4>微信自动补单监控：
http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/budan_wxpay.php?key=<?php echo $conf['cron_key']; ?><br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/budan_wxpay.php?key=<?php echo $conf['cron_key']; ?>" class="btn btn-xs btn-info">点击执行</a></a></h4>  
<h4>支付宝自动补单监控：
http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/budan_alipay.php?key=<?php echo $conf['cron_key']; ?><br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/budan_alipay.php?key=<?php echo $conf['cron_key']; ?>" class="btn btn-xs btn-info">点击执行</a></a></h4>
<h4>财付通自动补单监控：
http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/budan_tenpay.php?key=<?php echo $conf['cron_key']; ?><br/>
<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/shepay/cron/budan_tenpay.php?key=<?php echo $conf['cron_key']; ?>" class="btn btn-xs btn-info">点击执行</a></a></h4>
               </center>
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