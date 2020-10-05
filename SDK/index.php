<?php
include("../shepay/common.php");
if($conf['sdk_is']==0)sysmsg('在线测试支付页面已关闭，如有疑问请联系站点管理员！');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<head>
	<title><?php echo $conf['web_name']?> - 免签支付测试</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet"/>
      <link rel="stylesheet" href="https://css.letvcdn.com/lc04_yinyue/201612/19/20/00/bootstrap.min.css">
  <script src="//cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
  <link rel="icon" href="//www.71idc.cn/favicon.ico"  type="image/x-icon">
  <script src="//cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
      <div class="panel panel-primary">
        <div class="panel-body">
        <form name=alipayment action=epayapi.php method=post target="_blank">
            <div class="input-group">			 
              <span class="input-group-addon">商户ID</span>
			   <input size="30" name="id" value="<?php echo $pid?>"  class="form-control" placeholder="商户ID" />
			   </div>
			<br/>
            <div class="input-group">			 
              <span class="input-group-addon">商户密钥</span>
			   <input size="30" name="key" value="<?php echo $userrow['key']?>"  class="form-control" placeholder="商户密钥" />
			   </div>
			<br/>
            <div class="input-group">			 
              <span class="input-group-addon">商户订单号</span>
			   <input size="30" name="WIDout_trade_no" value="<?php echo date("YmdHis").mt_rand(100,999); ?>"  class="form-control" placeholder="商户订单号" />
			   </div>
			<br/>
			<div class="input-group">
              <span class="input-group-addon">商品名称</span>
              <input size="30" name="WIDsubject" value="测试商品" class="form-control" placeholder="商品名称" required="required" />			   
            </div>
			<br/>
			<div class="input-group">
              <span class="input-group-addon">付款金额</span>
              <input size="30" name="WIDtotal_fee" value="0.01" class="form-control" placeholder="付款金额" required="required"/>			        			        
            </div>        			
<br/>
					<dt></dt>
                    <dd>
                        <span class="new-btn-login-sp">
<input type="submit" class="btn btn-info btn-block" value="确定"></form>
                        </span>
                    </dd>
                </dl>
            </div>
		</form>