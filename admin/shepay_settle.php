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
$title='结算操作';
include './shepay_head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
?>
<?php

?>
      <div class="card card-primary">			

<div class="card-header"><h3 class="panel-title">结算列表下载</h3></div>
        <div class="card-body">
<?php
if(isset($_GET['batch'])){
	$batch=$_GET['batch'];
	$allmoney=$_GET['allmoney'];
	$count=$DB->query("SELECT * from pay_settle where batch='$batch'")->rowCount();
	$srow=$DB->query("SELECT * FROM pay_batch WHERE batch='{$batch}' limit 1")->fetch();
	if($srow['status']==0){
		$rs=$DB->query("SELECT * from pay_settle where batch='$batch'");
		while($row = $rs->fetch())
		{
			$dcmoney=$row['money']+$row['fee'];
			$DB->exec("update `pay_user` set `money`=`money`-'{$dcmoney}',`apply`='0' where `id`='{$row['pid']}'");
			$DB->exec("update `pay_settle` set `status`='1' where `id`='{$row['id']}'");
		}
		$DB->exec("update `pay_batch` set `status`='1' where `batch`='{$batch}'");
	}
?>
          <form action="shepay_download.php" method="get" role="form">
		  <input type="hidden" name="batch" value="<?php echo $batch?>"/>
		  <input type="hidden" name="allmoney" value="<?php echo $allmoney?>"/>
			<p>当前需要结算的共有<?php echo $count?>条记录</p>
			<p>批次号：<?php echo $batch?></p>
			<p>总金额：<?php echo $allmoney?>元</p>
            <p><input type="submit" value="下载CSV文件" class="btn btn-primary form-control"/></p><br/>
          </form>
		  <form action="shepay_transfer.php" method="get" role="form">
		  <input type="hidden" name="batch" value="<?php echo $batch?>"/>
            <p><input type="submit" value="单笔转账到支付宝账户" class="btn btn-success form-control"/></p><br/>
          </form>
		  <form action="shepay_wxtransfer.php" method="get" role="form">
		  <input type="hidden" name="batch" value="<?php echo $batch?>"/>
            <p><input type="submit" value="微信企业付款" class="btn btn-success form-control"/></p>
          </form>
<?php }else{?>
		<div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>批次号</th><th>总金额</th><th>生成时间</th><th>状态</th><th>操作</th></thead>
          <tbody>
<?php
$rs=$DB->query("SELECT * FROM pay_batch WHERE 1 order by time desc limit 10");
while($res = $rs->fetch())
{
echo '<tr><td><b>'.$res['batch'].'</b></td><td>'.$res['allmoney'].'</td><td>'.$res['time'].'</td><td>'.($res['status']==1?'<font color=green>已完成</font>':'<font color=red>未完成</font>').'</td><td><a href="./shepay_settle.php?batch='.$res['batch'].'&allmoney='.$res['allmoney'].'" class="btn btn-xs btn-info" onclick="return confirm(\'是否确定生成本批次结算列表？\');">生成结算列表</a></td></tr>';
}
?>
		  </tbody>
        </table>
<?php }?>
		<div class="panel-footer">
      <center>结算标准：金额大于<?php echo $conf['settle_money']?>元，需扣除<?php $a=100;$b=$conf['settle_rate'];echo $a*$b?>%手续费<br/>
		  结算列表请勿重复生成，CSV文件可以重复下载！
        </div>
      </div>
    </div>
  </div>