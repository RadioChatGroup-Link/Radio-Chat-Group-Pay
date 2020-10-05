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
$title='盈利费率配置';
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
<div class="card-header"><h3 class="panel-title">盈利费率配置</h3></div>
<div class="card-body">
  <form action="./shepay_ylfl.php?mod=site_n" method="post" class="form-horizontal" role="form">
     <div class="form-group">
	  <label class="col-sm-4 control-label">手动结算功能:</label>
	  <div class="col-sm-auto"><select class="form-control" name="settle_open" default="<?php echo $conf['settle_open']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">手动结算最低申请结算金额:</label>
	  <div class="col-sm-auto"><input type="text" name="sdtx_money_min" value="<?php echo $conf['sdtx_money_min']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">每笔交易费率（百分数）:</label>
	  <div class="col-sm-auto"><input type="text" name="money_rate" value="<?php echo $conf['money_rate']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">每天满多少元自动结算:</label>
	  <div class="col-sm-auto"><input type="text" name="settle_money" value="<?php echo $conf['settle_money']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">结算费率（实际为<?php $a=100;$b=$conf['settle_rate'];echo $a*$b?>%）:</label>
	  <div class="col-sm-auto"><input type="text" name="settle_rate" value="<?php echo $conf['settle_rate']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">结算手续费最小:</label>
	  <div class="col-sm-auto"><input type="text" name="settle_fee_min" value="<?php echo $conf['settle_fee_min']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">结算手续费最大:</label>
	  <div class="col-sm-auto"><input type="text" name="settle_fee_max" value="<?php echo $conf['settle_fee_max']; ?>" class="form-control" required/></div>
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