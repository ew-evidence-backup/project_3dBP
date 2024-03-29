<?php
/**
 * Love It
 *
 * @package Marketify
 */

/**
 * Don't output the Love It link automatically anywhere
 */
function marketify_li_display_love_links_on( $types ) {
	return array( '__marketify__' );
}
add_filter( 'li_display_love_links_on', 'marketify_li_display_love_links_on' );

/**
 * Manually output the link where we want it
 */
function marketify_li_love_link() {
	global $post;

	if ( ! is_object( $post ) )
		return;

	if ( class_exists( 'Love_It_Pro' ) ) {
		echo lip_love_it_link( $post->ID, '', '' );
	} else {
		echo li_love_link();
	}
}
add_action( 'marketify_download_grid_previewer_before', 'marketify_li_love_link' );
add_action( 'marketify_download_content_image_overlay_before', 'marketify_li_love_link' );
add_action( 'marketify_download_previewer_before', 'marketify_li_love_link' );

function marketify_love_it_url( $author = null ) {
	if ( ! $author ) {
		$author = wp_get_current_user();
	} else {
		$author = new WP_User( $author );
	}

	global $wp_rewrite;

	$page = marketify_find_page_with_template( 'page-templates/wishlist.php' );

	if ( $wp_rewrite->permalink_structure == '' ) {
		$vendor_url = add_query_arg( array( 'page_id' => $page->ID, 'author_wishlist' => $author->user_nicename ), home_url() );
	} else {
		$vendor_url = get_permalink( $page );
		$vendor_url = trailingslashit( $vendor_url ) . trailingslashit( $author->user_nicename );
	}

	return esc_url( $vendor_url );
}

/**
 * Love It Archives
 *
 * @since Marketify 1.2
 */
class Marketify_Love_It_Archives {

	/**
	 * @var $instance
	 */
	public static $instance;

	/*
	 * Init so we can attach to an action
	 */
	public static function init() {
		if ( ! isset ( self::$instance ) ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	public function __construct() {
		add_action( 'pre_get_posts', array( $this, 'vendor_download_query' ) );

		add_filter( 'generate_rewrite_rules', array( $this, 'rewrites' ) );
		add_action( 'query_vars', array( $this, 'query_vars' ) );

		add_filter( 'the_title',  array( $this, 'change_the_title' ) );

		add_action( 'template_redirect', array( $this, 'template_redirect' ) );
	}

	public function query_vars( $query_vars ) {
		$query_vars[] = 'author_wishlist';

		return $query_vars;
	}

	public function rewrites() {
		global $wp_rewrite;

		$page = get_post( marketify_find_page_with_template( 'page-templates/wishlist.php' ) );

		if ( ! $page ) {
			return;
		}

		$new_rules = array(
			$page->post_name . '/([^/]+)/?$' => 'index.php?page_id=' . $page->ID . '&author_wishlist=' . $wp_rewrite->preg_index(1),
			$page->post_name . '/([^/]+)/page/([0-9]+)?$' => 'index.php?page_id=' . $page->ID . '&author_wishlist=' . $wp_rewrite->preg_index(1) . '&paged=' . $wp_rewrite->preg_index(2),
		);

		$wp_rewrite->rules = $new_rules + $wp_rewrite->rules;

		return $wp_rewrite->rules;
	}

	public function vendor_download_query( $query ) {
		global $wp_query, $post;

		if ( is_admin() || ! is_page() ) {
			return;
		}

		if ( isset( $wp_query->query_vars[ 'author_wishlist' ] ) ) {
			add_filter( 'edd_downloads_query', array( $this, 'set_shortcode' ) );
		}
	}

	public function set_shortcode( $query ) {
		global $wp_query;

		$author = get_user_by( 'slug', $wp_query->query_vars[ 'author_wishlist' ] );
		$loves  = get_user_option( 'li_user_loves', $author->ID );

		if ( ! is_array( $loves ) ) {
			$loves = array(0);
		}

		$query[ 'post__in' ] = $loves;

		return $query;
	}

	public function change_the_title( $title ) {
		global $wp_query;

		if ( isset ( $wp_query->query_vars[ 'author_wishlist' ] ) && in_the_loop() && is_page_template( 'page-templates/wishlist.php' ) ) {
			remove_filter( 'the_title',  array( $this, 'change_the_title' ) );

			$vendor_nicename = get_query_var( 'author_wishlist' );
			$vendor          = get_user_by( 'slug', $vendor_nicename );

			$title = sprintf( __( '%s\'s Likes', 'marketify' ), $vendor->display_name );
		}

		return $title;
	}

	public function template_redirect() {
		global $wp_query;

		if ( ! is_page_template( 'page-templates/wishlist.php' ) ) {
			return;
		}

		if ( ! isset ( $wp_query->query_vars[ 'author_wishlist' ] ) ) {
			wp_safe_redirect( marketify_love_it_url( get_current_user_id() ), 301 );
			exit();
		}
	}
}
add_action( 'init', array( 'Marketify_Love_It_Archives', 'init' ), 100 );
