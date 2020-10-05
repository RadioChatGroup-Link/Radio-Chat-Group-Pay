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
$title='易支付接口配置';
include './shepay_head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
?>
<?php
header("Content-type: text/html; charset=utf-8");
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
if(($conf['yzfjk_moshi'])=="0"){$all='https://shepay.me.ayunx.com/readme/yzfjk_gf.txt';}
if(($conf['yzfjk_moshi'])=="1"){$all1='https://shepay.me.ayunx.com/readme/yzfjk_diy.txt';}
if(($conf['yzfjk_moshi'])=="1"){$all2='type="text" name="yzf_qqpay_api"';}
if(($conf['yzfjk_moshi'])=="0"){$all3='disabled="disabled"';}
if(($conf['yzfjk_moshi'])=="1"){$all4='<small>* 自定义模式接口头必带"http/https",接口尾必带"/"</small>';}
if(($conf['yzfjk_moshi'])=="1"){$all5='type="text" name="yzf_wxpay_api"';}
if(($conf['yzfjk_moshi'])=="1"){$all6='type="text" name="yzf_alipay_api"';}
if(($conf['yzfjk_moshi'])=="1"){$all7='type="text" name="yzf_tenpay_api"';}
?>
<?php
header("Content-type: text/html; charset=utf-8");
if(empty($conf['yzf_alipay_id'])||$conf['yzf_alipay_id']==''||empty($conf['yzf_alipay_key'])||$conf['yzf_alipay_key']==''){
    $shzt1 = "提交参数非法或不正确！";
}else{
    $post1 = json_decode(curl_get($conf['yzf_alipay_api'].'api.php?act=query&pid='.$conf['yzf_alipay_id'].'&key='.$conf['yzf_alipay_key']),1);
    $shzt1 = "接口商户信息获取成功！";
    if($post1[code]=='1'){
    }else{
        $shzt1 = "接口站点API连接失败！";
    }
}
if(empty($conf['yzf_wxpay_id'])||$conf['yzf_wxpay_id']==''||empty($conf['yzf_wxpay_key'])||$conf['yzf_wxpay_key']==''){
    $shzt2 = "提交参数非法或不正确！";
}else{
    $post2 = json_decode(curl_get($conf['yzf_wxpay_api'].'api.php?act=query&pid='.$conf['yzf_wxpay_id'].'&key='.$conf['yzf_wxpay_key']),1);
    $shzt2 = "接口商户信息获取成功！";
    if($post2[code]=='1'){
    }else{
        $shzt2 = "接口站点API连接失败！";
    }
}
if(empty($conf['yzf_qqpay_id'])||$conf['yzf_qqpay_id']==''||empty($conf['yzf_qqpay_key'])||$conf['yzf_qqpay_key']==''){
    $shzt3 = "提交参数非法或不正确！";
}else{
    $post3 = json_decode(curl_get($conf['yzf_qqpay_api'].'api.php?act=query&pid='.$conf['yzf_qqpay_id'].'&key='.$conf['yzf_qqpay_key']),1);
    $shzt3 = "接口商户信息获取成功！";
    if($post3[code]=='1'){
    }else{
        $shzt3 = "接口站点API连接失败！";
    }
}
if(empty($conf['yzf_tenpay_id'])||$conf['yzf_tenpay_id']==''||empty($conf['yzf_tenpay_key'])||$conf['yzf_tenpay_key']==''){
    $shzt4 = "提交参数非法或不正确！";
}else{
    $post4 = json_decode(curl_get($conf['yzf_tenpay_api'].'api.php?act=query&pid='.$conf['yzf_tenpay_id'].'&key='.$conf['yzf_tenpay_key']),1);
    $shzt4 = "接口商户信息获取成功！";
    if($post4[code]=='1'){
    }else{
        $shzt4 = "接口站点API连接失败！";
    }
}
?>
<div class="card card-primary">
    <div class="card-header"><h3 class="panel-title">易支付接口配置</h3>
    </div>
    <div class="card-body">
	<form action="./shepay_yzf.php?mod=site_n" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-sm-4 control-label">易支付接口模式:</label>
                <div class="col-sm-auto">
                    <select class="form-control" name="yzfjk_moshi" default="<?php echo $conf['yzfjk_moshi']?>">
                        <?php echo file_get_contents("https://shepay.me.ayunx.com/readme/yzfjk_moshi.txt");
                        ?>
                </div>
            </div><br />
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-auto"><input type="submit" name="submit" value="确定修改" class="btn btn-primary form-control" />
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card card-primary">
    <div class="card-header"><h3 class="panel-title">易支付接口调用状态</h3>
    </div>
    <div class="card-body">
	    <li class='list-group-item'>
            <b>当前QQ钱包接口：</b>
            <?php echo $conf['yzf_qqpay_api']?> <a href="<?php echo $conf['yzf_qqpay_api']?>" class="btn btn-xs btn-info">点此访问</a><br/>
            <b>接口信息获取状态：</b><?php echo $shzt3?><br/>
            <b>余额：</b><?php echo $post3[money]?>元<br/>
            <b>结算账号：</b><?php echo $post3[account]?><br/>
            <b>结算姓名：</b><?php echo $post3[username]?>
        </li>
		<li class='list-group-item'>
            <b>当前微信支付接口：</b>
            <?php echo $conf['yzf_wxpay_api']?> <a href="<?php echo $conf['yzf_wxpay_api']?>" class="btn btn-xs btn-info">点此访问</a><br/>
            <b>接口信息获取状态：</b><?php echo $shzt2?><br/>
            <b>余额：</b><?php echo $post2[money]?>元<br/>
            <b>结算账号：</b><?php echo $post2[account]?><br/>
            <b>结算姓名：</b><?php echo $post2[username]?>
        </li>
        <li class='list-group-item'>
            <b>当前支付宝接口：</b>
            <?php echo $conf['yzf_alipay_api']?> <a href="<?php echo $conf['yzf_alipay_api']?>" class="btn btn-xs btn-info">点此访问</a><br/>
            <b>接口信息获取状态：</b><?php echo $shzt1?><br/>
            <b>余额：</b><?php echo $post1[money]?>元<br/>
            <b>结算账号：</b><?php echo $post1[account]?><br/>
            <b>结算姓名：</b><?php echo $post1[username]?>
        </li>
        <li class='list-group-item'>
            <b>当前财付通接口：</b>
            <?php echo $conf['yzf_tenpay_api']?> <a href="<?php echo $conf['yzf_tenpay_api']?>" class="btn btn-xs btn-info">点此访问</a><br/>
            <b>接口信息获取状态：</b><?php echo $shzt4?><br/>
            <b>余额：</b><?php echo $post4[money]?>元<br/>
            <b>结算账号：</b><?php echo $post4[account]?><br/>
            <b>结算姓名：</b><?php echo $post4[username]?>
        </li>
    </div>
