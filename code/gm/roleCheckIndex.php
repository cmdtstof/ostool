openID :
<input id="openID" />
��ɫ��:
<input id="roleName" />
<input type="button" value="�˶�" onclick="checkrole();"/>

<script type="text/javascript">

function checkrole(){
	var openID = document.getElementById("openID");
	var roleName = document.getElementById("roleName");
    if(openID.value=="" || roleName.value==""){
        alert("������openId����ɫ����");
    }else{
    	this.location = "roleCheck.php?openID="+openID.value+"&roleName="+roleName.value;
    }
}
</script>

