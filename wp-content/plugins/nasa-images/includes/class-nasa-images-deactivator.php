<?php

/**
 * Fired during plugin deactivation
 *
 * @link       Pazyukal
 * @since      1.0.0
 *
 * @package    Nasa_Images
 * @subpackage Nasa_Images/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Nasa_Images
 * @subpackage Nasa_Images/includes
 * @author     Pazyukal <pazyukal@gmail.com>
 */
class Nasa_Images_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
        $posts = get_posts( array(
            'post_type' => 'post-nasa-gallery',
        ));
        foreach( $posts as $post ):
            wp_delete_attachment(get_post_thumbnail_id($post->ID), true);
            wp_delete_post($post->ID, true);
        endforeach;

        unregister_post_type('post-nasa-gallery');
	}

}