</div>
<div class="card card-primary">
    <div class="card-header"><h3 class="panel-title">易支付接口配置</h3>
    </div>
    <div class="card-body">
    <form action="./shepay_yzf.php?mod=site_n" method="post" class="form-horizontal" role="form">
            <div class="form-group">
                <label class="col-sm-4 control-label">QQ钱包接口地址:</label>
                <div class="col-sm-auto">
                    <select class="form-control" name="yzf_qqpay_api" default="<?php echo $conf['yzf_qqpay_api']?>">
                        <?php echo file_get_contents("$all");?>
                        <?php echo file_get_contents("$all1");?>
                    </select>
                    <input <?php echo $all2?> value="<?php echo $conf['yzf_qqpay_api']; ?>" class="form-control"
                    <?php echo $all3?> />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">QQ钱包接口商户ID:</label>
                <div class="col-sm-auto"><input type="text" name="yzf_qqpay_id" value="<?php echo $conf['yzf_qqpay_id']; ?>" class="form-control"/></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">QQ钱包接口商户密钥:</label>
                <div class="col-sm-auto"><input type="text" name="yzf_qqpay_key" value="<?php echo $conf['yzf_qqpay_key']; ?>" class="form-control"/></div>
            </div>
            <hr>
            <div class="form-group">
                <label class="col-sm-4 control-label">微信支付接口地址:</label>
                <div class="col-sm-auto">
                    <select class="form-control" name="yzf_wxpay_api" default="<?php echo $conf['yzf_wxpay_api']?>">
                        <?php echo file_get_contents("$all");?>
                        <?php echo file_get_contents("$all1");?>
                    </select>
                    <input <?php echo $all5?> value="<?php echo $conf['yzf_wxpay_api']; ?>" class="form-control"
                    <?php echo $all3?> />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">微信支付接口商户ID:</label>
                <div class="col-sm-auto"><input type="text" name="yzf_wxpay_id" value="<?php echo $conf['yzf_wxpay_id']; ?>" class="form-control"/></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">微信支付接口商户密钥:</label>
                <div class="col-sm-auto"><input type="text" name="yzf_wxpay_key" value="<?php echo $conf['yzf_wxpay_key']; ?>" class="form-control"/></div>
            </div>
            <hr>
            <div class="form-group">
                <label class="col-sm-4 control-label">支付宝接口地址:</label>
                <div class="col-sm-auto">
                    <select class="form-control" name="yzf_alipay_api" default="<?php echo $conf['yzf_alipay_api']?>">
                        <?php echo file_get_contents("$all");?>
                        <?php echo file_get_contents("$all1");?>
                    </select>
                    <input <?php echo $all6?> value="<?php echo $conf['yzf_alipay_api']; ?>" class="form-control"
                    <?php echo $all3?> />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">支付宝接口商户ID:</label>
                <div class="col-sm-auto"><input type="text" name="yzf_alipay_id" value="<?php echo $conf['yzf_alipay_id']; ?>" class="form-control"/></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">支付宝接口商户密钥:</label>
                <div class="col-sm-auto"><input type="text" name="yzf_alipay_key" value="<?php echo $conf['yzf_alipay_key']; ?>" class="form-control"/></div>
            </div>
            <hr>
            <div class="form-group">
                <label class="col-sm-4 control-label">财付通接口地址:</label>
                <div class="col-sm-auto">
                    <select class="form-control" name="yzf_tenpay_api" default="<?php echo $conf['yzf_tenpay_api']?>">
                        <?php echo file_get_contents("$all");?>
                        <?php echo file_get_contents("$all1");?>
                    </select>
                    <input <?php echo $all7?> value="<?php echo $conf['yzf_tenpay_api']; ?>" class="form-control"
                    <?php echo $all3?> />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">财付通接口商户ID:</label>
                <div class="col-sm-auto"><input type="text" name="yzf_tenpay_id" value="<?php echo $conf['yzf_tenpay_id']; ?>" class="form-control"/></div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">财付通接口商户密钥:</label>
                <div class="col-sm-auto"><input type="text" name="yzf_tenpay_key" value="<?php echo $conf['yzf_tenpay_key']; ?>" class="form-control"/></div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-auto"><input type="submit" name="submit" value="确定修改" class="btn btn-primary form-control" />
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card card-primary">
    <div class="card-header"><h3 class="panel-title">易支付接口配置公告</h3>
    </div>
    <div class="card-body">
        <?php echo file_get_contents("https://shepay.me.ayunx.com/readme/yzfjk-readme.txt");
        ?>
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