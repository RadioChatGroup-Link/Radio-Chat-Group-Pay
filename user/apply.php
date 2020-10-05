<?php
include("../shepay/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='手动结算';
include './head.php';
?>
<?php
if($conf['settle_open']==0){
			exit("<script language='javascript'>alert('本站管理员暂未开启手动结算功能，如有疑问请联系客服！');history.go(-1);</script>");
		}
$today=date("Y-m-d").' 00:00:00';
$rs=$DB->query("SELECT * from pay_order where pid={$pid} and status=1 and endtime>='$today'");
$order_today=0;
while($row = $rs->fetch())
{
	$order_today+=$row['money'];
}
$enable_money=round($userrow['money']-$order_today*$conf['money_rate']/100,2);
if(isset($_GET['act']) && $_GET['act']=='do'){
	if($_POST['submit']=='申请手动结算'){
		if($userrow['apply']==1){
			exit("<script language='javascript'>alert('很抱歉，您今天已经申请过手动结算，每日仅可申请一次，请勿重复申请！');history.go(-1);</script>");
		}
		if($enable_money<$conf['sdtx_money_min']){
			exit("<script language='javascript'>alert('很抱歉，您当前的商户余额不满足本站可申请手动结算的最低金额设定标准！');history.go(-1);</script>");
		}
		if($userrow['type']==2){
			exit("<script language='javascript'>alert('很抱歉，您的商户出现异常，无法申请手动结算！');history.go(-1);</script>");
		}
		$sqs=$DB->exec("update `pay_user` set `apply` ='1' where `id`='$pid'");
		exit("<script language='javascript'>alert('恭喜您，申请手动结算成功，相关费率信息请看底部说明！');history.go(-1);</script>");
	}
}
?>
<div class="main-panel" id="situation" value="">
    <div id="content" class="app-content" role="main">
        <div class="app-content-body ">
            <div class="wrapper-md control">
                <?php if(isset($msg)){?>
                <div class="alert alert-info">
                    <?php echo $msg?>
                </div>
                <?php }?>
                <div class="content">
     	<div class="container-fluid">
     		<h4 class="page-title"><?php echo $conf['web_name']?> - 会支付会生活</h4>
     		<div class="row">
     			<div class="col-md-12">
     				<div class="card">
     					<div class="card-header">
     						<div class="card-title">申请手动结算</div>
     					</div>
     					<div class="card-body">
                                        <form class="form-horizontal devform" action="./apply.php?act=do" method="post">
                                            <div class="form-groupas has-error has-feedback">
                                                <label>当前商户结算账号</label>
                                                    <input class="form-control" type="text" value="<?php echo $userrow['account']?>" disabled>
                                                </div>
                                            <div class="form-groupas has-success">
                                                <label>当前商户结算姓名</label>
                                                    <input class="form-control" type="text" value="<?php echo $userrow['username']?>" disabled>
                                                </div>
                                          <div class="form-groupas has-success">
     						                	<label>当前商户余额</label>
     					                		<input type="text" class="form-control" value="￥<?php echo $userrow['money']?>" disabled>
     						                  </div>
												<div class="form-groupas has-success">
                                                <label>每日自动结算金额标准</label>
                                                    <input class="form-control" type="text" name="tmoney" value="商户余额满<?php echo $conf['settle_money']; ?>元，系统每日自动结算！" disabled>
                                                </div>
												<div class="form-groupas has-success">
                                                <label>申请手动结算金额标准</label>
                                                    <input class="form-control" type="text" name="tmoney" value="商户余额满<?php echo $conf['sdtx_money_min']; ?>元，才可申请手动结算！" disabled>
                                                </div>
												<div class="form-groupas">
									<input type="submit" name="submit" value="申请手动结算" class="btn btn-primary form-control">
                                                </div><hr>
												<div class="form-groupas">
                                                        <h4><span class="glyphicon glyphicon-info-sign"></span>前提条件、功能介绍及手续费说明</h4>
                                                        <font color="#ff0000">前提条件：</font>当商户余额达到本站<font color="#ff0000">“申请手动结算金额标准”</font>即可申请手动结算！<br>
                                                        <font color="#ff0000">功能介绍：</font>手动结算功能可以让您在急需结算但商户余额未达到<font color="#ff0000">“每日自动结算金额标准”</font>时向管理员申请结算！<br>
														<font color="#ff0000">手续费：</font>款项将扣除<?php $a=100;$b=$conf['settle_rate'];echo $a*$b?>%结算手续费后在T+1工作日内结算到您的指定账户中；若上述结算手续费未满本站最低结算手续费<font color="#ff0000"><?php echo $conf['settle_fee_min']; ?>元</font>，我们将按本站最低结算手续费设定扣除手续费<font color="#ff0000"><?php echo $conf['settle_fee_min']; ?>元</font>，请知悉！
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php include 'foot.php';?>