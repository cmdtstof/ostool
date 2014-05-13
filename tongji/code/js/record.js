var ht = "http://tongji.lztcg.com/";
var gbitstj = {
		referrer:document.referrer,
		host:window.location.host, 
		url:document.domain,
		locationhref:window.location.href,
		project:"cainiao"
}
document.cookie="comefrom="+gbitstj.referrer;  //设置COOKIE
var d="referrer="+gbitstj.referrer+"&locationhref="+gbitstj.locationhref+"&type=in&project="+gbitstj.project;

var id = "";
$.ajax({
	type:'GET',
	url:ht+'access.php?'+encodeURI(encodeURI(d)),
	dataType: "jsonp",
	jsonp: "callback",
	jsonpCallback:"flightHandler",
	//data:encodeURI(encodeURI(d)),
	timeout:30000,
	error:function (data){
//		alert("系统繁忙，请稍后再试");
	},
	success:function(result){
		//alert(result.locationhref);
	}
});
function flightHandler(result){
	//alert(result);
}
var start;
var end;
var state;
start = new Date();//start是用户进入页面时间  

$(document).ready(function() {//用户页面加载完毕，这个是jquery初始化的语句（不知道初始化这个词用的是否正确）  
    $(window).unload(function() {//页面卸载，就是用户关闭页面、点击链接跳转到其他页面或者刷新页面都会执行  
        end = new Date();//用户退出时间  
        state = end.getTime() - start.getTime();//停留时间=退出时间-开始时间（得到的是一个整数，应该是毫秒为单位，1秒=1000）
        //d="recordid="+id;
        $.ajax({
        	type:'GET',
        	url:ht+'leave.php?'+encodeURI(encodeURI(d)),
        	dataType: "jsonp",
        	jsonp: "callback",
        	jsonpCallback:"flightHandler",
//        	data:encodeURI(encodeURI(d)),
        	timeout:30000,
        	error:function (data){
//        		alert("系统繁忙，请稍后再试");
        	},
        	success:function(result){
        		alert(result);
        	}
        });
    });  
}); 

window.onbeforeunload = onbeforeunload_handler;   
window.onunload = onunload_handler;   
function onbeforeunload_handler(){   
	end = new Date();//用户退出时间  
	  state = end.getTime() - start.getTime();//停留时间=退出时间-开始时间（得到的是一个整数，应该是毫秒为单位，1秒=1000）
	 // d="recordid="+id;
	 // return d;
	  $.ajax({
	  	type:'GET',
	  	url:ht+'leave.php?'+encodeURI(encodeURI(d)),
    	dataType: "jsonp",
    	jsonp: "callback",
    	jsonpCallback:"flightHandler",
//	  	data:encodeURI(encodeURI(d)),
	  	timeout:30000,
	  	error:function (data){
	  	},
	  	success:function(result){
    		alert(2+result);
	  	}
	  });

    }   
      
function onunload_handler(){   
	end = new Date();//用户退出时间  
	  state = end.getTime() - start.getTime();//停留时间=退出时间-开始时间（得到的是一个整数，应该是毫秒为单位，1秒=1000）
	  //d="recordid="+id;
	  $.ajax({
	  	type:'GET',
	  	url:ht+'leave.php?'+encodeURI(encodeURI(d)),
    	dataType: "jsonp",
    	jsonp: "callback",
    	jsonpCallback:"flightHandler",
//	  	data:encodeURI(encodeURI(d)),
	  	timeout:30000,
	  	error:function (data){
	  	},
	  	success:function(result){
    		alert(1+result);
	  	}
	  });
    }   

function push_event(eventName,eventParam){
	var d="referrer="+gbitstj.referrer+"&locationhref="+gbitstj.locationhref+"&project="+gbitstj.project+"&eventName="+eventName+"&eventParam="+eventParam;
	$.ajax({
		type:'GET',
		url:ht+'eventRecord.php?'+encodeURI(encodeURI(d)),
    	dataType: "jsonp",
    	jsonp: "callback",
    	jsonpCallback:"flightHandler",
//		data:encodeURI(encodeURI(d)),
		timeout:30000,
		error:function (data){
		//	alert("系统繁忙，请稍后再试");
		},
		success:function(result){
			//id = parseInt(result);
			//alert(id);
		}
	});
}