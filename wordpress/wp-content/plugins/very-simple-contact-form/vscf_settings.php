<?php
/**
 * Plugin Name: Very Simple Contact Form
 * Description: This is a very simple contact form. Use shortcode [contact] to display form on page or use the widget. For more info please check readme file.
 * Version: 3.3
 * Author: Guido van der Leest
 * Author URI: http://www.guidovanderleest.nl
 * License: GNU General Public License v3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: verysimple
 * Domain Path: translation
 */


// Load the plugin's text domain
function vscf_init() { 
	load_plugin_textdomain( 'verysimple', false, dirname( plugin_basename( __FILE__ ) ) . '/translation' );
}
add_action('plugins_loaded', 'vscf_init');


// Enqueues plugin scripts
function vscf_scripts() {	
	if(!is_admin())	{
		wp_enqueue_style('vscf_style', plugins_url('vscf_style.css',__FILE__));
	}
}
add_action('wp_enqueue_scripts', 'vscf_scripts');


// The sidebar widget
function register_vscf_widget() {
	register_widget( 'vscf_widget' );
}
add_action( 'widgets_init', 'register_vscf_widget' );


// Function to get the IP address of the user
function vscf_get_the_ip() {
	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	else {
		return $_SERVER["REMOTE_ADDR"];
	}
}


// Check data before saving it in database 
// Same as sanitize_text_field function but line breaks are allowed 
function vscf_sanitize_text_field($str) {
	$filtered = wp_check_invalid_utf8( $str );

	if ( strpos($filtered, '<') !== false ) {
		$filtered = wp_pre_kses_less_than( $filtered );
		$filtered = wp_strip_all_tags( $filtered, false );
	} else {
		$filtered = trim( preg_replace('/[\t ]+/', ' ', $filtered) );
	}

	$found = false;
	while ( preg_match('/%[a-f0-9]{2}/i', $filtered, $match) ) {
		$filtered = str_replace($match[0], '', $filtered);
		$found = true;
	}

	if ( $found ) {
		$filtered = trim( preg_replace('/ +/', ' ', $filtered) );
	}
	return apply_filters( 'vscf_sanitize_text_field', $filtered, $str );
}


// Add the admin options page
function vscf_menu_page() {
    add_options_page( __( 'VSCF Custom Style', 'verysimple' ), __( 'VSCF Custom Style', 'verysimple' ), 'manage_options', 'vscf', 'vscf_options_page' );
}
add_action( 'admin_menu', 'vscf_menu_page' );


// Add the admin settings and such 
function vscf_admin_init() {
    register_setting( 'vscf-options', 'vscf-setting', 'vscf_sanitize_text_field' );
    add_settings_section( 'vscf-section', __( 'Description', 'verysimple' ), 'vscf_section_callback', 'vscf' );
    add_settings_field( 'vscf-field', __( 'Custom Style', 'verysimple' ), 'vscf_field_callback', 'vscf', 'vscf-section' );
}
add_action( 'admin_init', 'vscf_admin_init' );


function vscf_section_callback() {
    echo __( 'On this page you can add Custom Style (CSS) to change the layout of your Very Simple Contact Form.', 'verysimple' ); 
}


function vscf_field_callback() {
    $vscf_setting = esc_textarea( get_option( 'vscf-setting' ) );
    echo "<textarea name='vscf-setting' rows='10' cols='60' maxlength='2000'>$vscf_setting</textarea>";
}


// Display the admin options page
function vscf_options_page() {
?>
<div class="wrap"> 
	<div id="icon-plugins" class="icon32"></div> 
	<h2><?php _e( 'Very Simple Contact Form', 'verysimple' ); ?></h2> 
	<form action="options.php" method="POST">
	<?php settings_fields( 'vscf-options' ); ?>
	<?php do_settings_sections( 'vscf' ); ?>
	<?php submit_button(__('Save Style', 'verysimple')); ?>
	</form>
	<table class="widefat"> 
	<tbody> 
	<tr> 
	<td>
	<p><strong><?php _e( 'Field label', 'verysimple' ); ?>:</strong></p>
	<p>#vscf label { }</p>
	<p><strong><?php _e( 'All fields', 'verysimple' ); ?>:</strong></p>
	<p>#vscf input, #vscf textarea { }</p>
	<p><strong><?php _e( 'Fields by name', 'verysimple' ); ?>:</strong></p>
	<p>#vscf_name, #vscf_email, #vscf_subject, #vscf_sum { }</p>
	<p>#vscf_message { }</p>
	<p><strong><?php _e( 'Submit button', 'verysimple' ); ?>:</strong></p>
	<p>#vscf_send { }</p>
	<p>#vscf_send:hover { }</p>
	</td>
	<td>
	<p><strong><?php _e( 'Field error', 'verysimple' ); ?>:</strong></p>
	<p>#vscf input.error, #vscf textarea.error { }</p>
	<p><strong><?php _e( 'Error and Thank You message', 'verysimple' ); ?>:</strong></p>
	<p>#vscf .error { }</p>
	<p>.vscf_info { }</p>
	<p><strong><?php _e( 'Widget', 'verysimple' ); ?>:</strong></p>
	<p>.vscf_sidebar { }</p>
	<p><strong><?php _e( 'Plugin Stylesheet', 'verysimple' ); ?>:</strong></p>
	<p><?php _e( 'For Default Style', 'verysimple' ); ?> <a href="plugin-editor.php?file=very-simple-contact-form/vscf_style.css"><?php _e( 'Click Here', 'verysimple' ); ?></a>.</p>
	</td>
	</tr>
	</tbody> 
	</table>
</div>
<?php
}


// Include custom CSS in header 
function vscf_custom_css() {
	$vscf_css = esc_textarea( get_option( 'vscf-setting' ) );
	if (!empty($vscf_css)) {
		echo '<style type="text/css">' . "\n"; 
		echo $vscf_css . "\n";
		echo '</style>' . "\n"; 
	}
}
add_action( 'wp_head', 'vscf_custom_css' );


include 'vscf_main.php';
include 'vscf_widget_form.php';
include 'vscf_widget.php';

?>