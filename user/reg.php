<?php
$is_defend=true;
include("../shepay/common.php");
if($conf['web_is']==1)sysmsg($conf['web_offtext']);
if($conf['web_is']==2)sysmsg($conf['web_offtext']);
if($conf['is_reg']==0)sysmsg($conf['reg_offtext']);
$tid = $_GET['id'];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="<?php echo $conf['web_name']?>,都潮汇系统" name="description" />
    <meta name="author" content="auth.ooeecc.cn" />
    <title>商户申请 | <?php echo $conf['web_name']?></title>
    <link href="//shepay.ayunx.com/user/css/app.min.css" rel="stylesheet" type="text/css">
</head>
<body class="authentication-bg">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <!-- Logo-->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <span><font color="white" size="5"><b><?php echo $conf['web_name']?></b></font></span>
                        </div>
                        <div class="card-body">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">自助申请商户</h4>
                            </div>
                            <form name="form">
                                <div class="form-group">
                                    <?php if($conf['is_payreg']){?><label>商户申请价格为：<b><?php echo $conf['reg_price']?></b> 元</label><?php }?>
                                    <select class="form-control" name="type"><?php if($conf['stype_1']){?><option value="1">支付宝结算</option><?php }if($conf['stype_2']){?><option value="2">微信结算</option><?php }if($conf['stype_3']){?><option value="3">QQ钱包结算</option><?php }if($conf['stype_4']){?><option value="4">银行卡结算</option>
                                    <?php }?></select>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="account" placeholder="结算账号" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="username" placeholder="真实姓名" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="url" placeholder="您的网站域名" required>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="email" placeholder="邮箱（用于接收商户信息）" required>
                                </div>
                                <?php if($conf['verifytype']==1){?>
                                <div class="form-group">
                                    <input class="form-control" type="text" name="phone" placeholder="手机号码" required>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="code" placeholder="短信验证码" required><div class="input-group-append"><button class="btn btn-dark" type="button" id="sendsms">获取验证码</button></div>
                                    </div>
                                </div>
                                <div id="embed-captcha"></div>
                                <?php }else{?>
                                <div class="form-group">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="code" placeholder="邮箱验证码" required><div class="input-group-append"><button class="btn btn-dark" type="button" id="sendcode">获取验证码</button></div>
                                    </div>
                                </div>
                                <?php }?>
								    <?php if($conf['tgfl_is']==1){?>
                                  <div class="form-group">
                                   <div class="input-group">
                                  <input class="form-control" type="text" name="tgid" placeholder="邀请人商户ID（没有请留空）" class="form-control no-border"  value="<?php echo $_GET['tgid']; ?>">
                                   </div>
                                  </div>
								    <?php }?>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="checkbox-signin" checked required>
                                        <label class="custom-control-label" for="checkbox-signin"><a href="agreement.php">同意商户服务协议</a></label>
                                    </div>
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary"  type="button" id="submit" ng-click="login()" ng-disabled="form.$invalid">立即注册</button>
                                </div>
                            </form>
                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">已有商户? <a href="login.php" class="text-dark ml-1"><b>返回登录</b></a></p>
                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->
    <footer class="footer footer-alt" style="text-transform: uppercase;">
        Copyright &copy; 2016-<?=date('Y')?> <?php echo $conf['web_name']?>
    </footer>
