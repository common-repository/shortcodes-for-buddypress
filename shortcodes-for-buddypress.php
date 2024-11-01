<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wbcomdesigns.com/plugins
 * @since             1.0.0
 * @package           Shortcodes_For_Buddypress
 *
 * @wordpress-plugin
 * Plugin Name:       Wbcom Designs – Shortcodes & Elementor Widgets For BuddyPress
 * Plugin URI:        https://github.com/wbcomdesigns/shortcodes-for-buddypress
 * Description:       This plugin will add an extended feature to BuddyPress that will add a Shortcode for Listing Activity Streams, Members, and Groups on any post/page on the website. It will offer the same features as you are getting on BuddyPress-mapped component pages.
 * Version:           2.7.1
 * Author:            Wbcom Designs
 * Author URI:        https://wbcomdesigns.com/plugins
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       shortcodes-for-buddypress
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( in_array( 'shortcode-for-buddypress-pro/shortcodes-for-buddypress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	if ( ! function_exists( 'deactivate_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	add_action(
		'admin_notices',
		function() {
			$bp_shortcode     = esc_html__( 'Wbcom Designs – Shortcodes & Elementor Widgets For BuddyPress', 'shortcodes-for-buddypress' );
			$bp_shortcode_pro = esc_html__( 'Wbcom Designs - Shortcode For BuddyPress Pro', 'shortcodes-for-buddypress' );
			echo '<div class="error"><p>';
			/* translators: %s: */
			echo sprintf( esc_html__( '%1$s and %2$s will not activate togather. Please deactivate %1$s', 'shortcodes-for-buddypress' ), '<strong>' . esc_html( $bp_shortcode_pro ) . '</strong>', '<strong>' . esc_html( $bp_shortcode ) . '</strong>' );
			echo '</p></div>';
		}
	);
	deactivate_plugins( 'shortcodes-for-buddypress/shortcodes-for-buddypress.php' );
	return false;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if ( ! defined( 'SHORTCODES_FOR_BUDDYPRESS_VERSION' ) ) {
	define( 'SHORTCODES_FOR_BUDDYPRESS_VERSION', '2.7.1' );
}

if ( ! defined( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR' ) ) {
	define( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_URL' ) ) {
	define( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
}
if ( ! defined( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_BASENAME' ) ) {
	define( 'SHORTCODES_FOR_BUDDYPRESS_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}


/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-shortcodes-for-buddypress-activator.php
 */
function activate_shortcodes_for_buddypress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes-for-buddypress-activator.php';
	Shortcodes_For_Buddypress_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-shortcodes-for-buddypress-deactivator.php
 */
function deactivate_shortcodes_for_buddypress() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes-for-buddypress-deactivator.php';
	Shortcodes_For_Buddypress_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_shortcodes_for_buddypress' );
register_deactivation_hook( __FILE__, 'deactivate_shortcodes_for_buddypress' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-shortcodes-for-buddypress.php';
require plugin_dir_path( __FILE__ ) . 'includes/functions.php';

require_once __DIR__ . '/vendor/autoload.php';
HardG\BuddyPress120URLPolyfills\Loader::init();

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_shortcodes_for_buddypress() {
	if ( in_array( 'shortcode-for-buddypress-pro/shortcodes-for-buddypress.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
		deactivate_plugins( 'shortcodes-for-buddypress/shortcodes-for-buddypress.php' );
	} else {
		$plugin = new Shortcodes_For_Buddypress();
		$plugin->run();
	}

}
run_shortcodes_for_buddypress();


add_action( 'admin_notices', 'shortcodes_for_buddypress_plugin_admin_notice' );
/**
 * Function to through admin notice if BuddyPress is not active.
 */
function shortcodes_for_buddypress_plugin_admin_notice() {

	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		require_once ABSPATH . '/wp-admin/includes/plugin.php';
	}
	$check_active = false;

	if ( ! is_plugin_active_for_network( 'buddypress/bp-loader.php' ) && ! in_array( 'buddypress/bp-loader.php', get_option( 'active_plugins' ) ) ) {
		$check_active = true;
	}

	if ( $check_active ) {
		$bmpro_plugin = 'Shortcode For BuddyPress';
		$bp_plugin    = 'BuddyPress';

		echo '<div class="error"><p>'
		. sprintf( esc_html( __( '%1$s is ineffective as it requires %2$s to be installed and active.', 'shortcodes-for-buddypress' ) ), '<strong>' . esc_html( $bmpro_plugin ) . '</strong>', '<strong>' . esc_html( $bp_plugin ) . '</strong>' )
		. '</p></div>';
	}
}

/**
 *  Check if buddypress activate.
 */
if ( ! function_exists( 'shortcodes_for_buddypress_requires_buddypress' ) ) {
	function shortcodes_for_buddypress_requires_buddypress() {
		if ( ! class_exists( 'Buddypress' ) ) {
			deactivate_plugins( plugin_basename( __FILE__ ) );
			// deactivate_plugins('buddypress-polls/buddypress-polls.php');
			add_action( 'admin_notices', 'shortcodes_for_buddypress_required_plugin_admin_notice' );
			$activate = filter_input( INPUT_GET, 'activate' );
			unset( $activate );
		}
	}

	add_action( 'admin_init', 'shortcodes_for_buddypress_requires_buddypress', 20 );
}


/**
 * Redirect to plugin settings page after activated.
 *
 * @since  1.0.0
 *
 * @param string $plugin Path to the plugin file relative to the plugins directory.
 */
function shortcodes_for_buddypress_activation_redirect_settings( $plugin ) {

	if ( plugin_basename( __FILE__ ) === $plugin && class_exists( 'BuddyPress' ) ) {
		if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] == 'activate' && isset( $_REQUEST['plugin'] ) && $_REQUEST['plugin'] == $plugin) { //phpcs:ignore
			wp_safe_redirect( admin_url( 'admin.php?page=shortcodes-for-buddypress' ) );
			exit;
		}
	}
	if ( $plugin == $_REQUEST['plugin'] && class_exists( 'Buddypress' ) ) {
		if ( isset( $_REQUEST['action'] ) && $_REQUEST['action']  == 'activate-plugin' && isset( $_REQUEST['plugin'] ) && $_REQUEST['plugin'] == $plugin) { //phpcs:ignore		
			set_transient( '_bp_shortcode_is_new_install', true, 30 );
		}
	}
}
add_action( 'activated_plugin', 'shortcodes_for_buddypress_activation_redirect_settings' );

/**
 * Shortcodes_for_buddypress_do_activation_redirect
 *
 * @return void
 */
function shortcodes_for_buddypress_do_activation_redirect() {
	if ( get_transient( '_bp_shortcode_is_new_install' ) ) {
		delete_transient( '_bp_shortcode_is_new_install' );
		wp_safe_redirect( admin_url( 'admin.php?page=shortcodes-for-buddypress' ) );
	}
}
add_action( 'admin_init', 'shortcodes_for_buddypress_do_activation_redirect' );

/**
 * Throw an Alert to tell the Admin why it didn't activate.
 *
 * @author wbcomdesigns
 * @since  2.2.0
 */
if ( ! function_exists( 'shortcodes_for_buddypress_required_plugin_admin_notice' ) ) {
	function shortcodes_for_buddypress_required_plugin_admin_notice() {

		$bpquotes_plugin = esc_html__( ' Shortcode For BuddyPress', 'shortcodes-for-buddypress' );
		$bp_plugin       = esc_html__( 'BuddyPress', 'shortcodes-for-buddypress' );
		echo '<div class="error"><p>';
		/* translators: %s: */
		echo sprintf( esc_html__( '%1$s is ineffective now as it requires %2$s to be installed and active.', 'shortcodes-for-buddypress' ), '<strong>' . esc_html( $bpquotes_plugin ) . '</strong>', '<strong>' . esc_html( $bp_plugin ) . '</strong>' );
		echo '</p></div>';
		if ( null !== filter_input( INPUT_GET, 'activate' ) ) {
			$activate = filter_input( INPUT_GET, 'activate' );
			unset( $activate );
		}
	}
}



/**
 * BuddyPress Activity Elements.
 *
 * @since 2.2.0
 */
if ( ! function_exists( 'buddypress_shortcodes_categories_registered' ) ) {
	function buddypress_shortcodes_categories_registered( $elements_manager ) {

		$elements_manager->add_category(
			'buddypress-widgets',
			array(
				'title' => 'BuddyPress Widgets',
				'icon'  => 'fa fa-plug',
			)
		);
	}

	add_action( 'elementor/elements/categories_registered', 'buddypress_shortcodes_categories_registered' );

}

if ( ! function_exists( 'shortcodes_for_buddypress_widgets_registered' ) ) {
	function shortcodes_for_buddypress_widgets_registered() {
		require plugin_dir_path( __FILE__ ) . 'buddypress-shortcodes-element.php';
		require plugin_dir_path( __FILE__ ) . 'buddypress-members-element.php';
		require plugin_dir_path( __FILE__ ) . 'buddypress-groups-element.php';
	}

	add_action( 'elementor/widgets/widgets_registered', 'shortcodes_for_buddypress_widgets_registered', 15 );

}

/**
 * Iterate_comments
 *
 * @param  mixed $comments for create activity data.
 * @return $childrens
 */
function iterate_comments( $comments ) {
	$childrens = array();
	foreach ( $comments as $comment ) {
		$userdata                        = get_userdata( $comment['user_id'] );
		$user_login                      = $userdata->data->user_login;
		$primary_link                    = get_site_url() . '/member' . '/' . $user_login;
		$user_email                      = $userdata->data->user_email;
		$user_nicename                   = $userdata->data->user_nicename;
		$user_login                      = $userdata->data->user_login;
		$tmp['id']                       = $comment['id'];
		$tmp['user_id']                  = $comment['user_id'];
		$tmp['component']                = $comment['component'];
		$tmp['type']                     = $comment['type'];
		$tmp['action']                   = $comment['title'];
		$tmp['content']                  = $comment['content']['rendered'];
		$tmp['primary_link']             = $primary_link;
		$tmp['item_id']                  = $comment['primary_item_id'];
		$tmp['secondary_item_id']        = $comment['secondary_item_id'];
		$tmp['date_gmt']                 = $comment['date_gmt'];
		$tmp['user_email']               = $user_email;
		$tmp['user_nicename']            = $user_nicename;
		$tmp['user_login']               = $user_login;
		$tmp['display_name']             = $user_nicename;
		$tmp['user_fullname']            = $user_nicename;
		$obj_children                    = new stdClass();
		$obj_children->id                = $tmp['id'];
		$obj_children->user_id           = $tmp['user_id'];
		$obj_children->component         = $tmp['component'];
		$obj_children->type              = $tmp['type'];
		$obj_children->action            = $tmp['action'];
		$obj_children->content           = $tmp['content'];
		$obj_children->primary_link      = $tmp['primary_link'];
		$obj_children->item_id           = $tmp['item_id'];
		$obj_children->secondary_item_id = $tmp['secondary_item_id'];
		$obj_children->date_recorded     = isset( $tmp['date_recorded'] ) ? $tmp['date_recorded'] : 0;
		$obj_children->user_email        = $tmp['user_email'];
		$obj_children->user_nicename     = $tmp['user_nicename'];
		$obj_children->user_login        = $tmp['user_login'];
		$obj_children->display_name      = $tmp['display_name'];
		$obj_children->user_fullname     = $tmp['user_fullname'];
		$obj_children->children          = isset( $comment['comments'] ) ? iterate_comments( $comment['comments'] ) : array();
		$obj_children->depth             = 1;
		$childrens[ $comment['id'] ]     = $obj_children;
	}
	return $childrens;
}

function shortcodes_for_buddypress_get_groups_loop_class( $classes, $component ) {

	$bp_nouveau = bp_nouveau();

	if ( $component == 'groups' ) {
		$customizer_option = sprintf( '%s_layout', $component );
		$layout_prefs      = bp_nouveau_get_temporary_setting(
			$customizer_option,
			bp_nouveau_get_appearance_settings( $customizer_option )
		);

		if ( $layout_prefs && (int) $layout_prefs > 1 && function_exists( 'bp_nouveau_customizer_grid_choices' ) ) {
			$grid_classes = bp_nouveau_customizer_grid_choices( 'classes' );

			if ( isset( $grid_classes[ $layout_prefs ] ) ) {
				$classes = array_merge(
					$classes,
					array(
						'grid',
						$grid_classes[ $layout_prefs ],
					)
				);
			}

			if ( ! isset( $bp_nouveau->{$component} ) ) {
				$bp_nouveau->{$component} = new stdClass();
			}
			// Set the global for a later use.
			if ( property_exists( $bp_nouveau, 'loop_layout' ) ) {
				$bp_nouveau->{$component}->loop_layout = $layout_prefs;
			}
		}
	}
	return $classes;
}
add_filter( 'bp_nouveau_get_loop_classes', 'shortcodes_for_buddypress_get_groups_loop_class', 10, 2 );

