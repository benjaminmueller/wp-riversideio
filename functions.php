<?php
/**
 * Riverside.io functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Riverside.io 1.0
 */

/**
 * Sets up the content width value based on the theme's design.
 * @see riversideio_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 604;

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Riverside.io supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add a Visual Editor stylesheet.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, admin bar, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Riverside.io 1.0
 *
 * @return void
 */
function riversideio_setup() {
	/*
	 * Makes Riverside.io available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Riverside.io, use a find and
	 * replace to change 'riversideio' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'riversideio', get_template_directory() . '/languages' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
	 */
	add_editor_style( 'css/editor-style.css' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * This theme supports all available post formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
	) );

	/*
	 * Custom callback to make it easier for our fixed navbar to coexist with
	 * the WordPress toolbar. See `.wp-toolbar` in style.css.
	 *
	 * @see WP_Admin_Bar::initialize()
	 */
	add_theme_support( 'admin-bar', array(
		'callback' => '__return_false'
	) );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'riversideio' ) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 604, 270, true );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}
add_action( 'after_setup_theme', 'riversideio_setup' );

/**
 * Loads our special font CSS file.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * To disable in a child theme, use wp_dequeue_style()
 * function mytheme_dequeue_fonts() {
 *     wp_dequeue_style( 'riversideio-fonts' );
 * }
 * add_action( 'wp_enqueue_scripts', 'mytheme_dequeue_fonts', 11 );
 *
 * Also used in the Appearance > Header admin panel:
 * @see riversideio_custom_header_setup()
 *
 * @since Riverside.io 1.0
 *
 * @return void
 */
function riversideio_fonts() {

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'riversideio' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'riversideio' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source+Sans+Pro:400,700,300italic,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$protocol = is_ssl() ? 'https' : 'http';
		$query_args = array(
			'family' => implode( '|', $font_families ),
			'subset' => 'latin,latin-ext',
		);
		wp_enqueue_style( 'riversideio-fonts', add_query_arg( $query_args, "$protocol://fonts.googleapis.com/css" ), array(), null );
	}
}
add_action( 'wp_enqueue_scripts', 'riversideio_fonts' );

/**
 * Enqueues scripts and styles for front end.
 *
 * @since Riverside.io 1.0
 *
 * @return void
 */
function riversideio_scripts_styles() {
	global $wp_styles;

	/*
	 * Adds JavaScript to pages with the comment form to support sites with
	 * threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds Masonry to handle vertical alignment of footer widgets.
	if ( is_active_sidebar( 'sidebar-1' ) )
		wp_enqueue_script( 'jquery-masonry' );

	// Loads JavaScript file with functionality specific to Riverside.io.
	wp_enqueue_script( 'riversideio-script', get_template_directory_uri() . '/js/functions.js', array( 'jquery' ), '20130211', true );

	// Loads our main stylesheet.
	wp_enqueue_style( 'riversideio-style', get_stylesheet_uri() );

	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'riversideio-ie', get_template_directory_uri() . '/css/ie.css', array( 'riversideio-style' ), '20130213' );
	$wp_styles->add_data( 'riversideio-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'riversideio_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Riverside.io 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function riversideio_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'riversideio' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'riversideio_wp_title', 10, 2 );

/**
 * Registers two widget areas.
 *
 * @since Riverside.io 1.0
 *
 * @return void
 */
function riversideio_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'riversideio' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site', 'riversideio' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Widget Area', 'riversideio' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'riversideio' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'riversideio_widgets_init' );

if ( ! function_exists( 'riversideio_paging_nav' ) ) :
/**
 * Displays navigation to next/previous set of posts when applicable.
 *
 * @since Riverside.io 1.0
 *
 * @return void
 */
