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
$title='集成文件配置';
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
		<div class="card-header"><h3 class="panel-title">集成包配置</h3></div>
<div class="card-body">
  <form action="./shepay_jcb.php?mod=site_n" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-4 control-label">SDK下载地址:</label>
	  <div class="col-sm-auto"><input type="text" name="sdk" value="<?php echo $conf['sdk']; ?>" class="form-control" required/><small>* 显示调用数据库表"['sdk']"。</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">彩虹代刷集成包下载地址:</label>
	  <div class="col-sm-auto"><input type="text" name="chds" value="<?php echo $conf['chds']; ?>" class="form-control" required/><small>* 显示调用数据库表"['chds']"。</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">VHMS集成包下载地址:</label>
	  <div class="col-sm-auto"><input type="text" name="vhms" value="<?php echo $conf['vhms']; ?>" class="form-control" required/><small>* 显示调用数据库表"['vhms']"。</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">SWAPIDC集成包下载地址:</label>
	  <div class="col-sm-auto"><input type="text" name="swapidc" value="<?php echo $conf['swapidc']; ?>" class="form-control" required/><small>* 显示调用数据库表"['swapidc']"。</small></div>
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