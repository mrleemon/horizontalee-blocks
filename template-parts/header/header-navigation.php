<?php
/**
 * Template part for displaying header navigation
 *
 * @package theme
 */

?>
<div class="header-navigation">

	<?php do_action( 'theme_navigation_top' ); ?>

	<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', 'theme' ); ?>">

		<?php do_action( 'theme_main_navigation_inner_before' ); ?>

		<?php
		// Primary navigation menu.
		wp_nav_menu(
			array(
				'container'      => false,
				'depth'          => 3,
				'item_spacing'   => 'discard',
				'menu_id'        => 'primary-menu',
				'theme_location' => 'primary',
				'show_toggles'   => true,
			)
		);
		?>

		<?php do_action( 'theme_main_navigation_inner_after' ); ?>

	</nav><!-- .main-navigation -->

	<?php do_action( 'theme_main_navigation_after' ); ?>

	<?php if ( has_nav_menu( 'additional' ) ) : ?>
		<nav id="additional-navigation" class="additional-navigation" aria-label="<?php esc_attr_e( 'Additional Menu', 'theme' ); ?>">

			<?php do_action( 'theme_additional_navigation_inner_before' ); ?>

			<?php
			// Additional navigation menu.
			wp_nav_menu(
				array(
					'container'      => false,
					'depth'          => 3,
					'item_spacing'   => 'discard',
					'menu_id'        => 'additional-menu',
					'theme_location' => 'additional',
					'fallback_cb'    => false,
				)
			);
			?>

			<?php do_action( 'theme_additional_navigation_inner_after' ); ?>

		</nav><!-- .additional-navigation -->
	<?php endif; ?>

	<?php do_action( 'theme_navigation_bottom' ); ?>

</div><!-- .header-navigation -->
