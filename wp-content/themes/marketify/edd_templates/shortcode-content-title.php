<?php
/**
 *
 */

global $post;
?>

<header class="entry-header">
	<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

	<?php if ( marketify_theme_mod( 'product-display', 'product-display-excerpt' ) ) : ?>

		<div class="entry-excerpt"><?php echo esc_attr( wp_trim_words( get_the_excerpt(), 10 ) ); ?></div>

	<?php endif; ?>

	<div class="entry-meta">
		<?php do_action( 'marketify_download_entry_meta_before_' . get_post_format() ); ?>

		<?php if ( marketify_is_multi_vendor() ) : ?>
			<?php
				printf(
					__( '<span class="byline"> by %1$s</span>', 'marketify' ),
					sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s %4$s</a></span>',
						marketify_edd_fes_author_url( get_the_author_meta( 'ID', $post->post_author ) ),
						esc_attr( sprintf( __( 'View all %s by %s', 'marketify' ), edd_get_label_plural(), get_the_author() ) ),
						esc_html( get_the_author_meta( 'display_name', $post->post_author ) ),
						get_avatar( get_the_author_meta( 'ID', $post->post_author ), 50, apply_filters( 'marketify_default_avatar', null ) )
					)
				);
			?>
		<?php endif; ?>

		<?php do_action( 'marketify_download_entry_meta_after_' . get_post_format() ); ?>
	</div>
</header><!-- .entry-header -->
