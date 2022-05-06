<?php
/*
Plugin Name:  CEOJuice API Connector
Plugin URI:   https://patrickbarnhardt.com/plugins/ceojuice-api
Description:  WorPress Plugin for contacting the CeoJuice API to retrieve and display NPS data and Testimonials. Based on the theme feature I created for Modern Impressions.
Version:      1.0.0
Author:       Patrick Barnhardt
Author URI:   https://www.patrickbarnhardt.com

 * @Author: crimsonstrife
 * @Date: 2022-04-26 15:30:51
 * @Last Modified by: crimsonstrife
 * @Last Modified time: 2022-04-29 14:51:14
*/

// Settings Page: CEOJuice
class ceojuice_Settings_Page
{

    public function __construct()
    {
        add_action('admin_menu', array($this, 'wph_create_settings'));
        add_action('admin_init', array($this, 'wph_setup_sections'));
        add_action('admin_init', array($this, 'wph_setup_fields'));
    }

    public function wph_create_settings()
    {
        $icon_base64 = 'PD94bWwgdmVyc2lvbj0iMS4wIiBzdGFuZGFsb25lPSJubyI/Pgo8IURPQ1RZUEUgc3ZnIFBVQkxJQyAiLS8vVzNDLy9EVEQgU1ZHIDIwMDEwOTA0Ly9FTiIKICJodHRwOi8vd3d3LnczLm9yZy9UUi8yMDAxL1JFQy1TVkctMjAwMTA5MDQvRFREL3N2ZzEwLmR0ZCI+CjxzdmcgdmVyc2lvbj0iMS4wIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciCiB3aWR0aD0iMTYuMDAwMDAwcHQiIGhlaWdodD0iMTYuMDAwMDAwcHQiIHZpZXdCb3g9IjAgMCAxNi4wMDAwMDAgMTYuMDAwMDAwIgogcHJlc2VydmVBc3BlY3RSYXRpbz0ieE1pZFlNaWQgbWVldCI+Cgo8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgwLjAwMDAwMCwxNi4wMDAwMDApIHNjYWxlKDAuMTAwMDAwLC0wLjEwMDAwMCkiCmZpbGw9IiMwMDAwMDAiIHN0cm9rZT0ibm9uZSI+CjxwYXRoIGQ9Ik00IDE0NyBjLTMgLTggLTQgLTQzIC0yIC03OCBsMyAtNjQgNzUgMCA3NSAwIDAgNzUgMCA3NSAtNzMgMyBjLTU1CjIgLTc0IC0xIC03OCAtMTF6IG0xMTQgLTMzIGMzMSAtNiAzMiAtOCAzMiAtNTUgbDAgLTQ5IC03MCAwIC03MCAwIDAgNjEgMCA2MQozOCAtNSBjMjAgLTMgNTIgLTkgNzAgLTEzeiIvPgo8cGF0aCBkPSJNMzAgNzYgYzAgLTIyIDI2IC0zOCA1NiAtMzQgMjggMyA1NCAzMiA0MCA0NSAtNCA0IC0xMiAwIC0xNyAtMTAKLTEyIC0yMSAtNDggLTIyIC01NSAtMiAtOCAxOSAtMjQgMjAgLTI0IDF6Ii8+CjwvZz4KPC9zdmc+Cg==';
        $icon_data_uri = 'data:image/svg+xml;base64,' . $icon_base64;

        $page_title = 'CEOJuice API Settings';
        $menu_title = 'CEOJuice';
        $capability = 'manage_options';
        $slug = 'ceojuice';
        $callback = array($this, 'wph_settings_content');
        $icon = $icon_data_uri;
        $position = 65;
        add_menu_page($page_title, $menu_title, $capability, $slug, $callback, $icon, $position);
    }

