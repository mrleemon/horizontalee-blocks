<?php
/**
 * The template for displaying archive pages
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

			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<div class="posts <?php theme_loop_class(); ?>">

				<?php
				// Start the loop.
				while ( have_posts() ) :
					the_post();

					// Include the content template.
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
