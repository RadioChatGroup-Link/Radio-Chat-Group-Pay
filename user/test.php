<?php
include("../shepay/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='测试支付';
include './head.php';
?>
    <div class="main-panel">
     <div class="content">
       <div class="container-fluid">
        <h4 class="page-title"><?php echo $conf['web_name']?> - 会支付会生活</h4>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">测试支付</h4>
                  <p class="card-description">
                    <?php echo $conf['web_name']?>感谢有您~
                  </p><hr>
                  <form class="forms-sample" name=alipayment action=test/epayapi.php method=post target="_blank">
                    <div class="form-groupas">
                      <label>商户ID</label>
                      <input class="form-control" name="id" value="<?php echo $pid?>" placeholder="商户ID">
                    </div>
                    <div class="form-groupas">
                      <label>商户密钥</label>
                      <input name="key" class="form-control" value="<?php echo $userrow['key']?>" placeholder="商户密钥">
                    </div>
                    <div class="form-groupas">
                      <label>商户订单号</label>
                      <input name="WIDout_trade_no" class="form-control" value="<?php echo date("YmdHis").mt_rand(100,999); ?>" placeholder="商户订单号">
                    </div>
                    <div class="form-groupas">
                      <label>商品名称</label>
                      <input name="WIDsubject" class="form-control" value="<?php echo $conf['web_name']?>余额充值" placeholder="<?php echo $conf['web_name']?>余额充值" required="required">
                    </div>
                    <div class="form-groupas">
                      <label>付款金额</label>
                      <input name="WIDtotal_fee" class="form-control" value="1" placeholder="付款金额" required="required">
                    </div>
                    <div class="card-action" style="text-align: center;">
                      <input type="submit" class="btn btn-danger" value="确认付款进行测试">
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
        <!-- 主页结束 -->
<?php include 'foot.php';?>