    public function wph_settings_content()
    {
        //Get the active tab from the $_GET param
        $default_tab = null;
        $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab; ?>
<div id="navWrapper" style="background-image: url(<?php echo CJ_PLUGIN_URL . "assets/img/Top_Background.png" ?>);">
    <nav class="navbar navbar-expand-xl navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="https://www.ceojuice.com/">
                <img id="navImage" src="<?php echo CJ_PLUGIN_URL . "assets/img/Logo.png" ?>">
            </a>
            <div class="collapse navbar-collapse flex-md-column" id="navbarToggler">
                <ul class="navbar-nav ml-auto small">
                    <li class="nav-item">
                        <a class="nav-link" id="navAbout" href="https://www.ceojuice.com/Home/About"
                            target="_blank">About CEO Juice</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<div class="wrap">
    <h2 class="nav-tab-wrapper">
        <a href="?page=ceojuice" class="nav-tab <?php if ($tab === null) : ?>nav-tab-active<?php endif; ?>">API
            Settings</a>
        <a href="?page=ceojuice&tab=features"
            class="nav-tab <?php if ($tab === 'features') : ?>nav-tab-active<?php endif; ?>">Features</a>
        <a href="?page=ceojuice&tab=cache"
            class="nav-tab <?php if ($tab === 'cache') : ?>nav-tab-active<?php endif; ?>">Caching</a>
        <a href="?page=ceojuice&tab=howto"
            class="nav-tab <?php if ($tab === 'howto') : ?>nav-tab-active<?php endif; ?>">How To Use</a>
    </h2>
    <div class="tab-content" ng-app="app">
        <?php switch ($tab):
                    case 'features':
                        settings_fields('ceojuice'); ?>
        <form method="post" action="options.php">
            <table class="form-table" role="presentation">
                <tbody>
                    <tr>
                        <th scope="row">
                            <h2>Enable CEOJuice API Features</h2>
                        </th>
                        <td>
                            <?php do_settings_fields('ceojuice', 'features_section'); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
        <div class="submit-section">
            <?php if ($tab != 'howto') {
                                submit_button(); ?>
            <div class="submit result">
                <div class="submit-message">
                    <?php settings_errors(); ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php break;
                    case 'cache':
                        settings_fields('ceojuice'); ?>
        <form method="post" action="options.php">
            <tr>
                <th scope="row">
                    <h2>Set API Cache Settings</h2>
                </th>
                <td>
                    <?php do_settings_fields('ceojuice', 'cache_section'); ?>
                </td>
            </tr>
            </tbody>
            </table>
        </form>
        <div class="submit-section">
            <?php if ($tab != 'howto') {
                                submit_button(); ?>
            <div class="submit result">
                <div class="submit-message">
                    <?php settings_errors(); ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php break;
                    case 'howto': ?>
        <?php require_once(CJ_PLUGIN_DIR . 'inc/howto.php');
                        ?>
        <?php break;
                    default:
                        settings_fields('ceojuice'); ?>
        <form method="post" action="options.php">
            <tr>
                <th scope="row">
                    <h2>Set API Settings</h2>
                </th>
                <td>
                    <?php do_settings_fields('ceojuice', 'ceojuice_section'); ?>
                </td>
            </tr>
            </tbody>
            </table>
        </form>
        <div class="submit-section">
            <?php if ($tab != 'howto') {
                                submit_button(); ?>
            <div class="submit result">
                <div class="submit-message">
                    <?php settings_errors(); ?>
                </div>
            </div>
            <?php } ?>
        </div>
        <?php break;
                endswitch; ?>
    </div>
    <script type="text/javascript" id="checked-unchecked">
    //Toggle the checked state of the checkbox switch
    jQuery(document).ready(function() {
        //If the .toggle span is clicked, add or remove the checked class from the checkbox input
        jQuery('.toggle').click(function() {
            jQuery(this).toggleClass('checked'); //toggle the checked class
            jQuery(this).prev('input').prop('checked', !jQuery(this).prev('input').prop(
                'checked')); //toggle the checked property of the input
        });
    });
    </script>
</div>
<?php
    }
    public function wph_setup_sections()
    {
        add_settings_section('ceojuice_section', 'Settings for the CEOJuice API', array(), 'ceojuice');
        add_settings_section('features_section', 'Enable API Features', array(), 'ceojuice');
        add_settings_section('cache_section', 'Settings for the API Cache', array(), 'ceojuice');
    }

    public function wph_setup_fields()
    {
        $fields = array(
            array(
                'label' => '*CEOJuice Customer Number',
                'id' => 'ceoJuice_custNum',
                'type' => 'text-required',
                'section' => 'ceojuice_section',
                'desc' => 'Your CEOJuice Customer Number',
                'placeholder' => '(required)',
            ),
            array(
                'label' => '*CEOJuice API Code',
                'id' => 'ceoJuice_apiCode',
                'type' => 'text-required',
                'section' => 'ceojuice_section',
                'desc' => 'Code required to request your data from the CEOJuice API',
                'placeholder' => '(required)',
            ),
            array(
                'label' => 'Enable PHPfastCache',
                'id' => 'ceoJuice_caching',
                'type' => 'checkbox',
                'section' => 'cache_section',
                'desc' => 'Enable built-in caching for this plugin to reduce API calls',
                'placeholder' => 'true',
                'style' => 'roundedswitch',
            ),
            array(
                'label' => 'Enable NetPromoterScore (NPS&#174;)',
                'id' => 'ceoJuice_enableNPS',
                'type' => 'checkbox',
                'section' => 'features_section',
                'desc' => 'Enable the NPS API feature',
                'placeholder' => 'false',
                'style' => 'roundedswitch',
            ),
            array(
                'label' => 'Enable Favorite Testimonials',
                'id' => 'ceoJuice_enableTestimonials',
                'type' => 'checkbox',
                'section' => 'features_section',
                'desc' => 'Enable Testimonials API feature - You need to favorite a testimonial to pull it from the API',
                'placeholder' => 'false',
                'style' => 'roundedswitch',
            ),
            array(
                'label' => 'Cache Duration',
                'id' => 'ceoJuice_cacheTime',
                'type' => 'number',
                'section' => 'cache_section',
                'desc' => 'Set the amount here, and the time unit in the next field.',
                'placeholder' => '3600',
                'min' => '60',
                'max' => '86400',
                'dependency' => 'ceoJuice_caching',
            ),
            array(
                'label' => 'Cache Duration Unit',
                'id' => 'ceoJuice_cacheUnit',
                'type' => 'select',
                'section' => 'cache_section',
                'options' => array(
                    'seconds' => 'Seconds',
                    'minutes' => 'Minutes',
                    'hours' => 'Hours',
                    'days' => 'Days',
                ),
                'placeholder' => 'Seconds',
                'dependency' => 'ceoJuice_cacheTime',
            ),
        );
        foreach ($fields as $field) {
            add_settings_field($field['id'], $field['label'], array($this, 'wph_field_callback'), 'ceojuice', $field['section'], $field);
            register_setting('ceojuice', $field['id'], array($this, 'sanitize'));
        }
    }

    public function wph_field_callback($field)
    {
        $value = get_option($field['id']);
        $placeholder = '';
        if (isset($field['placeholder'])) {
            $placeholder = $field['placeholder'];
        }
        switch ($field['type']) {
            case 'number':
                $dependency = '';
                $required = '';
                if (isset($field['dependency'])) {
                    $dependency = $field['dependency'];
                    $required = 'required';
                }
                if (!empty($field['min'])) {
                    printf(
                        '<input type="number" name="%1$s" id="%1$s" value="%2$s" placeholder="%3$s" min="%4$s" max="%5$s" %6$s/>',
                        $field['id'],
                        $value,
                        $placeholder,
                        $field['min'],
                        $field['max'],
                        $required,
                    );
                } else {
                    printf(
                        '<input type="number" name="%1$s" id="%1$s" value="%2$s" placeholder="%3$s" %4$s/>',
                        $field['id'],
                        $value,
                        $placeholder,
                        $required,
                    );
                }
                break;
            case 'checkbox':
                $checked = '';
                $class = '';
                $label = '';
                $after = '';
                $value = $field['placeholder'];
                if ($value === 'true') {
                    $checked = 'checked';
                }
                if (isset($field['style'])) {
                    switch ($field['style']) {
                        case 'roundedswitch':
                            $class = 'roundedswitch';
                            $label = '<label for="cbSwitchRounded" class="switchCtrl rounded">';
                            $after = '<span class="' . $field['id'] . ' toggle"></span></label>';
                            break;
                        default:
                    }
                }
                printf(
                    '%7$s<input %s id="%2$s" class="%2$s %5$s" name="%3$s" type="checkbox" value="%1$s" %4$s>%6$s',
                    $value === '1' ? 'checked' : '', // checked?
                    $field['id'],
                    $field['id'],
                    $checked,
                    $class,
                    $after,
                    $label,
                );
                break;
            case 'radio':
                if (!empty($field['options']) && is_array($field['options'])) {
                    $iterator = 0;
                    $checked = '';
                    foreach ($field['options'] as $key => $label) {
                        $iterator++;
                        if ($field['placeholder'] == $key) {
                            $checked = 'checked';
                        } else {
                            $checked = '';
                        }
                        printf(
                            '<label for="%1$s_%6$s"><input id="%1$s_%6$s" name="%1$s" type="%2$s" value="%3$s" %4$s /> %5$s</label><br/>',
                            $field['id'],
                            $field['type'],
                            $key,
                            $checked,
                            $label,
                            $iterator,
                        );
                    }
                }
                break;
            case 'select':
                if (!empty($field['options']) && is_array($field['options'])) {
                    $options_markup = '';
                    $iterator = 0;
                    $checked = '';
                    foreach ($field['options'] as $key => $label) {
                        $iterator++;
                        if ($field['placeholder'] == $key) {
                            $checked = 'selected';
                        } else {
                            $checked = '';
                        }
                        $options_markup .= sprintf(
                            '<option value="%1$s" %2$s>%3$s</option>',
                            $key,
                            $checked,
                            $label,
                        );
                    }
                    printf(
                        '<select name="%1$s" id="%1$s">%2$s</select>',
                        $field['id'],
                        $options_markup
                    );
                }
                break;
            case 'multiselect':
                if (!empty($field['options']) && is_array($field['options'])) {
                    $attr = '';
                    $options = '';
                    foreach ($field['options'] as $key => $label) {
                        $options .= sprintf(
                            '<option value="%s" %s>%s</option>',
                            $key,
                            selected($value, $key, false),
                            $label
                        );
                    }
                    if ($field['type'] === 'multiselect') {
                        $attr = ' multiple="multiple" ';
                    }
                    printf(
                        '<select name="%1$s" id="%1$s" %2$s>%3$s</select>',
                        $field['id'],
                        $attr,
                        $options
                    );
                }
                break;
            case 'text-required':
                printf(
                    '<input type="text" name="%1$s" id="%1$s" value="%2$s" size="45" maxlength="50" placeholder="%3$s" required /><span class="validity"></span>',
                    $field['id'],
                    $value,
                    $placeholder
                );
                break;
            default:
                printf(
                    '<input name="%1$s" id="%1$s" type="%2$s" placeholder="%3$s" value="%4$s" />',
                    $field['id'],
                    $field['type'],
                    $placeholder,
                    $value
                );
        }
        if (isset($field['desc'])) {
            if ($desc = $field['desc']) {
                printf('<p class="description">%s </p>', $desc);
            }
        }
    }
}
new ceojuice_Settings_Page();

function replace_footer_admin()
{
    echo '<span id="footer-thankyou">Thank you for creating with <a href="https://wordpress.org/">WordPress</a>.</span><br />';
    echo '<span>This unofficial plugin was developed by Patrick Barnhardt. It is not affiliated or supported by CEO Juice Inc. or Satmetrix Systems, Inc.</span><br />';
    echo '<span>CEOJUICE™ is a registered trademark of <a href="https://www.ceojuice.com/">CEO Juice Inc.</a></span><br />';
    echo '<span>Net Promoter, NPS, and Net Promoter Score are trademarks of Satmetrix Systems, Inc., Bain & Company, and Fred Reichheld.</span><br />';
}

if ($pagenow == 'admin.php' && $_GET['page'] == 'ceojuice') { // only run this on the plugin settings page
    add_filter('admin_footer_text', 'replace_footer_admin');
}

function add_apisettingslink_admin_submenu()
{
    global $submenu;
    $permalink = admin_url('admin.php?page=ceojuice');
    $submenu['ceojuice'][] = array('API Key', 'manage_options', $permalink);
}
add_action('admin_menu', 'add_apisettingslink_admin_submenu');

function add_featuresettingslink_admin_submenu()
{
    global $submenu;
    $permalink = admin_url('admin.php?page=ceojuice') . '&tab=features';
    $submenu['ceojuice'][] = array('Features', 'manage_options', $permalink);
}
add_action('admin_menu', 'add_featuresettingslink_admin_submenu');

function add_cachesettingslink_admin_submenu() //adds a link to the cache settings page to the admin menu
{
    global $submenu;
    $permalink = admin_url('admin.php?page=ceojuice') . '&tab=cache';
    $submenu['ceojuice'][] = array('Cache', 'manage_options', $permalink);
}
add_action('admin_menu', 'add_cachesettingslink_admin_submenu');

function add_ceohowto_admin_submenu()
{
    global $submenu;
    $permalink = admin_url('admin.php?page=ceojuice') . '&tab=howto';
    $submenu['ceojuice'][] = array('How To Use', 'manage_options', $permalink);
}
add_action('admin_menu', 'add_ceohowto_admin_submenu');

// Create Shortcode ceo_nps_score
// Shortcode: [ceo_nps_score meter_style="default" display_type="full"]
function create_ceonpsscore_shortcode($atts)
{

    // Attributes
    $atts = shortcode_atts(
        array(
            'meter_style' => 'default',
            'display_type' => 'full',
        ),
        $atts,
        'ceo_nps_score'
    );

    // Attributes in var
    $meter_style = $atts['meter_style'];
    $display_type = $atts['display_type'];

    // Your Code

}
add_shortcode('ceo_nps_score', 'create_ceonpsscore_shortcode'); ?>
