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
$title='模板切换';
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
<div class="card-header"><h3 class="panel-title">模板切换</h3></div>
<div class="card-body">
  <form action="./shepay_template.php?mod=site_n" method="post" class="form-horizontal" role="form">
		<div class="form-group">
	  <label class="col-sm-4 control-label">首页模板切换:</label>
	  <div class="col-sm-auto"><select class="form-control" name="template" default="<?php echo $conf['template']?>"><?php
echo file_get_contents("https://shepay.me.ayunx.com/readme/admin-template.txt");
?></select>
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
<div class="card-header"><h3 class="panel-title">模板使用提示</h3></div>
					<div class="card-body">
					<li class='list-group-item'>
						<b>当前使用模板目录：</b>/shepay/template/index/<?php echo $conf['template']?>
						</li>
						<li class='list-group-item'>
						<b>温馨提示：</b>感谢您选择都潮汇系统，由于模板较多，我们暂时没有时间将模板一个个优化的淋漓尽致，但已确保所有已提供模板的可用性，除各别模板已深度优化外，其它还请自行修改，谢谢！
						</li>

<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}
</script>

    </div>
  </div>