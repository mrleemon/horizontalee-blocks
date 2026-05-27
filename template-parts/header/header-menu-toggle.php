<?php
/**
 * Template part for displaying header menu toggle
 *
 * @package theme
 */

?>
<button type="button" class="menu-toggle" aria-expanded="false">
	<span class="menu-toggle-icon">
		<?php echo theme_get_icon_svg( 'menu' ); ?>
		<?php echo theme_get_icon_svg( 'close' ); ?>
	</span>
	<span class="screen-reader-text"><?php _e( 'Menu', 'theme' ); ?></span>
</button><!-- .menu-toggle -->
