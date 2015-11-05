<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Marketify
 */

get_header(); ?>

	<header class="page-header">
		<h1 class="page-title">
			<?php if ( is_tax() ) : ?>
				<?php single_term_title(); ?>
			<?php elseif ( is_search() ) : ?>
				<?php echo esc_attr( get_search_query() ); ?>
			<?php else : ?>
				<?php echo apply_filters( 'marketify_downloads_archive_title', edd_get_label_plural() ); ?>
			<?php endif; ?>
		</h1>
	</header><!-- .page-header -->

	<?php do_action( 'marketify_entry_before' ); ?>

	<div class="container">

		<?php if ( ! is_paged() && ! get_query_var( 'm-orderby' ) ) : ?>
			<?php get_template_part( 'content-grid-download', 'popular' ); ?>
		<?php endif; ?>

		<div id="content" class="site-content row">

			<section id="primary" class="content-area col-md-<?php echo is_active_sidebar( 'sidebar-download' ) ? '9' : '12'; ?> col-sm-7 col-xs-12">
				<main id="main" class="site-main" role="main">

				<div class="section-title"><span>
					<?php if ( is_search() ) : ?>
						<?php printf( '&quot;%s&quot;', esc_attr( get_search_query() ) ); ?>
					<?php else : ?>
						<?php marketify_downloads_section_title(); ?>
					<?php endif; ?>
				</span></div>

				<?php echo do_shortcode( sprintf( '[downloads number="%s"]', get_option( 'posts_per_page' ) ) ); ?>

				</main><!-- #main -->
			</section><!-- #primary -->

			<?php get_sidebar( 'archive-download' ); ?>

		</div><!-- #content -->
	</div>

<?php get_footer(); ?>