<script src="//shepay.ayunx.com/admin/js/app.min.js"></script>
<script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="//shepay.ayunx.com/assets/layer/layer.js"></script>
<script src="//static.geetest.com/static/tools/gt.js"></script>
<script>
  layer.open({
  type: 1
  ,area: ['350px', '200px']
  ,title: '<?php echo $conf['web_name']?>注册公告'
  ,shade: 0.5 //遮罩透明度
  ,maxmin: true //允许全屏最小化
  ,anim: 3 //0-6的动画形式，-1不开启
  ,content: '<div style="padding:50px;"><?php echo $conf['reggg']?></div>'
});
</script>
<script>
function invokeSettime(obj){
    var countdown=60;
    settime(obj);
    function settime(obj) {
        if (countdown == 0) {
            $(obj).attr("data-lock", "false");
            $(obj).text("获取验证码");
            countdown = 60;
            return;
        } else {
            $(obj).attr("data-lock", "true");
            $(obj).attr("disabled",true);
            $(obj).text("(" + countdown + ") s 重新发送");
            countdown--;
        }
        setTimeout(function() {
                    settime(obj) }
                ,1000)
    }
}
var handlerEmbed = function (captchaObj) {
    var phone;
    captchaObj.onReady(function () {
        $("#wait").hide();
    }).onSuccess(function () {
        var result = captchaObj.getValidate();
        if (!result) {
            return alert('请完成验证');
        }
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $.ajax({
            type : "POST",
            url : "ajax.php?act=sendsms",
            data : {phone:phone,geetest_challenge:result.geetest_challenge,geetest_validate:result.geetest_validate,geetest_seccode:result.geetest_seccode},
            dataType : 'json',
            success : function(data) {
                layer.close(ii);
                if(data.code == 0){
                    new invokeSettime("#sendsms");
                    layer.msg('发送成功，请注意查收！');
                }else{
                    layer.alert(data.msg);
                    captchaObj.reset();
                }
            } 
        });
    });
    $('#sendsms').click(function () {
        if ($(this).attr("data-lock") === "true") return;
        phone=$("input[name='phone']").val();
        if(phone==''){layer.alert('手机号码不能为空！');return false;}
        if(phone.length!=11){layer.alert('手机号码不正确！');return false;}
        captchaObj.verify();
    })
    // 更多接口参考：http://www.geetest.com/install/sections/idx-client-sdk.html
};
$(document).ready(function(){
    $("select[name='type']").change(function(){
        if($(this).val() == 1){
            $("input[name='account']").attr("placeholder","支付宝账号");
        }else if($(this).val() == 2){
            $("input[name='account']").attr("placeholder","微信号");
        }else if($(this).val() == 3){
            $("input[name='account']").attr("placeholder","QQ号");
        }else if($(this).val() == 4){
            $("input[name='account']").attr("placeholder","银行卡号");
        }
    });
    $("select[name='type']").change();
    if($.cookie('mch_info')){
        var data = $.cookie('mch_info').split("|");
        layer.open({
          type: 1,
          title: '你之前申请的商户',
          skin: 'layui-layer-rim',
          content: '<li class="list-group-item"><b>商户ID：</b>'+data[0]+'</li><li class="list-group-item"><b>商户密钥：</b>'+data[1]+'</li><li class="list-group-item"><a href="login.php?user='+data[0]+'&pass='+data[1]+'" class="btn btn-default btn-block">返回登录</a></li>'
        });
    }
    $("#sendcode").click(function(){
        if ($(this).attr("data-lock") === "true") return;
        var email=$("input[name='email']").val();
        if(email==''){layer.alert('邮箱不能为空！');return false;}
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $.ajax({
            type : "POST",
            url : "ajax.php?act=sendcode",
            data : {email:email},
            dataType : 'json',
            success : function(data) {
                layer.close(ii);
                if(data.code == 0){
                    new invokeSettime("#sendcode");
                    layer.msg('发送成功，请注意查收！');
                }else{
                    layer.alert(data.msg);
                }
            } 
        });
    });
    $("#submit").click(function(){
        if ($(this).attr("data-lock") === "true") return;
        var type=$("select[name='type']").val();
        var account=$("input[name='account']").val();
        var username=$("input[name='username']").val();
        var url=$("input[name='url']").val();
        var email=$("input[name='email']").val();
        var phone=$("input[name='phone']").val();
        var code=$("input[name='code']").val();
        var tgid=$("input[name='tgid']").val();
        if(account=='' || username=='' || url=='' || email=='' || phone=='' || code==''){layer.alert('请确保各项不能为空！');return false;}
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
        if (url.indexOf(" ")>=0){
            url = url.replace(/ /g,"");
        }
        if (url.toLowerCase().indexOf("http://")==0){
            url = url.slice(7);
        }
        if (url.toLowerCase().indexOf("https://")==0){
            url = url.slice(8);
        }
        if (url.slice(url.length-1)=="/"){
            url = url.slice(0,url.length-1);
        }
        $("input[name='url']").val(url);
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $(this).attr("data-lock", "true");
        $.ajax({
            type : "POST",
            url : "ajax.php?act=reg",
            data : {type:type,account:account,username:username,url:url,email:email,phone:phone,code:code,tgid:tgid},
            dataType : 'json',
            success : function(data) {
                $("#submit").attr("data-lock", "false");
                layer.close(ii);
                if(data.code == 1){
                    layer.open({
                      type: 1,
                      title: '商户申请成功',
                      skin: 'layui-layer-rim',
                      content: '<li class="list-group-item"><b>商户ID：</b>'+data.pid+'</li><li class="list-group-item"><b>商户密钥：</b>'+data.key+'</li><li class="list-group-item">以上商户信息已经发送到您的邮箱中</li><li class="list-group-item"><a href="login.php?user='+data.pid+'&pass='+data.key+'" class="btn btn-default btn-block">返回登录</a></li>'
                    });
                    var mch_info = data.pid+"|"+data.key;
                    $.cookie('mch_info', mch_info);
                }else if(data.code == 2){
                    layer.open({
                      type: 1,
                      title: '支付确认页面',
                      skin: 'layui-layer-rim',
                      content: '<li class="list-group-item"><b>所需支付金额：</b>'+data.need+'元</li><li class="list-group-item text-center"><a href="../submit2.php?type=alipay&trade_no='+data.trade_no+'" class="btn btn-primary">支付宝</a>&nbsp;<a href="../submit2.php?type=wxpay&trade_no='+data.trade_no+'" class="btn btn-primary">微信支付</a>&nbsp;<a href="../submit2.php?type=qqpay&trade_no='+data.trade_no+'" class="btn btn-primary">QQ钱包</a><br><br><a href="../submit2.php?type=tenpay&trade_no='+data.trade_no+'" class="btn btn-primary">财付通</a></li><li class="list-group-item">提示：支付完成后请勿关闭网页，否则无法显示商户注册成功信息！</li>'
                    });
                }else{
                    layer.alert(data.msg);
                }
            }
        });
    });
    $.ajax({
        // 获取id，challenge，success（是否启用failback）
        url: "ajax.php?act=captcha&t=" + (new Date()).getTime(), // 加随机数防止缓存
        type: "get",
        dataType: "json",
        success: function (data) {
            console.log(data);
            // 使用initGeetest接口
            // 参数1：配置参数
            // 参数2：回调，回调的第一个参数验证码对象，之后可以使用它做appendTo之类的事件
            initGeetest({
                width: '100%',
                gt: data.gt,
                challenge: data.challenge,
                new_captcha: data.new_captcha,
                product: "bind", // 产品形式，包括：float，embed，popup。注意只对PC版验证码有效
                offline: !data.success // 表示用户后台检测极验服务器是否宕机，一般不需要关注
                // 更多配置参数请参见：http://www.geetest.com/install/sections/idx-client-sdk.html#config
            }, handlerEmbed);
        }
    });
});
</script>

</body>
</html>