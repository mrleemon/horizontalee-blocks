<?php
/**
 * Template part for displaying page content in page.php
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

		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<?php do_action( 'theme_entry_header_bottom' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-content is-layout-flow">
		<?php the_content(); ?>
		<?php
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