function riversideio_paging_nav() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
		return;
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="assistive-text"><?php _e( 'Posts navigation', 'riversideio' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'riversideio' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'riversideio' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'riversideio_post_nav' ) ) :
/**
 * Displays navigation to next/previous post when applicable.
*
* @since Riverside.io 1.0
*
* @return void
*/
function riversideio_post_nav() {
	global $post;

	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous )
		return;
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="assistive-text"><?php _e( 'Post navigation', 'riversideio' ); ?></h1>
		<div class="nav-links">

			<?php previous_post_link( '%link', _x( '<span class="meta-nav">&larr;</span> %title', 'Previous post link', 'riversideio' ) ); ?>
			<?php next_post_link( '%link', _x( '%title <span class="meta-nav">&rarr;</span>', 'Next post link', 'riversideio' ) ); ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'riversideio_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments
 * template simply create your own riversideio_comment(), and that function
 * will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Riverside.io 1.0
 *
 * @param object $comment Comment to display.
 * @param array $args Optional args.
 * @param int $depth Depth of comment.
 * @return void
 */

function riversideio_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
		<p><?php _e( 'Pingback:', 'riversideio' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( 'Edit', 'riversideio' ), '<span class="ping-meta"><span class="edit-link">', '</span></span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
	?>
	<li id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" <?php comment_class(); ?>>
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment, 74 ); ?>
				<cite class="fn"><?php comment_author_link(); ?></cite>
			</div><!-- .comment-author -->

			<header class="comment-meta">
				<?php
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						sprintf( _x( '%1$s at %2$s', '1: date, 2: time', 'riversideio' ), get_comment_date(), get_comment_time() )
					);
					edit_comment_link( __( 'Edit', 'riversideio' ), '<span class="edit-link">', '</span>' );
				?>
			</header><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'riversideio' ); ?></p>
			<?php endif; ?>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div><!-- .comment-content -->

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'riversideio' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->
	<?php
		break;
	endswitch; // End comment_type check.
}
endif;

if ( ! function_exists( 'riversideio_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own riversideio_entry_meta() to override in a child theme.
 *
 * @since Riverside.io 1.0
 *
 * @return void
 */
function riversideio_entry_meta() {
	if ( is_sticky() && is_home() && ! is_paged() )
		echo '<span class="featured-post">' . __( 'Sticky', 'riversideio' ) . '</span>';

	if ( ! has_post_format( 'aside' ) && ! has_post_format( 'link' ) && 'post' == get_post_type() )
		riversideio_entry_date();

	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'riversideio' ) );
	if ( $categories_list ) {
		echo '<span class="categories-links">' . $categories_list . '</span>';
	}

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'riversideio' ) );
	if ( $tag_list ) {
		echo '<span class="tags-links">' . $tag_list . '</span>';
	}

	// Post author
	if ( 'post' == get_post_type() ) {
		printf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_attr( sprintf( __( 'View all posts by %s', 'riversideio' ), get_the_author() ) ),
			get_the_author()
		);
	}
}
endif;

