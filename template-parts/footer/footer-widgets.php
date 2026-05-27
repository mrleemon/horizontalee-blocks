<?php
/**
 * Template part for displaying footer widgets
 *
 * @package theme
 */

$footer_widget_areas = get_theme_mod( 'footer_widget_areas', 4 );
if ( $footer_widget_areas > 0 ) :
	?>

<div class="footer-widgets">

	<div class="inner-wrap">

		<?php
		for ( $i = 1; $i <= $footer_widget_areas; $i++ ) :
			?>
			<aside id="<?php echo esc_attr( 'footer-widget-area-' . $i ); ?>" class="widget-area">
			<?php
			if ( ! dynamic_sidebar( 'footer-' . $i ) ) :
				?>
				<section class="widget"></section>
				<?php
			endif;
			?>
			</aside><!-- .widget-area -->
			<?php
		endfor;
		?>

	</div><!-- .inner-wrap -->

</div><!-- .footer-widgets -->

	<?php
endif;
?>
