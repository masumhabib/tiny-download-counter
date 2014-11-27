<?php
/*
Plugin Name: Tiny Download Counter
Plugin URI: http://github.org/masum.habib
Description: Counts how many times a given file has been being downloaded 
Version: 0.02.0
Author: K M Masum Habib
Author URI: http://masumhabib.com/

Released under the GPL version 2.0, http://www.gnu.org/licenses/gpl-2.0.html

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License version 2.0 for more details.
*/


require_once(dirname(__FILE__)."/settings.php");

define('TDC_PLUGIN_BASEDIR', plugin_basename());
define('TDC_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once(TDC_PLUGIN_DIR."/functions.php");        
require_once(TDC_PLUGIN_DIR."/ui.php");        

// [tdc_file name="file.zip"]
function tdc_tag_handler( $atts ) {
    $file = shortcode_atts( array(
        'name' => 'NONE',
        'label' => 'NONE',
        'icon' => 'icon1'
    ), $atts);

    $file_name = $file['name'];
    if( $file_name != 'NONE'){
        $icon = $file['icon'];

        list($link, $label, $size, $count) = tdc_get_fileinfo($file_name);

        if ($file['label'] != 'NONE'){
            $label = $file['label'];
        }

        $text = create_button($link, $label, $size, $count, $icon);

        return "{$text}";
    }
}
add_shortcode( 'tdc_file', 'tdc_tag_handler' );

