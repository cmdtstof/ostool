function change()
{
	var radio = document.getElementsByName("s");
 	//var radio = document.getElementByIdx_x("form1");
  	// 用ById就不能取得全部的radio值,而是每次返回都为1
 	var radioLength = radio.length;
 	for(var i = 0;i < radioLength;i++)
 	{
	  	if(radio[i].checked)
	  	{
	   		var radioValue = radio[i].value;
	   		parent.document.getElementById('mainFrame').src=window.location+'&radioValue=' + radioValue;
	  	}
 	}
}