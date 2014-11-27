<?php
require_once(dirname(__FILE__)."/settings.php");
require_once(TDC_PLUGIN_DIR."/functions.php");        

// get the requested file name
$file_name = $_REQUEST['file_name'];

// get the file and send it back
tdc_do_download($file_name);

?>
