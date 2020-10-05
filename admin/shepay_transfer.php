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
if(isset($_GET['reset'])){
	$batch=$_GET['batch'];
	unset($_SESSION['privatekey']);
	exit("<script language='javascript'>window.location.href='./shepay_transfer.php?batch={$batch}';</script>");
}elseif(isset($_POST['batch']) && isset($_POST['privatekey'])){
	$batch=$_POST['batch'];
	if(strlen($_POST['privatekey'])<100)exit("<script language='javascript'>alert('商户私钥不正确');history.go(-1);</script>");
	$_SESSION['privatekey']=$_POST['privatekey'];
	exit("<script language='javascript'>window.location.href='./shepay_transfer.php?batch={$batch}';</script>");
}elseif(isset($_GET['batch']) && isset($_SESSION['privatekey'])){
	$batch=$_GET['batch'];
	$count=$DB->query("SELECT * from pay_batch where batch='$batch'")->rowCount();
	if($count<1)showmsg('批次号不存在');
	$list=$DB->query("SELECT * FROM pay_settle WHERE batch='{$batch}' and type=1")->fetchAll();

?>
<script>
function SelectAll(chkAll) {
	var items = $('.uins');
	for (i = 0; i < items.length; i++) {
		if (items[i].id.indexOf("uins") != -1) {
			if (items[i].type == "checkbox") {
				items[i].checked = chkAll.checked;
			}
		}
	}
}
function Transfer(){
	var url="shepay_transfer_do.php";
	$("input[name=uins]:checked:first").each(function(){
		var checkself=$(this);
		var id=checkself.val();
		var statusself=$('#id'+id);
		statusself.html("<img src='//shepay.ayunx.com/assets/img/load.gif' height=22>");
		xiha.postData(url,'id='+id, function(d) {
			if(d.code==0){
				transnum++;
				var num = $('#hydx').text();
				num=parseInt(num);
				num++;
				$('#hydx').text(num);
				if(d.ret==1){
					statusself.html('<font color="green">成功</font>');
				}else if(d.ret==2){
					statusself.html('<font color="green">已完成</font>');
				}else{
					statusself.html('<font color="red">失败</font>');
				}
				$('#res'+id).html('<font color="blue">'+d.result+'</font>');
				checkself.attr('checked',false);
				Transfer();
			}else if(d.code==-1){
				statusself.html('<font color="red">失败</font>');
				alert(d.msg);
			}else{
				statusself.html('<font color="red">失败</font>');
			}
		});
		return true;
	});
}
var transnum = 0;
$(document).ready(function(){
	var allmoney = 0;
	var items = $('.money');
	for (i = 0; i < items.length; i++) {
		allmoney+=parseFloat(items[i].innerHTML);
	}
	$('#allmoney').html('总金额:'+allmoney.toFixed(2));
	$('#startsend').click(function(){
		var self=$(this);
		if (self.attr("data-lock") === "true") return;
			else self.attr("data-lock", "true");
		self.html('正在转账中');
		Transfer();
		if(transnum<1) self.html('没有待转账的记录');
		else self.html('转账处理完成');
		self.attr("data-lock", "false");
	});
	$('.recheck').click(function(){
		var self=$(this),
			id=self.attr('uin');
		var url="shepay_transfer_do.php";
		self.html("<img src='//shepay.ayunx.com/assets/img/load.gif' height=22>");
		xiha.postData(url,'id='+id, function(d) {
			if(d.code==0){
				if(d.ret==1){
					self.html('<font color="green">成功</font>');
				}else if(d.ret==2){
					self.html('<font color="green">已完成</font>');
				}else{
					self.html('<font color="red">失败</font>');
				}
				$('#res'+id).html('<font color="blue">'+d.result+'</font>');
				$('.uins[value='+id+']').attr('checked',false);
				self.removeClass('nocheck');
			}else if(d.code==-1){
				self.html('<font color="red">失败</font>');
				alert(d.msg);
			}else{
				self.html('<font color="red">失败</font>');
			}
		});
	});
});
var xiha={
	postData: function(url, parameter, callback, dataType, ajaxType) {
		if(!dataType) dataType='json';
		$.ajax({
			type: "POST",
			url: url,
			async: true,
			dataType: dataType,
			json: "callback",
			data: parameter,
			success: function(data,status) {
				if (callback == null) {
					return;
				}
				callback(data);
			},
			error: function(error) {
				//alert('创建连接失败');
			}
		});
	}
}
</script>
<div class="card card-primary">

<div class="card-header">
		<div class="panel-title">
			<div class="input-group" style="padding:8px 0;">
				<div class="input-group-addon btn">全选<input type="checkbox" onclick="SelectAll(this)" /></div>
				<div class="input-group-addon btn" id="startsend">点此开始转账</div>
				<div class="input-group-addon btn"><span onclick="window.location.href='shepay_transfer.php?reset=1&batch=<?php echo $batch?>'">重置商户私钥</span></div>
				<div class="input-group-addon btn"><span id="allmoney">总金额</span></div>
			</div>
			<div id="result"></div>
		</div>
	</div>
</div>

<div class="card card-primary">

<div class="card-header">
	<table class="table table-bordered table-condensed">
		<tbody>
			<tr>
			<td align="center"><span style="color:silver;"><b>ID</b></span></td>
			<td align="center"><span style="color:silver;"><b>商户ID</b></span></td>
			<td align="center"><span style="color:silver;"><b>结算账号</b></span></td>
			<td align="center"><span style="color:silver;"><b>结算姓名</b></span></td>
			<td align="center"><span style="color:silver;"><b>金额</b></span></td>
			<td align="center"><span style="color:silver;"><b>操作</b></span></td>
			</tr>
			<?php
			echo '<tr><td colspan="6" align="center">总共<span id="hyall">'.count($list).'<span>个记录,已经处理<span id="hydx">0</span>个记录！</td></tr>';
			foreach($list as $row) {
			echo '<tr><td uin="'.$row['id'].'"><input name="uins" type="checkbox" id="uins" class="uins" value="'.$row['id'].'" '.($row['transfer_status']!=1?'checked':null).'>'.$row['id'].'</td><td>'.$row['pid'].'</td><td>'.$row['account'].'</td><td>'.$row['username'].'</td><td class="money">'.$row['money'].'</td><td id="id'.$row['id'].'" uin="'.$row['id'].'" class="nocheck recheck" align="center">'.($row['transfer_status']!=1?'<span class="btn btn-xs btn-block btn-primary">立即转账</span>':'<font color="green">已完成</font>').'</td></tr><tr><td><span style="color:silver;">结果</span></td><td colspan="5" id="res'.$row['id'].'"><font color="blue">'.($row['transfer_status']==1?'支付宝转账单据号:'.$row['transfer_result'].' 支付时间:'.$row['transfer_date']:$row['transfer_result']).'</font></td></tr>';
			}
			?>
		</tbody>
	</table>
</div>
</div>
    </div>
<?php }elseif(isset($_GET['batch'])){
$batch=$_GET['batch'];
?>
	<div class="card card-primary">
<div class="card-header">
      <div class="panel panel-primary">
        <div class="card-heading"><h3 class="panel-title">批量转账到支付宝</h3></div>
          <div class="card-body box">
			<form action="shepay_transfer.php" method="post"><input type="hidden" name="batch" value="<?php echo $batch?>"/>
			<div class="form-group">
			<label>商户私钥：</label><br>
			<textarea class="form-control" name="privatekey" rows="4" placeholder="填写商户私钥" required></textarea>
			</div>
			<div class="form-group text-right">
			<button type="submit" class="btn btn-primary btn-block" id="save">保存</button>
			</div>
			</form>
		</div>
      </div>
    </div>

<?php }?>
  </div>