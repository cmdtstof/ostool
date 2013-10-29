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
			alert("请输入物品类型");
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
		var d = "action=search&table="+table+"&name="+$('#name').val()+"&account="+$('#account').val()+"&update_time="+$('#update_time').val();
		if($('#item_name').val()==""){
			alert("请选择物品类型");
			return ;
		}else if($('#item_name').val()=="card_back"){
			d = d + "&item_type="+$('#item_name').val();
		}else{
			d = d + "&item_name="+$('#item_name').val();
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
	function searchlog2(){
		if($("#name2").val()=="" && $("#account2").val()==""){
			$("#name2").focus();
			alert("请输入角色或账号");
			return ;
		}
		if($("#starttime2").val()==""){
			$("#starttime2").focus();
			alert("请输入开始时间，格式格式如‘2013-01-04 00:00:00’");
			return ;
		}
		if($("#starttime2").val().length!=19){
			alert("时间格式错误，格式格式如‘2013-01-04 00:00:00’");
			$("#starttime2").focus();
			return ;
		}
		if($("#endtime2").val()==""){
			$("#endtime2").focus();
			alert("请输入结束时间，格式格式如‘2013-01-04 00:00:00’");
			return ;
		}
		if($("#endtime2").val().length!=19){
			alert("时间格式错误，格式格式如‘2013-01-04 00:00:00’");
			$("#endtime2").focus();
			return ;
		}
		var search1 =document.getElementById("search2");
		search1.disabled="true";
		var d = "action=search&name="+$('#name2').val()+"&account="+$('#account2').val()+"&starttime="+$('#starttime2').val()+"&endtime="+$('#endtime2').val();
		$.ajax({
			type:'POST',
			url:'special/shuangbeijifen.php',
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
	function searchlog3(){
		if($("#name3").val()=="" && $("#account3").val()==""){
			alert("请输入角色或账号");
			$("#name3").focus();
			return ;
		}
		if($("#starttime3").val()==""){
			alert("请输入开始时间，格式格式如‘2013-01-04 00:00:00’");
			$("#starttime3").focus();
			return ;
		}
		if($("#starttime3").val().length!=19){
			alert("时间格式错误，格式格式如‘2013-01-04 00:00:00’");
			$("#starttime3").focus();
			return ;
		}
		if($("#endtime3").val()==""){
			alert("请输入结束时间，格式格式如‘2013-01-04 00:00:00’");
			$("#endtime3").focus();
			return ;
		}
		if($("#endtime3").val().length!=19){
			alert("时间格式错误，格式格式如‘2013-01-04 00:00:00’");
			$("#endtime3").focus();
			return ;
		}
		var search1 =document.getElementById("search3");
		search1.disabled="true";
		var d = "action=search&name="+$('#name3').val()+"&account="+$('#account3').val()+"&starttime="+$('#starttime3').val()+"&endtime="+$('#endtime3').val();
		$.ajax({
			type:'POST',
			url:'special/cardback.php',
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
		<legend style="font-size:12px;color:#3333FF;">双倍积分、卡背核实</legend>
		角色名：<input id="name" name="name" />
		账号：<input id="account" name="account"/>
		物品类型：<select id="item_name" name="item_name"><option value="">--请选择--</option><option value="双倍积分">双倍积分</option><option value="card_back">卡背</option></select>
		时间>=：<input id="update_time" name="update_time" />（时间格式 '2013-01-04 00:00:00') 
		<input type="button" onclick="searchlog1('item_log');" id="search1" value ="查询"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">数据</legend>
<div id="tableshow1">请查询...</div>
</fieldset>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;">双倍积分查询</legend>
		角色名：<input id="name2" name="name2" />
		账号：<input id="account2" name="account2"/>
		开始时间：<input id="starttime2" name="starttime2" /> 
		结束时间：<input id="endtime2" name="endtime2" /> （时间格式 '2013-01-04 00:00:00') 
		<input type="button" onclick="searchlog2();" id="search2" value ="查询"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">数据</legend>
<div id="tableshow2">请查询...</div>
</fieldset>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;">卡背查询</legend>
		角色名：<input id="name3" name="name3" />
		账号：<input id="account3" name="account3"/>
		开始时间：<input id="starttime3" name="starttime3" /> 
		结束时间：<input id="endtime3" name="endtime3" /> （时间格式 '2013-01-04 00:00:00') 
		<input type="button" onclick="searchlog3();" id="search3" value ="查询"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">数据</legend>
<div id="tableshow3">请查询...</div>
</fieldset>

</body>
</html>