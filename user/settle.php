<?php
include("../shepay/common.php");
if($islogin2==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$title='结算记录';
include './head.php';
?>
<?php
$numrows=$DB->query("SELECT * from pay_settle WHERE pid={$pid}")->rowCount();
$pagesize=365;
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
$list=$DB->query("SELECT * FROM pay_settle WHERE pid={$pid} order by id desc limit $offset,$pagesize")->fetchAll();
?>
    <div class="main-panel">
     <div class="content">
       <div class="container-fluid">
         <h4 class="page-title"><?php echo $conf['web_name']?> - 会支付会生活</h4>
          <div class="row">
            <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">您有<?php echo $numrows?>条结算记录(显示近365条)</div>
                  </div>
                  <div class="card-bodyorder">
                    <table class="table table-head-bg-primary">
                      <thead><tr><th>ID</th><th>结算账号</th><th>结算金额</th><th>手续费</th><th>结算时间</th><th>状态</th></tr></thead>
                      <tbody>
                        <?php
                      foreach($list as $res){
                        echo '<tr><td>'.$res['id'].'</td><td>'.$res['account'].'</td><td>￥ <b>'.$res['money'].'</b></td><td>￥ <b>'.$res['fee'].'</b></td><td>'.$res['time'].'</td><td>'.($res['status']==1?'<font color=green>已完成</font>':'<font color=red>未完成</font>').'</td></tr>';
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