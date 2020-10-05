<?php
include("../shepay/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='订单记录';
include './head.php';
?>
<?php
function do_callback($data){
  global $DB,$userrow;
  if($data['status']>=1)$trade_status='TRADE_SUCCESS';
  else $trade_status='TRADE_FAIL';
  $array=array('pid'=>$data['pid'],'trade_no'=>$data['trade_no'],'out_trade_no'=>$data['out_trade_no'],'type'=>$data['type'],'name'=>$data['name'],'money'=>$data['money'],'trade_status'=>$trade_status);
  $arg=argSort(paraFilter($array));
  $prestr=createLinkstring($arg);
  $urlstr=createLinkstringUrlencode($arg);
  $sign=md5Sign($prestr, $userrow['key']);
  if(strpos($data['notify_url'],'?'))
    $url=$data['notify_url'].'&'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
  else
    $url=$data['notify_url'].'?'.$urlstr.'&sign='.$sign.'&sign_type=MD5';
  return $url;
}
if(!empty($_GET['type']) && !empty($_GET['kw'])) {
  $kw=daddslashes($_GET['kw']);
  if($_GET['type']==1)$sql=" and trade_no='$kw'";
  elseif($_GET['type']==2)$sql=" and out_trade_no='$kw'";
  elseif($_GET['type']==3)$sql=" and name='$kw'";
  elseif($_GET['type']==4)$sql=" and money='$kw'";
  elseif($_GET['type']==5)$sql=" and type='$kw'";
  else $sql="";
  $link='&type='.$_GET['type'].'&kw='.$_GET['kw'];
}else{
  $sql="";
  $link='';
}
$numrows=$DB->query("SELECT count(*) from pay_order WHERE pid={$pid}{$sql}")->fetchColumn();
$pagesize=200;
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
$list=$DB->query("SELECT * FROM pay_order WHERE pid={$pid}{$sql} order by trade_no desc limit $offset,$pagesize")->fetchAll();
?>
    <div class="main-panel">
     <div class="content">
       <div class="container-fluid">
         <h4 class="page-title"><?php echo $conf['web_name']?> - 会支付会生活</h4>
          <div class="row">
            <div class="col-lg-6">
              <form class="form-inline">
                <select name="type" class="form-control mb-2 mr-sm-2">
                  <option value="1">交易号</option>
                  <option value="2">商户订单号</option>
                  <option value="3">商品名称</option>
                  <option value="4">商品金额</option>
                  <option value="5">支付方式</option>
                </select>
                <input type="text" class="form-control mb-2 mr-sm-2" name="kw" placeholder="搜索内容">
                <button type="submit" class="btn btn-primary btn-round mb-2">搜索</button>
              </form>
            </div>
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">您有<?php echo $numrows?>条订单记录(显示近200条)</div>
                  </div>
                  <div class="card-bodyorder">
                    <table class="table table-head-bg-primary">
                      <thead><tr><th>交易号/商户订单号</th><th>商品名称</th><th>商品金额</th><th>支付方式</th><th>创建时间/完成时间</th><th>状态</th><th>操作</th></tr></thead>
                      <tbody>
                        <?php
                      foreach($list as $res){
                      echo '<tr><td>'.$res['trade_no'].'<br/>'.$res['out_trade_no'].'</td><td>'.$res['name'].'</td><td>￥ <b>'.$res['money'].'</b></td><td> <b>'.$res['type'].'</b></td><td>'.$res['addtime'].'<br/>'.$res['endtime'].'</td><td>'.($res['status']==1?'<font color=green>已完成</font>':'<font color=red>未完成</font>').'</td><td><a href="'.do_callback($res).'" target="_blank" rel="noreferrer">重新通知</a></td></tr>';
                    }?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
      <!-- 主页结束 -->
<?php include 'foot.php';?>