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
$title='管理员账号配置';
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
			<div class="card-header">
    <h3 class="panel-title">管理员账号配置</h3></div>
    <div class="card-body">
  <form action="./shepay_adminset.php?mod=site_n" method="post" class="form-horizontal" role="form">
<div class="form-group">
	  <label class="col-sm-4 control-label">管理员帐号:</label>
	  <div class="col-sm-auto"><input type="text" name="admin_user" value="<?php echo $conf['admin_user']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">管理员密码:</label>
	  <div class="col-sm-auto"><input type="text" name="admin_pwd" value="<?php echo $conf['admin_pwd']; ?>" class="form-control" required/></div>
	</div><br/>
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