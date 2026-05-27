<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package theme
 */

?>

<?php if ( theme_has_sidebar() ) : ?>
	
	<?php if ( is_active_sidebar( 'sidebar' ) ) : ?>

		<?php do_action( 'theme_before_sidebar' ); ?>
	
		<aside id="secondary" class="sidebar widget-area">

			<?php do_action( 'theme_sidebar_top' ); ?>

			<?php block_template_part( 'sidebar' ); ?>

			<?php do_action( 'theme_sidebar_bottom' ); ?>

		</aside><!-- #secondary -->

		<?php do_action( 'theme_after_sidebar' ); ?>

	<?php endif; ?>

<?php endif; ?>
