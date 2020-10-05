<?php
include("../shepay/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='推广返利';
include 'head.php';
?>
<?php
if($conf['tgfl_is']==0){
			exit("<script language='javascript'>alert('本站管理员暂未开启推广返利功能，如有疑问请联系客服！');history.go(-1);</script>");
		}
?>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
  <?php echo $msg?>
</div>
<?php }?>
</div>
  <div class="main-panel">
    <div class="content">
      <div class="container-fluid">
        <h4 class="page-title"><?php echo $conf['web_name']?> - 会支付会生活</h4>
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <div class="card-title">我的推广详情</div>
              </div>
              <div class="card-body">
                <div class="form-groupas">
                	<label>您的推广链接</label>
                	<div class="input-group">
                		<input type="text" class="form-control" value="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/user/reg.php?tgid='.$pid; ?>" disabled="">
                	</div>
                </div>
				<div class="form-groupas">
                	<label>推广成功统计</label>
                	<div class="form-groupas has-success">
                		<input type="text" class="form-control" value="您已成功推广<?php echo $userrow['tgrs']?>位小伙伴，共计返利<?php echo $userrow['gjfl']?>元" disabled="">
                	</div>
                </div>
                <div class="form-groupas">
                 推广佣金说明<br>
                <font color="#ff0000">须知：</font>只要有商户通过您的推广链接成功注册，您将获得<?php echo $conf['tgye']?>元佣金，推广获得的佣金都是实时到账您的余额的！<br>
                  <font color="#ff0000">推广：</font>将您的推广链接分享到QQ、贴吧、社区、论坛、博客。<br>
                  <font color="#ff0000">说明：</font>虽然显得有些微不足道，但是日积夜累，积少成多，您动动手指就能赚到的钱还需要纠结？别犹豫快上车。
                </div>
            </div>
              </div>
          </div>
        </div>
              </div>
          </div>
  </div>
              </div>
          </div>
         
<?php include 'foot.php';?>