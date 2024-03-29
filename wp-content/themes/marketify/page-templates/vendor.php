<?php
/**
 * Template Name: Vendor
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Marketify
 */

if ( function_exists( 'fes_get_vendor' ) ) {
	$author = fes_get_vendor();
} else {
	$author = get_query_var( 'vendor' );
	$author = get_user_by( 'slug', $author );

	if ( ! $author ) {
		$author = get_current_user_id();
	}
}

get_header(); ?>

	<?php while ( have_posts() ) : the_post(); ?>

	<header class="page-header">
		<h1 class="page-title"><?php the_title(); ?></h1>
	</header><!-- .page-header -->

	<?php do_action( 'marketify_entry_before' ); ?>

	<div class="container">
		<div id="content" class="site-content row">

			<div id="secondary" class="author-widget-area col-md-3 col-sm-5 col-xs-12" role="complementary">
				<div class="download-product-details author-archive">
					<?php do_action( 'marketify_vendor_profile_before', $author ); ?>

					<div class="download-author">
						<?php echo get_avatar( $author->ID, 130 ); ?>
						<?php printf( '<a class="author-link" href="%s" rel="author">%s</a>', marketify_edd_fes_author_url( $author->ID ), '' != $author->display_name ? esc_attr( $author->display_name ) : esc_attr( $author->user_login ) ); ?>
						<span class="author-joined"><?php printf( __( 'Author since: %s', 'marketify' ), date_i18n( 'Y', strtotime( $author->user_registered ) ) ); ?></span>
					</div>

					<?php do_action( 'marketify_vendor_profile_after_author', $author ); ?>

					<?php if ( '' != $author->description ) : ?>
					<div class="download-author-bio">

						<?php echo esc_html( $author->description ); ?>

					</div>
					<?php endif; ?>

					<?php do_action( 'marketify_vendor_profile_after_bio', $author ); ?>

					<div class="download-author-sales">
						<strong><?php echo marketify_count_user_downloads( $author->ID ); ?></strong>

						<?php echo _n( edd_get_label_singular(), edd_get_label_plural(), marketify_count_user_downloads( $author->ID ), 'marketify' ); ?>
					</div>

					<?php do_action( 'marketify_vendor_profile_after_sales', $author ); ?>

					<?php if ( marketify_entry_author_social( $author->ID ) ) : ?>
					<div class="download-author-social">
						<?php echo marketify_entry_author_social( $author->ID ); ?>
					</div>
					<?php endif; ?>

					<?php do_action( 'marketify_vendor_profile_after_social', $author ); ?>

					<?php if ( get_current_user_id() != $author->ID ) : ?>
					<div class="download-author-message">
						<?php echo do_shortcode( '[fes_vendor_contact_form id="' . $author->ID . '"]' ); ?>
					</div>
					<?php endif; ?>

					<?php do_action( 'marketify_vendor_profile_after', $author ); ?>
				</div>
			</div><!-- #secondary -->

			<section id="primary" class="content-area col-md-9 col-sm-7 col-xs-12">
				<main id="main" class="site-main" role="main">

					<div class="entry-content">
						<?php the_content(); ?>
					</div>

				</main><!-- #main -->
			</section><!-- #primary -->

		</div><!-- #content -->
	</div>

	<?php endwhile; ?>

<?php get_footer(); ?>
