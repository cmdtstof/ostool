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
			alert("�������ɫ���˺�");
			$("#name").focus();
			return ;
		}
		if($("#item_name").val()==""){
			alert("��������Ʒ����");
			$("#item_name").focus();
			return ;
		}
		if($("#update_time").val()==""){
			alert("�������ѯʱ�䣬��ʽ��ʽ�确2013-01-04 00:00:00��");
			$("#update_time").focus();
			return ;
		}
		if($("#update_time").val().length!=19){
			alert("ʱ���ʽ���󣬸�ʽ��ʽ�确2013-01-04 00:00:00��");
			$("#update_time").focus();
			return ;
		}
		var d = "action=search&table="+table+"&name="+$('#name').val()+"&account="+$('#account').val()+"&update_time="+$('#update_time').val();
		if($('#item_name').val()==""){
			alert("��ѡ����Ʒ����");
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
			error:function (data){alert("ϵͳ��æ�����Ժ�����");},
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
			alert("�������ɫ���˺�");
			return ;
		}
		if($("#starttime2").val()==""){
			$("#starttime2").focus();
			alert("�����뿪ʼʱ�䣬��ʽ��ʽ�确2013-01-04 00:00:00��");
			return ;
		}
		if($("#starttime2").val().length!=19){
			alert("ʱ���ʽ���󣬸�ʽ��ʽ�确2013-01-04 00:00:00��");
			$("#starttime2").focus();
			return ;
		}
		if($("#endtime2").val()==""){
			$("#endtime2").focus();
			alert("���������ʱ�䣬��ʽ��ʽ�确2013-01-04 00:00:00��");
			return ;
		}
		if($("#endtime2").val().length!=19){
			alert("ʱ���ʽ���󣬸�ʽ��ʽ�确2013-01-04 00:00:00��");
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
			alert("�������ɫ���˺�");
			$("#name3").focus();
			return ;
		}
		if($("#starttime3").val()==""){
			alert("�����뿪ʼʱ�䣬��ʽ��ʽ�确2013-01-04 00:00:00��");
			$("#starttime3").focus();
			return ;
		}
		if($("#starttime3").val().length!=19){
			alert("ʱ���ʽ���󣬸�ʽ��ʽ�确2013-01-04 00:00:00��");
			$("#starttime3").focus();
			return ;
		}
		if($("#endtime3").val()==""){
			alert("���������ʱ�䣬��ʽ��ʽ�确2013-01-04 00:00:00��");
			$("#endtime3").focus();
			return ;
		}
		if($("#endtime3").val().length!=19){
			alert("ʱ���ʽ���󣬸�ʽ��ʽ�确2013-01-04 00:00:00��");
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
		<legend style="font-size:12px;color:#3333FF;">˫�����֡�������ʵ</legend>
		��ɫ����<input id="name" name="name" />
		�˺ţ�<input id="account" name="account"/>
		��Ʒ���ͣ�<select id="item_name" name="item_name"><option value="">--��ѡ��--</option><option value="˫������">˫������</option><option value="card_back">����</option></select>
		ʱ��>=��<input id="update_time" name="update_time" />��ʱ���ʽ '2013-01-04 00:00:00') 
		<input type="button" onclick="searchlog1('item_log');" id="search1" value ="��ѯ"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">����</legend>
<div id="tableshow1">���ѯ...</div>
</fieldset>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;">˫�����ֲ�ѯ</legend>
		��ɫ����<input id="name2" name="name2" />
		�˺ţ�<input id="account2" name="account2"/>
		��ʼʱ�䣺<input id="starttime2" name="starttime2" /> 
		����ʱ�䣺<input id="endtime2" name="endtime2" /> ��ʱ���ʽ '2013-01-04 00:00:00') 
		<input type="button" onclick="searchlog2();" id="search2" value ="��ѯ"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">����</legend>
<div id="tableshow2">���ѯ...</div>
</fieldset>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;">������ѯ</legend>
		��ɫ����<input id="name3" name="name3" />
		�˺ţ�<input id="account3" name="account3"/>
		��ʼʱ�䣺<input id="starttime3" name="starttime3" /> 
		����ʱ�䣺<input id="endtime3" name="endtime3" /> ��ʱ���ʽ '2013-01-04 00:00:00') 
		<input type="button" onclick="searchlog3();" id="search3" value ="��ѯ"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">����</legend>
<div id="tableshow3">���ѯ...</div>
</fieldset>

</body>
</html>