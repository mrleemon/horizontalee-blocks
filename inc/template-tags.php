<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package theme
 */

/**
 * Prints HTML with meta information for the categories, tags.
 */
function theme_entry_meta() {
	if ( in_array( get_post_type(), array( 'post', 'attachment' ), true ) ) {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf(
			$time_string,
			esc_attr( get_the_date( 'c' ) ),
			get_the_date(),
			esc_attr( get_the_modified_date( 'c' ) ),
			get_the_modified_date()
		);

		printf(
			'<span class="posted-on">%1$s <span class="screen-reader-text">%2$s </span><a href="%3$s" rel="bookmark">%4$s</a></span>',
			theme_get_icon_svg( 'calendar', 14 ),
			esc_html_x( 'Posted on', 'Used before publish date.', 'theme' ),
			esc_url( get_permalink() ),
			$time_string
		);
	}

	if ( 'post' === get_post_type() ) {
		if ( is_singular() || is_multi_author() ) {
			printf(
				'<span class="byline">%1$s <span class="author vcard"><span class="screen-reader-text">%2$s </span><a class="url fn n" href="%3$s">%4$s</a></span></span>',
				theme_get_icon_svg( 'person', 14 ),
				esc_html_x( 'Author', 'Used before post author name.', 'theme' ),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				get_the_author()
			);
		}

		$categories_list = get_the_category_list( esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'theme' ) );
		if ( $categories_list && theme_categorized_blog() ) {
			printf(
				'<span class="cat-links">%1$s <span class="screen-reader-text">%2$s </span>%3$s</span>',
				theme_get_icon_svg( 'folder', 14 ),
				esc_html_x( 'Categories', 'Used before category names.', 'theme' ),
				$categories_list
			);
		}

		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'Used between list items, there is a space after the comma.', 'theme' ) );
		if ( $tags_list ) {
			printf(
				'<span class="tags-links">%1$s <span class="screen-reader-text">%2$s </span>%3$s</span>',
				theme_get_icon_svg( 'tag', 14 ),
				esc_html_x( 'Tags', 'Used before tag names.', 'theme' ),
				$tags_list
			);
		}
	}

	if ( is_attachment() && wp_attachment_is_image() ) {
		// Retrieve attachment metadata.
		$metadata = wp_get_attachment_metadata();

		if ( $metadata ) {
			printf(
				'<span class="full-size-link"><span class="screen-reader-text">%1$s </span><a href="%2$s">%3$s &times; %4$s</a></span>',
				esc_html_x( 'Full size', 'Used before full size attachment link.', 'theme' ),
				esc_url( wp_get_attachment_url() ),
				esc_html( $metadata['width'] ),
				esc_html( $metadata['height'] )
			);
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">' . theme_get_icon_svg( 'comment', 14 ) . ' ';
		/* translators: %s: post title */
		comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'theme' ), wp_kses_post( get_the_title() ) ) );
		echo '</span>';
	}
}

/**
 * Displays the class names for the loop element.
 *
 * @param string $classname  Classes for the loop element.
 * @return void
 */
function theme_loop_class( $classname = '' ) {
	$classes = array();

	$classes[] = sanitize_html_class( get_theme_mod( 'blog_layout', 'list' ) );
	if ( get_theme_mod( 'blog_layout', 'list' ) === 'grid' ) {
		$classes[] = 'columns-' . sanitize_html_class( get_theme_mod( 'grid_post_thumbnail_columns', 4 ) );
	}

	if ( ! empty( $classname ) ) {
		if ( ! is_array( $classname ) ) {
			$classname = preg_split( '#\s+#', $classname );
		}
		$classes = array_merge( $classes, $classname );
	} else {
		// Ensure that we always coerce class to being an array.
		$classname = array();
	}

	$classes = array_map( 'esc_attr', $classes );

	/**
	 * Filters the list of CSS class names for the current post or page.
	 *
	 * @param string[] $classes    An array of loop class names.
	 * @param string[] $classname  An array of additional class names added to the element.
	 */
	$classes = apply_filters( 'theme_loop_class', $classes, $classname );

	$classes = array_unique( $classes );

	// Separates class names with a single space, collates class names for loop element.
	echo ' ' . implode( ' ', $classes );
}

/**
 * Displays a post thumbnail on single pages.
 */
function theme_single_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	?>

	<div class="single-post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .single-post-thumbnail -->

	<?php
}

