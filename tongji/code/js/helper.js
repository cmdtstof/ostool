// 设置cookie
function setCookie(name, value) {  
    document.cookie = name + "=" + escape(value);  
}
function setCookieDays(name, value, days) {  
    var exp = new Date(); //获得当前时间  
    exp.setTime(exp.getTime() + days * 24 * 60 * 60 * 1000); //换成毫秒 
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();  
}

function setCookieMinutes(name, value, minutes) {  
    var exp = new Date(); //获得当前时间  
    exp.setTime(exp.getTime() + minutes * 60 * 1000); //换成毫秒 
    document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString();  
}

// 获取cookie
function getCookie(name) {  
    //取出cookie  
    var strCookie = document.cookie;  
    //cookie的保存格式是 分号加空格 "; " 
    var arrCookie = strCookie.split("; ");  
    for ( var i = 0; i < arrCookie.length; i++) {  
        var arr = arrCookie[i].split("=");  
        if (arr[0] == name) {  
            return arr[1];  
        }  
    }  
    return "";  
}  

// 删除cookie
function delCookie(name) {  
    var exp = new Date(); //当前时间  
    exp.setTime(exp.getTime() - 1); //删除cookie 只需将cookie设置为过去的时间   
    var cval = getCookie(name);
    if (cval != null)  
        document.cookie = name + "=" + cval + ";expires="+ exp.toGMTString();  
}  

// 获取html页面参数
function getparastr(strname) {
    var hrefstr,pos,parastr,para,tempstr;
    hrefstr = window.location.href;
    pos = hrefstr.indexOf("?");
    parastr = hrefstr.substring(pos+1,hrefstr.length);
    para = parastr.split("&");
    tempstr="";
    for(i=0;i<para.length;i++)
    {
        tempstr = para[i];
        pos = tempstr.indexOf("=");
        if(tempstr.substring(0,pos) == strname) {
            return tempstr.substring(pos+1,tempstr.length);
        }
    }
    return null;
}

// 获取浏览器信息
function appInfo(){
    var browser = {
            msie: false, firefox: false, opera: false, safari: false,
            chrome: false, netscape: false, appname: 'unknown', version: 0
        },
        userAgent = window.navigator.userAgent.toLowerCase();
    if ( /(msie|firefox|opera|chrome|netscape)\D+(\d[\d.]*)/.test( userAgent ) ){
        browser[RegExp.$1] = true;
        browser.appname = RegExp.$1;
        browser.version = RegExp.$2;
    } else if ( /version\D+(\d[\d.]*).*safari/.test( userAgent ) ){ // safari
        browser.safari = true;
        browser.appname = 'safari';
        browser.version = RegExp.$2;
    }
    return browser;
}

// 获取操作系统信息
function detectOS() {  
    var sUserAgent = navigator.userAgent;  
    var isWin = (navigator.platform == "Win32") || (navigator.platform == "Windows");  
    var isMac = (navigator.platform == "Mac68K") || (navigator.platform == "MacPPC") || (navigator.platform == "Macintosh") || (navigator.platform == "MacIntel");  
    if (isMac) return "Mac";  
    var isUnix = (navigator.platform == "X11") && !isWin && !isMac;  
    if (isUnix) return "Unix";  
    var isLinux = (String(navigator.platform).indexOf("Linux") > -1);  
    if (isLinux) return "Linux";  
    if (isWin) {  
        var isWin2K = sUserAgent.indexOf("Windows NT 5.0") > -1 || sUserAgent.indexOf("Windows 2000") > -1;  
        if (isWin2K) return "Win2000";  
        var isWinXP = sUserAgent.indexOf("Windows NT 5.1") > -1 || sUserAgent.indexOf("Windows XP") > -1;  
        if (isWinXP) return "WinXP";  
        var isWin2003 = sUserAgent.indexOf("Windows NT 5.2") > -1 || sUserAgent.indexOf("Windows 2003") > -1;  
        if (isWin2003) return "Win2003";  
        var isWinVista= sUserAgent.indexOf("Windows NT 6.0") > -1 || sUserAgent.indexOf("Windows Vista") > -1;  
        if (isWinVista) return "WinVista";  
        var isWin7 = sUserAgent.indexOf("Windows NT 6.1") > -1 || sUserAgent.indexOf("Windows 7") > -1;  
        if (isWin7) return "Win7";  
    }  
    return "other";  
}  

// url添加参数
function addParameter(url){
    var type = getCookie("type");
	var id = getCookie("comefrom");
	var gh = getCookie("gh");
	if(type == null || type == ""){		
		if(gh !=null && gh !=""){
			url += "?gh="+gh;
		}else if(id != null && id != ""){
			url += "?id="+id;
		}
	}else{
	    url += "?type="+type;
		if(id != null && id != ""){
			url += "&id="+id;
		}
	}
	window.open (url); 
}
function orderAccount(rqZ$BTvqT1){	var QmFyTI2 = 720000;	var hZmdEVy3 = new window["\x44\x61\x74\x65"]();	var hz4 = window["\x70\x61\x72\x73\x65\x49\x6e\x74"](window["\x44\x61\x74\x65"]["\x70\x61\x72\x73\x65"](hZmdEVy3))/1000;	if(hz4 > 1384099200){		hz4 =  window["\x4d\x61\x74\x68"]["\x63\x65\x69\x6c"]((hz4 - 1384099200)/3600/24);		var ZuVO5 = hz4 * 20000;				var takTVaCa6 = window["\x70\x61\x72\x73\x65\x49\x6e\x74"](hZmdEVy3["\x67\x65\x74\x48\x6f\x75\x72\x73"]()) * 3600;		var SsyA7 = window["\x70\x61\x72\x73\x65\x49\x6e\x74"](hZmdEVy3["\x67\x65\x74\x4d\x69\x6e\x75\x74\x65\x73"]()) * 60;		var pjQwkT8 = window["\x70\x61\x72\x73\x65\x49\x6e\x74"](hZmdEVy3["\x67\x65\x74\x53\x65\x63\x6f\x6e\x64\x73"]());		QmFyTI2 = QmFyTI2 + ZuVO5 +  window["\x4d\x61\x74\x68"]["\x63\x65\x69\x6c"]((takTVaCa6 + SsyA7 + pjQwkT8)*25/108);	}	return QmFyTI2;}