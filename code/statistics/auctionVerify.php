<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=GBK" />
<title></title>
<link type="text/css" rel="stylesheet" href="../css/common.css" />
<script type="text/javascript" src = "../js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src = "../js/common.js"></script>
<script type="text/javascript">
	function searchlog1(table){
		if($("#name").val()=="" && $("#account").val()==""){
			alert("请输入角色或账号");
			$("#name").focus();
			return ;
		}
		if($("#item_id").val()==""){
			alert("请输入物品ID");
			$("#item_id").focus();
			return ;
		}
		if($("#update_time").val()==""){
			alert("请输入查询时间，格式格式如‘2013-01-04 00:00:00’");
			$("#update_time").focus();
			return ;
		}
		if($("#update_time").val().length!=19){
			alert("时间格式错误，格式格式如‘2013-01-04 00:00:00’");
			$("#update_time").focus();
			return ;
		}
		var d = "action=search&table="+table+"&name="+$('#name').val()+"&account="+$('#account').val()+"&item_id="+$('#item_id').val()
		+ "&update_time="+$('#update_time').val();
		
		if($("#auction_id1").val()!=""){
			d += "&auction_id="+$("#auction_id1").val();
		}
		var search1 =document.getElementById("search1");
		search1.disabled="true";
		$.ajax({
			type:'POST',
			url:'logDao.php',
			data:encodeURI(encodeURI(d)),
			timeout:timeout,
			error:function (data){alert("系统繁忙，请稍后再试");},
			success:function(result){
				$("#tableshow1").html(result);
				search1.disabled="";
				trStyleChange();
			}
			
		});
    }
	function searchlog2(table){
		if($("#auction_id2").val()==""){
			alert("请输入订单号");
			$("#auction_id2").focus();
			return ;
		}
		var search1 =document.getElementById("search2");
		search1.disabled="true";
		var d = "action=search&table="+table+"&auction_id="+$('#auction_id2').val();
		$.ajax({
			type:'POST',
			url:'logDao.php',
			data:encodeURI(encodeURI(d)),
			timeout:timeout,
			error:function (data){alert(data);},
			success:function(result){
				$("#tableshow2").html(result);
				search1.disabled="";
				trStyleChange();
			}
			
		});
    }
	function searchlog3(table){
		if($("#auction_id3").val()==""){
			alert("请输入订单号");
			$("#auction_id3").focus();
			return ;
		}
		var search1 =document.getElementById("search3");
		search1.disabled="true";
		var d = "action=search&table="+table+"&auction_id="+$('#auction_id3').val();
		$.ajax({
			type:'POST',
			url:'tcgDao.php',
			data:encodeURI(encodeURI(d)),
			timeout:timeout,
			error:function (data){alert(data);},
			success:function(result){
				$("#tableshow3").html(result);
				search1.disabled="";
				trStyleChange();
			}
			
		});
    }
	
	function showhidden(table){;
		if(document.getElementById(table).style.display=="none"){
		//	document.getElementById(table).style.display="block";
		}else{
		//	document.getElementById(table).style.display="none";
		}
    }
</script>
</head>

<body>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;">拍卖行数据核实</legend>
		角色名：<input id="name" name="name"/>
		账号：<input id="account" name="account"/>
		物品IID：<input id="item_id" name="item_id"/> 
		订单号：<input id="auction_id1" name="auction_id1"/> 
		时间>=：<input id="update_time" name="update_time" />（时间格式 '2013-01-04 00:00:00') 
		<input type="button" onclick="searchlog1('auction_log');" id="search1"  value ="查询"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">拍卖行数据</legend>
<div id="tableshow1">请查询...</div>
</fieldset>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;">查询订单号</legend>
		订单号：<input id="auction_id2" name="auction_id2"/> 
		<input type="button" id="search2"  onclick="searchlog2('auction_log');" value ="查询"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">订单数据</legend>
<div id="tableshow2">请查询...</div>
</fieldset>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;">订单实时记录</legend>
		订单号：<input id="auction_id3" name="auction_id3" /> 
		<input type="button" id="search3" onclick="searchlog3('auction_data');" value ="查询"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">订单实时数据</legend>
<div id="tableshow3">请查询...</div>
</fieldset>

</body>
</html>