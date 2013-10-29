var timeout = 60000;

function minmaxsize(obj){
	var reg = new RegExp("^[0-9]*$");
	 if(!reg.test(obj.value)){
        alert("请输入数字!");
		obj.value=100;
		return;
    }
    if(obj.value==""){
        alert("最小为1");
		obj.value=1;
		return;
    }
	
    if(obj.value>10000){
        alert("最大显示量为10000");
		obj.value=10000;
		return;
    }
}


function del2(){
	var x =document.getElementById("ccccccc");
	var destOpts = x.options; 
	for(var i=x.length-1; i>=0; i--){
		 if(x.options[i].selected){
       		destOpts.remove(i); 
		 }
	}
}


function addcondition(){
	if($("#fieldvalue").val()==""){
		alert("请输入值");
		$("#fieldvalue").focus();
		return;
	}else{
		var x =document.getElementById("ccccccc");
		var destOpts = x.options; 

		var fn = $("#fieldname").val();
	//	if(fn=='name'){
	//		if( $("#collate").val()=="gbk_chinese_ci"){
	//			fn = fn + " COLLATE gbk_bin";
	//		}else if($("#collate").val()=="utf8_general_ci"){
	//			fn = fn + " COLLATE utf8_bin";
	//		}		
	//	}
		if($("#guanxi").val()=="like"){
			var newOpt = new Option( fn + " " + $("#guanxi").val() + " '%" + $("#fieldvalue").val()+"%'",fn + " " + $("#guanxi").val() + " '%" + $("#fieldvalue").val() +"%'"); 
			destOpts.add(newOpt); 
		}else{
			var newOpt = new Option( fn + " " + $("#guanxi").val() + " '" + $("#fieldvalue").val()+"'",fn + " " + $("#guanxi").val() + " '" + $("#fieldvalue").val() +"'"); 
			destOpts.add(newOpt); 
		}
	}
}



function init()
{
	var tn = document.getElementById("tablename").value;
	if(tn=="score_log"){
		var table =document.getElementById("tab1");
		var rows = table.rows.length;
		
		var colums = table.rows[0].cells.length;
		var scoreflag=0;
		for(i=0;i<colums;i++){
			var temp = table.rows[0].cells[i].innerHTML;
			
			if(temp=="积分"){
				scoreflag = i;
			}
		}
		
		for(i=1;i<rows;i++){
			if(i==rows-1){
				table.rows[i].cells[colums-2].innerHTML=0;
			}else{
				table.rows[i].cells[colums-2].innerHTML=table.rows[i+1].cells[scoreflag].innerHTML;
			}
			var re = Number(table.rows[i].cells[scoreflag].innerHTML)-Number(table.rows[i].cells[colums-1].innerHTML)-Number(table.rows[i].cells[colums-2].innerHTML);
			if(re==0){
				table.rows[i].cells[colums-1].innerHTML=re;
			}else{
				table.rows[i].cells[colums-1].innerHTML="<font color='red'>"+re+"</font>";
			}
		}
	}
}



