<?php
/*
Plugin Name: JWDMC Videos
Plugin URI: http://www.jenniferwebdesignlasvegas.com
Description: Generates a custom post type for videos.
Version: 1.0
Author: Jennifer Web Design
Author URI: http://www.jenniferwebdesignlasvegas.com
License: GPL2
*/


// Activation hook
function jwdmc_videos_activation() {
	// Define CPT and taxonomies
	jwdmc_videos_cpt();
	jwdmc_video_taxonomies();

	// Recreate rewrite rules to account for CPT
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'jwdmc_videos_activation' );


// Register the CPT
function jwdmc_videos_cpt() {
	$labels = array(
		'name'               => _x( 'Videos', 'post type general name' ),
		'singular_name'      => _x( 'Video', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'book' ),
		'add_new_item'       => __( 'Add New Video' ),
		'edit_item'          => __( 'Edit Video' ),
		'new_item'           => __( 'New Video' ),
		'all_items'          => __( 'All Videos' ),
		'view_item'          => __( 'View Video' ),
		'search_items'       => __( 'Search Videos' ),
		'not_found'          => __( 'No videos found' ),
		'not_found_in_trash' => __( 'No videos found in the Trash' ),
		'parent_item_colon'  => '',
		'menu_name'          => 'Videos'
		);
	$args = array(
		'labels'        => $labels,
		'description'   => 'Holds our videos and video specific data',
		'public'        => true,
		'menu_icon'     => 'dashicons-video-alt',
		'menu_position' => 25,
		'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions' ),
		'has_archive'   => true,
		'rewrite'       => array('slug' => 'videos')
		);
	register_post_type( 'video', $args );
}
add_action( 'init', 'jwdmc_videos_cpt' );


// Add custom messages (replaces 'post' with 'video')
function jwdmc_video_messages( $messages ) {
	global $post, $post_ID;
	$messages['video'] = array(
		0 => '',
		1 => sprintf( __('Video updated. <a href="%s">View video</a>'), esc_url( get_permalink($post_ID) ) ),
		2 => __('Custom field updated.'),
		3 => __('Custom field deleted.'),
		4 => __('Video updated.'),
		5 => isset($_GET['revision']) ? sprintf( __('Video restored to revision from %s'), wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,
		6 => sprintf( __('Video published. <a href="%s">View video</a>'), esc_url( get_permalink($post_ID) ) ),
		7 => __('Video saved.'),
		8 => sprintf( __('Video submitted. <a target="_blank" href="%s">Preview video</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		9 => sprintf( __('Video scheduled for: <strong>%1$s</strong>. <a target="_blank" href="%2$s">Preview video</a>'), date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ), esc_url( get_permalink($post_ID) ) ),
		10 => sprintf( __('Video draft updated. <a target="_blank" href="%s">Preview video</a>'), esc_url( add_query_arg( 'preview', 'true', get_permalink($post_ID) ) ) ),
		);
return $messages;
}
add_filter( 'post_updated_messages', 'jwdmc_video_messages' );


// Video categories
function jwdmc_video_taxonomies() {
	$labels = array(
		'name'              => _x( 'Video Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Video Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Video Categories' ),
		'all_items'         => __( 'All Video Categories' ),
		'parent_item'       => __( 'Parent Video Category' ),
		'parent_item_colon' => __( 'Parent Video Category:' ),
		'edit_item'         => __( 'Edit Video Category' ),
		'update_item'       => __( 'Update Video Category' ),
		'add_new_item'      => __( 'Add New Video Category' ),
		'new_item_name'     => __( 'New Video Category' ),
		'menu_name'         => __( 'Video Categories' ),
		);
	$args = array(
		'labels' => $labels,
		'hierarchical' => true,
		'show_admin_column' => true,
		'rewrite' => array(
			'slug' => 'video-category'
			)
		);
	register_taxonomy( 'video_category', 'video', $args );
}
add_action( 'init', 'jwdmc_video_taxonomies', 0 );


// Check for custom template files in theme and use files in plugin if they don't exist
function jwdmc_video_template_include($template) {
	if ( is_post_type_archive('video') || is_tax('video_category') ) {
		if ( file_exists(get_stylesheet_directory() . '/archive-video.php') )
			return get_stylesheet_directory() . '/archive-video.php';
		return plugin_dir_path(__FILE__) . '/archive-video.php';
	} elseif ( is_singular('video') ) {
		if ( file_exists(get_stylesheet_directory() . '/single-video.php') )
			return get_stylesheet_directory() . '/single-video.php';
		return plugin_dir_path(__FILE__) . '/single-video.php';
	}
	return $template;
}
add_filter('template_include', 'jwdmc_video_template_include');

?>
