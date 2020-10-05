<?php
$mod='blank';
include("../shepay/common.php");
$title='都潮汇-检查版本更新';
include './shepay_head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
?>

<?php
	if($islogin == 1){
	}else{
		exit("<script language='javascript'>window.location.href='./shepay_login.php';</script>");
	}
	//解压函数
	function zipExtract ($src,$dest){
		$zip=new ZipArchive();
		if($zip->open($src)===true){
			$zip->extractTo($dest);
			$zip->close();
			return true;
		}
		return false;
	}
?>
			<div class="card card-primary">	
			
			<div class="card-header">
			<h3 class="panel-title">都潮汇-检查版本更新</h3></div>
					<div class="card-body">
<?php 
					$do=isset($_GET['do'])?$_GET['do']:null;
					switch($do){
						default:
							$res=update_version();
							echo '<div class="alert alert-info">'.$res['msg'].'</div>';
							echo '<hr/>';
							if($res['code']==1){//正版 且系统需要更新
								if(!class_exists('ZipArchive') || defined("SAE_ACCESSKEY") || defined("BAE_ENV_APPID")){
									echo '您的空间不支持自动更新，请手动下载更新包并覆盖到程序根目录！<br/>更新包下载：<a href="'.$res['file'].'" style="background:linear-gradient(to right,#b221ff,#14b7ff);" class="btn btn-primary btn-block"><font color="white">点击下载</font></a><br>';//手动下载
								}else{
									echo '<a href="shepay_update.php?act=set-update&do=do" style="background:linear-gradient(to right,#b221ff,#14b7ff);" class="btn btn-primary btn-block"><font color="white">立即更新到最新版本</a></font>';//在线更新
								}
								echo '<hr/><div class="well"></div>';
							}elseif($res['code']==0){//正版不需要更新
							}
						break;
						//楼下数据库 楼上程序自身
						case 'do':
							$res=update_version();
							$RemoteFile=$res['file'];//程序更新包
							//file_put_contents(ROOT.'admin/shupdate.zip',file_get_contents($res['file']));
							//exit();
							$ZipFile="./shupdate.zip";//下载到的临时文件
							copy($RemoteFile,$ZipFile) or die("无法下载更新包文件！".'<a href="shepay_update.php?act=set-update">返回上级</a>');
							echo '<p>程序下载成功</p>';	
							include(SYSTEM_ROOT."/pclzip.php"); 						
							$zip = new ZipArchive;
							if($zip->open('./shupdate.zip') && $zip->extractTo('../')){
								echo '<p>程序解压成功</p>';
							}else{
								echo '<p>程序解压失败</p>';
							}
							if($res['code_sql']==1){//正版 且数据库需要更新
								if(!class_exists('ZipArchive') || defined("SAE_ACCESSKEY") || defined("BAE_ENV_APPID")){
									echo '您的空间不支持自动更新数据库，请手动下载数据库并导入数据库！<br/>数据库下载：<a href="'.$res['sql'].'" style="background:linear-gradient(to right,#b221ff,#14b7ff);" class="btn btn-primary btn-block"><font color="red">点击下载</font></a><br>';//手动下载
								}else{
									echo '<a href="shepay_update.php?act=set-update&do=sql" style="background:linear-gradient(to right,#b221ff,#14b7ff);" class="btn btn-primary btn-block"><font color="red">检测到您的数据库还要更新 点击继续更新</a></font><br>';//在线更新
								}
							}
						break;
						case 'sql':
							$res=update_version();
							$sql=file_get_contents('./update.sql');//数据库更新包
							$sql = explode(';', $sql);	
							/* print_r($sql);
							exit(); */
							$t=0;$e=0;$error='';
							for($i=0;$i<count($sql);$i++){
								if(trim($sql[$i])=='')continue;
								if($DB->query($sql[$i])){
									++$t;
								}else{
									++$e;
									$error.=$DB->error().'<br/>';
								}
							}			
							$e=$e-1;
							$addstr='数据库更新成功。SQL成功'.$t.'句/失败'.$e.'句';
							echo "<p>$addstr</p>";
						break;
					}
					echo '</div></div></div></div>';