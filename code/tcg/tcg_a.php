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
<?php
   //查询 字段
  $strsql="select column_name from information_schema.COLUMNS where TABLE_SCHEMA='".$tcg_database."' and TABLE_NAME='".$_GET["tablename"]."'";
 //	echo $strsql;
   // 执行sql查询
  $result=mysql_query($strsql, $tcgconn);
    
?>

<?php 
require '../common/field.php';
require '../common/filter.php';
require '../common/choose.php';
?>
<?php
    
    // 释放资源
    mysql_free_result($result);
    // 关闭连接
    mysql_close($tcgconn);

?>

<?php
require '../common/condition.php';
require '../common/showdata.php';
?>