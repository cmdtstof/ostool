<link type="text/css" rel="stylesheet" href="../css/common.css" />
<body>
<?php
require '../utils/dbTcgUtils.php';
require '../utils/iniUtils.php';

if(!isset($_GET["tablename"])){
}else {
	if($_GET["tablename"]=='users'){
		require './tcg_user.php';
	}else {
		require './tcg_a.php';
	}
}
?>
</body>