
<?php
/**
* 读取4中配置的表信息,现支持php.ini,xml.yaml
*/
class Settings{
var $_settings = array();
	/**
    * 获取某些设置的值
    *
    * @param unknown_type $var
    * @return unknown
    */
	
       function get($var) {
         $var = explode('.', $var);

         $result = $this->_settings;
         foreach ($var as $key) {
                   if (!isset($result[$key])) {
						return ''; 
				   }

                   $result = $result[$key];
         }
         return $result;

        // trigger_error ('Not yet implemented', E_USER_ERROR);//引发一个错误
       }

       function load($file) {
	echo "12312";
            trigger_error ('Not yet implemented', E_USER_ERROR);
       }
}


Class Settings_INI Extends Settings {
	function load ($file) {
			 if (file_exists($file) == false) { return false; }
			 $this->_settings = parse_ini_file ($file, true);
	}
}


$settings = new Settings_INI;
$settings->load('../config.ini'); 

$commonset = new Settings_INI;
$commonset->load('../common.ini'); 

//echo 'INI: 1' . $settings->get('DB.host') . '';
?>

