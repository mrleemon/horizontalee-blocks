<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package theme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php do_action( 'theme_main_top' ); ?>

		<?php if ( have_posts() ) : ?>

			<?php if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>
			<?php endif; ?>

			<div class="posts <?php theme_loop_class(); ?>">

				<?php
				// Start the loop.
				while ( have_posts() ) :
					the_post();

					if ( get_theme_mod( 'blog_layout', 'list' ) === 'list' ) {
						get_template_part( 'template-parts/content/content' );
					} else {
						get_template_part( 'template-parts/content/content', 'grid' );
					}

					// End the loop.
				endwhile;
				?>

			</div><!-- .posts -->

			<?php
			// Previous/next page navigation.
			theme_the_posts_navigation();

			// If no content, include the "No posts found" template.
		else :
			get_template_part( 'template-parts/content/content', 'none' );

		endif;
		?>

		<?php do_action( 'theme_main_bottom' ); ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php
get_sidebar();
get_footer();
