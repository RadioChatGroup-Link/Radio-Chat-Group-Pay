<?php
include("../shepay/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='用户中心';
include './head.php';
?>
<?php
$orders=$DB->query("SELECT count(*) from pay_order WHERE pid={$pid}")->fetchColumn();
$lastday=date("Ymd",strtotime("-1 day")).'00000000000';
$today=date("Ymd").'00000000000';
$order_today['all']=$DB->query("SELECT sum(money) from pay_order where pid={$pid} and status=1 and trade_no>='$today'")->fetchColumn();
$order_lastday['all']=$DB->query("SELECT sum(money) from pay_order where pid={$pid} and status=1 and trade_no>='$lastday' and trade_no<'$today'")->fetchColumn();
$order_today['alipay']=$DB->query("SELECT sum(money) from pay_order where pid={$pid} and status=1 and trade_no>='$today' and type='alipay'")->fetchColumn();
$order_today['qqpay']=$DB->query("SELECT sum(money) from pay_order where pid={$pid} and status=1 and trade_no>='$today' and type='qqpay'")->fetchColumn();
$order_today['wxpay']=$DB->query("SELECT sum(money) from pay_order where pid={$pid} and status=1 and trade_no>='$today' and type='wxpay'")->fetchColumn();
$order_lastday['alipay']=$DB->query("SELECT sum(money) from pay_order where pid={$pid} and status=1 and trade_no>='$lastday' and trade_no<'$today' and type='alipay'")->fetchColumn();
$order_lastday['qqpay']=$DB->query("SELECT sum(money) from pay_order where pid={$pid} and status=1 and trade_no>='$lastday' and trade_no<'$today' and type='qqpay'")->fetchColumn();
$order_lastday['wxpay']=$DB->query("SELECT sum(money) from pay_order where pid={$pid} and status=1 and trade_no>='$lastday' and trade_no<'$today' and type='wxpay'")->fetchColumn();
$rs=$DB->query("SELECT * from pay_settle where pid={$pid} and status=1");
$settle_money=0;
$max_settle=0;
$chart='';
$i=0;
while($row = $rs->fetch())
{
  $settle_money+=$row['money'];
  if($row['money']>$max_settle)$max_settle=$row['money'];
  if($i<9)$chart.='['.$i.','.$row['money'].'],';
  $i++;
}
$chart=substr($chart,0,-1);
if($conf['verifytype']==1 && empty($userrow['phone']))$alertinfo='您还没有绑定密保手机，请&nbsp;<a href="userinfo.php" class="btn btn-sm btn-info">尽快绑定</a>';
elseif(empty($userrow['email']))$alertinfo='您还没有绑定密保邮箱，请&nbsp;<a href="userinfo.php" class="btn btn-sm btn-info">尽快绑定</a>';
?>
<div class="wrapper-md control">
<?php if(isset($msg)){?>
<div class="alert alert-info">
  <?php echo $msg?>
</div>
<?php }?>
</div>
<!-- 用户中心模板原创自都潮汇系统，盗版狗必死 -->
    <div class="main-panel">
     <div class="content">
       <div class="container-fluid">
         <h4 class="page-title"><?php echo $conf['web_name']?> - 会支付会生活</h4>
         <div class="row">
           <div class="col-md-3"><div class="card card-stats card-warning"><div class="card-body "><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-smile-o"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">商户余额</p><h4 class="card-title">￥<?php echo $userrow['money']?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats card-danger"><div class="card-body "><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-bar-chart"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">订单总数</p><h4 class="card-title"><?php echo $orders?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats card-primary"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-calculator"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">已结算金额</p><h4 class="card-title">￥<?php echo $settle_money?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats card-success"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-css3"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">每笔订单费率</p><h4 class="card-title"><?php $a=100;$b=$conf['money_rate'];echo $a-$b?>%</h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats"><div class="card-body "><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-cc-paypal text-default"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">支付宝今日收入</p><h4 class="card-title">￥<?php echo round($order_today['alipay'],2)?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats"><div class="card-body "><div class="row"><div class="col-5"><div class="icon-big text-center icon-warning"><i class="la la-qq text-primary"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">QQ今日收入</p><h4 class="card-title">￥<?php echo round($order_today['qqpay'],2)?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats"><div class="card-body "><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-weixin text-success"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">微信今日收入</p><h4 class="card-title">￥<?php echo round($order_today['wxpay'],2)?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-cc-paypal text-info"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">支付宝昨日收入</p><h4 class="card-title">￥<?php echo round($order_lastday['alipay'],2)?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-qq text-warning"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">QQ昨日收入</p><h4 class="card-title">￥<?php echo round($order_lastday['qqpay'],2)?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-weixin text-danger"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">微信昨日收入</p><h4 class="card-title">￥<?php echo round($order_lastday['wxpay'],2)?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-area-chart"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">今日总收入</p><h4 class="card-title">￥<?php echo round($order_today['all'],2)?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><div class="card card-stats"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-area-chart text-primary"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><p class="card-category">昨日总收入</p><h4 class="card-title">￥<?php echo round($order_lastday['all'],2)?></h4></div></div></div></div></div></div>
           <div class="col-md-3"><a href="<?php echo $conf['sdk']?>"onclick="return confirm('您将要下载接口SDK文件，点击确定开始下载！')"><div class="card card-stats card-primary"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-soundcloud"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><h4 class="card-title">易支付SDK</h4></div></div></div></div></div></a></div>
           <div class="col-md-3"><a href="<?php echo $conf['chds']?>"onclick="return confirm('您将要下载彩虹代刷系统集成包文件，将文件覆盖到您站点根目录即可完成对接，点击确定开始下载！')"><div class="card card-stats card-primary"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-soundcloud"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><h4 class="card-title">彩虹代刷集成包</h4></div></div></div></div></div></a></div>
           <div class="col-md-3"><a href="<?php echo $conf['vhms']?>"onclick="return confirm('您将要下载VHMS系统集成包文件，将文件覆盖到您站点根目录即可完成对接，点击确定开始下载！')"><div class="card card-stats card-primary"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-soundcloud"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><h4 class="card-title">VHMS集成包</h4></div></div></div></div></div></a></div>
           <div class="col-md-3"><a href="<?php echo $conf['swapidc']?>"onclick="return confirm('您将要下载SWAP系统集成包文件，将文件覆盖到您站点根目录即可完成对接，点击确定开始下载！')"><div class="card card-stats card-primary"><div class="card-body"><div class="row"><div class="col-5"><div class="icon-big text-center"><i class="la la-soundcloud"></i></div></div><div class="col-7 d-flex align-items-center"><div class="numbers"><h4 class="card-title">SWAP集成包</h4></div></div></div></div></div></a></div>
         </div>
       <div class="row">
         <div class="col-md-12">
           <div class="card card-tasks">
             <div class="card-header ">
               <h4 class="card-title">官方公告信息版</h4>
             </div>
             <div class="card-bodyindex">
              <div class="table-full-width">
                <table class="table"><thead><tr><th>来自<?php echo $conf['web_name']?>的⑤条暖心公告</th><th>详情</th></tr></thead><tbody><tr><td><i class="la la-twitch"></i><?php echo substr($conf['gg1'],0,33);?>...</td><td class="td-actions text-right"><div class="form-button-action"><button type="button"data-toggle="modal"data-target="#aswlcm5gg1"title="点我查看详情"class="btn btn-link btn-simple-primary"data-original-title="点我查看详情"><i class="la la-user-secret"></i></button></div></td></tr><tr><td><i class="la la-twitch"></i><?php echo substr($conf['gg2'],0,33);?>...</td><td class="td-actions text-right"><div class="form-button-action"><button type="button"data-toggle="modal"data-target="#aswlcm5gg2"title="点我查看详情"class="btn btn-link btn-simple-primary"data-original-title="点我查看详情"><i class="la la-user-secret"></i></button></div></td></tr><tr><td><i class="la la-twitch"></i><?php echo substr($conf['gg3'],0,33);?>...</td><td class="td-actions text-right"><div class="form-button-action"><button type="button"data-toggle="modal"data-target="#aswlcm5gg3"title="点我查看详情"class="btn btn-link btn-simple-primary"data-original-title="点我查看详情"><i class="la la-user-secret"></i></button></div></td></tr><tr><td><i class="la la-twitch"></i><?php echo substr($conf['gg4'],0,33);?>...</td><td class="td-actions text-right"><div class="form-button-action"><button type="button"data-toggle="modal"data-target="#aswlcm5gg4"title="点我查看详情"class="btn btn-link btn-simple-primary"data-original-title="点我查看详情"><i class="la la-user-secret"></i></button></div></td></tr><tr><td><i class="la la-twitch"></i><?php echo substr($conf['gg5'],0,33);?>...</td><td class="td-actions text-right"><div class="form-button-action"><button type="button"data-toggle="modal"data-target="#aswlcm5gg5"title="点我查看详情"class="btn btn-link btn-simple-primary"data-original-title="点我查看详情"><i class="la la-user-secret"></i></button></div></td></tr></tbody></table>
              </div>
            </div>
           </div>
         </div>
        </div>
       </div>
     </div>
     <div class="modal fade"id="aswlcm5gg1"tabindex="-1"role="dialog"aria-labelledby="aswlcm"aria-hidden="true"><div class="modal-dialog modal-dialog-centered"role="document"><div class="modal-content"><div class="modal-header bg-primary"><h6 class="modal-title"><i class="la la-frown-o"></i> <?php echo $conf['web_name']?>官方公告①</h6><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><p><?=$conf['gg1']?></p></div><div class="modal-footer"><button type="button"class="btn btn-secondary"data-dismiss="modal">朕已阅</button></div></div></div></div>
     <div class="modal fade"id="aswlcm5gg2"tabindex="-1"role="dialog"aria-labelledby="aswlcm"aria-hidden="true"><div class="modal-dialog modal-dialog-centered"role="document"><div class="modal-content"><div class="modal-header bg-primary"><h6 class="modal-title"><i class="la la-frown-o"></i> <?php echo $conf['web_name']?>官方公告②</h6><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><p><?=$conf['gg2']?></p></div><div class="modal-footer"><button type="button"class="btn btn-secondary"data-dismiss="modal">朕已阅</button></div></div></div></div>
     <div class="modal fade"id="aswlcm5gg3"tabindex="-1"role="dialog"aria-labelledby="aswlcm"aria-hidden="true"><div class="modal-dialog modal-dialog-centered"role="document"><div class="modal-content"><div class="modal-header bg-primary"><h6 class="modal-title"><i class="la la-frown-o"></i> <?php echo $conf['web_name']?>官方公告③</h6><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><p><?=$conf['gg3']?></p></div><div class="modal-footer"><button type="button"class="btn btn-secondary"data-dismiss="modal">朕已阅</button></div></div></div></div>
     <div class="modal fade"id="aswlcm5gg4"tabindex="-1"role="dialog"aria-labelledby="aswlcm"aria-hidden="true"><div class="modal-dialog modal-dialog-centered"role="document"><div class="modal-content"><div class="modal-header bg-primary"><h6 class="modal-title"><i class="la la-frown-o"></i> <?php echo $conf['web_name']?>官方公告④</h6><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><p><?=$conf['gg4']?></p></div><div class="modal-footer"><button type="button"class="btn btn-secondary"data-dismiss="modal">朕已阅</button></div></div></div></div>
     <div class="modal fade"id="aswlcm5gg5"tabindex="-1"role="dialog"aria-labelledby="aswlcm"aria-hidden="true"><div class="modal-dialog modal-dialog-centered"role="document"><div class="modal-content"><div class="modal-header bg-primary"><h6 class="modal-title"><i class="la la-frown-o"></i> <?php echo $conf['web_name']?>官方公告⑤</h6><button type="button"class="close"data-dismiss="modal"aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body text-center"><p><?=$conf['gg5']?></p></div><div class="modal-footer"><button type="button"class="btn btn-secondary"data-dismiss="modal">朕已阅</button></div></div></div></div>
    <!-- 主页结束 -->
<?php include 'foot.php';?>