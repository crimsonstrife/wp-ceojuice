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
 * @Last Modified time: 2022-04-26 21:58:21
 * @requires: PHP 7.3+
 * @requires: WP 5.9.0+
 * @requires: ID230 and ID125 on the CeoJuice API
 * @requires: PHPfastCache 8.0.0+

Requires PHPfastCache (included in this plugin)
Requires PHP 7.3+ because of the PHPfastCache library
With caching disabled you may be able to run this plugin on lower versions of PHP, but this is untested.
*/

use Phpfastcache\CacheManager;
use Phpfastcache\Config\ConfigurationOption;

define('CJ_API_URL', 'https://www.ceojuice.com/api/');
define('CJ_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CJ_PLUGIN_URL', plugin_dir_url(__FILE__));
define('CJ_CACHE_DIR', CJ_PLUGIN_DIR . 'cache/');
define('CJ_CUSTOMER_NUMBER', get_option('ceoJuice_custNum'));
define('CJ_API_KEY', get_option('ceoJuice_apiCode'));
define('CJ_CACHE_TIME_SET', get_option('ceoJuice_cacheTime'));
define('CJ_CACHE_ENABLED', get_option('ceoJuice_caching'));
define('CJ_CACHE_ENABLED_DEFAULT', 'true');
define('CJ_CACHE_PREFIX', 'ceojuice_');
define('CJ_CACHE_TIME_DEFAULT', 3600);
define('CJ_CACHE_TIME_MIN', 60);
define('CJ_CACHE_TIME_MAX', 86400);
define('CJ_CACHE_UNIT', get_option('ceoJuice_cacheUnit'));
define('CJ_CACHE_UNIT_DEFAULT', 'seconds');
require_once(dirname(__FILE__) . '/inc/globalfunctions.php');

if (CJ_CACHE_ENABLED == 'true') {
    if (PHP_VERSION < 7.3) {
        add_action('admin_notices', 'show_ceoadmin_invalidphp');
        $InstanceCache = null;
    } else {
        require_once(dirname(__FILE__) . '/inc/phpfastcache/lib/Phpfastcache/Autoload/Autoload.php'); // Load PHPfastCache Autoloader
        // Setup File Path
        // Please note that as of the V6.1 the "path" config
        // can also be used for Unix sockets (Redis, Memcache, etc)
        CacheManager::setDefaultConfig(new ConfigurationOption([
            'path' => CJ_PLUGIN_DIR . '/cache/phpfastcache/ceojuice-api-cache',
        ]));
        $InstanceCache = CacheManager::getInstance('files'); // Get the cache instance.
        if (CJ_CACHE_TIME_SET != null && CJ_CACHE_TIME_SET != '') {
            $cacheTime = intval(CJ_CACHE_TIME_SET);
            if ($cacheTime < CJ_CACHE_TIME_MIN) {
                $cacheTime = CJ_CACHE_TIME_MIN;
            } elseif ($cacheTime > CJ_CACHE_TIME_MAX) {
                $cacheTime = CJ_CACHE_TIME_MAX;
            }
        } else {
            $cacheTime = CJ_CACHE_TIME_DEFAULT;
        }
        switch (CJ_CACHE_UNIT) {
            case 'seconds':
                $cacheTime = $cacheTime; // if seconds, do nothing
                break;
            case 'minutes':
                $cacheTime = $cacheTime * 60; // if minutes, convert to seconds
                break;
            case 'hours':
                $cacheTime = $cacheTime * 60 * 60; // if hours, convert to seconds
                break;
            case 'days':
                $cacheTime = $cacheTime * 60 * 60 * 24; // if days, convert to seconds
                break;
            default:
                $cacheTime = CJ_CACHE_TIME_DEFAULT; // if no unit, default to seconds
                break;
        }
        define('CJ_CACHE_TIME', $cacheTime); // define the cache time
    }
} elseif (CJ_CACHE_ENABLED == 'false') {
    $InstanceCache = null;
} else {
    $InstanceCache = null;
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

function enqueuing_cjadmin_scripts($screen)
{
    // Check the $screen variable to see what page we're on
    // if you created a top level page in the previous step
    // $screen should be toplevel_page_$slug
    // If $screen doesn't match, we will quit so we don't
    // pollute the whole admin with our scripts/styles
    if ($screen != 'toplevel_page_ceojuice') { // If we're not on the CEOJuice API page.
        return; // Quit.
    }
    // Enqueue our scripts
    wp_dequeue_script('jquery');
    wp_enqueue_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array(), '3.6.0');
    wp_enqueue_script('jqueryuijs', 'https://cdn.jsdelivr.net/npm/jquery-ui-dist@1.12.1/jquery-ui.min.js', array(), '1.12.1');
    wp_enqueue_style('jqueryuics', 'https://cdn.jsdelivr.net/npm/jquery-ui-dist@1.12.1/jquery-ui.min.css', array(), '1.12.1');
    wp_enqueue_style('cjbootstrapcs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css', array(), '5.1.3');
    wp_enqueue_style('ceojuiceadmin', CJ_PLUGIN_URL . "assets/css/admin.min.css", array(), '1.0.0');
    wp_enqueue_script('cjbootstrapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.1.3', true);
}

add_action('admin_enqueue_scripts', 'enqueuing_cjadmin_scripts');

// Show admin notice
function show_ceoadmin_invalidphp()
{
    $class = 'notice notice-error is-dismissible';
    $message = __('Your PHP Version is incompatible with the PHPfastcache, update to 7.3+ ' . ' Current Version is: ' . PHP_VERSION, 'ceoJuice-api');

    printf('<div class="%1$s"><p>%2$s</p></div>', esc_attr($class), esc_html($message));
}
