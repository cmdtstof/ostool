
<link type="text/css" rel="stylesheet" href="../css/common.css" />
<script type="text/javascript" src = "../js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src = "../js/common.js"></script>
<?php
header('Content-type: text/html;charset=GB2312');
if(!isset($_GET['action'])){
}else if($_GET['action']=='detail')
{
?>
<input type="hidden" id="table" name="table" value="<?php 
	if(!isset($_GET['table'])){
	echo"";
	}else{
	$str=urldecode($_GET["table"]);
	$str =iconv("UTF-8","GBK",$str); //����ת��
	echo $str;
	}?>"/>
<input type="hidden" id="name" name="name" value="<?php 
	if(!isset($_GET['name'])){
	echo"";
	}else{
	$str=urldecode($_GET["name"]);
	$str =iconv("UTF-8","GBK",$str); //����ת��
	echo $str;
	}?>"/>
<input type="hidden" id="account" name="account" value="<?php 
	if(!isset($_GET['account'])){
	echo"";
	}else{
	$str=urldecode($_GET["account"]);
	$str =iconv("UTF-8","GBK",$str); //����ת��
	echo $str;
	}?>"/>
<input type="hidden" id="card_iid" name="card_iid" value="<?php 
	if(!isset($_GET['card_iid'])){
	echo"";
	}else{
	$str=urldecode($_GET["card_iid"]);
	$str =iconv("UTF-8","GBK",$str); //����ת��
	echo $str;
	}?>"/>

<input type="hidden" id="item_iid" name="item_iid" value="<?php 
	if(!isset($_GET['item_iid'])){
	echo"";
	}else{
	$str=urldecode($_GET["item_iid"]);
	$str =iconv("UTF-8","GBK",$str); //����ת��
	echo $str;
	}?>"/>
<input type="hidden" id="update_time" name="update_time" value="<?php 
	if(!isset($_GET['update_time'])){
	echo"";
	}else{
	$str=urldecode($_GET["update_time"]);
	$str =iconv("UTF-8","GBK",$str); //����ת��
	echo $str;
	}?>"/>
<script type="text/javascript">
var d = "action=search&table="+$('#table').val()+"&name="+$('#name').val()+"&account="+$('#account').val()+"&card_iid="+$('#card_iid').val()+"&item_iid="+$('#item_iid').val()+"&update_time="+$('#update_time').val();

$.ajax({
			type:'POST',
			url:'logDao.php',
			data:encodeURI(encodeURI(d)),
			timeout:timeout,
			error:function (data){alert("ϵͳ��æ�����Ժ�����");},
			success:function(result){
				$("#tableshow3").html(result);
			}
			
});
</script>
<?php

}
?>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">��ϸ</legend>
<div id="tableshow3" style="width:98%;">���ݼ�����...</div>
</fieldset>