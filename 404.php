<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package theme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php do_action( 'theme_main_top' ); ?>

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'theme' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">

					<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'theme' ); ?></p>
					<?php get_search_form(); ?>

				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		<?php do_action( 'theme_main_bottom' ); ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php
get_sidebar();
get_footer();
