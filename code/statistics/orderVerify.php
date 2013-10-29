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
		if($("#item_name").val()==""){
			alert("请输入物品名称");
			$("#item_name").focus();
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
		var search1 =document.getElementById("search1");
		search1.disabled="true";
		var d = "action=search&table="+table+"&name="+$('#name').val()+"&account="+$('#account').val()+"&item_name="+$('#item_name').val();
		d += "&update_time="+$("#update_time").val();
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
		if($("#rid").val()==""){
			alert("请输入订单号");
			$("#rid").focus();
			return ;
		}
		var search1 =document.getElementById("search2");
		search1.disabled="true";
		var d = "action=search&table="+table+"&rid="+$('#rid').val();
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
		if($("#memo").val()==""){
			alert("请输入订单号");
			$("#memo").focus();
			return ;
		}
		var search1 =document.getElementById("search3");
		search1.disabled="true";
		var d = "action=search&table="+table+"&memo="+$('#memo').val();
		$.ajax({
			type:'POST',
			url:'logDao.php',
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
		<legend style="font-size:12px;color:#3333FF;">充值核实</legend>
		<font color="red">*</font>角色名：<input id="name" name="name"/>
		账号：<input id="account" name="account"/>
		<font color="red">*</font>物品名称：<input id="item_name" name="item_name"/> 
		<font color="red">*</font>时间>=：<input id="update_time" name="update_time"/>（时间格式 '2013-01-04 00:00:00') 
		<input type="button" onclick="searchlog1('order_log');"  id="search1" value ="查询"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">数据</legend>
<div id="tableshow1">请查询...</div>
</fieldset>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;">订单号</legend>
		<font color="red">*</font>订单号：<input id="rid" name="rid"/> 
		<input type="button" onclick="searchlog2('order_log');" id="search2" value ="查询"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">数据</legend>
<div id="tableshow2">请查询...</div>
</fieldset>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;">物品发放</legend>
		<font color="red">*</font>订单号：<input id="memo" name="memo" /> 
		<input type="button" onclick="searchlog3('item_log');" id="search3" value ="查询"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">数据</legend>
<div id="tableshow3">请查询...</div>
</fieldset>

</body>
</html>