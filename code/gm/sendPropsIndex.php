<html>
<body>

<?php
require '../common/userinfo.php';
if($_COOKIE["username"]==$os_user_name){ ?>
<form action="upload_file.php" method="post"
	enctype="multipart/form-data"><label for="file">请选择要上传的文件（txt格式）:</label>
<input type="file" name="file" id="file" /> <br />
<input type="submit" name="submit" value="提交" /> <br />
<font color="red"> txt的文件名请选择英文;<br />
TXT中的内容格式如下（符号为半角）：<br />

--------积分 角色名,,积分,补偿原因;<br />
角色名,,积分,补偿原因;<br />
角色名,,积分,补偿原因;<br />
角色名,,积分,补偿原因;<br />
---------道具卡牌 角色名,道具ID,个数,补偿原因;<br />
角色名,道具ID,个数,补偿原因;<br />
角色名,道具ID,个数,补偿原因;<br />
角色名,道具ID,个数,补偿原因;<br />

<br />
<br />
<br />
<br />
由于网络等各种原因：单个文件请勿过大(1000条内);<br />
</font></form>
<?php }else {

	echo "你没有权限！";
}?>
</body>
</html>
