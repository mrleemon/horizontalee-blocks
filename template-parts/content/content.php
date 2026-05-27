<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'theme_entry_top' ); ?>

	<header class="entry-header">

		<?php do_action( 'theme_entry_header_top' ); ?>

		<?php
		if ( is_singular() ) :
			the_title( '<h1 class="entry-title">', '</h1>' );
			else :
				the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
			endif;
			?>

		<?php do_action( 'theme_entry_header_bottom' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content is-layout-flow">
		<?php
			the_content(
				sprintf(
					wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'theme' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);

			wp_link_pages(
				array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'theme' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'theme' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				)
			);
			?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">

		<?php do_action( 'theme_entry_footer_top' ); ?>

		<?php theme_entry_meta(); ?>

		<?php
		edit_post_link(
			__( 'Edit', 'theme' ),
			'<span class="edit-link">',
			'</span>'
		);
		?>

		<?php do_action( 'theme_entry_footer_bottom' ); ?>

	</footer><!-- .entry-footer -->

	<?php do_action( 'theme_entry_bottom' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
