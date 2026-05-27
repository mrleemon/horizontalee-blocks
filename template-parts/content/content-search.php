<?php
/**
 * Template part for displaying results in search pages
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

		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

		<?php do_action( 'theme_entry_header_bottom' ); ?>

	</header><!-- .entry-header -->

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->

	<?php if ( 'post' === get_post_type() ) : ?>

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

	<?php else : ?>

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

	<?php endif; ?>

	<?php do_action( 'theme_entry_bottom' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
