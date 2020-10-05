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
$title='在线客服配置';
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
			<div class="card-header"><h3 class="panel-title">在线客服配置</h3></div>
<div class="card-body">
  <form action="./shepay_mqkf.php?mod=site_n" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-4 control-label">美恰ID信息:</label>
	  <div class="col-sm-auto"><input type="text" name="kfset_mqid" value="<?php echo $conf['kfset_mqid']; ?>" class="form-control" required/><small>* 留空则不启用，美恰客服小工具，配置调用数据库表"['kfset_mqid']"（各别模板将会显示）</small>
	</div>
	</div>
		<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-auto"><input type="submit" name="submit" value="确定修改" class="btn btn-primary form-control"/>
	 </div>
	</div>
	</form>
</div>
</div>
	<div class="card card-primary">				
<div class="card-header"><h3 class="panel-title">在线客服使用说明</h3></div>
<div class="card-body">
					<li class='list-group-item'>
	<b>①都潮汇在线客服服务由 <a href="https://meiqia.com/" target="blank" class="btn btn-xs btn-info">美恰</a> 提供服务支持。</b>						
							</li>
							<li class='list-group-item'>
	<b>②获取美恰ID请 <a href="https://app.meiqia.com/setting/id-query" target="blank" class="btn btn-xs btn-info">点此</a> 。</b>
	</li>
	<li class='list-group-item'>
	<b>③使用美恰在线客服功能需要注册美恰账号，美恰公司与都潮汇程序没有直接关系，仅由深海独家整合本功能。</b>
	</li>
	<li class='list-group-item'>
	<b>④美恰ID正确配置并保存后，易支付平台全站右下角将显示美恰在线客服按钮。</b>
	</li>
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