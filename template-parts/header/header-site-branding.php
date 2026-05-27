<?php
/**
 * Template part for displaying header site branding
 *
 * @package theme
 */

?>
<div class="site-branding">

	<?php do_action( 'theme_site_branding_top' ); ?>

	<?php the_custom_logo(); ?>

	<h1 class="site-title">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
	</h1>

	<?php
	$description = get_bloginfo( 'description', 'display' );
	if ( $description || is_customize_preview() ) :
		?>
		<p class="site-description"><?php echo $description; ?></p>
		<?php
	endif;
	?>

	<?php do_action( 'theme_site_branding_bottom' ); ?>

</div><!-- .site-branding -->