/**
 * Displays a post thumbnail on grid pages.
 *
 * @param string $size  The thumbnail size.
 * @return void
 */
function theme_grid_post_thumbnail( $size = 'thumbnail' ) {
	if ( post_password_required() || is_attachment() ) {
		return;
	}
	?>

	<div class="grid-post-thumbnail">
		<a href="<?php the_permalink(); ?>">

		<?php
		if ( has_post_thumbnail() ) :
			the_post_thumbnail(
				$size,
				array(
					'alt' => the_title_attribute(
						array(
							'echo' => false,
						)
					),
				)
			);
			?>
			<?php
			else :
				$attachment_id = get_theme_mod( 'default_grid_post_thumbnail' );
				if ( wp_attachment_is_image( $attachment_id ) ) :
					echo wp_get_attachment_image(
						$attachment_id,
						$size,
						false,
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
				else :
					if ( has_image_size( $size ) ) {
						$additional_sizes = wp_get_additional_image_sizes();
						$width            = intval( $additional_sizes[ $size ]['width'] );
						$height           = intval( $additional_sizes[ $size ]['height'] );
					} else {
						$width  = intval( get_option( $size . '_size_w' ) );
						$height = intval( get_option( $size . '_size_h' ) );
					}

					?>
					<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/placeholder.png' ); ?>" width="<?php echo esc_attr( $width ); ?>" height="<?php echo esc_attr( $height ); ?>" alt="<?php the_title_attribute(); ?>" />
					<?php
				endif;
			endif;
			?>

		<div class="overlay">
			<header class="entry-header">

				<?php do_action( 'theme_grid_entry_header_top' ); ?>

				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

				<?php do_action( 'theme_grid_entry_header_bottom' ); ?>

			</header>
		</div>

		</a>

		<?php
			edit_post_link(
				__( 'Edit', 'theme' ),
				'<span class="edit-link">',
				'</span>'
			);
		?>

	</div><!-- .grid-post-thumbnail -->

	<?php
}

/**
 * Displays previous/next page navigation.
 */
function theme_the_posts_navigation() {
	$order          = get_query_var( 'order', 'DESC' );
	$old_posts_text = _x( 'Previous', 'Previous set of posts', 'theme' );
	$new_posts_text = _x( 'Next', 'Next set of posts', 'theme' );
	the_posts_pagination(
		array(
			'type'               => 'list',
			'prev_text'          => sprintf(
				'%s <span class="screen-reader-text">%s</span>',
				'&larr;',
				( 'DESC' === $order ) ? $new_posts_text : $old_posts_text,
			),
			'next_text'          => sprintf(
				'<span class="screen-reader-text">%s</span> %s',
				( 'DESC' === $order ) ? $old_posts_text : $new_posts_text,
				'&rarr;',
			),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'theme' ) . ' </span>',
		)
	);
}

/**
 * Determine whether page has a sidebar.
 *
 * @return bool True if page has a sidebar, false otherwise.
 */
function theme_has_sidebar() {
	if ( is_front_page() ) {
		if ( get_theme_mod( 'front_sidebar_layout', 'none' ) !== 'none' ) {
			return true;
		}
	} elseif ( is_home() || is_singular( 'post' ) || is_category() || is_tag() || is_date() || is_author() || is_search() ) {
		if ( get_theme_mod( 'blog_sidebar_layout', 'right' ) !== 'none' ) {
			return true;
		}
	} elseif ( get_theme_mod( 'default_sidebar_layout', 'none' ) !== 'none' ) {
		return true;
	}
	return false;
}

/**
 * Determine whether blog/site has more than one category.
 *
 * @return bool True if there is more than one category, false otherwise.
 */
function theme_categorized_blog() {
	$category_count = get_transient( 'theme_categories' );

	if ( false === $category_count ) {
		// Create an array of all the categories that are attached to posts.
		$categories = get_categories(
			array(
				'fields'     => 'ids',
				'hide_empty' => 1,
				// We only need to know if there is more than one category.
				'number'     => 2,
			)
		);

		// Count the number of categories that are attached to the posts.
		$category_count = count( $categories );

		set_transient( 'theme_categories', $category_count );
	}

	return $category_count > 1;
}

/**
 * Flush out the transients used in {@see theme_categorized_blog()}.
 */
function theme_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'theme_categories' );
}
add_action( 'edit_category', 'theme_category_transient_flusher' );
add_action( 'save_post', 'theme_category_transient_flusher' );

