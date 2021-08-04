<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              Pazyukal
 * @since             1.0.0
 * @package           Nasa_Images
 *
 * @wordpress-plugin
 * Plugin Name:       NASA images
 * Plugin URI:        nasa-images
 * Description:       Very simple task for show a gallery of NASA images
 * Version:           1.0.0
 * Author:            Pazyukal
 * Author URI:        Pazyukal
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       nasa-images
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'NASA_IMAGES_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-nasa-images-activator.php
 */
function activate_nasa_images() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nasa-images-activator.php';
	Nasa_Images_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-nasa-images-deactivator.php
 */
function deactivate_nasa_images() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-nasa-images-deactivator.php';
	Nasa_Images_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_nasa_images' );
register_deactivation_hook( __FILE__, 'deactivate_nasa_images' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-nasa-images.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_nasa_images() {
	$plugin = new Nasa_Images();
	$plugin->run();

}
run_nasa_images();

function reg_nasa_post_type() {
    register_post_type( 'post-nasa-gallery1',
        array(
            'labels' => array(
                'name' => __( 'NASA images' ),
                'singular_name' => __( 'NASA image' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'nasa-gallery'),
        )
    );
}

add_action( 'init', 'reg_nasa_post_type');
