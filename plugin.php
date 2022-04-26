<?php
/*
Plugin Name:  CEOJuice API Connector
Plugin URI:   https://patrickbarnhardt.com/plugins/ceojuice-api
Description:  WorPress Plugin for contacting the CeoJuice API to retrieve and display NPS data and Testimonials. Based on the theme feature I created for Modern Impressions.
Version:      1.0.0
Author:       Patrick Barnhardt
Author URI:   https://www.patrickbarnhardt.com
Repository URI: https://github.com/crimsonstrife/wp-ceojuice.git
License:      GPL3
Text Domain:  ceoJuice-api

 * @Author: crimsonstrife
 * @Date: 2022-04-26 14:49:01
 * @Last Modified by: crimsonstrife
 * @Last Modified time: 2022-04-26 16:39:19
 * @requires: PHP 8.0+
 * @requires: WP 5.9.0+
 * @requires: ID230 and ID125 on the CeoJuice API
 * @requires: PHPfastCache 9.0.0+

Requires PHPfastCache (included in this plugin)
Requires PHP 8.0+ because of the PHPfastCache library
With caching disabled you may be able to run this plugin on lower versions of PHP, but this is untested.
*/
define('CJ_API_URL', 'https://www.ceojuice.com/api/');
define('CJ_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CJ_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CJ_CACHE_DIR', CJ_PLUGIN_DIR . 'cache/');
require_once(dirname(__FILE__) . '/inc/globalfunctions.php');

// Admin notice if the CEOJuice Customer Number and API codes are not set.
if (get_option('ceoJuice_custNum') != null and get_option('ceoJuice_apiKey') != null) { // If the CEOJuice Customer Number and API codes are set.
    if (get_option('ceoJuice_custNum') != '' and get_option('ceoJuice_apiKey') != '') { // If the CEOJuice Customer Number and API codes are not empty.
        if (get_option('ceoJuice_custNum') != 'ceo001') { // If the CEOJuice Customer Number is not set to ceo001.
            $isCeoJuiceApiConfigured = true;
        } else {
            $isCeoJuiceApiConfigured = false;
        }
    } else {
        $isCeoJuiceApiConfigured = false;
    }
} else {
    $isCeoJuiceApiConfigured = false;
}
function show_ceoadmin_setcustomerinfo()
{
    $class = 'notice notice-warning is-dismissible';
    $message = __('You&#39;ll need to set the following in the plugin Settings:', 'ceoJuice-api');

    printf('<div class="%1$s"><p>%2$s<ol><li>Your CEO Juice Customer Number</li><li>Your CEO Juice API Code</li></ol>These can be found at the link below:</p><a href="https://www.ceojuice.com/CustomerAdmin/AccountDetails" target="_blank">https://www.ceojuice.com/CustomerAdmin/AccountDetails</a></div>', esc_attr($class), esc_html($message));
}
// Check if the CEOJuice Customer Number and API codes are set, if not display the notice.
if ($isCeoJuiceApiConfigured != true) {
    add_action('admin_notices', 'show_ceoadmin_setcustomerinfo');
}
