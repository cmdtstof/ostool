<link type="text/css" rel="stylesheet" href="../css/common.css" />
<body>
<?php
require '../utils/iniUtils.php';

if(!isset($_GET["tablename"])){
}else {
	if($_GET["tablename"]=='item'){
		require './ostool_item.php';
	}else if($_GET["tablename"]=='card'){
		require './ostool_card.php';
	}
}
?>
</body>