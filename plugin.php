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
 * @Last Modified time: 2022-04-26 18:54:30
 * @requires: PHP 7.3+
 * @requires: WP 5.9.0+
 * @requires: ID230 and ID125 on the CeoJuice API
 * @requires: PHPfastCache 8.0.0+

Requires PHPfastCache (included in this plugin)
Requires PHP 7.3+ because of the PHPfastCache library
With caching disabled you may be able to run this plugin on lower versions of PHP, but this is untested.
*/
define('CJ_API_URL', 'https://www.ceojuice.com/api/');
define('CJ_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CJ_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CJ_CACHE_DIR', CJ_PLUGIN_DIR . 'cache/');
define('CJ_CUSTOMER_NUMBER', get_option('ceoJuice_custNum'));
define('CJ_API_KEY', get_option('ceoJuice_apiCode'));
define('CJ_CACHE_TIME', get_option('ceoJuice_cacheTime'));
define('CJ_CACHE_ENABLED', get_option('ceoJuice_caching'));
define('CJ_CACHE_TIME_DEFAULT', 3600);
define('CJ_CACHE_TIME_MIN', 60);
define('CJ_CACHE_TIME_MAX', 86400);
define('CJ_CACHE_UNIT', get_option('ceoJuice_cacheUnit'));
define('CJ_CACHE_UNIT_DEFAULT', 'seconds');
require_once(dirname(__FILE__) . '/inc/globalfunctions.php');

if (CJ_CACHE_ENABLED == 'true') {
require_once(dirname(__FILE__) . '/inc/phpfastcache/lib/Phpfastcache/Autoload/Autoload.php');
use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

// Setup File Path on your config files
// Please note that as of the V6.1 the "path" config
// can also be used for Unix sockets (Redis, Memcache, etc)
CacheManager::setDefaultConfig(new ConfigurationOption([
    'path' => CJ_PLUGIN_DIR . '/cache/phpfastcache/ceojuice-api-cache',
]));
}

// Admin notice if the CEOJuice Customer Number and API codes are not set.
if (CJ_CUSTOMER_NUMBER != null and CJ_API_KEY != null) { // If the CEOJuice Customer Number and API codes are set.
    if (CJ_CUSTOMER_NUMBER != '' and CJ_API_KEY != '') { // If the CEOJuice Customer Number and API codes are not empty.
        if (CJ_CUSTOMER_NUMBER != 'ceo001') { // If the CEOJuice Customer Number is not set to ceo001.
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
