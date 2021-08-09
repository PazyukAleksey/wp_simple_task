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
    register_post_type( 'post-nasa-gallery',
        array(
            'labels' => array(
                'name' => __( 'NASA images' ),
                'singular_name' => __( 'NASA image' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'nasa-gallery'),
            'supports' => array('title', 'editor', 'thumbnail')
        )
    );

}
add_action( 'init', 'reg_nasa_post_type');

add_action('action_get_day_image', 'get_day_image');
function get_day_image(){
    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
    $nasa_image = new Nasa_Images();
    $post_data = $nasa_image->get_nasa_api_day_data();
    $post_arr = array(
        'post_status'       => 'publish',
        'post_title'        => $post_data->date,
        'post_thumbnail'    => $post_data->url,
        'post_content'      => $post_data->explanation,
        'post_author'   => 2,
        'post_type'     => 'post-nasa-gallery',
        'post_parent'   => 0,
    );
    $post = wp_insert_post($post_arr);
    $img_tag = media_sideload_image($post_data->url, 0, 'NASA image', 'id');
    set_post_thumbnail($post, $img_tag);
}

function nasa_slider_shortcode() {
    $nasa_posts = get_posts( array(
        'post_type' => 'post-nasa-gallery',
        'numberposts' => '5',
    ));
    ?>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php foreach ($nasa_posts as $nasa_post): ?>
                <div class="swiper-slide">
                    <img class="nasa-image" src="<?php echo get_the_post_thumbnail_url($nasa_post->ID, array(500, 400)) ?>" alt="NASA image">
                </div>
            <?php endforeach; ?>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>
    <?php
}
add_shortcode('nasa_slider', 'nasa_slider_shortcode');