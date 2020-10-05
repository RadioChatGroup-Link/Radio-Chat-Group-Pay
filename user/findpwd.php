<?php
include("../shepay/common.php");
if($conf['web_is']==1)sysmsg($conf['web_offtext']);
if($conf['web_is']==2)sysmsg($conf['web_offtext']);
if($conf['is_reg']==0)sysmsg($conf['reg_offtext']);
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta content="auth.ooeecc.cn,<?php echo $conf['web_name']?>,都潮汇系统-最专业的易支付系统" name="description" />
    <meta name="author" content="m6e6.cn" />
    <title>商户信息找回 | <?php echo $conf['web_name']?></title>
    <link href="//shepay.ayunx.com/user/css/app.min.css" rel="stylesheet" type="text/css">
</head>
<body class="authentication-bg">
    <div class="account-pages mt-5 mb-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card">
                        <!-- Logo -->
                        <div class="card-header pt-4 pb-4 text-center bg-primary">
                            <span><font color="white" size="5"><b><?php echo $conf['web_name']?></b></font></span>
                        </div>
                        <div class="card-body p-4">
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 font-weight-bold">验证邮箱找回密钥</h4>
                            </div>
                            <form action="#">
                                <div class="form-group">
                                    <label for="emailaddress">请认真确认您所填写的邮箱地址</label>
                                    <input class="form-control" type="email" name="email" required="" placeholder="请输入您绑定的邮箱地址">
                                </div>
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-primary" type="button" id="submit" ng-click="login()" ng-disabled="form.$invalid">发送找回邮件</button>
                                </div>
                            </form>
                        </div> 
						<!-- end card -->
                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted">已经找回? <a href="login.php" class="text-dark ml-1"><b>返回登录</b></a></p>
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
        Copyright &copy; 2016-<?=date('Y')?> <?php echo $conf['web_name']?> - <?php echo $_SERVER['SERVER_NAME']?>
    </footer>
<script src="//shepay.ayunx.com/admin/js/app.min.js"></script>
<script src="//cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
<script src="//shepay.ayunx.com/assets/layer/layer.js"></script>
<script>
$(document).ready(function(){
    $("#submit").click(function(){
        if ($(this).attr("data-lock") === "true") return;
        var email=$("input[name='email']").val();
        if(email==''){layer.alert('邮箱不能为空！');return false;}
        var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/;
        if(!reg.test(email)){layer.alert('邮箱格式不正确！');return false;}
        var ii = layer.load(2, {shade:[0.1,'#fff']});
        $.ajax({
            type : "POST",
            url : "ajax.php?act=find",
            data : {email:email},
            dataType : 'json',
            success : function(data) {
                layer.close(ii);
                if(data.code == 0){
                    layer.msg('发送成功，请注意查收！');
                }else{
                    layer.alert(data.msg);
                }
            }
        });
    })
});
</script>
</body>
</html>