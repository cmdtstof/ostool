openID :
<input id="openID" />
角色名:
<input id="roleName" />
<input type="button" value="核对" onclick="checkrole();"/>

<script type="text/javascript">

function checkrole(){
	var openID = document.getElementById("openID");
	var roleName = document.getElementById("roleName");
    if(openID.value=="" || roleName.value==""){
        alert("请输入openId及角色名！");
    }else{
    	this.location = "roleCheck.php?openID="+openID.value+"&roleName="+roleName.value;
    }
}
</script>

