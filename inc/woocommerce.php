<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package theme
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)-in-3.0.0
 *
 * @return void
 */
function theme_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'product_grid' => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'theme_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function theme_woocommerce_scripts() {
	wp_enqueue_style(
		'theme-woocommerce-style',
		get_template_directory_uri() . '/assets/css/woocommerce.css',
		array( 'woocommerce-layout', 'woocommerce-smallscreen' ),
		filemtime( get_template_directory() . '/assets/css/woocommerce.css' )
	);

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: WooCommerce;
			src: url("' . $font_path . 'WooCommerce.woff2") format("woff2"),
				url("' . $font_path . 'WooCommerce.woff") format("woff"),
				url("' . $font_path . 'WooCommerce.ttf") format("truetype");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'theme-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'theme_woocommerce_scripts' );

/**
 * Disable some WooCommerce styles
 *
 * @param array $enqueue_styles List of default WooCommerce styles.
 */
function theme_woocommerce_enqueue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );    // Remove the gloss.
	// unset( $enqueue_styles['woocommerce-layout'] );      // Remove the layout.
	// unset( $enqueue_styles['woocommerce-smallscreen'] ); // Remove the smallscreen.optimisation
	return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'theme_woocommerce_enqueue_styles' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function theme_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'theme_woocommerce_active_body_class' );

/**
 * Default loop columns on product archives.
 *
 * @return integer products per row.
 */
function theme_woocommerce_loop_columns() {
	$columns = wc_get_default_products_per_row();
	return $columns;
}

/**
 * Pagination Args.
 *
 * @param array $args pagination args.
 * @return array $args pagination args.
 */
