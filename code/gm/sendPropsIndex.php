<html>
<body>

<?php
require '../common/userinfo.php';
if($_COOKIE["username"]==$os_user_name){ ?>
<form action="upload_file.php" method="post"
	enctype="multipart/form-data"><label for="file">��ѡ��Ҫ�ϴ����ļ���txt��ʽ��:</label>
<input type="file" name="file" id="file" /> <br />
<input type="submit" name="submit" value="�ύ" /> <br />
<font color="red"> txt���ļ�����ѡ��Ӣ��;<br />
TXT�е����ݸ�ʽ���£�����Ϊ��ǣ���<br />

--------���� ��ɫ��,,����,����ԭ��;<br />
��ɫ��,,����,����ԭ��;<br />
��ɫ��,,����,����ԭ��;<br />
��ɫ��,,����,����ԭ��;<br />
---------���߿��� ��ɫ��,����ID,����,����ԭ��;<br />
��ɫ��,����ID,����,����ԭ��;<br />
��ɫ��,����ID,����,����ԭ��;<br />
��ɫ��,����ID,����,����ԭ��;<br />

<br />
<br />
<br />
<br />
��������ȸ���ԭ�򣺵����ļ��������(1000����);<br />
</font></form>
<?php }else {

	echo "��û��Ȩ�ޣ�";
}?>
</body>
</html>
