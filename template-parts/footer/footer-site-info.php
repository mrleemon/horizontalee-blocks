<?php
/**
 * Template part for displaying footer site info
 *
 * @package theme
 */

?>
<div class="site-info">

	<div class="inner-wrap">

		<div class="footer-text">
			<?php theme_footer_text(); ?>
		</div><!-- .footer-text -->

		<div class="footer-credits">
			<?php
			the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
			?>
			<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'theme' ) ); ?>" class="imprint">
				<?php
				/* translators: %s: CMS name, i.e. WordPress. */
				printf( __( 'Proudly powered by %s', 'theme' ), 'WordPress' );
				?>
			</a>
		</div><!-- .footer-credits -->

	</div><!-- .inner-wrap -->

</div><!-- .site-info -->