function theme_woocommerce_pagination_args( $args ) {
	$defaults = array(
		'end_size' => 1,
		'mid_size' => 1,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_pagination_args', 'theme_woocommerce_pagination_args', 20 );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function theme_woocommerce_related_products_args( $args ) {
	$columns  = wc_get_default_products_per_row();
	$defaults = array(
		'posts_per_page' => $columns,
		'columns'        => $columns,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'theme_woocommerce_related_products_args', 20 );

/**
 * Upsell Products Args.
 *
 * @param array $args upsell products args.
 * @return array $args upsell products args.
 */
function theme_woocommerce_upsell_products_args( $args ) {
	$columns  = wc_get_default_products_per_row();
	$defaults = array(
		'columns' => $columns,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_upsell_display_args', 'theme_woocommerce_upsell_products_args', 20 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

/**
 * Before Content.
 *
 * Wraps all WooCommerce content in wrappers which match the theme markup.
 *
 * @return void
 */
function theme_woocommerce_wrapper_before() {
	?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main">
		<?php
}
add_action( 'woocommerce_before_main_content', 'theme_woocommerce_wrapper_before' );

/**
 * After Content.
 *
 * Closes the wrapping divs.
 *
 * @return void
 */
function theme_woocommerce_wrapper_after() {
	?>
		</main><!-- #main -->
	</div><!-- #primary -->
	<?php
}
add_action( 'woocommerce_after_main_content', 'theme_woocommerce_wrapper_after' );

/**
 * Add out of stock badge
 */
function theme_woocommerce_before_shop_loop_item_title() {
	global $product;
	if ( ! $product->is_in_stock() ) {
		echo '<div class="out-of-stock-badge"><span>' . apply_filters( 'woocommerce_get_availability_text', __( 'Out of stock', 'theme' ) ) . '</span></div>';
	}
}
add_action( 'woocommerce_before_shop_loop_item_title', 'theme_woocommerce_before_shop_loop_item_title' );

/**
 * Add cart item remove icon
 *
 * @param  string $link The cart item remove link markup.
 * @return string The cart item remove link markup.
 */
function theme_woocommerce_cart_item_remove_link( $link ) {
	return str_replace( '&times;', theme_get_icon_svg( 'cancel', 18 ), $link );
}
add_action( 'woocommerce_cart_item_remove_link', 'theme_woocommerce_cart_item_remove_link' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'theme_woocommerce_header_cart' ) ) {
			theme_woocommerce_header_cart();
		}
	?>
 */

/**
 * Cart Fragments.
 *
 * Ensure cart contents update when products are added to the cart via AJAX.
 *
 * @param array $fragments Fragments to refresh via AJAX.
 * @return array Fragments to refresh via AJAX.
 */
function theme_woocommerce_cart_link_fragment( $fragments ) {
	ob_start();
	theme_woocommerce_cart_link();
	$fragments['a.cart-contents'] = ob_get_clean();

	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'theme_woocommerce_cart_link_fragment' );

/**
 * Validates whether the Woo Cart instance is available in the request
 *
 * @return bool
 */
function theme_woocommerce_cart_available() {
	$woo = WC();
	return $woo instanceof \WooCommerce && $woo->cart instanceof \WC_Cart;
}

/**
 * Cart Link.
 *
 * Displayed a link to the cart including the number of items present and the cart total.
 *
 * @return void
 */
function theme_woocommerce_cart_link() {
	if ( ! theme_woocommerce_cart_available() ) {
		return;
	}
	?>
	<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>">
		<span class="screen-reader-text">
			<?php
				printf(
					/* translators: %1$d is the number of products in the cart. */
					_n(
						'%1$d item in cart',
						'%1$d items in cart',
						WC()->cart->get_cart_contents_count(),
						'theme'
					),
					WC()->cart->get_cart_contents_count()
				);
			?>
		</span>
		<span class="cart-button">
			<?php
			echo theme_get_icon_svg( 'shopping_cart', 20 );
			if ( WC()->cart->get_cart_contents_count() > 0 ) :
				?>
				<span class="cart-badge"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
				<?php
			endif;
			?>
		</span>
	</a>
	<?php
}

/**
 * Display Header Cart.
 *
 * @return void
 */
function theme_woocommerce_header_cart() {
	if ( is_cart() ) {
		$class = 'current-menu-item';
	} else {
		$class = '';
	}
	?>
	<ul id="site-header-cart" class="site-header-cart">
		<li class="<?php echo esc_attr( $class ); ?>">
			<?php theme_woocommerce_cart_link(); ?>
		</li>
		<li>
			<?php
			$instance = array(
				'title' => '',
			);

			the_widget( 'WC_Widget_Cart', $instance );
			?>
		</li>
	</ul>
	<?php
}

/**
 * Display Header Cart Drawer.
 *
 * @return void
 */
function theme_woocommerce_header_cart_drawer() {
	if ( is_cart() ) {
		$class = 'current-menu-item';
	} else {
		$class = '';
	}
	?>
	<ul id="site-header-cart" class="site-header-cart">
		<li class="<?php echo esc_attr( $class ); ?>">
			<?php
				echo do_blocks( '<!-- wp:woocommerce/mini-cart {"productCountColor":{"color":"var(--theme-badge-background-color)"}} /-->' );
			?>
		</li>
	</ul>
	<?php
}

/**
 * Add a search icon at the end of the primary menu location.
 *
 * Use: add_filter( 'wp_nav_menu_items', 'theme_add_product_search_icon_item', 10, 2 );
 *
 * @param string $items  The HTML list content for the menu items.
 * @param object $args   An object containing wp_nav_menu() arguments.
 * @return string The HTML list content for the menu items.
 */
function theme_add_product_search_icon_item( $items, $args ) {
	$location = apply_filters( 'theme_product_search_icon_item_location', 'primary' );
	if ( $location === $args->theme_location ) {
		$items .= '<li class="menu-item menu-item-object-product_search_icon"><a href="#" class="search-toggle">' . theme_get_icon_svg( 'search', 20 ) . '</a><div class="search-wrap">' . get_product_search_form( false ) . '</div></li>';
	}
	return $items;
}

/**
 * Customize the product search form
 *
 * @param string $form  The search form markup.
 * @return string The search form markup.
 */
function theme_product_search_form( $form ) {
	$form = '<form role="search" method="get" class="woocommerce-product-search" action="' . esc_url( home_url( '/' ) ) . '">
		<label class="screen-reader-text" for="woocommerce-product-search-field-' . ( isset( $index ) ? absint( $index ) : 0 ) . '">' . esc_html__( 'Search for:', 'theme' ) . '</label>
		<input type="search" id="woocommerce-product-search-field-' . ( isset( $index ) ? absint( $index ) : 0 ) . '" class="search-field" placeholder="' . esc_attr__( 'Search products&hellip;', 'theme' ) . '" value="' . get_search_query() . '" name="s" />
		<button type="submit" value="' . esc_attr_x( 'Search', 'submit button', 'theme' ) . '">' . theme_get_icon_svg( 'search', 20 ) . '<span class="screen-reader-text">' . esc_html_x( 'Search', 'submit button', 'theme' ) . '</span></button>
		<input type="hidden" name="post_type" value="product" />
	</form>';
	return $form;
}
add_filter( 'get_product_search_form', 'theme_product_search_form' );

/**
 * Remove WooCommerce suggestions.
 */
add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );
