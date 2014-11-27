<?php
/*
Plugin Name: Tiny Download Counter
Plugin URI: https://github.com/masumhabib/tiny-download-counter
Description: Counts how many times a given file has been being downloaded 
Version: 0.02.0
Author: K M Masum Habib
Author URI: http://masumhabib.com/

Released under the BSD license. See the license.txt for details.

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
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

