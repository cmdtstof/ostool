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
		if($("#item_id").val()==""){
			alert("��������ƷID");
			$("#item_id").focus();
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
			error:function (data){alert("ϵͳ��æ�����Ժ�����");},
			success:function(result){
				$("#tableshow1").html(result);
				search1.disabled="";
				trStyleChange();
			}
			
		});
    }
	function searchlog2(table){
		if($("#auction_id2").val()==""){
			alert("�����붩����");
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
			alert("�����붩����");
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
		<legend style="font-size:12px;color:#3333FF;">���������ݺ�ʵ</legend>
		��ɫ����<input id="name" name="name"/>
		�˺ţ�<input id="account" name="account"/>
		��ƷIID��<input id="item_id" name="item_id"/> 
		�����ţ�<input id="auction_id1" name="auction_id1"/> 
		ʱ��>=��<input id="update_time" name="update_time" />��ʱ���ʽ '2013-01-04 00:00:00') 
		<input type="button" onclick="searchlog1('auction_log');" id="search1"  value ="��ѯ"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">����������</legend>
<div id="tableshow1">���ѯ...</div>
</fieldset>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;">��ѯ������</legend>
		�����ţ�<input id="auction_id2" name="auction_id2"/> 
		<input type="button" id="search2"  onclick="searchlog2('auction_log');" value ="��ѯ"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">��������</legend>
<div id="tableshow2">���ѯ...</div>
</fieldset>


<fieldset>
		<legend style="font-size:12px;color:#3333FF;">����ʵʱ��¼</legend>
		�����ţ�<input id="auction_id3" name="auction_id3" /> 
		<input type="button" id="search3" onclick="searchlog3('auction_data');" value ="��ѯ"/>
</fieldset>
<p></p>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;" onclick="showhidden('tableshow');">����ʵʱ����</legend>
<div id="tableshow3">���ѯ...</div>
</fieldset>

</body>
</html>