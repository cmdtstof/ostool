<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>数据查询</title>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
		<link rel="stylesheet" type="text/css" href="css/login.css" />
		<script type="text/javascript" src = "js/jquery-1.6.2.min.js"></script>

<script type="text/javascript">
        
        
        function login() {
			var name = document.getElementById("username");
			var pwd = document.getElementById("pwd");
			if(name.value==""){
				alert("请输入用户名");
				name.focus();
				return ;
			}else if(pwd.value==""){
				alert("请输入密码");
				pwd.focus();
				return ;
			}else{
				document.getElementById("loginForm").action="index.php";
        		document.getElementById("loginForm").submit();
			}
        }

        function cancle(){
        	document.getElementById("userName").value="";
        	document.getElementById("pwd").value="";
        }
</script>
</head>

<body><div id="login">
			<form id="loginForm" action="" method="post">
					<table border=0 cellpadding="0" cellspacing="0"
						style="line-height: 30px; width: 250px; font-size: 13px;">
						<tr>
							<td style="width: 80px;">
								用户:
							</td>
							<td>
								<input type="text" id="username" name="username"
									style="width: 150px; height: 20px" value="" />
							</td>
						</tr>
						<tr>
							<td>
								密码:
							</td>
							<td>
								<input type="password" id="pwd" name="pwd"
									style="width: 150px; height: 20px" value="" />
							</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align: center;">
								<input type="image" src="img/login.jpg"
									onclick="login();" />
								&nbsp;
								<img name="reg" style="cursor: pointer"
									src="img/reset.jpg" onclick="cancle();" />
							</td>
						</tr>
					</table>
					</form>
		</div>
</body>
</html>