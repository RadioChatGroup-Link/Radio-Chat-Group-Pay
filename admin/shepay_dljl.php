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
$title='登录记录';
include './shepay_head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
?>
<div class="card card-primary">	
			<div class="card-header">
<?php
if($my=='search') {
	$sql=" `{$_GET['column']}`='{$_GET['value']}'";
	$numrows=$DB->query("SELECT * from panel_log WHERE{$sql}")->rowCount();
	$con='包含 '.$_GET['value'].' 的共有 <b>'.$numrows.'</b> 个登陆记录';
	$link='&my=search&column='.$_GET['column'].'&value='.$_GET['value'];
}else{
	$numrows=$DB->query("SELECT * from panel_log WHERE 1")->rowCount();
	$sql=" 1";
	$con='共有 <b>'.$numrows.'</b> 个登陆记录';
}
echo $con;
?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>登陆ID</th><th>登陆操作</th><th>登录时间</th><th>登陆地点</th><th>登陆IP</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
{
 $pages++;
 }
if (isset($_GET['page'])){
$page=intval($_GET['page']);
}
else{
$page=1;
}
$offset=$pagesize*($page - 1);

$rs=$DB->query("SELECT * FROM panel_log WHERE{$sql} order by id desc limit $offset,$pagesize");
while($res = $rs->fetch())
{
echo '<tr><td><b>'.$res['id'].'</b></td><td>'.$res['uid'].'</td><td>'.$res['type'].'</td><td>'.$res['date'].'</td><td>'.$res['city'].'</td><td>'.$res['data'].'</td></td></tr>';
}
?>
          </tbody>
        </table>
      </div>
			<?php
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="shepay_dljl.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="shepay_dljl.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="shepay_dljl.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$pages;$i++)
echo '<li><a href="shepay_dljl.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="shepay_dljl.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="shepay_dljl.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页

?>
    </div>
  </div>