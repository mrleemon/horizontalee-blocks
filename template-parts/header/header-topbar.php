<?php
/**
 * Template part for displaying header top bar
 *
 * @package theme
 */

$topbar_widget_areas = get_theme_mod( 'topbar_widget_areas', 0 );
if ( $topbar_widget_areas > 0 ) :
	?>

<div class="topbar">

	<div class="inner-wrap">

	<?php
	for ( $i = 1; $i <= $topbar_widget_areas; $i++ ) :
		?>
			<div id="<?php echo esc_attr( 'topbar-widget-area-' . $i ); ?>" class="widget-area" role="complementary">
		<?php
		if ( ! dynamic_sidebar( 'top-' . $i ) ) :
			?>
				<aside class="widget"></aside>
			<?php
			endif;
		?>
			</div><!-- .widget-area -->
		<?php
		endfor;
	?>

	</div><!-- .inner-wrap -->

</div><!-- .topbar -->

	<?php
endif;
?>
