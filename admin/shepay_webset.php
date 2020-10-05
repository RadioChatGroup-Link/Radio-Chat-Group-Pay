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
$title='站点信息配置';
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
    <h3 class="panel-title">站点信息配置</h3></div>
    <div class="card-body">
  <form action="./shepay_webset.php?mod=site_n" method="post" class="form-horizontal" role="form">
	<div class="form-group">
	  <label class="col-sm-4 control-label">网站名称:</label>
	  <div class="col-sm-auto"><input type="text" name="web_name" value="<?php echo $conf['web_name']; ?>" class="form-control" required/><small>* 显示调用数据库表"['web_name']"（各别模板将会显示）</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">站点备案号:</label>
	  <div class="col-sm-auto"><input type="text" name="beian" value="<?php echo $conf['beian']; ?>" class="form-control"><small>* 显示调用数据库表"['beian']"（各别模板底部将会显示）</small></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">本站URL:</label>
	  <div class="col-sm-auto"><input type="text" name="local_domain" value="<?php echo $conf['local_domain']; ?>" class="form-control" required/><small>* 显示调用数据库表"['local_domain']"（支付回调、各别模板显示）</small></div>
	</div>
<div class="form-group">
	  <label class="col-sm-4 control-label">配置接口站跳转URL:</label>
	  <div class="col-sm-auto"><input type="text" name="api_link" value="<?php echo $conf['api_link']; ?>" class="form-control"><small>* 如需开启接口站，请配置好跳转地址后前往模板切换中选择接口站模板并保存修改！(按Http头,/尾的格式填写)</small></div>
	  </div>
	  <div class="form-group">
	  <label class="col-sm-4 control-label">极验CAPTCHA_ID:</label>
	  <div class="col-sm-auto"><input type="text" name="CAPTCHA_ID" value="<?php echo $conf['CAPTCHA_ID']; ?>" class="form-control" required/><small>* Geetest极验验证码ID配置（商户修改信息时验证）</small></div>
          </div>
  <div class="form-group">
	 <label class="col-sm-4 control-label">极验PRIVATE_KEY:</label>
	  <div class="col-sm-auto"><input type="text" name="PRIVATE_KEY" value="<?php echo $conf['PRIVATE_KEY']; ?>" class="form-control" required/><small>* Geetest极验验证码Key配置（商户修改信息时验证）</small>
	  </div>
	  <hr>
 </div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">客服QQ:</label>
	  <div class="col-sm-auto"><input type="text" name="web_qq" value="<?php echo $conf['web_qq']; ?>" class="form-control" required/><small>* 显示调用数据库表"['web_qq']"（各别模板将会显示）</small></div>
	</div>
<div class="form-group">
	  <label class="col-sm-4 control-label">联系电话:</label>
	  <div class="col-sm-auto"><input type="text" name="phone" value="<?php echo $conf['phone']; ?>" class="form-control"><small>* 显示调用数据库表"['phone']"（各别模板将会显示）</small></div>
	</div>
<div class="form-group">
	  <label class="col-sm-4 control-label">联系邮箱:</label>
	  <div class="col-sm-auto"><input type="text" name="web_mail" value="<?php echo $conf['web_mail']; ?>" class="form-control"><small>* 显示调用数据库表"['web_mail']"（各别模板将会显示）</small></div>
	</div>
<div class="form-group">
	  <label class="col-sm-4 control-label">公司地址:</label>
	  <div class="col-sm-auto"><input type="text" name="dizhi" value="<?php echo $conf['dizhi']; ?>" class="form-control"><small>* 显示调用数据库表"['dizhi']"（各别模板将会显示）</small></div>
	  <hr>
	</div>
<div class="form-group">
	  <label class="col-sm-4 control-label">QQ交流群群号:</label>
	  <div class="col-sm-auto"><input type="text" name="jlqh" value="<?php echo $conf['jlqh']; ?>" class="form-control"><small>* 显示调用数据库表"['jlqh']"（各别模板将会显示）</small></div>
	</div>
<div class="form-group">
	  <label class="col-sm-4 control-label">QQ交流群链接:</label>
	  <div class="col-sm-auto"><input type="text" name="jlqlj" value="<?php echo $conf['jlqlj']; ?>" class="form-control"><small>* 显示调用数据库表"['jlqlj']"（各别模板将会显示）</small></div>
	</div>
