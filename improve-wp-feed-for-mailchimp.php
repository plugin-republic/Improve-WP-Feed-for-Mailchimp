<?php
/**
 * Plugin Name: Improve WP Feed for Mailchimp
 * Plugin URI: https://wisdomplugin.com/how-to-automatically-export-wordpress-posts-to-mailchimp
 * Description: Add a featured image to your feed and use the More tag instead of excerpt
 * Author: Catapult Themes
 * Version: 1.0.0
*/

/**
 * Get the post content up to the More tag
 * @see https://codex.wordpress.org/Function_Reference/get_extended
 */
function atp_get_content_to_more_tag() {
	global $post;
	$content_main = get_extended( $post->post_content );
	$content_main = $content_main['main'];
	return wpautop( $content_main );
}

/**
 * Filter the content feed to use main content instead of excerpt
 * Add a featured image
 * @see https://codex.wordpress.org/Plugin_API/Filter_Reference/the_content_feed
 */
function atp_filter_content_feed( $excerpt ) {
	// Add featured image?
	global $post;
	$excerpt = atp_get_content_to_more_tag();
	if( has_post_thumbnail( $post->ID ) ) {
		$excerpt = get_the_post_thumbnail( array( 'style' => 'max-width: 600px; width: 100%; height: auto; margin: 30px 0;' ) ) . $excerpt;
	}
	return $excerpt;
}
add_filter( 'the_excerpt_rss', 'atp_filter_content_feed', 999, 1 );
add_filter( 'the_content_feed', 'atp_filter_content_feed', 999, 1 );
