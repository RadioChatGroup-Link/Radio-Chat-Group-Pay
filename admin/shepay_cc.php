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
$title='CC防护模块配置-都潮汇系统独家原创功能';
include './shepay_head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
?>

<?php
if(isset($_POST['submit'])) {
	$defendid=$_POST['defendid'];
	$file="<?php\r\n//都潮汇系统原创防CC模块设置框架\r\ndefine('CC_Defender', ".$defendid.");\r\n?>";
	if(file_put_contents(SYSTEM_ROOT.'base.php',$file))showmsg('修改成功！',1);
    exit();
}
?>

  <!--站点内置CC防护模块-都潮汇系统独家原创功能，盗版必究-->
       <div class="card card-primary">	
		<div class="card-header"><h3 class="panel-title">CC防护模块配置</h3></div>
       <div class="card-body">
       <form action="./shepay_cc.php?mod=site_n" method="post" class="form-horizontal" role="form">
       <div class="form-group">
	   <label class="col-sm-4 control-label">CC防护等级：</label>
	   <div class="col-sm-auto"><select class="form-control" name="defendid" default="<?php echo CC_Defender;?>">
	   <option value="0">关闭</option>
	   <option value="1">低(推荐)</option>
	   <option value="2">中</option>
	   <option value="3">高</option>
	   </select></div>
	</div><br/>
	<div class="form-group">
	  <div class="col-sm-offset-2 col-sm-auto"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	  <hr>
	 </div>
</div>
<div class="panel-footer">
<span class="glyphicon glyphicon-info-sign"></span><b>CC防护说明：</b><br>
高：全局使用防CC，会影响站点支付、及用户体验，非迫不得已不推荐使用！<br>
中：会影响搜索引擎的收录，建议仅在正在受到中小型CC攻击且防御不佳时开启！<br>
低：对首次访问的用户的进行验证（推荐）
</div>
	</div>
  </form>
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