<div class="form-group">
	  <label class="col-sm-4 control-label">商户结算群群号:</label>
	  <div class="col-sm-auto"><input type="text" name="shqh" value="<?php echo $conf['shqh']; ?>" class="form-control"><small>* 显示调用数据库表"['shqh']"（各别模板将会显示）</small></div>
	</div>
<div class="form-group">
	  <label class="col-sm-4 control-label">商户结算群链接:</label>
	  <div class="col-sm-auto"><input type="text" name="qun" value="<?php echo $conf['qun']; ?>" class="form-control"><small>* 显示调用数据库表"['qun']"（各别模板将会显示）</small>
	  </div>
	  <hr>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">合作伙伴①名称:</label>
	  <div class="col-sm-auto"><input type="text" name="hzhb1" value="<?php echo $conf['hzhb1']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">合作伙伴①链接:</label>
	  <div class="col-sm-auto"><input type="text" name="hzlink1" value="<?php echo $conf['hzlink1']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">合作伙伴②名称:</label>
	  <div class="col-sm-auto"><input type="text" name="hzhb2" value="<?php echo $conf['hzhb2']; ?>" class="form-control" required/></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">合作伙伴②链接:</label>
	  <div class="col-sm-auto"><input type="text" name="hzlink2" value="<?php echo $conf['hzlink2']; ?>" class="form-control" required/></div>
	  <hr>
	</div>
			<div class="form-group">
	  <label class="col-sm-4 control-label">微信H5支付:</label>
	  <div class="col-sm-auto"><select class="form-control" name="wxpay_h5" default="<?php echo $conf['wxpay_h5']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">QQ防红跳转:</label>
	  <div class="col-sm-auto"><select class="form-control" name="qqtz" default="<?php echo $conf['qqtz']?>"><option value="0">关闭</option><option value="1">开启</option></select></div>
	</div>
	<div class="form-group">
	  <label class="col-sm-4 control-label">SDK测试支付页面:</label>
	  <div class="col-sm-auto"><select class="form-control" name="sdk_is" default="<?php echo $conf['sdk_is']?>"><option value="0">关闭</option><option value="1">开启</option></select>
	  </div>
	  <hr>
	  </div>
  <div class="form-group">
<label class="col-sm-4 control-label">商户密钥验证错误提示内容:</label>
<div class="col-sm-auto">
              <textarea name="key_no" rows="5" class="form-control"><?php echo $conf['key_no']; ?></textarea>
          <small>* 此内容强烈建议填写，否则支付时商户密钥验证错误弹出阻断页中提示内容为空，容易误导用户！</small></div>
</div>
<div class="form-group">
<label class="col-sm-4 control-label">已封禁商户提示内容:</label>
<div class="col-sm-auto">
              <textarea name="user_no" rows="5" class="form-control"><?php echo $conf['user_no']; ?></textarea>
          <small>* 此内容强烈建议填写，否则已封禁账户登录及支付时弹出阻断页中提示内容为空，容易误导用户！</small>
          </div>
          <hr>
</div>
 <div class="form-group">
	  <label class="col-sm-4 control-label">维护模式选项:</label>
	  <div class="col-sm-auto"><select class="form-control" name="web_is" default="<?php echo $conf['web_is']?>"><option value="0">关闭所有（站点正常运行）</option><option value="1">开启界面维护（开启后，商户前、后台所有页面将弹出维护提示，但对接支付模块任可正常运行，也就是收银台可正常支付收款）</option><option value="2">开启整站维护（开启后，商户前、后台、所有页面及对接支付模块全部弹出维护提示，也就是收银台无法支付收款）</option></select></div>
	</div>
	<div class="form-group">
<label class="col-sm-4 control-label">维护提示信息:</label>
<div class="col-sm-auto">
<textarea name="web_offtext" rows="5" class="form-control"><?php echo $conf['web_offtext']; ?></textarea>
<small>* 所填提示内容将会在开启维护模式的情况下显示在相应页面，如果上方按钮为关闭，此提示将不会显示！</small>
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