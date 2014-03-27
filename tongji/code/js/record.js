document.write(document.referrer); 
var referrer = document.referrer;
document.cookie="comefrom="+referrer;  //设置COOKIE
var host = window.location.host;
var project = "cainiao";

var url=document.domain;
var locationhref = window.location.href;
var d="referrer="+referrer+"&locationhref="+locationhref+"&type=in&project="+project;
var id;
$.ajax({
	type:'POST',
	url:'access.php',
	data:encodeURI(encodeURI(d)),
	timeout:30000,
	error:function (data){
	//	alert("系统繁忙，请稍后再试");
	},
	success:function(result){
		id = parseInt(result);
		//alert(id);
	}
});




var start;  
var end;  
var state;  
start = new Date();//start是用户进入页面时间  

$(document).ready(function() {//用户页面加载完毕，这个是jquery初始化的语句（不知道初始化这个词用的是否正确）  
    $(window).unload(function() {//页面卸载，就是用户关闭页面、点击链接跳转到其他页面或者刷新页面都会执行  
        end = new Date();//用户退出时间  
        state = end.getTime() - start.getTime();//停留时间=退出时间-开始时间（得到的是一个整数，应该是毫秒为单位，1秒=1000）
        d="recordid="+id;

        $.ajax({
        	type:'POST',
        	url:'leave.php',
        	data:encodeURI(encodeURI(d)),
        	timeout:30000,
        	error:function (data){
        		//alert("系统繁忙，请稍后再试");
        	},
        	success:function(result){
        		//alert(result);
        	}
        });
    });  
}); 


function push_event(eventName,eventParam){
	var d="referrer="+referrer+"&locationhref="+locationhref+"&project="+project+"&eventName="+eventName+"&eventParam="+eventParam;

	alert(d);
	$.ajax({
		type:'POST',
		url:'eventRecord.php',
		data:encodeURI(encodeURI(d)),
		timeout:30000,
		error:function (data){
		//	alert("系统繁忙，请稍后再试");
		},
		success:function(result){
			id = parseInt(result);
			//alert(id);
		}
	});
}