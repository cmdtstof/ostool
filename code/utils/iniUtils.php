
<?php
/**
* ��ȡ4�����õı���Ϣ,��֧��php.ini,xml.yaml
*/
class Settings{
var $_settings = array();
	/**
    * ��ȡĳЩ���õ�ֵ
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

        // trigger_error ('Not yet implemented', E_USER_ERROR);//����һ������
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