/**
 * Add a sub nav icon to menu.
 *
 * @param stdClass $args An array of arguments.
 * @param string   $item Menu item.
 *
 * @return stdClass $args An object of wp_nav_menu() arguments.
 */
function theme_nav_menu_item_args( $args, $item ) {

	if ( isset( $args->show_toggles ) && $args->show_toggles ) {
		if ( in_array( 'menu-item-has-children', $item->classes, true ) ) {
			$args->after      = '<button type="button" class="dropdown-toggle" aria-expanded="false">' . theme_get_icon_svg( 'chevron_down', 26 ) . '<span class="screen-reader-text">' . __( 'Expand child menu', 'theme' ) . '</span></button>';
			$args->link_after = theme_get_icon_svg( 'chevron_down', 18 );
		} else {
			$args->after      = '';
			$args->link_after = '';
		}
	}

	return $args;
}
add_filter( 'nav_menu_item_args', 'theme_nav_menu_item_args', 10, 3 );

/**
 * Add a pencil icon to edit links in posts.
 *
 * @param string $link    Anchor tag for the edit link.
 * @param int    $post_id Post ID.
 * @param string $text    Anchor text.
 */
function theme_edit_post_link( $link, $post_id, $text ) {
	if ( is_admin() ) {
		return $link;
	}

	$edit_url = get_edit_post_link( $post_id );

	if ( ! $edit_url ) {
		return;
	}

	return theme_get_icon_svg( 'edit', 14 ) . '<a class="post-edit-link" href="' . esc_url( $edit_url ) . '">' . $text . '</a>';
}
add_filter( 'edit_post_link', 'theme_edit_post_link', 10, 3 );

/**
 * Add a pencil icon to edit links in comments.
 *
 * @param string $link       Anchor tag for the edit link.
 * @param int    $comment_id Comment ID.
 * @param string $text       Anchor text.
 */
function theme_edit_comment_link( $link, $comment_id, $text ) {
	if ( is_admin() ) {
		return $link;
	}

	$edit_url = get_edit_comment_link( $comment_id );

	if ( ! $edit_url ) {
		return;
	}

	return theme_get_icon_svg( 'edit', 14 ) . '<a class="comment-edit-link" href="' . esc_url( $edit_url ) . '">' . $text . '</a>';
}
add_filter( 'edit_comment_link', 'theme_edit_comment_link', 10, 3 );

/**
 * Add a reply icon to comments.
 *
 * @param stdClass $args An array of arguments.
 * @return stdClass $args An object of comment reply link arguments.
 */
function theme_comment_reply_link_args( $args ) {
	$args['before'] = '<div class="reply">' . theme_get_icon_svg( 'reply', 14 );
	$args['after']  = '</div>';
	return $args;
}
add_filter( 'comment_reply_link_args', 'theme_comment_reply_link_args' );

/**
 * Displays the footer text.
 */
function theme_footer_text() {
	$footer_text = get_theme_mod( 'footer_text' );
	echo wp_kses_post( do_shortcode( $footer_text ) );
}

/**
 * Registers block bindings.
 */
function theme_register_block_bindings() {
	register_block_bindings_source(
		'theme/copyright',
		array(
			'label'              => __( 'Copyright Year', 'theme' ),
			'get_value_callback' => function () {
				return sprintf(
					/* translators: 1: Copyright year, 2: Site name. */
					__( '&copy; %1$s %2$s. All Rights Reserved.', 'theme' ),
					wp_date( 'Y' ),
					get_bloginfo( 'name' )
				);
			},
		)
	);
	register_block_bindings_source(
		'theme/privacy',
		array(
			'label'              => __( 'Privacy Policy', 'theme' ),
			'get_value_callback' => function () {
				return get_the_privacy_policy_link( '', '<span role="separator" aria-hidden="true"></span>' );
			},
		)
	);
	register_block_bindings_source(
		'theme/wordpress',
		array(
			'label'              => __( 'WordPress', 'theme' ),
			'get_value_callback' => function () {
				/* translators: %s: CMS name, i.e. WordPress. */
				return '<a href="' . esc_url( __( 'https://wordpress.org/', 'theme' ) ) . '" class="imprint">' . sprintf( __( 'Proudly powered by %s', 'theme' ), 'WordPress' ) . '</a>';
			},
		)
	);
}
add_action( 'init', 'theme_register_block_bindings' );