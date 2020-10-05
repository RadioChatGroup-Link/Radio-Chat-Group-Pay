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
$title='用户公告配置';
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
			<div class="card-header"><h3 class="panel-title">用户公告配置</h3></div>
<div class="card-body">
  <form action="./shepay_gg.php?mod=site_n" method="post" class="form-horizontal" role="form">
	<div class="form-group">
<label class="col-sm-4 control-label">登录页弹窗公告内容:</label>
<div class="col-sm-auto">
              <textarea name="dlgg" rows="5" class="form-control"><?php echo $conf['dlgg']; ?></textarea>
          <small>* 该文本支持Html，显示调用数据库表"['dlgg']"。</small>
          </div>
          </div>
	<div class="form-group">
<label class="col-sm-4 control-label">注册页弹窗公告内容:</label>
<div class="col-sm-auto">
              <textarea name="reggg" rows="5" class="form-control"><?php echo $conf['reggg']; ?></textarea>
          <small>* 该文本支持Html，显示调用数据库表"['reggg']"。</small>
          </div>
          </div>
		  <hr>
  <div class="form-group">
<label class="col-sm-4 control-label">用户中心侧边栏弹窗公告:</label>
<div class="col-sm-auto">
              <textarea name="tcgg" rows="5" class="form-control"><?php echo $conf['tcgg']; ?></textarea>
          <small>* 该文本支持Html，显示调用数据库表"['tcgg']"。</small>
          </div>
          </div>
	<div class="form-group">
<label class="col-sm-4 control-label">用户中心公告①内容:</label>
<div class="col-sm-auto">
              <textarea name="gg1" rows="5" class="form-control"><?php echo $conf['gg1']; ?></textarea>
          <small>* 该文本支持Html，显示调用数据库表"['gg1']"。</small>
          </div>
          </div>
          <div class="form-group">
<label class="col-sm-4 control-label">用户中心公告②内容:</label>
<div class="col-sm-auto">
              <textarea name="gg2" rows="5" class="form-control"><?php echo $conf['gg2']; ?></textarea>
          <small>* 该文本支持Html，显示调用数据库表"['gg2']"。</small>
          </div>
          </div>
          <div class="form-group">
<label class="col-sm-4 control-label">用户中心公告③内容:</label>
<div class="col-sm-auto">
              <textarea name="gg3" rows="5" class="form-control"><?php echo $conf['gg3']; ?></textarea>
          <small>* 该文本支持Html，显示调用数据库表"['gg3']"。</small>
          </div>
          </div>
          <div class="form-group">
<label class="col-sm-4 control-label">用户中心公告④内容:</label>
<div class="col-sm-auto">
              <textarea name="gg4" rows="5" class="form-control"><?php echo $conf['gg4']; ?></textarea>
          <small>* 该文本支持Html，，显示调用数据库表"['gg4']"。</small>
          </div>
          </div>
          <div class="form-group">
<label class="col-sm-4 control-label">用户中心公告⑤内容:</label>
<div class="col-sm-auto">
              <textarea name="gg5" rows="5" class="form-control"><?php echo $conf['gg5']; ?></textarea>
          <small>* 该文本支持Html，显示调用数据库表"['gg5']"。</small>
          </div>
          </div>
	<div class="form-group">
	  <div class="col-sm-auto"><input type="submit" name="submit" value="保存修改" class="btn btn-primary form-control"/>
	 </div>
	</div>     
  </form>  
</div>
</div>
    </div>
  </div>