<?php
/*
Plugin Name: I Am From
Plugin URI: https://github.com/mittmedia/i_am_from
Description: Adds user meta with user location (selection, not geoposition).
Version: 1.0.0
Author: Fredrik Sundström
Author URI: https://github.com/fredriksundstrom
License: MIT
*/

/*
Copyright (c) 2012 Fredrik Sundström

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
*/

require_once( 'wp_mvc/init.php' );

$i_am_from_app = new \WpMvc\Application();

$i_am_from_app->init( 'IAmFrom', WP_PLUGIN_DIR . '/i_am_from' );

// WP: Add pages
add_action( 'network_admin_menu', 'i_am_from_add_pages' );
function i_am_from_add_pages()
{
  add_submenu_page( 'settings.php', 'I Am From Settings', 'I Am From', 'Super Admin', 'i_am_from_settings', 'i_am_from_settings_page');
}

function i_am_from_settings_page()
{
  global $i_am_from_app;
  
  $i_am_from_app->settings_controller->index();
}

add_action( 'admin_enqueue_scripts', 'i_am_from_add_styles' );
function i_am_from_add_styles() {
  wp_enqueue_style( 'i_am_from_style_settings', WP_PLUGIN_URL . '/i_am_from/assets/build/stylesheets/settings.css' );
  wp_enqueue_script( 'i_am_from_script_settings', WP_PLUGIN_URL . '/i_am_from/assets/build/javascripts/settings.js' );
}

if ( isset( $_GET['i_am_from_updated'] ) ) {
  add_action( 'network_admin_notices', 'i_am_from_updated_notice' );
}

function i_am_from_updated_notice()
{
  $html = \WpMvc\ViewHelper::admin_notice( __( 'Settings saved.' ) );

  echo $html;
}

function wp_custom_user_profile_fields( $user )
    { ?>
 
        <h3><?php _e("Custom Profile Information"); ?></h3>
 
        <table class="form-table">
            <tr>
                <th><label for="address"><?php _e("Address"); ?></label></th>
                <td>
                    <input type="text" name="address" id="address" value="<?php echo esc_attr( get_the_author_meta( 'address', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your address."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="city"><?php _e("City"); ?></label></th>
                <td>
                    <input type="text" name="city" id="city" value="<?php echo esc_attr( get_the_author_meta( 'city', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your city."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="province"><?php _e("Province"); ?></label></th>
                <td>
                    <input type="text" name="province" id="province" value="<?php echo esc_attr( get_the_author_meta( 'province', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your province."); ?></span>
                </td>
            </tr>
            <tr>
                <th><label for="postalcode"><?php _e("Postal Code"); ?></label></th>
                <td>
                    <input type="text" name="postalcode" id="postalcode" value="<?php echo esc_attr( get_the_author_meta( 'postalcode', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e("Please enter your postal code."); ?></span>
                </td>
            </tr>
        </table>
<?php }
 
add_action( 'show_user_profile', 'wp_custom_user_profile_fields' ); //Add Some Action
add_action( 'edit_user_profile', 'wp_custom_user_profile_fields' );
 
function wp_save_custom_user_profile_fields( $user_id )
    {
        if ( !current_user_can( 'edit_user', $user_id ) ) { return false; } //User Auth
 
        update_usermeta( $user_id, 'address', $_POST['address'] );
        update_usermeta( $user_id, 'city', $_POST['city'] );
        update_usermeta( $user_id, 'province', $_POST['province'] );
        update_usermeta( $user_id, 'postalcode', $_POST['postalcode'] );
    }
 
//add_action( 'personal_options_update', 'wp_save_custom_user_profile_fields' );
//add_action( 'edit_user_profile_update', 'wp_save_custom_user_profile_fields' );