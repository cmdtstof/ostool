<script type="text/javascript" src = "../js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src = "../js/common.js"></script>
<script type="text/javascript">
	function search22(){	
		var x =document.getElementById("ccccccc");
		//if(x.length==0){
		//	alert("�����Ӳ�ѯ����");
		//	return ;
		//<h2></h2>}
		var search1 =document.getElementById("search");
		search1.disabled="true";
		var temp ="";
		for(var i=0; i<x.length; i++){
			if(temp ==""){
				temp =  x.options[i].value +" "; 
			}else{
				temp +=  " and " + x.options[i].value; 
			}
		}
		$("#condition").val(temp);
		var d = document.getElementsByName("shows");
		var s = "";
		for(i=0;i<d.length;i++){
		 var t = d[i];
		 if(t.checked){
			if(s==""){
				s=t.value;
			}else{
				s=s+","+ t.value;
			}
		 }
		}
		$("#showFileds").val(s);
		
		var f = document.getElementsByName("filter");
		var fs = "";
		for(i=0;i<f.length;i++){
		 var t = f[i];
		 if(t.checked){
			if(fs==""){
				fs=t.value;
			}else{
				fs=fs+","+ t.value;
			}
		 }
		}
		$("#filters").val(fs);
		var d = "action=search&tablename="+$("#tablename").val()+"&showFileds="+$("#showFileds").val()+"&condition="+
		$("#condition").val()+"&maxsize="+$("#maxsize").val()+"&filters="+$("#filters").val();
		$.ajax({
			type:'POST',
			url:'ostool_t.php',
			data:encodeURI(encodeURI(d)),
			timeout:timeout,
			error:function (data){
				alert("ϵͳ��æ�����Ժ�����");
				search1.disabled="";
				},
			success:function(result){
				$("#tableshow1").html(result);
				search1.disabled="";
				trStyleChange();
			}
			
		});
    }
</script>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;">��Ʒ��Ϣ_�ֶ�</legend>
			<input type="checkbox" checked name="shows" id="shows" value="name" /><?php echo $settings->get("item.name"); ?>
			<input type="checkbox" checked name="shows" id="shows" value="id" /><?php echo $settings->get("item.id"); ?>
</fieldset>

<fieldset>
	<legend style="font-size:12px;color:#3333FF;">��������</legend>
	<input type="checkbox"  name="filter" id="filter" value="name"/><?php echo $settings->get("item.name"); ?>
	<input type="checkbox"  name="filter" id="filter" value="id"/><?php echo $settings->get("item.id"); ?>
</fieldset>

<fieldset>
	<legend style="font-size:12px;color:#3333FF;">����ѡ��</legend>
�ֶ�:
<select id="fieldname" name="fieldname">
	<option value="name"><?php echo $settings->get("item.name"); ?></option>
	<option value="id"><?php echo $settings->get("item.id"); ?></option>
</select>
�ȽϹ�ϵ:
<select id="guanxi" name="guanxi">
	<option value="=">=</option>
	<option value="like">like</option>
</select>
ֵ:<input type="text" id="fieldvalue" name="fieldvalue" />
<input type="hidden" id="tablename" name="tablename" readOnly value="<?php echo $_GET["tablename"];?>"/>
<input type="hidden" name="showFileds"  id="showFileds" readOnly value=""/>
<input type="hidden" name="filters"  id="filters" readOnly value=""/>
<input class="login-regist" id = "diary-right-margin" type="button" name = "add" onclick="addcondition();" value="��������" />
</fieldset>
<fieldset>
<legend style="font-size:12px;color:#3333FF;">��ѯ����</legend>
	<table border="0">
		<tr>
			<td rowspan="3">
				<input type="hidden" id="condition" name="condition"/>
				<select size="5" style="width:400px;" id="ccccccc" name="ccccccc"></select>
			</td>
			<td>
				�����ʾ����:<input type="text" id="maxsize" size=4  name="maxsize" onblur="minmaxsize(this);"value=""/><font color="#FF0000" >��һ�������ʾ10000����</font>
			</td>
		<tr>
		<tr>
			<td>
				<input type="button" name = "del" onclick="del2();" value="ɾ������" />
				<input type="button" name = "search" id = "search" onclick="search22();" value="��ѯ" /><font color="#FF0000" >����ѯ����Ϊ��ʱ��ʾ���п��ƣ�</font>
			</td>
		</tr>
	</table>
</fieldset>
<?php
require '../common/showdata.php';
?>