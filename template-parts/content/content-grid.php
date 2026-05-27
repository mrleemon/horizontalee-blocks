<?php
/**
 * Template part for displaying posts on a grid
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php do_action( 'theme_entry_top' ); ?>

	<?php
		$image_size = get_theme_mod( 'grid_post_thumbnail_size', 'thumbnail' );
		theme_grid_post_thumbnail( $image_size );
	?>

	<?php do_action( 'theme_entry_bottom' ); ?>

</article><!-- #post-<?php the_ID(); ?> -->
