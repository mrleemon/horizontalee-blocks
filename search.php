<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package theme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php do_action( 'theme_main_top' ); ?>

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( __( 'Search Results for: %s', 'theme' ), '<span>' . esc_html( get_search_query() ) . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<div class="posts">

				<?php
				// Start the loop.
				while ( have_posts() ) :
					the_post();
					?>

					<?php
					/*
					* Run the loop for the search to output the results.
					* If you want to overload this in a child theme then include a file
					* called content-search.php and that will be used instead.
					*/
					get_template_part( 'template-parts/content/content', 'search' );

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