if ( ! function_exists( 'riversideio_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own riversideio_entry_date() to override in a child theme.
 *
 * @since Riverside.io 1.0
 *
 * @param boolean $echo Whether to echo the date. Default true.
 * @return string
 */
function riversideio_entry_date( $echo = true ) {
	$format_prefix = ( has_post_format( 'chat' ) || has_post_format( 'status' ) ) ? _x( '%1$s on %2$s', '1: post format name. 2: date', 'riversideio' ): '%2$s';

	$date = sprintf( '<span class="date"><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
		esc_url( get_permalink() ),
		esc_attr( sprintf( __( 'Permalink to %s', 'riversideio' ), the_title_attribute( 'echo=0' ) ) ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( sprintf( $format_prefix, get_post_format_string( get_post_format() ), get_the_date() ) )
	);

	if ( $echo )
		echo $date;

	return $date;
}
endif;

if ( ! function_exists( 'riversideio_get_first_url' ) ) :
/**
 * Return the URL for the first link in the post content or the permalink if no
 * URL is found.
 *
 * @since Riverside.io 1.0
 * @return string URL
 */
function riversideio_get_first_url() {
	$has_url = preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $match );
	$link    = ( $has_url ) ? $match[1] : apply_filters( 'the_permalink', get_permalink() );

	return esc_url_raw( $link );
}
endif;

if ( ! function_exists( 'riversideio_featured_gallery' ) ) :
/**
 * Displays first gallery from post content. Changes image size from thumbnail
 * to large, to display a larger first image.
 *
 * @since Riverside.io 1.0
 *
 * @return void
 */
function riversideio_featured_gallery() {
	$pattern = get_shortcode_regex();

	if ( preg_match( "/$pattern/s", get_the_content(), $match ) ) {
		if ( 'gallery' == $match[2] ) {
			if ( ! strpos( $match[3], 'size' ) )
				$match[3] .= ' size="medium"';

			echo do_shortcode_tag( $match );
		}
	}
}
endif;

/**
 * Extends the default WordPress body class to denote:
 * 1. Custom fonts enabled.
 * 2. Single or multiple authors.
 * 3. Active widgets in the sidebar to change the layout and spacing.
 *
 * @since Riverside.io 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function riversideio_body_class( $classes ) {

	// Enable custom font class only if the font CSS is queued to load.
	if ( wp_style_is( 'riversideio-fonts', 'queue' ) )
		$classes[] = 'custom-font';

	if ( ! is_multi_author() )
		$classes[] = 'single-author';

	if ( is_active_sidebar( 'sidebar-2' ) && ! is_attachment() && ! is_404() )
		$classes[] = 'sidebar';

	return $classes;
}
add_filter( 'body_class', 'riversideio_body_class' );

/**
 * Extends the default WordPress comment class to add 'no-avatars' class
 * if avatars are disabled in discussion settings.
 *
 * @since Riverside.io 1.0
 *
 * @param array $classes Existing class values.
 * @return array Filtered class values.
 */
function riversideio_comment_class( $classes ) {
	if ( ! get_option ( 'show_avatars' ) )
		$classes[] = 'no-avatars';

	return $classes;
}
add_filter( 'comment_class', 'riversideio_comment_class' );

/**
 * Adjusts content_width value for image post formats, video post formats, and
 * image attachment templates.
 *
 * @since Riverside.io 1.0
 */
function riversideio_content_width() {
	if ( has_post_format( 'image' ) || has_post_format( 'video' ) || is_attachment() ) {
		global $content_width;
		$content_width = 724;
	}
}
add_action( 'template_redirect', 'riversideio_content_width' );

/**
 * Adds entry date to aside posts after the content.
 *
 *
 * @since Riverside.io 1.0
 *
 * @param string $content Post content.
 * @return string Post content.
 */
function riversideio_aside_date( $content ) {
	if ( ! is_feed() && has_post_format( 'aside' ) ) {
		$content .= riversideio_entry_date( false );
	}
	return $content;
}
add_filter( 'the_content', 'riversideio_aside_date', 8 ); // After embeds, before everything else.

/**
 * Usability improvement for better viewing of images on attachment pages.
 *
 * Moves the focus down to the main content area to by appending an in-page
 * anchor to attachment link URLs.
 *
 * @since Riverside.io 1.0
 *
 * @param string $url The image attachment URL
 * @return string URL with extra anchor appended.
 */
function riversideio_attachment_link( $url ) {
	if ( wp_attachment_is_image() )
		$url .= '#main';

	return $url;
}
add_filter( 'attachment_link', 'riversideio_attachment_link' );

/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Riverside.io 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
function riversideio_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'riversideio_customize_register' );

/**
 * Binds JavaScript handlers to make Customizer preview reload changes
 * asynchronously.
 *
 * @since Riverside.io 1.0
 */
function riversideio_customize_preview_js() {
	wp_enqueue_script( 'riversideio-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}
add_action( 'customize_preview_init', 'riversideio_customize_preview_js' );

/**
 * Adds support for a custom header image.
 */
require( get_template_directory() . '/inc/custom-header.php' );
