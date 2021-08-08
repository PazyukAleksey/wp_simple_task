<?php

/**
 * Fired during plugin activation
 *
 * @link       Pazyukal
 * @since      1.0.0
 *
 * @package    Nasa_Images
 * @subpackage Nasa_Images/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Nasa_Images
 * @subpackage Nasa_Images/includes
 * @author     Pazyukal <pazyukal@gmail.com>
 */
class Nasa_Images_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        require_once(ABSPATH . "wp-admin" . '/includes/image.php');
        require_once(ABSPATH . "wp-admin" . '/includes/file.php');
        require_once(ABSPATH . "wp-admin" . '/includes/media.php');
        $nasa_images = new Nasa_Images();

        foreach ($nasa_images->get_nasa_api_data() as $item):
            $post_arr = array(
                'post_status'   => 'publish',
                'post_title'    => $item->date,
                'post_thumbnail'    => $item->url,
                'post_content'    => $item->explanation,
                'post_author'   => get_current_user_id(),
                'post_type'     => 'post-nasa-gallery',
                'post_parent'   => 0,
            );
            $post = wp_insert_post($post_arr);
            $img_tag = media_sideload_image($item->url, 0, 'NASA image', id);
            set_post_thumbnail($post, $img_tag);
        endforeach;
	}

}