function trStyleChange() {
	$(".simpleList tbody tr:nth-child(2n+1)", document).addClass("odd")
			.removeClass("even");
	$(".simpleList tbody tr:nth-child(2n)", document).addClass("even")
			.removeClass("odd");
	$(".simpleList tbody tr", document).hover(function() {
		$(this).addClass("now");
	}, function() {
		$(this).removeClass("now");
	});
	$(".simpleList tbody tr", document).click(function() {
		$(".selectedRow", $(this).closest("table")).removeClass("selectedRow");
		$(this).addClass("selectedRow");
	}).dblclick(function() {
		$(".selectedRow", $(this).closest("table")).removeClass("selectedRow");
		$(this).addClass("selectedRow");
	}).mouseover(function() {
		$(".selectedRow", $(this).closest("table")).removeClass("selectedRow");
		$(this).addClass("selectedRow");
	});

}



	function resort(t,v,type){
		var table =document.getElementById(t);
		var colums = table.rows[0].cells.length;
		if($("#"+t+" tbody th:eq("+v+")").attr("class")==undefined || $("#"+t+" tbody th:eq("+v+")").attr("class")=="" ){
			for (z=0;z<colums;z++){
				if(z==v){
					$("#"+t+" tbody th:eq("+z+")").attr("class","asc");
				}else{
					$("#"+t+" tbody th:eq("+z+")").addClass("").removeClass($("#"+t+" tbody th:eq("+z+")").attr("class"));
				}
			}
			upsort(t,v,type);
		}else if($("#"+t+" tbody th:eq("+v+")").attr("class")=="desc"){
			for (z=0;z<colums;z++){
				if(z==v){
					$("#"+t+" tbody th:eq("+z+")").addClass("asc").removeClass("desc");
				}else{
					$("#"+t+" tbody th:eq("+z+")").addClass("").removeClass("desc");
				}
			}
			upsort(t,v,type);
		}else if($("#"+t+" tbody th:eq("+v+")").attr("class")=="asc"){
			for (z=0;z<colums;z++){
				if(z==v){
					$("#"+t+" tbody th:eq("+z+")").addClass("desc")	.removeClass("asc");
				}else{
					$("#"+t+" tbody th:eq("+z+")").addClass("").removeClass("asc");
				}
			}
			downsort(t,v,type);
		}
	}
	
	function upsort(t,v,type){
		var table =document.getElementById(t);
		var rows =table.rows.length;
		for (i=1;i<rows-1;i++){
			k=i;
			for (j=i+1;j<rows;j++){
				if(type=="1"){
					if (parseInt(table.rows[k].cells[v].innerHTML)>parseInt(table.rows[j].cells[v].innerHTML))
						k=j;
				}else{
					if (table.rows[k].cells[v].innerHTML>	table.rows[j].cells[v].innerHTML)
						k=j;
				}
			}
			if (k>i)
			{
				tmp=table.rows[i].innerHTML;
				table.rows[i].innerHTML = table.rows[k].innerHTML;
				table.rows[k].innerHTML = tmp;
			}
		}
	}
	function downsort(t,v,type){
		var table =document.getElementById(t);
		var rows =table.rows.length;
		for (i=1;i<rows-1;i++){
			k=i;
			for (j=i+1;j<rows;j++){
				if(type=="1"){
					if (parseInt(table.rows[k].cells[v].innerHTML)<parseInt(table.rows[j].cells[v].innerHTML))
						k=j;
				}else{
					if (table.rows[k].cells[v].innerHTML<	table.rows[j].cells[v].innerHTML)
						k=j;
				}
			}
			if (k>i)
			{
				tmp=table.rows[i].innerHTML;
				table.rows[i].innerHTML = table.rows[k].innerHTML;
				table.rows[k].innerHTML = tmp;
			}
		}
	}
	function upsort1(t,v){
		var rows =$("#"+t+" tbody tr").length;
		var table =document.getElementById(t);
		var colums = table.rows[0].cells.length;
	
		for (i=0;i<rows-1;i++){
			k=i;
			for (j=i+1;j<rows;j++){
			
			if ($("#tab1 tbody tr:eq("+k+") td:eq("+v+")").text()>$("#tab1 tbody tr:eq("+j+") td:eq("+v+")").text())
				k=j;
			}
			if (k>i)
			{
				for (z=0;z<colums;z++){
					tmp=$("#tab1 tbody tr:eq("+i+") td:eq("+z+")").text();
					$("#tab1 tbody tr:eq("+i+") td:eq("+z+")").text($("#tab1 tbody tr:eq("+k+") td:eq("+z+")").text());
					$("#tab1 tbody tr:eq("+k+") td:eq("+z+")").text(tmp);
				}
			}
		}
	}
	
	
	function downsort1(v){
		var rows =$("#tab1 tbody tr").length;
		var table =document.getElementById("tab1");
		var colums = table.rows[0].cells.length;
	
		for (i=0;i<rows;i++){
			k=i;
			for (j=i+1;j<rows;j++){
			
			if ($("#tab1 tbody tr:eq("+k+") td:eq("+v+")").text()<$("#tab1 tbody tr:eq("+j+") td:eq("+v+")").text())
				k=j;
			}
			if (k>i)
			{
				for (z=0;z<colums;z++){
					tmp=$("#tab1 tbody tr:eq("+i+") td:eq("+z+")").text();
					$("#tab1 tbody tr:eq("+i+") td:eq("+z+")").text($("#tab1 tbody tr:eq("+k+") td:eq("+z+")").text());
					$("#tab1 tbody tr:eq("+k+") td:eq("+z+")").text(tmp);
				}
			}
		}
	}
	
	function todayTimeLimit(v){
		var today = curDateTime();
		if(v.value.length!=19){
			alert("时间格式错误");
			v.focus();
			return;
		}
		var time = v.value.split(" ");
		var tmp = compareDate(time[0],today);
		if(tmp==0){
			return;
		}else{
			alert("你说输入的时间只能是本日");
			v.value= today + " " + time[1];
			return ;
		}
	}
	function historyTimeLimit(v){
		var today = curDateTime();
		if(v.value.length!=19){
			alert("时间格式错误");
			v.focus();
			return;
		}
		var time = v.value.split(" ");
		var tmp = compareDate(time[0],today);
		alert(tmp);
		if(tmp==-1){
			return;
		}else{
			alert("你说输入的时间只能是今天之前的数据");
			var yesday = getYestoday(new Date());
			v.value= yesday + " " + time[1];
			return ;
		}
	}
	
	function curDateTime(){
		var d = new Date(); 
		var year = d.getFullYear(); 
		var month = d.getMonth()+1; 
		var date = d.getDate(); 
		var day = d.getDay(); 
		var hours = d.getHours(); 
		var minutes = d.getMinutes(); 
		var seconds = d.getSeconds(); 
		var ms = d.getMilliseconds();   
		var curDateTime= year;
		if(month>9)
		 curDateTime = curDateTime +"-"+month;
		else
		 curDateTime = curDateTime +"-0"+month;
		if(date>9)
		 curDateTime = curDateTime +"-"+date;
		else
		 curDateTime = curDateTime +"-0"+date;
	//	if(hours>9)
	//	 curDateTime = curDateTime +" "+hours;
	//	else
	//	 curDateTime = curDateTime +" 0"+hours;
	//	if(minutes>9)
	//	 curDateTime = curDateTime +":"+minutes;
	//	else
	//	 curDateTime = curDateTime +":0"+minutes;
	//	if(seconds>9)
	//	 curDateTime = curDateTime +":"+seconds;
	//	else
	//	 curDateTime = curDateTime +":0"+seconds;
		return curDateTime; 
	}
	
	function getYestoday(date){    
		var yesterday_milliseconds=date.getTime()-1000*60*60*24;     
		var yesterday = new Date();     
		yesterday.setTime(yesterday_milliseconds);     
		   
		var strYear = yesterday.getFullYear();  
		var strDay = yesterday.getDate();  
		var strMonth = yesterday.getMonth()+1;
		if(strMonth<10)  
		{  
			strMonth="0"+strMonth;  
		}  
		datastr = strYear+"-"+strMonth+"-"+strDay;
		return datastr;
	}
	
	function compareDate(DateOne,DateTwo)
	{
		var OneMonth = DateOne.substring(5,DateOne.lastIndexOf ("-"));
		var OneDay = DateOne.substring(DateOne.length,DateOne.lastIndexOf ("-")+1);
		var OneYear = DateOne.substring(0,DateOne.indexOf ("-"));

		var TwoMonth = DateTwo.substring(5,DateTwo.lastIndexOf ("-"));
		var TwoDay = DateTwo.substring(DateTwo.length,DateTwo.lastIndexOf ("-")+1);
		var TwoYear = DateTwo.substring(0,DateTwo.indexOf ("-"));

		if (Date.parse(OneMonth+"/"+OneDay+"/"+OneYear) > Date.parse(TwoMonth+"/"+TwoDay+"/"+TwoYear)){
			return 1;
		}else if (Date.parse(OneMonth+"/"+OneDay+"/"+OneYear) == Date.parse(TwoMonth+"/"+TwoDay+"/"+TwoYear)){
			return 0;
		}else {
			return -1;
		}
	}