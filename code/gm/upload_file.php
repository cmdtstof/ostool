<?php
//echo $_FILES["file"]["type"];
$checkFileName = "";
if ((($_FILES["file"]["type"] == "text/plain"))
&& ($_FILES["file"]["size"] < 2000000))
{
	if ($_FILES["file"]["error"] > 0)
	{
		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	}
	else
	{
		$checkFileName = date('YmdHis',time()).".txt";
		iconv("utf-8","gb2312",$_FILES["file"]["name"]);
		//echo "Upload: " . iconv("utf-8","gb2312",$_FILES["file"]["name"]). "<br />";
		$encoding = mb_detect_encoding($_FILES["file"]["name"], array('GB2312','GBK','UTF-16','UCS-2','UTF-8','BIG5','ASCII'));
		$checkFileName = date('YmdHis',time())."_".$_FILES["file"]["name"];
		//$buffer  = substr($buffer,0,strlen($buffer)-2);
		// echo "Type: " . $_FILES["file"]["type"] . "<br />";
		// echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		// echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
		if (file_exists("upload/" . $checkFileName))
		{
			echo $checkFileName . " already exists. ";
		}
		else
		{

			move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $checkFileName);
			echo "文件上传成功,以下为文件内容<br/>";
			//echo "Stored in: " . "upload/" . $_FILES["file"]["name"]."<br/>";
	  readTxt("upload/" . $checkFileName);

		}
	}
}
else
{
	echo "Invalid file";
}


function readTxt($file_name){
	$fp=fopen($file_name,'r');

	echo "<table border='1'><thead><tr><td>角色名</td><td>物品ID</td><td>数量</td><td>备注</td></tr></thead><tbody>";

	while(!feof($fp))
	{
		$buffer=fgets($fp);
		if(strlen($buffer)>0){
			//if (preg_match("/^abc\s$/",$buffer))
			//{echo "找到了";}
			//echo $buffer."<br>";
			//$encoding = mb_detect_encoding($buffer, array('GB2312','GBK','UTF-16','UCS-2','UTF-8','BIG5','ASCII'));
			//echo $encoding;
			// echo "1".mb_convert_encoding ( $buffer, 'UTF-8','Unicode');
			// echo  "2".iconv($encoding, 'UTF-8', $buffer);
			//echo "3".iconv('gb2312','utf-8',$buffer);
				
			$buffer  = substr($buffer,0,strpos($buffer, ";"));
			$a = explode(',',$buffer);
			$rolename=$a[0];
			$prop=$a[1];
			$num=$a[2];
			$remark=$a[3];
			echo "<tr><td>".$rolename."</td><td>".$prop."</td><td>".$num."</td><td>".$remark."</td></tr>";
			insertbc($rolename,$prop,$num,$remark,$file_name) or  die("1111111");
			//gm_addItem($rolename,$prop,$num,$remark);
		}
	}
	echo "</tbody></table>";
	fclose($fp);
}

function insertbc($rolename,$prop,$num,$remark,$filename){
	//$rolename = iconv('gb2312','utf-8',$rolename);
	//echo $prop;
	//echo $num;
	//echo $remark."<br/>";
	require '../utils/dbOstoolUtils.php';
	$server =$_SERVER['SERVER_NAME'];
	$logsql = "INSERT INTO buchang (rolename,propsId,num,remark,filename,type,op,isDeal,server) VALUES ('".$rolename."','.$prop.','.$num.','.$remark.','.$filename.','','',0,'.$server.');";
	//	echo $logsql."<br/>";
	$result=mysql_query($logsql, $osconn)  or  die("Unable to connect");
	// 释放资源
	//mysql_free_result($result);
	// 关闭连接
	mysql_close($osconn) or die("Unable to close connect");;
	return true;
}



?>

命令类型
<select id="cmdselect" name="cmdselect">
<option value="">--请选择--</option>
<option value="1">添加积分</option>
<option value="2">添加卡牌</option>
<option value="3">添加物品</option>
</select>
<input type="button" onclick="sendProps('<?php echo $checkFileName ?>')" value="发送"/>

<script type="text/javascript">
function sendProps(filename){
	var cmd =document.getElementById("cmdselect").value;
	if(cmd==""){
		 alert("请选择要执行的命令");
	}else{
		this.location = "sendProps.php?filename="+filename+"&cmd="+cmd;
	}
}

</script>