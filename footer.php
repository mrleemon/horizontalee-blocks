<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package theme
 */

?>

		</div><!-- .inner-wrap -->

	<?php do_action( 'theme_content_bottom' ); ?>

	</div><!-- .site-content -->

	<footer id="colophon" class="site-footer">

		<?php do_action( 'theme_footer_top' ); ?>

		<?php
		// Include the footer template part.
		block_template_part( 'footer' );
		?>

		<?php do_action( 'theme_footer_bottom' ); ?>

	</footer><!-- .site-footer -->

	<?php do_action( 'theme_site_bottom' ); ?>

</div><!-- .site -->

<?php wp_footer(); ?>

</body>
</html>
