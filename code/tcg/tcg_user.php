<script type="text/javascript" src = "../js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" src = "../js/common.js"></script>
<script type="text/javascript">
	function search22(){	
		var x =document.getElementById("ccccccc");
		if(x.length==0){
			alert("请增加查询条件");
			return ;
		}
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
			url:'tcg_t.php',
			data:encodeURI(encodeURI(d)),
			timeout:timeout,
			error:function (data){
				alert("系统繁忙，请稍后再试");
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
		<legend style="font-size:12px;color:#3333FF;"><?php 
$tn = $_GET["tablename"].".".$_GET["tablename"]."_title"; echo $settings->get("$tn")==""?$_GET["tablename"]:$settings->get("$tn");?>_字段</legend>
	<input type="checkbox" checked name="shows" id="shows" value="account"/><?php echo $settings->get("users.account") ?>
	<input type="checkbox" checked name="shows" id="shows" value="name"/><?php echo $settings->get("users.name") ?>
	<input type="checkbox" checked name="shows" id="shows" value="group_cards"/><?php echo $settings->get("users.group_cards") ?>
	<input type="checkbox" checked name="shows" id="shows" value="all_cards"/><?php echo $settings->get("users.all_cards") ?>
	<input type="checkbox" checked name="shows" id="shows" value="level"/><?php echo $settings->get("users.level") ?>
	<input type="checkbox" checked name="shows" id="shows" value="all_score"/><?php echo $settings->get("users.all_score") ?>
	<input type="checkbox" checked name="shows" id="shows" value="remain_score"/><?php echo $settings->get("users.remain_score") ?>
	<input type="checkbox" checked name="shows" id="shows" value="achievement"/><?php echo $settings->get("users.achievement") ?>
	<input type="checkbox" checked name="shows" id="shows" value="buff"/><?php echo $settings->get("users.buff") ?>
	<input type="checkbox" checked name="shows" id="shows" value="item"/><?php echo $settings->get("users.item") ?>
	<input type="checkbox" checked name="shows" id="shows" value="task"/><?php echo $settings->get("users.task") ?>
	<input type="checkbox" checked name="shows" id="shows" value="social_contact"/><?php echo $settings->get("users.social_contact") ?>
	<input type="checkbox" checked name="shows" id="shows" value="card_smelt"/><?php echo $settings->get("users.card_smelt") ?>
	<input type="checkbox" checked name="shows" id="shows" value="card_collection"/><?php echo $settings->get("users.card_collection") ?>
	<input type="checkbox" checked name="shows" id="shows" value="card_collection_num"/><?php echo $settings->get("users.card_collection_num") ?>
	<input type="checkbox" checked name="shows" id="shows" value="newcomer_bonus"/><?php echo $settings->get("users.newcomer_bonus") ?>
	<input type="checkbox" checked name="shows" id="shows" value="gm_sign"/><?php echo $settings->get("users.gm_sign") ?>
	<input type="checkbox" checked name="shows" id="shows" value="competition"/><?php echo $settings->get("users.competition") ?>
</fieldset>
<fieldset>
		<legend style="font-size:12px;color:#3333FF;">条件选择</legend>
字段:
<select id="fieldname" name="fieldname">
	<option value="name"><?php echo $settings->get("users.name") ?></option>
	<option value="account"><?php echo $settings->get("users.account") ?></option>
</select>
比较关系:
<select id="guanxi" name="guanxi">
	<option value="=">=</option>
	<option value=">">></option>
	<option value=">=">>=</option>
	<option value="<"><</option>
	<option value="<="><=</option>
	<option value="!=">!=</option>
	<option value="like">like</option>
	
</select>
值:<input type="text" id="fieldvalue" name="fieldvalue" />

<input type="hidden" id="tablename" name="tablename" readOnly value="<?php echo $_GET["tablename"];?>"/>
<input type="hidden" name="showFileds"  id="showFileds" readOnly value=""/>
<input type="hidden" name="filters"  id="filters" readOnly value=""/>
<input class="login-regist" id = "diary-right-margin" type="button" name = "add" onclick="addcondition();" value="增加条件" />
</fieldset>
<?php
require '../common/condition.php';
require '../common/showdata.php';
?>