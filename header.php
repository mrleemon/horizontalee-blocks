<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="pingback" href="<?php echo esc_url( bloginfo( 'pingback_url' ) ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php theme_body_data_attributes(); ?>>

<?php wp_body_open(); ?>

<div id="page" class="site">

	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'theme' ); ?></a>

	<?php do_action( 'theme_site_top' ); ?>

	<div id="mainbar" class="site-mainbar">

		<?php do_action( 'theme_mainbar_top' ); ?>

		<?php
		// Include the top bar template.
		get_template_part( 'template-parts/header/header', 'topbar' );
		?>

		<header id="masthead" class="site-header">

			<?php do_action( 'theme_header_top' ); ?>

			<?php

			if ( has_custom_header() ) {
				// Include the header media.
				get_template_part( 'template-parts/header/header', 'media' );
			}

			?>

			<div class="inner-wrap">

				<?php do_action( 'theme_header_wrap_top' ); ?>

				<?php

				// Include the site branding template.
				get_template_part( 'template-parts/header/header', 'site-branding' );

				do_action( 'theme_site_branding_after' );

				// Include the menu toggle template.
				get_template_part( 'template-parts/header/header', 'menu-toggle' );

				do_action( 'theme_menu_toggle_after' );

				// Include the header navigation template.
				get_template_part( 'template-parts/header/header', 'navigation' );

				?>

				<?php do_action( 'theme_header_wrap_bottom' ); ?>

			</div><!-- .inner-wrap -->

			<?php do_action( 'theme_header_bottom' ); ?>

		</header><!-- .site-header -->

		<?php do_action( 'theme_mainbar_bottom' ); ?>

	</div><!-- .site-mainbar -->

	<div id="content" class="site-content">

	<?php do_action( 'theme_content_top' ); ?>

		<div class="inner-wrap">
