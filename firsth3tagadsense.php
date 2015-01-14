<?php
/*
Plugin Name: Fisrt H3 Tag Adsense
Plugin URI: https://github.com/j801/firsth3tagadsense
Description: This is The Plugin is For Google Adxsense.
Author: Minoru Wada
Version: 1.0
Author URI: http://mon8co.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

define('H3_REG', '/<h3.*?>/i');

function add_adsense_custom_fields_FirstH3TagAdsense() {
    add_settings_field( 'adsense_seting', 
                        'adsense_Manege', 
                        'custom_adsense_field_FirstH3TagAdsense', 
                        'general', 
                        'default', 
                        array( 'label_for' => 'adsense_code' ) );
}

add_action( 'admin_init', 'add_adsense_custom_fields_FirstH3TagAdsense' );
 
function custom_adsense_field_FirstH3TagAdsense( $args ) {
    $adsense_code = get_option( 'adsense_code' );
?>
    <textarea name="adsense_code" id="adsense_code" cols="100" rows="10"   >
         <?php echo esc_html( $adsense_code );?>
	  </textarea>
<?php
}

function add_custom_whitelist_options_fields_FirstH3TagAdsense() {
    register_setting( 'general', 'adsense_code' );
}

add_filter( 'admin_init', 'add_custom_whitelist_options_fields_FirstH3TagAdsense' );

function get_h3_included_in_body_FirstH3TagAdsense( $the_content ){
  if ( preg_match_all( H3_REG, $the_content, $h3results,0,1 )) {
    return $h3results[0];
  }
}

function add_ads_before_1st_h3_FirstH3TagAdsense($the_content) {
  if ( is_single() ) {
    
    $ad_template = get_option('adsense_code');
    
    $h3result = get_h3_included_in_body_FirstH3TagAdsense( $the_content );

    if ( $h3result ) {
      $the_content = preg_replace(H3_REG, $ad_template.$h3result[0], $the_content, 1);
    }
  }
  return $the_content;
}

// set that function up to execute when action is called
add_filter('the_content', 'add_ads_before_1st_h3_FirstH3TagAdsense');

if ( function_exists('register_uninstall_hook') )
    register_uninstall_hook(__FILE__, 'my_uninstall_hook_FirstH3TagAdsense');

function my_uninstall_hook_FirstH3TagAdsense()
{
    delete_option('adsense_seting');
}
?>