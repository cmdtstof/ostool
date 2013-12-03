<script type="text/javascript" src="js/jquery-1.6.2.min.js"></script>
<script
	type="text/javascript" src="js/common.js"></script>
<script type="text/javascript">
	function search22(host,port,linename,divname){
		var d = "host="+host+"&port="+port+"&linename="+linename;
		$.ajax({
			type:'POST',
			url:'linelink.php',
			data:encodeURI(encodeURI(d)),
			timeout:30000,
			error:function (data){
				//alert("系统繁忙，请稍后再试");
				},
			success:function(result){
				$("#"+divname).html(result);
			}
			
		});
    }
</script>

检测时间:<?php date_default_timezone_set("PRC");echo date("Y-m-d H:i:s",time());?>
<HR/>
<?php
header('Content-type: text/html;charset=gbk');
error_reporting(E_ERROR);
require './utils/iniUtils.php';
$lineset = new Settings_INI;
$lineset->load('serverline.ini');



//登控部分
$host = $lineset->get("login.ip");
$port = $lineset->get("login.port");
$linename =$lineset->get("login.linename");
echo $linename.'['.$host.':'.$port.']';
?>
<lable id="dengkongshow" name="dengkongshow"><font color="#ff6801" >连接中....</font><br/>
</lable>
<script type="text/javascript">search22('<?php echo $host;?>','<?php echo $port;?>','<?php echo $linename;?>',"dengkongshow");</script>
<?php
ob_flush();
flush();

// 新手场

$i=1;
while (true){
	$host = $lineset->get("newline".$i.".ip");
	$port = $lineset->get("newline".$i.".port");
	$linename =$lineset->get("newline".$i.".linename");
	if($host==''){
		break;
	}
	$i++;
	//lineceshi($host,$port,$linename);
	echo $linename.'['.$host.':'.$port.']';
	?>
<lable id="xinshou<?php echo $i;?>" name="xinshou<?php echo $i;?>"><font color="#ff6801" >连接中....</font><br/>
</lable>
<script type="text/javascript">search22('<?php echo $host;?>','<?php echo $port;?>','<?php echo $linename;?>',"xinshou"+'<?php echo $i;?>');</script>
	<?php
	ob_flush();
	flush();

}

// 普通场

$i=1;
while (true){
	$host = $lineset->get("commonline".$i.".ip");
	$port = $lineset->get("commonline".$i.".port");
	$linename =$lineset->get("commonline".$i.".linename");
	if($host==''){
		break;
	}
	$i++;
	//lineceshi($host,$port,$linename);
	echo $linename.'['.$host.':'.$port.']';
	?>
<lable id="common<?php echo $i;?>" name="common<?php echo $i;?>"><font color="#ff6801" >连接中....</font><br/>
</lable>
<script type="text/javascript">search22('<?php echo $host;?>','<?php echo $port;?>','<?php echo $linename;?>',"common"+'<?php echo $i;?>');</script>
	<?php
	ob_flush();
	flush();
}

?>
<hr/>