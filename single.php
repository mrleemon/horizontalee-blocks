<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package theme
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php do_action( 'theme_main_top' ); ?>

		<?php
		// Start the loop.
		while ( have_posts() ) :
			the_post();

			// Include the content template.
			get_template_part( 'template-parts/content/content' );

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

			// Previous/next post navigation.
			the_post_navigation(
				array(
					'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'theme' ) . '</span>' .
						'<span class="screen-reader-text">' . __( 'Next post:', 'theme' ) . '</span>' .
						'<span class="post-title">%title</span>',
					'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'theme' ) . '</span>' .
						'<span class="screen-reader-text">' . __( 'Previous post:', 'theme' ) . '</span>' .
						'<span class="post-title">%title</span>',
				)
			);

			// End the loop.
		endwhile;
		?>

		<?php do_action( 'theme_main_bottom' ); ?>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php
get_sidebar();
get_footer();
