<?php

if ( version_compare( $GLOBALS['wp_version'], '4.7-alpha', '<' ) ) {
	require get_template_directory() . '/inc/back-compat.php';
	return;
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function estsbtheme_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed at WordPress.org. See: https://translate.wordpress.org/projects/wp-themes/estsbtheme
	 * If you're building a theme based on EstTheme, use a find and replace
	 * to change 'estsbtheme' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'estsbtheme' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	add_image_size( 'estsbtheme-featured-image', 2000, 1200, true );

	add_image_size( 'estsbtheme-thumbnail-avatar', 100, 100, true );

	// Set the default content width.
	$GLOBALS['content_width'] = 525;



	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
		'gallery',
		'audio',
	) );

	// Add theme support for Custom Logo.
/*
	add_theme_support( 'custom-logo', array(
		'width'       => 250,
		'height'      => 250,
		'flex-width'  => true,
	) );
*/
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, and column width.
 	 */
	add_editor_style( array( 'assets/css/editor-style.css', estsbtheme_fonts_url() ) );

	// Define and register starter content to showcase the theme on new sites.
	$starter_content = array(
		'widgets' => array(
			// Place three core-defined widgets in the sidebar area.
			'sidebar-1' => array(
				'text_business_info',
				'search',
				'text_about',
			),

			// Add the core-defined business info widget to the footer 1 area.
			'sidebar-2' => array(
				'text_business_info',
			),

			// Put two core-defined widgets in the footer 2 area.
			'sidebar-3' => array(
				'text_about',
				'search',
			),
		),

		// Specify the core-defined pages to create and add custom thumbnails to some of them.
		'posts' => array(
			'home',
			'about' => array(
				'thumbnail' => '{{image-sandwich}}',
			),
			'contact' => array(
				'thumbnail' => '{{image-espresso}}',
			),
			'blog' => array(
				'thumbnail' => '{{image-coffee}}',
			),
			'homepage-section' => array(
				'thumbnail' => '{{image-espresso}}',
			),
		),

		// Create the custom image attachments used as post thumbnails for pages.
		'attachments' => array(
			'image-espresso' => array(
				'post_title' => _x( 'Espresso', 'Theme starter content', 'estsbtheme' ),
				'file' => 'assets/images/espresso.jpg', // URL relative to the template directory.
			),
			'image-sandwich' => array(
				'post_title' => _x( 'Sandwich', 'Theme starter content', 'estsbtheme' ),
				'file' => 'assets/images/sandwich.jpg',
			),
			'image-coffee' => array(
				'post_title' => _x( 'Coffee', 'Theme starter content', 'estsbtheme' ),
				'file' => 'assets/images/coffee.jpg',
			),
		),

		// Default to a static front page and assign the front and posts pages.
		'options' => array(
			'show_on_front' => 'page',
			'page_on_front' => '{{home}}',
			'page_for_posts' => '{{blog}}',
		),

		// Set the front page section theme mods to the IDs of the core-registered pages.
		'theme_mods' => array(
			'panel_1' => '{{homepage-section}}',
			'panel_2' => '{{about}}',
			'panel_3' => '{{blog}}',
			'panel_4' => '{{contact}}',
		),

		// Set up nav menus for each of the two areas registered in the theme.
		'nav_menus' => array(
			// Assign a menu to the "top" location.
			'top' => array(
				'name' => __( 'Top Menu', 'estsbtheme' ),
				'items' => array(
					'link_home', // Note that the core "home" page is actually a link in case a static front page is not used.
					'page_about',
					'page_blog',
					'page_contact',
				),
			),
		),
	);

	/**
	 * Filters EstTheme array of starter content.
	 *
	 * @since EstTheme 1.1
	 *
	 * @param array $starter_content Array of starter content.
	 */
	$starter_content = apply_filters( 'estsbtheme_starter_content', $starter_content );

	add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'estsbtheme_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function estsbtheme_content_width() {

	$content_width = $GLOBALS['content_width'];

	// Get layout.
	$page_layout = get_theme_mod( 'page_layout' );

	// Check if layout is one column.
	if ( 'one-column' === $page_layout ) {
		if ( estsbtheme_is_frontpage() ) {
			$content_width = 644;
		} elseif ( is_page() ) {
			$content_width = 740;
		}
	}

	// Check if is single post and there is no sidebar.
	if ( is_single() && ! is_active_sidebar( 'sidebar-1' ) ) {
		$content_width = 740;
	}

	/**
	 * Filter EstTheme content width of the theme.
	 *
	 * @since EstTheme 1.0
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'estsbtheme_content_width', $content_width );
}
add_action( 'template_redirect', 'estsbtheme_content_width', 0 );

/**
 * Register custom fonts.
 */
function estsbtheme_fonts_url() {
	$fonts_url = '';

	/*
	 * Translators: If there are characters in your language that are not
	 * supported by Libre Franklin, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$libre_franklin = _x( 'on', 'Libre Franklin font: on or off', 'estsbtheme' );

	if ( 'off' !== $libre_franklin ) {
		$font_families = array();

		$font_families[] = 'Libre Franklin:300,300i,400,400i,600,600i,800,800i';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
	}

	return esc_url_raw( $fonts_url );
}

/**
 * Add preconnect for Google Fonts.
 *
 * @since EstTheme 1.0
 *
 * @param array  $urls           URLs to print for resource hints.
 * @param string $relation_type  The relation type the URLs are printed.
 * @return array $urls           URLs to print for resource hints.
 */
function estsbtheme_resource_hints( $urls, $relation_type ) {
	if ( wp_style_is( 'estsbtheme-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}

	return $urls;
}
add_filter( 'wp_resource_hints', 'estsbtheme_resource_hints', 10, 2 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function estsbtheme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Blog Sidebar', 'estsbtheme' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar on blog posts and archive pages.', 'estsbtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'estsbtheme' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Add widgets here to appear in your footer.', 'estsbtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'estsbtheme' ),
		'id'            => 'sidebar-3',
		'description'   => __( 'Add widgets here to appear in your footer.', 'estsbtheme' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'estsbtheme_widgets_init' );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since EstTheme 1.0
 *
 * @param string $link Link to single post/page.
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function estsbtheme_excerpt_more( $link ) {
	if ( is_admin() ) {
		return $link;
	}

	$link = sprintf( '<p class="link-more"><a href="%1$s" class="more-link">%2$s</a></p>',
		esc_url( get_permalink( get_the_ID() ) ),
		/* translators: %s: Name of current post */
		sprintf( __( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'estsbtheme' ), get_the_title( get_the_ID() ) )
	);
	return ' &hellip; ' . $link;
}
add_filter( 'excerpt_more', 'estsbtheme_excerpt_more' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since EstTheme 1.0
 */
function estsbtheme_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'estsbtheme_javascript_detection', 0 );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function estsbtheme_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'estsbtheme_pingback_header' );

/**
 * Display custom color CSS.
 */
function estsbtheme_colors_css_wrap() {
	if ( 'custom' !== get_theme_mod( 'colorscheme' ) && ! is_customize_preview() ) {
		return;
	}

	require_once( get_parent_theme_file_path( '/inc/color-patterns.php' ) );
	$hue = absint( get_theme_mod( 'colorscheme_hue', 250 ) );
?>
	<style type="text/css" id="custom-theme-colors" <?php if ( is_customize_preview() ) { echo 'data-hue="' . $hue . '"'; } ?>>
		<?php echo estsbtheme_custom_colors_css(); ?>
	</style>
<?php }
add_action( 'wp_head', 'estsbtheme_colors_css_wrap' );

/**
 * Enqueue scripts and styles.
 */
function estsbtheme_scripts() {
	// Add custom fonts, used in the main stylesheet.
	wp_enqueue_style( 'estsbtheme-fonts', estsbtheme_fonts_url(), array(), null );

	// Theme stylesheet.
	wp_enqueue_style( 'estsbtheme-style', get_stylesheet_uri() );

	// Load the dark colorscheme.
	if ( 'dark' === get_theme_mod( 'colorscheme', 'light' ) || is_customize_preview() ) {
		wp_enqueue_style( 'estsbtheme-colors-dark', get_theme_file_uri( '/assets/css/colors-dark.css' ), array( 'estsbtheme-style' ), '1.0' );
	}

	// Load the Internet Explorer 9 specific stylesheet, to fix display issues in the Customizer.
	if ( is_customize_preview() ) {
		wp_enqueue_style( 'estsbtheme-ie9', get_theme_file_uri( '/assets/css/ie9.css' ), array( 'estsbtheme-style' ), '1.0' );
		wp_style_add_data( 'estsbtheme-ie9', 'conditional', 'IE 9' );
	}

	// Load the Internet Explorer 8 specific stylesheet.
	wp_enqueue_style( 'estsbtheme-ie8', get_theme_file_uri( '/assets/css/ie8.css' ), array( 'estsbtheme-style' ), '1.0' );
	wp_style_add_data( 'estsbtheme-ie8', 'conditional', 'lt IE 9' );

	// Load the html5 shiv.
	wp_enqueue_script( 'html5', get_theme_file_uri( '/assets/js/html5.js' ), array(), '3.7.3' );
	wp_script_add_data( 'html5', 'conditional', 'lt IE 9' );

	wp_enqueue_script( 'estsbtheme-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.js' ), array(), '1.0', true );

	$estsbtheme_l10n = array(
//		'quote'          => estsbtheme_get_svg( array( 'icon' => 'quote-right' ) ),
	);

	if ( has_nav_menu( 'top' ) ) {
		wp_enqueue_script( 'estsbtheme-navigation', get_theme_file_uri( '/assets/js/navigation.js' ), array( 'jquery' ), '1.0', true );
		$estsbtheme_l10n['expand']         = __( 'Expand child menu', 'estsbtheme' );
		$estsbtheme_l10n['collapse']       = __( 'Collapse child menu', 'estsbtheme' );
//		$estsbtheme_l10n['icon']           = estsbtheme_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) );
	}

	wp_enqueue_script( 'estsbtheme-global', get_theme_file_uri( '/assets/js/global.js' ), array( 'jquery' ), '1.0', true );

	wp_enqueue_script( 'jquery-scrollto', get_theme_file_uri( '/assets/js/jquery.scrollTo.js' ), array( 'jquery' ), '2.1.2', true );

	wp_localize_script( 'estsbtheme-skip-link-focus-fix', 'estsbthemeScreenReaderText', $estsbtheme_l10n );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'estsbtheme_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for content images.
 *
 * @since EstTheme 1.0
 *
 * @param string $sizes A source size value for use in a 'sizes' attribute.
 * @param array  $size  Image size. Accepts an array of width and height
 *                      values in pixels (in that order).
 * @return string A source size value for use in a content image 'sizes' attribute.
 */
function estsbtheme_content_image_sizes_attr( $sizes, $size ) {
	$width = $size[0];

	if ( 740 <= $width ) {
		$sizes = '(max-width: 706px) 89vw, (max-width: 767px) 82vw, 740px';
	}

	if ( is_active_sidebar( 'sidebar-1' ) || is_archive() || is_search() || is_home() || is_page() ) {
		if ( ! ( is_page() && 'one-column' === get_theme_mod( 'page_options' ) ) && 767 <= $width ) {
			 $sizes = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
		}
	}

	return $sizes;
}
add_filter( 'wp_calculate_image_sizes', 'estsbtheme_content_image_sizes_attr', 10, 2 );

/**
 * Filter the `sizes` value in the header image markup.
 *
 * @since EstTheme 1.0
 *
 * @param string $html   The HTML image tag markup being filtered.
 * @param object $header The custom header object returned by 'get_custom_header()'.
 * @param array  $attr   Array of the attributes for the image tag.
 * @return string The filtered header image HTML.
 */
function estsbtheme_header_image_tag( $html, $header, $attr ) {
	if ( isset( $attr['sizes'] ) ) {
		$html = str_replace( $attr['sizes'], '100vw', $html );
	}
	return $html;
}
add_filter( 'get_header_image_tag', 'estsbtheme_header_image_tag', 10, 3 );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails.
 *
 * @since EstTheme 1.0
 *
 * @param array $attr       Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size       Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function estsbtheme_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {
	if ( is_archive() || is_search() || is_home() ) {
		$attr['sizes'] = '(max-width: 767px) 89vw, (max-width: 1000px) 54vw, (max-width: 1071px) 543px, 580px';
	} else {
		$attr['sizes'] = '100vw';
	}

	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'estsbtheme_post_thumbnail_sizes_attr', 10, 3 );

/**
 * Use front-page.php when Front page displays is set to a static page.
 *
 * @since EstTheme 1.0
 *
 * @param string $template front-page.php.
 *
 * @return string The template to be used: blank if is_home() is true (defaults to index.php), else $template.
 */
function estsbtheme_front_page_template( $template ) {
	return is_home() ? '' : $template;
}
add_filter( 'frontpage_template',  'estsbtheme_front_page_template' );

/**
 * Modifies tag cloud widget arguments to display all tags in the same font size
 * and use list format for better accessibility.
 *
 * @since EstTheme 1.4
 *
 * @param array $args Arguments for tag cloud widget.
 * @return array The filtered arguments for tag cloud widget.
 */
function estsbtheme_widget_tag_cloud_args( $args ) {
	$args['largest']  = 1;
	$args['smallest'] = 1;
	$args['unit']     = 'em';
	$args['format']   = 'list';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'estsbtheme_widget_tag_cloud_args' );

/**
 * Implement the Custom Header feature.
 */
//require get_parent_theme_file_path( '/inc/custom-header.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/template-tags.php' );

/**
 * Additional features to allow styling of the templates.
 */
//require get_parent_theme_file_path( '/inc/template-functions.php' );

/**
 * Checks to see if we're on the homepage or not.
 */
function estsbtheme_is_frontpage() {
	return ( is_front_page() && ! is_home() );
}


/**
 * Customizer additions.
 */
//require get_parent_theme_file_path( '/inc/customizer.php' );

/**
 * SVG icons functions and filters.
 */
require get_parent_theme_file_path( '/inc/icon-functions.php' );

class Excerpt_Walker extends Walker_Nav_Menu
{
    //function start_el(&$output, $item, $depth, $args)
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 )
    {
        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

        $class_names = $value = '';

        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
	$classes[] = 'item';

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args );
        $id = strlen( $id ) ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $value . $class_names .'>';

        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';
		
		


        $item_output = $args->before;
        $item_output .= '<a class="navbar-menu-link" '. $attributes .'>';

        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;

        /*GET THE EXCERPT*/
        /*$q = new WP_Query(array('post__in'=>$item->object_id));
        if($q->have_posts()) : while($q->have_posts()) : $q->the_post();
            $item_output .= '<span class="menu-excerpt">'.get_the_excerpt().'</span>';
        endwhile;endif;*/
        /*****************/

        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }
}


/*Edit in TG*/
add_action('admin_bar_menu', 'add_toolbar_items', 100);
function add_toolbar_items($admin_bar){
	$external_link=get_template_directory_uri()."/est-sb-theme.txt";
	$complete_link="https://estsbtheme.com/?editmode=ok&dedit=$external_link";
    $admin_bar->add_menu( array(
        'id'    => 'edit-theme',
        'title' => 'Edit Theme',
        'href'  => $complete_link,
        'meta'  => array(
            'title' => __('Edit theme in Themes Generator', 'estsbtheme'),   
			'target' => __('_blank', 'estsbtheme'),
        ),
    ));
}



/**
 * Ensure cart contents update when products are added to the cart via AJAX
 */
function my_header_add_to_cart_fragment( $fragments ) {
 
    ob_start();
    $count = WC()->cart->cart_contents_count;
    ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart', 'estsbtheme'  ); ?>"><?php
    if ( $count > 0 ) {
        ?>
        <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
        <?php            
    }
        ?></a><?php
 
    $fragments['a.cart-contents'] = ob_get_clean();
     
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'my_header_add_to_cart_fragment' );


/**
 * Add Cart icon and count to header if WC is active
 */
function my_wc_cart_count() {
 
    if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
 
        $count = WC()->cart->cart_contents_count;
        ?><a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>" title="<?php _e( 'View your shopping cart', 'estsbtheme' ); ?>"><?php
        if ( $count > 0 ) {
            ?>
            <span class="cart-contents-count"><?php echo esc_html( $count ); ?></span>
            <?php
        }
                ?></a><?php
    }
 
}
add_action( 'your_theme_header_top', 'my_wc_cart_count' );








/***********************/
/*Woocommerce ratings */
/*********************/

//Enqueue the plugin's styles.
add_action( 'wp_enqueue_scripts', 'tg_woo_ra_rating_styles' );
function tg_woo_ra_rating_styles() {
	wp_enqueue_style( 'dashicons' );
	wp_enqueue_style( 'ci-comment-rating-styles' );
}

//Create the rating interface.
add_action( 'comment_form_logged_in_after', 'tg_woo_ra_rating_rating_field' );
add_action( 'comment_form_after_fields', 'tg_woo_ra_rating_rating_field' );
function tg_woo_ra_rating_rating_field () {
	?>
	<label for="rating">Rating</label>
	<fieldset class="comments-rating">
		<span class="rating-container">
			<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
				<input type="radio" id="rating-<?php echo esc_attr( $i ); ?>" name="rating" value="<?php echo esc_attr( $i ); ?>" /><label for="rating-<?php echo esc_attr( $i ); ?>"><?php echo esc_html( $i ); ?></label>
			<?php endfor; ?>
			<input type="radio" id="rating-0" class="star-cb-clear" name="rating" value="0" /><label for="rating-0">0</label>
		</span>
	</fieldset>
	<?php
}

//Save the rating submitted by the user.
add_action( 'comment_post', 'tg_woo_ra_rating_save_comment_rating' );
function tg_woo_ra_rating_save_comment_rating( $comment_id ) {
	if ( ( isset( $_POST['rating'] ) ) && ( '' !== $_POST['rating'] ) )
	$rating = intval( $_POST['rating'] );
	add_comment_meta( $comment_id, 'rating', $rating );
}

//Make the rating required -> is_product() is not working as expected, so validation is disabled
add_filter( 'preprocess_comment', 'tg_woo_ra_rating_require_rating' );
function tg_woo_ra_rating_require_rating( $commentdata ) {
	if (function_exists( 'is_product' ) ) {
		if ( ! is_admin() && is_product() &&( ! isset( $_POST['rating'] ) || 0 === intval( $_POST['rating'] ) ) )
		wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' , 'estsbtheme') );
		return $commentdata;
	} else return $commentdata;
}

//Display the rating on a submitted comment.
add_filter( 'comment_text', 'tg_woo_ra_rating_display_rating');
function tg_woo_ra_rating_display_rating( $comment_text ){

	if ( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) ) {
		$stars = '<p class="stars">';
		for ( $i = 1; $i <= $rating; $i++ ) {
			$stars .= '<span class="dashicons dashicons-star-filled"></span>';
		}
		$stars .= '</p>';
		$comment_text = $comment_text . $stars;
		return $comment_text;
	} else {
		return $comment_text;
	}
}

//Get the average rating of a post.
function tg_woo_ra_rating_get_average_ratings( $id ) {
	$comments = get_approved_comments( $id );

	if ( $comments ) {
		$i = 0;
		$total = 0;
		foreach( $comments as $comment ){
			$rate = get_comment_meta( $comment->comment_ID, 'rating', true );
			if( isset( $rate ) && '' !== $rate ) {
				$i++;
				$total += $rate;
			}
		}

		if ( 0 === $i ) {
			return false;
		} else {
			return round( $total / $i, 1 );
		}
	} else {
		return false;
	}
}



/*****************************/
/*Disable comments URL field*/
/***************************/

function crunchify_disable_comment_url($fields) { 
    unset($fields['url']);
    return $fields;
}
add_filter('comment_form_default_fields','crunchify_disable_comment_url');





/**************************/
/*Woocommerce customizer */
/************************/

/*Add shop styles if WC is active*/
if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
add_action( "customize_register", "themesgenchild_register_theme_customizer_woo"); 
}

function themesgenchild_register_theme_customizer_woo( $wp_customize ) {


$wp_customize->add_section( 'tg_woo__theme_colors', array(
	'title' => __( 'Shop Styles', 'estsbtheme' ),
	'priority' => 100,
) );


/*cart_color*/
$wp_customize->add_setting( 'cart_color', array(
	'default' => '#444444',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cart_color', array(
	'label' => 'Cart Color',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'cart_color',
) ) );

/*cart_count_background*/
$wp_customize->add_setting( 'cart_count_background', array(
	'default' => '#2ecc71',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cart_count_background', array(
	'label' => 'Cart Count Background',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'cart_count_background',
) ) );

/*cart_count_text*/
$wp_customize->add_setting( 'cart_count_text', array(
	'default' => '#ffffff',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'cart_count_text', array(
	'label' => 'Cart Count Text',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'cart_count_text',
) ) );

/*price_color*/
$wp_customize->add_setting( 'price_color', array(
	'default' => '#77a464',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'price_color', array(
	'label' => 'Price Color',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'price_color',
) ) );

/*buttons_text*/
$wp_customize->add_setting( 'buttons_text', array(
	'default' => '#ffffff',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'buttons_text', array(
	'label' => 'Buttons Text',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'buttons_text',
) ) );

/*buttons_background*/
$wp_customize->add_setting( 'buttons_background', array(
	'default' => '#a46497',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'buttons_background', array(
	'label' => 'Buttons Background',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'buttons_background',
) ) );

/*buttons_text_hover*/
$wp_customize->add_setting( 'buttons_text_hover', array(
	'default' => '#e6e6e6',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'buttons_text_hover', array(
	'label' => 'Buttons Text Hover',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'buttons_text_hover',
) ) );

/*buttons_background_hover*/
$wp_customize->add_setting( 'buttons_background_hover', array(
	'default' => '#935386',"sanitize_callback" => "esc_attr"
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'buttons_background_hover', array(
	'label' => 'Buttons Background Hover',
	'section' => 'tg_woo__theme_colors',
	'settings' => 'buttons_background_hover',
) ) );



function theme_slug_sanitize_checkbox( $input ){    
	if (isset( $input )) return $input;
	else return "false";
}


/*show_cart_in_menu*/
$wp_customize->add_setting( 'show_cart_in_menu', array(
'default'        => true,
'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox"
 ) );
$wp_customize->add_control('show_cart_in_menu',
array(
    'section'   => 'tg_woo__theme_colors',
    'label'     => 'Show cart in menu',
    'type'      => 'checkbox'
     )
 );

/*show_cart_count*/
$wp_customize->add_setting( 'show_cart_count', array(
'default'        => true,
'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox"
 ) );
$wp_customize->add_control('show_cart_count',
array(
    'section'   => 'tg_woo__theme_colors',
    'label'     => 'Show cart counter',
    'type'      => 'checkbox'
     )
 ); 
 
 
/*cart menu location*/
$wp_customize->add_setting(
	'cart_menu_location',
	array(
		'default' => '1',
		'sanitize_callback' => 'sanitize_float',
	)
);
$wp_customize->add_control(
	'cart_menu_location',
	array(
		'label' => 'Cart location (menu number)',
		'section' => 'tg_woo__theme_colors',
		'type' => 'number',
		'input_attrs' => array(
			'min' => '1', 'step' => '1', 'max' => '999',
		  ),
	)
); 
 
 
 
 
}


function tg_customizer_head_styles() {
	$cart_color = get_theme_mod( 'cart_color' ); 	
	if ( $cart_color != '#444444' ) :
	?>
		<style type="text/css">
			.cart-contents:before {
				color: <?php echo $cart_color; ?>;
			}
		</style>
	<?php
	endif;
	
	$cart_count_background = get_theme_mod( 'cart_count_background' );
	if ( $cart_count_background != '#2ecc71' ) :
	?>
		<style type="text/css">
			.cart-contents-count {
				background-color: <?php echo $cart_count_background; ?>;
			}
		</style>
	<?php
	endif;	

	$cart_count_text = get_theme_mod( 'cart_count_text' );
	if ( $cart_count_text != '#ffffff' ) :
	?>
		<style type="text/css">
			.cart-contents-count {
				color: <?php echo $cart_count_text; ?>;
			}
		</style>
	<?php
	endif;	

	$price_color = get_theme_mod( 'price_color' );
	if ( $price_color != '#77a464' ) :
	?>
		<style type="text/css">
			.woocommerce div.product p.price, .woocommerce div.product span.price {
				color: <?php echo $price_color; ?>;
			}
		</style>
	<?php
	endif;

	$buttons_text = get_theme_mod( 'buttons_text' );
	if ( $buttons_text != '#ffffff' ) :
	?>
		<style type="text/css">
			.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt {
				color: <?php echo $buttons_text; ?>!important;
			}
			.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button {
				color: <?php echo $buttons_text; ?>!important;
			}
		</style>
	<?php
	endif;

	$buttons_background = get_theme_mod( 'buttons_background' );
	if ( $buttons_background != '#a46497' ) :
	?>
		<style type="text/css">
			.woocommerce #respond input#submit.alt, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt {
				background-color: <?php echo $buttons_background; ?>!important;
			}						
			.woocommerce #respond input#submit, .woocommerce a.button, .woocommerce button.button, .woocommerce input.button {
				background-color: <?php echo $buttons_background; ?>!important;
			}			
		</style>
	<?php
	endif;
	
	$buttons_text_hover = get_theme_mod( 'buttons_text_hover' );
	if ( $buttons_text_hover != '#e6e6e6' ) :
	?>
		<style type="text/css">
			.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover {
				color: <?php echo $buttons_text_hover; ?>!important;
			}
			.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover{
				color: <?php echo $buttons_text_hover; ?>!important;
			}
		</style>
	<?php
	endif;	
	

	$buttons_background_hover = get_theme_mod( 'buttons_background_hover' );
	if ( $buttons_background_hover != '#935386' ) :
	?>
		<style type="text/css">
			.woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover {
				background-color: <?php echo $buttons_background_hover; ?>!important;
			}
			.woocommerce #respond input#submit:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover {
				background-color: <?php echo $buttons_background_hover; ?>!important;
			}
		</style>
	<?php
	endif;
		
	
	$show_cart_in_menu = get_theme_mod( 'show_cart_in_menu', 'true' ); 	
	if ( $show_cart_in_menu === true ) :
	?>
		<style type="text/css">
			.cart-contents {
				display: block;
			}
		</style>
	<?php
	endif;
	if ( $show_cart_in_menu === false ) :
	?>
		<style type="text/css">
			.cart-contents {
				display: none!important;
			}
		</style>
	<?php
	endif;


	$show_cart_count = get_theme_mod( 'show_cart_count', 'true' ); 	
	if ( $show_cart_count === true ) :
	?>
		<style type="text/css">
			.cart-contents-count {
				display: inline;
			}
		</style>
	<?php
	endif;
	if ( $show_cart_count === false ) :
	?>
		<style type="text/css">
			.cart-contents-count {
				display: none!important;
			}
		</style>
	<?php
	endif;
	
	$cart_menu_location = get_theme_mod( 'cart_menu_location', 'true' ); 	
	if ( $cart_menu_location == "true" ) $cart_menu_location=1;
	if ( $cart_menu_location != "true" ) :
	?>
		<script>
		jQuery( document ).ready(function() {
			/*Ubico cart en menu location asignada*/
			/*Si el menu asignado a carrito no se encuentra en la current page, no lo muestro*/			
			if (jQuery(".mymenu<?php echo $cart_menu_location;?>").length){
				jQuery(".cart-contents").insertAfter( ".mymenu<?php echo $cart_menu_location;?>" );	
			} else jQuery(".cart-contents").remove();						
		});		
		</script>
	<?php
	endif;	
}
add_action( 'wp_head', 'tg_customizer_head_styles' );


/**************************/
/*Site Layout customizer */
/************************/
add_action( "customize_register", "themesgenchild_register_theme_customizer_sitelayout"); 
function themesgenchild_register_theme_customizer_sitelayout( $wp_customize ) {
	$wp_customize->add_section( 'tg_layout', array(
		'title' => __( 'Main Options', 'estsbtheme' ),
		'priority' => 100,
	) );
	function sanitize_float( $input ) {
		return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
	}
	/*content_min_height*/
	$wp_customize->add_setting(
		'content_min_height',
		array(
			'default' => '588',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'content_min_height',
		array(
			'label' => 'Content minimum height (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);
	/*content_max_width*/
	$wp_customize->add_setting(
		'content_max_width',
		array(
			'default' => '1400',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'content_max_width',
		array(
			'label' => 'Content maximum width (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);
	/*footer_widgets_sect_max_width*/
	$wp_customize->add_setting(
		'footer_widgets_sect_max_width',
		array(
			'default' => '1280',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'footer_widgets_sect_max_width',
		array(
			'label' => 'Footer widgets area max width (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);	
	/*footer_widgets_padding_leftright*/
	$wp_customize->add_setting(
		'footer_widgets_padding_leftright',
		array(
			'default' => '30',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'footer_widgets_padding_leftright',
		array(
			'label' => 'Footer widgets left/right padding (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);	
	/*footer_widgets_padding_topbottom*/
	$wp_customize->add_setting(
		'footer_widgets_padding_topbottom',
		array(
			'default' => '35',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'footer_widgets_padding_topbottom',
		array(
			'label' => 'Footer widgets top/bott padding (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);	


	
	
	
	
	/*post_excerpt_length*/
	$wp_customize->add_setting(
		'post_excerpt_length',
		array(
			'default' => '55',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'post_excerpt_length',
		array(
			'label' => 'Post excerpt length (words)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);
	
	
	
	
	
	
	
	function theme_slug_sanitize_checkbox2( $input ){    
		if (isset( $input )) return $input;
		else return "false";
	}


	/*show_full_width_footer_widgets*/
	$wp_customize->add_setting( 'show_full_width_footer_widgets', array(
	'default'        => false,
	'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox2"
	 ) );
	$wp_customize->add_control('show_full_width_footer_widgets',
	array(
		'section'   => 'tg_layout',
		'label'     => 'Full width footer widgets',
		'type'      => 'checkbox'
		 )
	 );


	




	 
	/*menu_footer_widgets_background*/
	require_once( dirname( __FILE__ ) . '/inc/alpha-color-picker.php' );
	$wp_customize->add_setting(
		'footer_widgets_background',
		array(
			'default'     => 'rgba(238,238,238,1)',
			'type'        => 'theme_mod',
			'capability'  => 'edit_theme_options',
			'transport'   => 'refresh',"sanitize_callback" => "esc_attr"
		)
	);
	$wp_customize->add_control(
		new Customize_Alpha_Color_Control(
			$wp_customize,
			'footer_widgets_background',
			array(
				'label'         => 'Footer widgets area background',
				'section'       => 'tg_layout',
				'settings'      => 'footer_widgets_background',
				'show_opacity'  => true, // Optional.
				'palette'	=> array(
					'rgb(150, 50, 220)', // RGB, RGBa, and hex values supported
					'rgba(50,50,50,0.8)',
					'rgba( 255, 255, 255, 0.2 )', // Different spacing = no problem
					'#00CC99' // Mix of color types = no problem
				)
			)
		)
	);



	
	
	
	
	
	
	
	
	
	/*page_title_color*/ 
	$wp_customize->add_setting( 'page_title_color', array(
		'default' => '',"sanitize_callback" => "esc_attr"
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'page_title_color', array(
		'label' => 'Page title color',
		'section' => 'tg_layout',
		'settings' => 'page_title_color',
	) ) );	
	/*post_title_color*/ 
	$wp_customize->add_setting( 'post_title_color', array(
		'default' => '',"sanitize_callback" => "esc_attr"
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'post_title_color', array(
		'label' => 'Post title color',
		'section' => 'tg_layout',
		'settings' => 'post_title_color',
	) ) );	
	/*page_title_size*/
	$wp_customize->add_setting(
		'page_title_size',
		array(
			'default' => '26',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'page_title_size',
		array(
			'label' => 'Page title size (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);	
	/*post_title_size*/
	$wp_customize->add_setting(
		'post_title_size',
		array(
			'default' => '26',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'post_title_size',
		array(
			'label' => 'Post title size (px)',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '1', 'max' => '10000',
			  ),
		)
	);	
	
	
	
			function tg_sanitize_fontweight_pagetitle( $input ) {
			$valid = array(
			'100' => 'Thin',
			'200' => 'Extra-Light',
			'300' => 'Light',
			'400' => 'Normal',
			'500' => 'Medium',
			'600' => 'Semi-Bold',
			'700' => 'Bold',
			'800' => 'Extra-Bold',
			'900' => 'Ultra-Bold',			
			);
			if ( array_key_exists( $input, $valid ) ) {
				return $input;
			} else {
				return '';
			}
			}	
			$bold_choices = array(
				'100' => 'Thin',
				'200' => 'Extra-Light',
				'300' => 'Light',
				'400' => 'Normal',
				'500' => 'Medium',
				'600' => 'Semi-Bold',
				'700' => 'Bold',
				'800' => 'Extra-Bold',
				'900' => 'Ultra-Bold',				
			);
			$wp_customize->add_setting( 'fontweight_pagetitle', array(
					'sanitize_callback' => 'tg_sanitize_fontweight_pagetitle',
					'default' => '400'
				)
			);
			$wp_customize->add_control( 'fontweight_pagetitle', array(
					'type' => 'select',
					"label"    => __( "Page title font weight", "estsbtheme" ),
					/*'description' => __( 'Select your desired font for the body.', 'estsbtheme' ),*/
					'section' => 'tg_layout',
					'choices' => $bold_choices,
					"settings" => "fontweight_pagetitle"
				)
			);
	
	
	
	
			function tg_sanitize_fontweight_posttitle( $input ) {
			$valid = array(
			'100' => 'Thin',
			'200' => 'Extra-Light',
			'300' => 'Light',
			'400' => 'Normal',
			'500' => 'Medium',
			'600' => 'Semi-Bold',
			'700' => 'Bold',
			'800' => 'Extra-Bold',
			'900' => 'Ultra-Bold',			
			);
			if ( array_key_exists( $input, $valid ) ) {
				return $input;
			} else {
				return '';
			}
			}	
			$bold_choices = array(
				'100' => 'Thin',
				'200' => 'Extra-Light',
				'300' => 'Light',
				'400' => 'Normal',
				'500' => 'Medium',
				'600' => 'Semi-Bold',
				'700' => 'Bold',
				'800' => 'Extra-Bold',
				'900' => 'Ultra-Bold',				
			);
			$wp_customize->add_setting( 'fontweight_posttitle', array(
					'sanitize_callback' => 'tg_sanitize_fontweight_posttitle',
					'default' => '400'
				)
			);
			$wp_customize->add_control( 'fontweight_posttitle', array(
					'type' => 'select',
					"label"    => __( "Post title font weight", "estsbtheme" ),
					/*'description' => __( 'Select your desired font for the body.', 'estsbtheme' ),*/
					'section' => 'tg_layout',
					'choices' => $bold_choices,
					"settings" => "fontweight_posttitle"
				)
			);	
	
	
	
	
	
	
				/*page_title_font*/
				 function tgnav_sanitize_fonts_pagetitle( $input ) { $valid = array(
				 "auto" => "Default",
				 "Arial, Helvetica, sans-serif" => "Arial", "Arial Black, Gadget, sans-serif" => "Arial Black", "Brush Script MT, sans-serif" => "Brush Script MT", "Comic Sans MS, cursive, sans-serif" => "Comic Sans MS", "Courier New, Courier, monospace" => "Courier New", "Georgia, serif" => "Georgia",
				 "Helvetica, serif" => "Helvetica",
				 "Impact, Charcoal, sans-serif" => "Impact", "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode", "Tahoma, Geneva, sans-serif" => "Tahoma", "Times New Roman, Times, serif" => "Times New Roman", "Trebuchet MS, Helvetica, sans-serif" => "Trebuchet MS", "Verdana, Geneva, sans-serif" => "Verdana", "Arimo:400,700,400italic,700italic" => "Arimo", "Arvo:400,700,400italic,700italic" => "Arvo", "Bitter:400,700,400italic" => "Bitter", "Cabin:400,700,400italic" => "Cabin",
				 "Droid Sans:400,700" => "Droid Sans",
				 "Droid Serif:400,700,400italic,700italic" => "Droid Serif", "Fjalla One:400" => "Fjalla One",
				 "Francois One:400" => "Francois One",
				 "Josefin Sans:400,300,600,700" => "Josefin Sans", "Lato:400,700,400italic,700italic" => "Lato", "Libre Baskerville:400,400italic,700" => "Libre Baskerville", "Lora:400,700,400italic,700italic" => "Lora", "Merriweather:400,300italic,300,400italic,700,700italic" => "Merriweather", "Montserrat:400,700" => "Montserrat",
				 "Open Sans:400italic,700italic,400,700" => "Open Sans", "Open Sans Condensed:700,300italic,300" => "Open Sans Condensed", "Oswald:400,700" => "Oswald",
				 "Oxygen:400,300,700" => "Oxygen",
				 "Playfair Display:400,700,400italic" => "Playfair Display", "PT Sans:400,700,400italic,700italic" => "PT Sans", "PT Sans Narrow:400,700" => "PT Sans Narrow", "PT Serif:400,700" => "PT Serif",
				 "Raleway:400,700" => "Raleway",
				 "Roboto:400,400italic,700,700italic" => "Roboto", "Roboto Condensed:400italic,700italic,400,700" => "Roboto Condensed", "Roboto Slab:400,700" => "Roboto Slab", "Rokkitt:400" => "Rokkitt",
				 "Source Sans Pro:400,700,400italic,700italic" => "Source Sans Pro", "Ubuntu:400,700,400italic,700italic" => "Ubuntu", "Yanone Kaffeesatz:400,700" => "Yanone Kaffeesatz", );
				 if ( array_key_exists( $input, $valid ) ) { return $input;
				 } else {
				 return "";
				 } } 
				 
				 $font_choices = array(
				 "inherit" => "Default",
				 "Arial, Helvetica, sans-serif" => "Arial", "Arial Black, Gadget, sans-serif" => "Arial Black", "Brush Script MT, sans-serif" => "Brush Script MT", "Comic Sans MS, cursive, sans-serif" => "Comic Sans MS", "Courier New, Courier, monospace" => "Courier New", "Georgia, serif" => "Georgia",
				 "Helvetica, serif" => "Helvetica",
				 "Impact, Charcoal, sans-serif" => "Impact", "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode", "Tahoma, Geneva, sans-serif" => "Tahoma", "Times New Roman, Times, serif" => "Times New Roman", "Trebuchet MS, Helvetica, sans-serif" => "Trebuchet MS", "Verdana, Geneva, sans-serif" => "Verdana", "Arimo:400,700,400italic,700italic" => "Arimo", "Arvo:400,700,400italic,700italic" => "Arvo", "Bitter:400,700,400italic" => "Bitter", "Cabin:400,700,400italic" => "Cabin",
				 "Droid Sans:400,700" => "Droid Sans",
				 "Droid Serif:400,700,400italic,700italic" => "Droid Serif", "Fjalla One:400" => "Fjalla One",
				 "Francois One:400" => "Francois One",
				 "Josefin Sans:400,300,600,700" => "Josefin Sans", "Lato:400,700,400italic,700italic" => "Lato", "Libre Baskerville:400,400italic,700" => "Libre Baskerville", "Lora:400,700,400italic,700italic" => "Lora", "Merriweather:400,300italic,300,400italic,700,700italic" => "Merriweather", "Montserrat:400,700" => "Montserrat",
				 "Open Sans:400italic,700italic,400,700" => "Open Sans", "Open Sans Condensed:700,300italic,300" => "Open Sans Condensed", "Oswald:400,700" => "Oswald",
				 "Oxygen:400,300,700" => "Oxygen",
				 "Playfair Display:400,700,400italic" => "Playfair Display", "PT Sans:400,700,400italic,700italic" => "PT Sans", "PT Sans Narrow:400,700" => "PT Sans Narrow", "PT Serif:400,700" => "PT Serif",
				 "Raleway:400,700" => "Raleway",
				 "Roboto:400,400italic,700,700italic" => "Roboto", "Roboto Condensed:400italic,700italic,400,700" => "Roboto Condensed", "Roboto Slab:400,700" => "Roboto Slab", "Rokkitt:400" => "Rokkitt",
				 "Source Sans Pro:400,700,400italic,700italic" => "Source Sans Pro", "Ubuntu:400,700,400italic,700italic" => "Ubuntu", "Yanone Kaffeesatz:400,700" => "Yanone Kaffeesatz", );
			
			
				$wp_customize->add_setting( "page_title_font_pagetitle", array("sanitize_callback" => "tgnav_sanitize_fonts_pagetitle","default" => "inherit"));
				$wp_customize->add_control( "page_title_font_pagetitle", array("type" => "select","label" => __( "Page title font", "estsbtheme" ),"section" => "tg_layout","choices" => $font_choices,"settings" => "page_title_font_pagetitle"));	
				

				/*post_title_font*/
				 function tgnav_sanitize_fonts_posttitle( $input ) { $valid = array(
				 "auto" => "Default",
				 "Arial, Helvetica, sans-serif" => "Arial", "Arial Black, Gadget, sans-serif" => "Arial Black", "Brush Script MT, sans-serif" => "Brush Script MT", "Comic Sans MS, cursive, sans-serif" => "Comic Sans MS", "Courier New, Courier, monospace" => "Courier New", "Georgia, serif" => "Georgia",
				 "Helvetica, serif" => "Helvetica",
				 "Impact, Charcoal, sans-serif" => "Impact", "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode", "Tahoma, Geneva, sans-serif" => "Tahoma", "Times New Roman, Times, serif" => "Times New Roman", "Trebuchet MS, Helvetica, sans-serif" => "Trebuchet MS", "Verdana, Geneva, sans-serif" => "Verdana", "Arimo:400,700,400italic,700italic" => "Arimo", "Arvo:400,700,400italic,700italic" => "Arvo", "Bitter:400,700,400italic" => "Bitter", "Cabin:400,700,400italic" => "Cabin",
				 "Droid Sans:400,700" => "Droid Sans",
				 "Droid Serif:400,700,400italic,700italic" => "Droid Serif", "Fjalla One:400" => "Fjalla One",
				 "Francois One:400" => "Francois One",
				 "Josefin Sans:400,300,600,700" => "Josefin Sans", "Lato:400,700,400italic,700italic" => "Lato", "Libre Baskerville:400,400italic,700" => "Libre Baskerville", "Lora:400,700,400italic,700italic" => "Lora", "Merriweather:400,300italic,300,400italic,700,700italic" => "Merriweather", "Montserrat:400,700" => "Montserrat",
				 "Open Sans:400italic,700italic,400,700" => "Open Sans", "Open Sans Condensed:700,300italic,300" => "Open Sans Condensed", "Oswald:400,700" => "Oswald",
				 "Oxygen:400,300,700" => "Oxygen",
				 "Playfair Display:400,700,400italic" => "Playfair Display", "PT Sans:400,700,400italic,700italic" => "PT Sans", "PT Sans Narrow:400,700" => "PT Sans Narrow", "PT Serif:400,700" => "PT Serif",
				 "Raleway:400,700" => "Raleway",
				 "Roboto:400,400italic,700,700italic" => "Roboto", "Roboto Condensed:400italic,700italic,400,700" => "Roboto Condensed", "Roboto Slab:400,700" => "Roboto Slab", "Rokkitt:400" => "Rokkitt",
				 "Source Sans Pro:400,700,400italic,700italic" => "Source Sans Pro", "Ubuntu:400,700,400italic,700italic" => "Ubuntu", "Yanone Kaffeesatz:400,700" => "Yanone Kaffeesatz", );
				 if ( array_key_exists( $input, $valid ) ) { return $input;
				 } else {
				 return "";
				 } } 
				 
				 $font_choices = array(
				 "inherit" => "Default",
				 "Arial, Helvetica, sans-serif" => "Arial", "Arial Black, Gadget, sans-serif" => "Arial Black", "Brush Script MT, sans-serif" => "Brush Script MT", "Comic Sans MS, cursive, sans-serif" => "Comic Sans MS", "Courier New, Courier, monospace" => "Courier New", "Georgia, serif" => "Georgia",
				 "Helvetica, serif" => "Helvetica",
				 "Impact, Charcoal, sans-serif" => "Impact", "Lucida Sans Unicode, Lucida Grande, sans-serif" => "Lucida Sans Unicode", "Tahoma, Geneva, sans-serif" => "Tahoma", "Times New Roman, Times, serif" => "Times New Roman", "Trebuchet MS, Helvetica, sans-serif" => "Trebuchet MS", "Verdana, Geneva, sans-serif" => "Verdana", "Arimo:400,700,400italic,700italic" => "Arimo", "Arvo:400,700,400italic,700italic" => "Arvo", "Bitter:400,700,400italic" => "Bitter", "Cabin:400,700,400italic" => "Cabin",
				 "Droid Sans:400,700" => "Droid Sans",
				 "Droid Serif:400,700,400italic,700italic" => "Droid Serif", "Fjalla One:400" => "Fjalla One",
				 "Francois One:400" => "Francois One",
				 "Josefin Sans:400,300,600,700" => "Josefin Sans", "Lato:400,700,400italic,700italic" => "Lato", "Libre Baskerville:400,400italic,700" => "Libre Baskerville", "Lora:400,700,400italic,700italic" => "Lora", "Merriweather:400,300italic,300,400italic,700,700italic" => "Merriweather", "Montserrat:400,700" => "Montserrat",
				 "Open Sans:400italic,700italic,400,700" => "Open Sans", "Open Sans Condensed:700,300italic,300" => "Open Sans Condensed", "Oswald:400,700" => "Oswald",
				 "Oxygen:400,300,700" => "Oxygen",
				 "Playfair Display:400,700,400italic" => "Playfair Display", "PT Sans:400,700,400italic,700italic" => "PT Sans", "PT Sans Narrow:400,700" => "PT Sans Narrow", "PT Serif:400,700" => "PT Serif",
				 "Raleway:400,700" => "Raleway",
				 "Roboto:400,400italic,700,700italic" => "Roboto", "Roboto Condensed:400italic,700italic,400,700" => "Roboto Condensed", "Roboto Slab:400,700" => "Roboto Slab", "Rokkitt:400" => "Rokkitt",
				 "Source Sans Pro:400,700,400italic,700italic" => "Source Sans Pro", "Ubuntu:400,700,400italic,700italic" => "Ubuntu", "Yanone Kaffeesatz:400,700" => "Yanone Kaffeesatz", );
			
			
				$wp_customize->add_setting( "post_title_font_posttitle", array("sanitize_callback" => "tgnav_sanitize_fonts_posttitle","default" => "inherit"));
				$wp_customize->add_control( "post_title_font_posttitle", array("type" => "select","label" => __( "Post title font", "estsbtheme" ),"section" => "tg_layout","choices" => $font_choices,"settings" => "post_title_font_posttitle"));	
		

	

	/*show_posts_sidebar*/
	$wp_customize->add_setting( 'show_posts_sidebar', array(
	'default'        => false,
	'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox2"
	 ) );
	$wp_customize->add_control('show_posts_sidebar',
	array(
		'section'   => 'tg_layout',
		'label'     => 'Sidebar in blog & WooCommerce',
		'type'      => 'checkbox'
		 )
	 );	
	 
	 
	 
	/*show_back_to_top_button*/
	$wp_customize->add_setting( 'show_back_to_top_button', array(
	'default'        => false,
	'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox2"
	 ) );
	$wp_customize->add_control('show_back_to_top_button',
	array(
		'section'   => 'tg_layout',
		'label'     => 'Show back to top button',
		'type'      => 'checkbox'
		 )
	 );


	/*back_to_top_button_arrow_color*/ 
	$wp_customize->add_setting( 'back_to_top_button_arrow_color', array(
		'default' => '',"sanitize_callback" => "esc_attr"
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'back_to_top_button_arrow_color', array(
		'label' => 'Back to top arrow',
		'section' => 'tg_layout',
		'settings' => 'back_to_top_button_arrow_color',
	) ) );

	
	/*back_to_top_button_arrow_background*/ 
	$wp_customize->add_setting( 'back_to_top_button_arrow_background', array(
		'default' => '',"sanitize_callback" => "esc_attr"
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'back_to_top_button_arrow_background', array(
		'label' => 'Back to top background',
		'section' => 'tg_layout',
		'settings' => 'back_to_top_button_arrow_background',
	) ) );


	/*back_to_top_button_arrow_hover*/ 
	$wp_customize->add_setting( 'back_to_top_button_arrow_hover', array(
		'default' => '',"sanitize_callback" => "esc_attr"
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'back_to_top_button_arrow_hover', array(
		'label' => 'Back to top hover',
		'section' => 'tg_layout',
		'settings' => 'back_to_top_button_arrow_hover',
	) ) );	




	/*back_to_top_button_align_left*/
	$wp_customize->add_setting( 'back_to_top_button_align_left', array(
	'default'        => false,
	'capability'     => 'edit_theme_options',"sanitize_callback" => "theme_slug_sanitize_checkbox2"
	 ) );
	$wp_customize->add_control('back_to_top_button_align_left',
	array(
		'section'   => 'tg_layout',
		'label'     => 'Back to top button align left',
		'type'      => 'checkbox'
		 )
	 );
	 
	 
	 
	 
	 
	/*back_to_top_button_opacity*/
	$wp_customize->add_setting(
		'back_to_top_button_opacity',
		array(
			'default' => '1',
			'sanitize_callback' => 'sanitize_float',
		)
	);
	$wp_customize->add_control(
		'back_to_top_button_opacity',
		array(
			'label' => 'Back to top button opacity',
			'section' => 'tg_layout',
			'type' => 'number',
			'input_attrs' => array(
				'min' => '0', 'step' => '0.1', 'max' => '1',
			  ),
		)
	);
	
}
/*Page title font, outside the main customizer function*/
function tgnav_scripts_pagetitle() { $page_title_font_pagetitle = esc_html(get_theme_mod("page_title_font_pagetitle")); if( $page_title_font_pagetitle ) { $not_google_fonts_pagetitle = array("inherit", "Arial", "Brush Script MT", "Comic Sans MS", "Courier New", "Georgia", "Helvetica", "Impact", "Lucida Sans Unicode", "Times New Roman", "Trebuchet MS", "Verdana"); foreach ($not_google_fonts_pagetitle as $url) { if (strpos($page_title_font_pagetitle, $url) !== FALSE) { return true;}}	wp_enqueue_style( "estsbtheme-body-fonts_pagetitle", "//fonts.googleapis.com/css?family=". $page_title_font_pagetitle ); } else { wp_enqueue_style( "estsbtheme-source-body_pagetitle", "//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,700,600");}}add_action( "wp_enqueue_scripts", "tgnav_scripts_pagetitle" );
function tg_sitelayout_latest_posts_2_pagetitle() { $page_title_font_pagetitle = esc_html(get_theme_mod("page_title_font_pagetitle")); if ( $page_title_font_pagetitle ) {	$font_pieces = explode(":", $page_title_font_pagetitle); $custom = "body.page:not(.estsbtheme-front-page) .entry-title { font-family: ".$font_pieces[0]."!important; }"."\n";} if ( $page_title_font_pagetitle ) : ?> <style type="text/css"> <?php echo $custom;?> </style> <?php endif; } add_action( "wp_head", "tg_sitelayout_latest_posts_2_pagetitle" );

/*Post title font, outside the main customizer function*/
function tgnav_scripts_posttitle() { $post_title_font_posttitle = esc_html(get_theme_mod("post_title_font_posttitle")); if( $post_title_font_posttitle ) { $not_google_fonts_posttitle = array("inherit", "Arial", "Brush Script MT", "Comic Sans MS", "Courier New", "Georgia", "Helvetica", "Impact", "Lucida Sans Unicode", "Times New Roman", "Trebuchet MS", "Verdana"); foreach ($not_google_fonts_posttitle as $url) { if (strpos($post_title_font_posttitle, $url) !== FALSE) { return true;}}	wp_enqueue_style( "estsbtheme-body-fonts_posttitle", "//fonts.googleapis.com/css?family=". $post_title_font_posttitle ); } else { wp_enqueue_style( "estsbtheme-source-body_posttitle", "//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,400italic,700,600");}}add_action( "wp_enqueue_scripts", "tgnav_scripts_posttitle" );
function tg_sitelayout_latest_posts_2_posttitle() { $post_title_font_posttitle = esc_html(get_theme_mod("post_title_font_posttitle")); if ( $post_title_font_posttitle ) {	$font_pieces = explode(":", $post_title_font_posttitle); $custom = "body.single:not(.estsbtheme-front-page) .entry-title { font-family: ".$font_pieces[0]."!important; }"."\n";} if ( $post_title_font_posttitle ) : ?> <style type="text/css"> <?php echo $custom;?> </style> <?php endif; } add_action( "wp_head", "tg_sitelayout_latest_posts_2_posttitle" );
	



function tg_sitelayout_head_styles() {
	$content_min_height = get_theme_mod( 'content_min_height' ); 	
	if ( $content_min_height != '588' ) :
	?>
		<style type="text/css">
			body:not(.home) .site-content {
				min-height: <?php echo $content_min_height; ?>px;
			}
		</style>
	<?php
	endif;
	$content_max_width = get_theme_mod( 'content_max_width' ); 	
	if ( $content_max_width != '1400' ) :
	?>
		<style type="text/css">
			body:not(.home) .wrap{
				max-width: <?php echo $content_max_width; ?>px;
				margin: 0 auto;
			}
		</style>
	<?php
	endif;
	$footer_widgets_sect_max_width = get_theme_mod( 'footer_widgets_sect_max_width' ); 	
	if ( $footer_widgets_sect_max_width != '1280' ) :
	?>
		<style type="text/css">
			.home .site-footer .widget-area{
				max-width: <?php echo $footer_widgets_sect_max_width; ?>px!important;
			}
		</style>
	<?php
	endif;
	$footer_widgets_padding_leftright = get_theme_mod( 'footer_widgets_padding_leftright' ); 	
	if ( $footer_widgets_padding_leftright != '30' ) :
	?>
		<style type="text/css">
			.site-footer .widget-column{
				padding-left: <?php echo $footer_widgets_padding_leftright; ?>px!important;
				padding-right: <?php echo $footer_widgets_padding_leftright; ?>px!important;
			}
		</style>
	<?php
	endif;
	$footer_widgets_padding_topbottom = get_theme_mod( 'footer_widgets_padding_topbottom' ); 	
	if ( $footer_widgets_padding_topbottom != '35' ) :
	?>
		<style type="text/css">
			.site-footer .widget-column{
				padding-top: <?php echo $footer_widgets_padding_topbottom; ?>px!important;
				padding-bottom: <?php echo $footer_widgets_padding_topbottom; ?>px!important;
			}
		</style>
	<?php
	endif;
	
	

	$post_excerpt_length = get_theme_mod( 'post_excerpt_length' ); 	
	if ( $post_excerpt_length != '55' ) :
		function wpdocs_custom_excerpt_length( $length ) {
			$post_excerpt_length = get_theme_mod( 'post_excerpt_length' ); 
			if (empty($post_excerpt_length)) $post_excerpt_length='55';
			return $post_excerpt_length;
		}
		add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );	
	endif;




	
	





	$back_to_top_button_opacity = get_theme_mod( 'back_to_top_button_opacity' ); 	
	if ( $back_to_top_button_opacity != '1' ) :
	?>
		<style type="text/css">
			#backtotopbutton.show {
				opacity: <?php echo $back_to_top_button_opacity; ?>!important;
			}
		</style>
	<?php
	endif;	
	
		

	
	
	

	
	$show_full_width_footer_widgets = get_theme_mod( 'show_full_width_footer_widgets', 'true' );
	if ( $show_full_width_footer_widgets === true ) :
	?>
		<style type="text/css">
			.site-footer .widget-column{
				width: 100%!important;
			}
		</style>
	<?php
	endif;
	if ( $show_full_width_footer_widgets === false ) :
	?>
		<style type="text/css">
			.site-footer .widget-column{
				width: 36%;
			}
		</style>
	<?php
	endif;
	
	
	
	
	
	
	

	
	
	
	
	
	$show_back_to_top_button = get_theme_mod( 'show_back_to_top_button', 'true' );
	if ( $show_back_to_top_button === true ) :
	?>
		<style type="text/css">
		#backtotopbutton.show {
				  opacity: 1;
				  visibility: visible;
				}
		</style>
	<?php
	endif;
	if ( $show_back_to_top_button === false ) :
	?>
		<style type="text/css">
			#backtotopbutton.show {
			  opacity: 0;
			  visibility: hidden;
			}
		</style>
	<?php
	endif;	
	



	
	
	$back_to_top_button_align_left = get_theme_mod( 'back_to_top_button_align_left', 'true' );
	if ( $back_to_top_button_align_left === true ) :
	?>
		<style type="text/css">
			#backtotopbutton {
			  left: 30px;
			  right: auto;
			}
		</style>
	<?php
	endif;
	if ( $back_to_top_button_align_left === false ) :
	?>
		<style type="text/css">
			#backtotopbutton {
			  right: 30px;
			}
		</style>
	<?php
	endif;	





	
	
/*Begin page & post title*/		
	$page_title_color = get_theme_mod( 'page_title_color' ); 	
	if (( $page_title_color != 'inherit' )&&( $page_title_color != '' )) :
	?>
		<style type="text/css">
			body.page:not(.estsbtheme-front-page) .entry-title{
				color: <?php echo $page_title_color; ?>!important;
			}
		</style>
	<?php
	endif;	
	$page_title_size = get_theme_mod( 'page_title_size' ); 	
	if ( $page_title_size != '26.5' ) :
	?>
		<style type="text/css">
			body.page:not(.estsbtheme-front-page) .entry-title{
				font-size: <?php echo $page_title_size; ?>px!important;
			}
		</style>
	<?php
	endif;
	
	
	
	
	$page_title_fontweight = esc_html(get_theme_mod('fontweight_pagetitle'));
	if ( $page_title_fontweight ) {
			?>
				<style type="text/css">					
					body.page:not(.estsbtheme-front-page) .entry-title { font-weight: <?php echo $page_title_fontweight;?>!important; }
				</style>
			<?php
	}
		
	$post_title_fontweight = esc_html(get_theme_mod('fontweight_posttitle'));
	if ( $post_title_fontweight ) {
			?>
				<style type="text/css">					
					body.single:not(.estsbtheme-front-page) .entry-title { font-weight: <?php echo $post_title_fontweight;?>!important; }
				</style>
			<?php
	}	




	
		
		
	$post_title_color = get_theme_mod( 'post_title_color' ); 	
	if (( $post_title_color != 'inherit' )&&( $post_title_color != '' )) :
	?>
		<style type="text/css">
			body.single:not(.estsbtheme-front-page) .entry-title{
				color: <?php echo $post_title_color; ?>!important;
			}
		</style>
	<?php
	endif;	
	$post_title_size = get_theme_mod( 'post_title_size' ); 	
	if ( $post_title_size != '26.5' ) :
	?>
		<style type="text/css">
			body.single:not(.estsbtheme-front-page) .entry-title{
				font-size: <?php echo $post_title_size; ?>px!important;
			}
		</style>
	<?php
	endif;	
/*End page & post title*/		


	
	
	
	
	
	
	$back_to_top_button_arrow_color = get_theme_mod( 'back_to_top_button_arrow_color' ); 	
	if (( $back_to_top_button_arrow_color != 'inherit' )&&( $back_to_top_button_arrow_color != '' )) :
	?>
		<style type="text/css">
			#backtotopbutton::after {
				color: <?php echo $back_to_top_button_arrow_color; ?>!important;
			}
		</style>
	<?php
	endif;
	
	
	$back_to_top_button_arrow_background = get_theme_mod( 'back_to_top_button_arrow_background' ); 	
	if (( $back_to_top_button_arrow_background != 'inherit' )&&( $back_to_top_button_arrow_background != '' )) :
	?>
		<style type="text/css">
			#backtotopbutton {
				background-color: <?php echo $back_to_top_button_arrow_background; ?>;
			}
		</style>
	<?php
	endif;	
	
	$back_to_top_button_arrow_hover = get_theme_mod( 'back_to_top_button_arrow_hover' ); 	
	if (( $back_to_top_button_arrow_hover != 'inherit' )&&( $back_to_top_button_arrow_hover != '' )) :
	?>
		<style type="text/css">
			#backtotopbutton:hover {
				background-color: <?php echo $back_to_top_button_arrow_hover; ?>;
			}
		</style>
	<?php
	endif;		
	
	
	
	
	
	$footer_widgets_background = get_theme_mod( 'footer_widgets_background' ); 	
	if ( $footer_widgets_background != 'rgba(238,238,238,1)' ) :
	?>
		<style type="text/css">
			.site-footer {
				background-color: <?php echo $footer_widgets_background; ?>!important;
			}
		</style>
	<?php
	endif;



	
	$show_posts_sidebar = get_theme_mod( 'show_posts_sidebar', 'true' ); 
	/*Sidebar function*/ function init_add_sidebar_classes_to_body2($classes = ""){		$classes[] = "has-sidebar";    return $classes;}	
	if ( $show_posts_sidebar === true ) {
		add_filter("body_class", "init_add_sidebar_classes_to_body2");		
	}
	if ( $show_posts_sidebar === false ) {
		remove_filter("body_class", "init_add_sidebar_classes_to_body2");
		remove_filter("body_class", "init_add_sidebar_classes_to_body");
	}

	
}	
add_action( 'wp_head', 'tg_sitelayout_head_styles' );

function shop_cat_sidebar() {
	get_sidebar();
}
add_action( 'woocommerce_after_shop_loop', 'shop_cat_sidebar', 2);




/*******************************/
/*Translate customizer strings*/
/*****************************/
function youruniqueprefix_filter_gettext( $translated, $original, $domain ) {
 
    // This is an array of original strings
    // and what they should be replaced with
    $strings = array(
        'Your latest posts' => 'Themes Generator',
        'Howdy, %1$s' => 'Greetings, %1$s!',
        // Add some more strings here
    );
 
    // See if the current string is in the $strings array
    // If so, replace it's translation
    if ( isset( $strings[$original] ) ) {
        // This accomplishes the same thing as __()
        // but without running it through the filter again
        $translations = get_translations_for_domain( $domain );
        $translated = $translations->translate( $strings[$original] );
    }
 
    return $translated;
}
 
add_filter( 'gettext', 'youruniqueprefix_filter_gettext', 10, 3 );






// Wrap all categories in a function
function wcat2() {
    $out = array();
    $categories = get_categories();
	$out['showallcategories'] = 'all';
    foreach( $categories as $category ) {
		/*
        $out[$category->term_id] = array(
            'label' => $category->slug,
            'value' => $category->term_id
        );
		*/
		
		 $out[$category->slug] = $category->slug;
    }
    //return array('options'=>$out);
    return $out;
}


function wpse55748_filter_post_thumbnail_html( $html ) {
    // If there is no post thumbnail,
    // Return a default image
    if ( '' == $html ) {
        /*return '<img src="' . get_template_directory_uri() . '/images/no-photo-available.svg" class="image-size-name" />';*/
		return '<img src="https://gist.githubusercontent.com/xamdam777/451b47c2f450ff13a21e9930f7ba65ff/raw/cd28ec1bd6647f4fca3177fb35c076f40f151440/no-image.svg?sanitize=true" class="image-size-name" />';
		
    }
    // Else, return the post thumbnail
    return $html;
}
add_filter( 'post_thumbnail_html', 'wpse55748_filter_post_thumbnail_html' );


/*Custom js (tracking code)*/
add_action( 'customize_register', 'tg_tracking_code' );
function tg_tracking_code( $wp_customize ) {	 
		$wp_customize->add_section( 'custom_js', array(
			'title'    => __( 'Additional Code', 'textdomain' ),
			'priority' => 190,
		) );
	 
		$wp_customize->add_setting( 'custom_js', array(
			'type' => 'option',
		) );	 
		$wp_customize->add_control( new WP_Customize_Code_Editor_Control( $wp_customize, 'custom_html', array(
			'label'     => 'Tracking Code',
			'code_type' => 'javascript',
			'settings'  => 'custom_js',
			'section'   => 'custom_js',
		) ) );	 
	}	 
add_action( 'wp_footer', 'prefix_customize_output' );
function prefix_customize_output() {	 
		$js = get_option( 'custom_js', '' );	 
		if ( '' === $js ) {	 
			return;	 
		} 
		echo $js . "\n";
	}
	
/*Activate TG front page after install*/	
function themename_after_setup_theme() {
 $site_type = get_option('show_on_front');
 if($site_type == 'page') {
  update_option( 'show_on_front', 'posts' );
 }
}
add_action( 'after_switch_theme', 'themename_after_setup_theme' );	























/* Page & post settings (title, todo...) */
function estsbtheme_metabox_get_meta( $value ) {
	global $post;
	$field = get_post_meta( $post->ID, $value, true );
	if ( ! empty( $field ) ) {
		return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
	} else {
		return false;
	}
}

function estsbtheme_metabox_add_meta_box() {
	add_meta_box(
		'estsbtheme_metabox-custom-metabox',
		__( 'Page extra options', 'estsbtheme' ),
		'estsbtheme_metabox_html',
		'page',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'estsbtheme_metabox_add_meta_box' );
function estsbtheme_metabox_html( $post) {
	wp_nonce_field( '_estsbtheme_metabox_nonce', 'estsbtheme_metabox_nonce' ); ?>
	<p> <label style="display: block;" for="custom_metabox_show_title"><?php _e( 'Show the page title in the frontend', 'estsbtheme' ); ?></label><br>
		<select name="custom_metabox_show_title" id="custom_metabox_show_title">
			<option value="block" <?php echo (estsbtheme_metabox_get_meta( 'custom_metabox_show_title' ) === 'block' ) ? 'selected' : '' ?>>Yes</option>
			<option value="none" <?php echo (estsbtheme_metabox_get_meta( 'custom_metabox_show_title' ) === 'none' ) ? 'selected' : '' ?>>No</option>
		</select>
	</p>	
<?php
}
function estsbtheme_metabox_showpostmeta_html() {
	add_meta_box(
		'estsbtheme_metabox-custom-metabox-postmeta',
		__( 'Post extra options', 'estsbtheme' ),
		'estsbtheme_postmetabox_html',
		'post',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes', 'estsbtheme_metabox_showpostmeta_html' );
function estsbtheme_postmetabox_html($post) {
	wp_nonce_field( '_estsbtheme_metabox_noncepost', 'estsbtheme_metabox_noncepost' ); ?>
	<p> 
	<label style="display: block;" for="custom_metabox_show_titlepost"><?php _e( 'Show the post title in the frontend', 'estsbtheme' ); ?></label><br>
		<select name="custom_metabox_show_titlepost" id="custom_metabox_show_titlepost">
			<option value="block" <?php echo (estsbtheme_metabox_get_meta( 'custom_metabox_show_titlepost' ) === 'block' ) ? 'selected' : '' ?>>Yes</option>
			<option value="none" <?php echo (estsbtheme_metabox_get_meta( 'custom_metabox_show_titlepost' ) === 'none' ) ? 'selected' : '' ?>>No</option>
		</select>
	</p>
	<p> <label style="display: block;" for="custom_metabox_show_metapost"><?php _e( 'Show the post meta data (date & author) in the frontend', 'estsbtheme' ); ?></label><br>
		<select name="custom_metabox_show_metapost" id="custom_metabox_show_metapost">
			<option value="block" <?php echo (estsbtheme_metabox_get_meta( 'custom_metabox_show_metapost' ) === 'block' ) ? 'selected' : '' ?>>Yes</option>
			<option value="none" <?php echo (estsbtheme_metabox_get_meta( 'custom_metabox_show_metapost' ) === 'none' ) ? 'selected' : '' ?>>No</option>
		</select>
	</p>	
<?php
}
function estsbtheme_metabox_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;		
	if (( ! isset( $_POST['estsbtheme_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['estsbtheme_metabox_nonce'], '_estsbtheme_metabox_nonce' ) )&&( ! isset( $_POST['estsbtheme_metabox_noncepost'] ) || ! wp_verify_nonce( $_POST['estsbtheme_metabox_noncepost'], '_estsbtheme_metabox_noncepost' ) )) return;		
	if ( ! current_user_can( 'edit_post', $post_id ) ) return;	
	if ( isset( $_POST['custom_metabox_show_title'] ) )	update_post_meta( $post_id, 'custom_metabox_show_title', esc_attr( $_POST['custom_metabox_show_title'] ) );
	if ( isset( $_POST['custom_metabox_show_titlepost'] ) )	update_post_meta( $post_id, 'custom_metabox_show_titlepost', esc_attr( $_POST['custom_metabox_show_titlepost'] ) );	
	if ( isset( $_POST['custom_metabox_show_metapost'] ) )	update_post_meta( $post_id, 'custom_metabox_show_metapost', esc_attr( $_POST['custom_metabox_show_metapost'] ) );
}
add_action( 'save_post', 'estsbtheme_metabox_save' );






/**
 * Include the TGM_Plugin_Activation class for Easy Theme and Plugin Upgrades
 */
require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';
add_action( 'tgmpa_register', 'my_theme_register_required_pluginsEasyUpgrades' );
function my_theme_register_required_pluginsEasyUpgrades() {
	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		/** This is an example of how to include a plugin pre-packaged with a theme */
		/*
		array(
			'name'     => 'TGM Example Plugin', // The plugin name
			'slug'     => 'tgm-example-plugin', // The plugin slug (typically the folder name)
			'source'   => get_stylesheet_directory() . '/lib/plugins/tgm-example-plugin.zip', // The plugin source
			'required' => false,
		),
		*/
		/** This is an example of how to include a plugin from the WordPress Plugin Repository */
		array(
			'name' => 'Easy Theme and Plugin Upgrades',
			'slug' => 'easy-theme-and-plugin-upgrades',
		)
	);
	/** Change this to your theme text domain, used for internationalising strings */
	$theme_text_domain = 'estsbtheme';
	/**
	 * Array of configuration settings. Uncomment and amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * uncomment the strings and domain.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		/*'domain'       => $theme_text_domain,         // Text domain - likely want to be the same as your theme. */
		/*'default_path' => '',                         // Default absolute path to pre-packaged plugins */
		/*'menu'         => 'install-my-theme-plugins', // Menu slug */
		'strings'      	 => array(
			/*'page_title'             => __( 'Install Required Plugins', $theme_text_domain ), // */
			/*'menu_title'             => __( 'Install Plugins', $theme_text_domain ), // */
			/*'instructions_install'   => __( 'The %1$s plugin is required for this theme. Click on the big blue button below to install and activate %1$s.', $theme_text_domain ), // %1$s = plugin name */
			/*'instructions_activate'  => __( 'The %1$s is installed but currently inactive. Please go to the <a href="%2$s">plugin administration page</a> page to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL */
			/*'button'                 => __( 'Install %s Now', $theme_text_domain ), // %1$s = plugin name */
			/*'installing'             => __( 'Installing Plugin: %s', $theme_text_domain ), // %1$s = plugin name */
			/*'oops'                   => __( 'Something went wrong with the plugin API.', $theme_text_domain ), // */
			/*'notice_can_install'     => __( 'This theme requires the %1$s plugin. <a href="%2$s"><strong>Click here to begin the installation process</strong></a>. You may be asked for FTP credentials based on your server setup.', $theme_text_domain ), // %1$s = plugin name, %2$s = TGMPA page URL */
			/*'notice_cannot_install'  => __( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', $theme_text_domain ), // %1$s = plugin name */
			/*'notice_can_activate'    => __( 'This theme requires the %1$s plugin. That plugin is currently inactive, so please go to the <a href="%2$s">plugin administration page</a> to activate it.', $theme_text_domain ), // %1$s = plugin name, %2$s = plugins page URL */
			/*'notice_cannot_activate' => __( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', $theme_text_domain ), // %1$s = plugin name */
			/*'return'                 => __( 'Return to Required Plugins Installer', $theme_text_domain ), // */
		),
	);
	tgmpa( $plugins, $config );
}
add_action( "customize_register", "themesgenchild_register_theme_customizer"); function themesgenchild_register_theme_customizer( $wp_customize ) {	$wp_customize->add_panel( "text_blocks", array(	"priority" => 69, "theme_supports" => "", "title" => __( "Text Blocks", "estsbtheme" ), "description" => __( "Set editable text for certain content.", "estsbtheme" ),)); function sanitize_text( $text ) { $allowed_html = array("a" => array( "href" => array(), "title" => array(), "target" => array(),"class" => array(), "id" => array() ), "span" => array( "class" => array(), "id" => array() ), "br" => array(), "em" => array(), "strong" => array(),); return wp_kses( $text, $allowed_html ); } 
$wp_customize->add_section( "customtgtext-1" , array("title" => __("Change Text 1","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-1", array( "default" => __( "EST SIDI BENNOUR
        ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-1", array( "label"    => __( "Text 1", "estsbtheme" ), "section"  => "customtgtext-1", "settings" => "tgtext-1", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-1", array("selector" => "#tgtext-1",));

$wp_customize->add_section( "customtgtext-2" , array("title" => __("Change Text 2","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-2", array( "default" => __( "GI-TM-GA
      ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-2", array( "label"    => __( "Text 2", "estsbtheme" ), "section"  => "customtgtext-2", "settings" => "tgtext-2", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-2", array("selector" => "#tgtext-2",));

$wp_customize->add_section( "customtgtext-3" , array("title" => __("Change Text 3","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-3", array( "default" => __( "À PROPOS DE NOUS ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-3", array( "label"    => __( "Text 3", "estsbtheme" ), "section"  => "customtgtext-3", "settings" => "tgtext-3", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-3", array("selector" => "#tgtext-3",));

$wp_customize->add_section( "customtgtext-4" , array("title" => __("Change Text 4","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-4", array( "default" => __( "Ecole Supérieure de Technologie Sidi Bennour  est un établissement public d’enseignement supérieur à finalité de formation des Techniciens Supérieurs. Elle a été créée en Août 2016 par le Ministère de l’Enseignement Supérieur, de la Formation des Cadres et de la Recherche Scientifique du Royaume du Maroc.", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-4", array( "label"    => __( "Text 4", "estsbtheme" ), "section"  => "customtgtext-4", "settings" => "tgtext-4", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-4", array("selector" => "#tgtext-4",));

$wp_customize->add_section( "customtgtext-5" , array("title" => __("Change Text 5","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-5", array( "default" => __( "L’Ecole Supérieure de Technologie Sidi Bennour est une composante de l’Université Chouaib Doukkali d’El Jadida. Sa vocation est de former des Techniciens Supérieurs polyvalents, hautement qualifiés et immédiatement opérationnels après leur sortie de l’Ecole en tant que collaborateurs d’ingénieurs et de managers. Sont admis à l’ESTSB.", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-5", array( "label"    => __( "Text 5", "estsbtheme" ), "section"  => "customtgtext-5", "settings" => "tgtext-5", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-5", array("selector" => "#tgtext-5",));

$wp_customize->add_section( "customtgtext-6" , array("title" => __("Change Text 6","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-6", array( "default" => __( "les bacheliers de l’enseignement secondaire technique, scientifique et tertiaire. L’admission à l’Ecole (au de Diplôme Universitaire de Technologie « DUT ») se fait par voie de sélection par ordre de mérite après une présélection sur la base des notes obtenues au baccalauréat. Les candidats doivent être âgés de 22 ans au plus au 31 Décembre de l’année du concours et doivent déposer leurs dossiers de pré-inscription avant le 30 Juin de chaque année universitaire", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-6", array( "label"    => __( "Text 6", "estsbtheme" ), "section"  => "customtgtext-6", "settings" => "tgtext-6", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-6", array("selector" => "#tgtext-6",));

$wp_customize->add_section( "customtgtext-7" , array("title" => __("Change Text 7","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-7", array( "default" => __( "Génie agroenvironment", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-7", array( "label"    => __( "Text 7", "estsbtheme" ), "section"  => "customtgtext-7", "settings" => "tgtext-7", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-7", array("selector" => "#tgtext-7",));

$wp_customize->add_section( "customtgtext-8" , array("title" => __("Change Text 8","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-8", array( "default" => __( "GA", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-8", array( "label"    => __( "Text 8", "estsbtheme" ), "section"  => "customtgtext-8", "settings" => "tgtext-8", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-8", array("selector" => "#tgtext-8",));

$wp_customize->add_section( "customtgtext-9" , array("title" => __("Change Text 9","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-9", array( "default" => __( "La formation génie agroenvironment. permet  d'appréhender et gérer la complexité du vivant : végétaux, animaux, en intervenant sur leur production, leur transformation.", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-9", array( "label"    => __( "Text 9", "estsbtheme" ), "section"  => "customtgtext-9", "settings" => "tgtext-9", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-9", array("selector" => "#tgtext-9",));

$wp_customize->add_section( "customtgtext-10" , array("title" => __("Change Text 10","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-10", array( "default" => __( "Les filières", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-10", array( "label"    => __( "Text 10", "estsbtheme" ), "section"  => "customtgtext-10", "settings" => "tgtext-10", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-10", array("selector" => "#tgtext-10",));

$wp_customize->add_section( "customtgtext-11" , array("title" => __("Change Text 11","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-11", array( "default" => __( "Génie Informatique", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-11", array( "label"    => __( "Text 11", "estsbtheme" ), "section"  => "customtgtext-11", "settings" => "tgtext-11", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-11", array("selector" => "#tgtext-11",));

$wp_customize->add_section( "customtgtext-12" , array("title" => __("Change Text 12","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-12", array( "default" => __( "GI", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-12", array( "label"    => __( "Text 12", "estsbtheme" ), "section"  => "customtgtext-12", "settings" => "tgtext-12", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-12", array("selector" => "#tgtext-12",));

$wp_customize->add_section( "customtgtext-13" , array("title" => __("Change Text 13","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-13", array( "default" => __( "La filières Génie Infomatique forme les professionels qui participent à la conception, la réalisation et la mise en oeuvre de solutions informatiques. ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-13", array( "label"    => __( "Text 13", "estsbtheme" ), "section"  => "customtgtext-13", "settings" => "tgtext-13", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-13", array("selector" => "#tgtext-13",));

$wp_customize->add_section( "customtgtext-14" , array("title" => __("Change Text 14","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-14", array( "default" => __( "Technique de Management", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-14", array( "label"    => __( "Text 14", "estsbtheme" ), "section"  => "customtgtext-14", "settings" => "tgtext-14", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-14", array("selector" => "#tgtext-14",));

$wp_customize->add_section( "customtgtext-15" , array("title" => __("Change Text 15","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-15", array( "default" => __( "TM", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-15", array( "label"    => __( "Text 15", "estsbtheme" ), "section"  => "customtgtext-15", "settings" => "tgtext-15", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-15", array("selector" => "#tgtext-15",));

$wp_customize->add_section( "customtgtext-16" , array("title" => __("Change Text 16","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-16", array( "default" => __( "La formation a pour projet de former des techniciens supérieurs en Techniques de management capables d’aider le responsable d’entreprise dans la gestion quotidienne de ses affaires", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-16", array( "label"    => __( "Text 16", "estsbtheme" ), "section"  => "customtgtext-16", "settings" => "tgtext-16", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-16", array("selector" => "#tgtext-16",));

$wp_customize->add_section( "customtgtext-17" , array("title" => __("Change Text 17","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-17", array( "default" => __( ".
              
              
              ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-17", array( "label"    => __( "Text 17", "estsbtheme" ), "section"  => "customtgtext-17", "settings" => "tgtext-17", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-17", array("selector" => "#tgtext-17",));

$wp_customize->add_section( "customtgtext-18" , array("title" => __("Change Text 18","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-18", array( "default" => __( "Baddi youssef", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-18", array( "label"    => __( "Text 18", "estsbtheme" ), "section"  => "customtgtext-18", "settings" => "tgtext-18", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-18", array("selector" => "#tgtext-18",));

$wp_customize->add_section( "customtgtext-19" , array("title" => __("Change Text 19","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-19", array( "default" => __( "Enseignant chercheur", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-19", array( "label"    => __( "Text 19", "estsbtheme" ), "section"  => "customtgtext-19", "settings" => "tgtext-19", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-19", array("selector" => "#tgtext-19",));

$wp_customize->add_section( "customtgtext-20" , array("title" => __("Change Text 20","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-20", array( "default" => __( "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-20", array( "label"    => __( "Text 20", "estsbtheme" ), "section"  => "customtgtext-20", "settings" => "tgtext-20", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-20", array("selector" => "#tgtext-20",));

$wp_customize->add_section( "customtgtext-21" , array("title" => __("Change Text 21","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-21", array( "default" => __( "ln", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-21", array( "label"    => __( "Text 21", "estsbtheme" ), "section"  => "customtgtext-21", "settings" => "tgtext-21", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-21", array("selector" => "#tgtext-21",));

$wp_customize->add_section( "customtgtext-22" , array("title" => __("Change Text 22","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-22", array( "default" => __( "Najib Saber", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-22", array( "label"    => __( "Text 22", "estsbtheme" ), "section"  => "customtgtext-22", "settings" => "tgtext-22", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-22", array("selector" => "#tgtext-22",));

$wp_customize->add_section( "customtgtext-23" , array("title" => __("Change Text 23","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-23", array( "default" => __( "Directeur", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-23", array( "label"    => __( "Text 23", "estsbtheme" ), "section"  => "customtgtext-23", "settings" => "tgtext-23", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-23", array("selector" => "#tgtext-23",));

$wp_customize->add_section( "customtgtext-24" , array("title" => __("Change Text 24","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-24", array( "default" => __( "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-24", array( "label"    => __( "Text 24", "estsbtheme" ), "section"  => "customtgtext-24", "settings" => "tgtext-24", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-24", array("selector" => "#tgtext-24",));

$wp_customize->add_section( "customtgtext-25" , array("title" => __("Change Text 25","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-25", array( "default" => __( "ln", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-25", array( "label"    => __( "Text 25", "estsbtheme" ), "section"  => "customtgtext-25", "settings" => "tgtext-25", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-25", array("selector" => "#tgtext-25",));

$wp_customize->add_section( "customtgtext-26" , array("title" => __("Change Text 26","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-26", array( "default" => __( "Saidi abdelali ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-26", array( "label"    => __( "Text 26", "estsbtheme" ), "section"  => "customtgtext-26", "settings" => "tgtext-26", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-26", array("selector" => "#tgtext-26",));

$wp_customize->add_section( "customtgtext-27" , array("title" => __("Change Text 27","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-27", array( "default" => __( "Enseignant chercheur", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-27", array( "label"    => __( "Text 27", "estsbtheme" ), "section"  => "customtgtext-27", "settings" => "tgtext-27", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-27", array("selector" => "#tgtext-27",));

$wp_customize->add_section( "customtgtext-28" , array("title" => __("Change Text 28","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-28", array( "default" => __( "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-28", array( "label"    => __( "Text 28", "estsbtheme" ), "section"  => "customtgtext-28", "settings" => "tgtext-28", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-28", array("selector" => "#tgtext-28",));

$wp_customize->add_section( "customtgtext-29" , array("title" => __("Change Text 29","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-29", array( "default" => __( "ln", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-29", array( "label"    => __( "Text 29", "estsbtheme" ), "section"  => "customtgtext-29", "settings" => "tgtext-29", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-29", array("selector" => "#tgtext-29",));

$wp_customize->add_section( "customtgtext-30" , array("title" => __("Change Text 30","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-30", array( "default" => __( "Toumi Hicham", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-30", array( "label"    => __( "Text 30", "estsbtheme" ), "section"  => "customtgtext-30", "settings" => "tgtext-30", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-30", array("selector" => "#tgtext-30",));

$wp_customize->add_section( "customtgtext-31" , array("title" => __("Change Text 31","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-31", array( "default" => __( "Enseignant chercheur", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-31", array( "label"    => __( "Text 31", "estsbtheme" ), "section"  => "customtgtext-31", "settings" => "tgtext-31", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-31", array("selector" => "#tgtext-31",));

$wp_customize->add_section( "customtgtext-32" , array("title" => __("Change Text 32","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-32", array( "default" => __( "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-32", array( "label"    => __( "Text 32", "estsbtheme" ), "section"  => "customtgtext-32", "settings" => "tgtext-32", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-32", array("selector" => "#tgtext-32",));

$wp_customize->add_section( "customtgtext-33" , array("title" => __("Change Text 33","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-33", array( "default" => __( "ln", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-33", array( "label"    => __( "Text 33", "estsbtheme" ), "section"  => "customtgtext-33", "settings" => "tgtext-33", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-33", array("selector" => "#tgtext-33",));

$wp_customize->add_section( "customtgtext-34" , array("title" => __("Change Text 34","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-34", array( "default" => __( "Mabrouk abdelfettah ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-34", array( "label"    => __( "Text 34", "estsbtheme" ), "section"  => "customtgtext-34", "settings" => "tgtext-34", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-34", array("selector" => "#tgtext-34",));

$wp_customize->add_section( "customtgtext-35" , array("title" => __("Change Text 35","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-35", array( "default" => __( "Enseignant chercheur", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-35", array( "label"    => __( "Text 35", "estsbtheme" ), "section"  => "customtgtext-35", "settings" => "tgtext-35", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-35", array("selector" => "#tgtext-35",));

$wp_customize->add_section( "customtgtext-36" , array("title" => __("Change Text 36","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-36", array( "default" => __( "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-36", array( "label"    => __( "Text 36", "estsbtheme" ), "section"  => "customtgtext-36", "settings" => "tgtext-36", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-36", array("selector" => "#tgtext-36",));

$wp_customize->add_section( "customtgtext-37" , array("title" => __("Change Text 37","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-37", array( "default" => __( "ln", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-37", array( "label"    => __( "Text 37", "estsbtheme" ), "section"  => "customtgtext-37", "settings" => "tgtext-37", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-37", array("selector" => "#tgtext-37",));

$wp_customize->add_section( "customtgtext-38" , array("title" => __("Change Text 38","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-38", array( "default" => __( "LOCATION", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-38", array( "label"    => __( "Text 38", "estsbtheme" ), "section"  => "customtgtext-38", "settings" => "tgtext-38", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-38", array("selector" => "#tgtext-38",));

$wp_customize->add_section( "customtgtext-39" , array("title" => __("Change Text 39","estsbtheme"),	"panel"    => "text_blocks","priority" => 19) );
$wp_customize->add_setting( "tgtext-39", array( "default" => __( "Copyright © 2020  Ecole Supérieure de Technologie Sidi Bennour ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtext-39", array( "label"    => __( "Text 39", "estsbtheme" ), "section"  => "customtgtext-39", "settings" => "tgtext-39", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tgtext-39", array("selector" => "#tgtext-39",));

$wp_customize->add_section( "customtgtext-9999" , array("title" => __("See all","estsbtheme"),	"panel"    => "text_blocks","priority" => 1) );
$wp_customize->add_setting( "tgtext-1", array( "default" => __( "EST SIDI BENNOUR
        ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-2", array( "default" => __( "GI-TM-GA
      ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-3", array( "default" => __( "À PROPOS DE NOUS ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-4", array( "default" => __( "Ecole Supérieure de Technologie Sidi Bennour  est un établissement public d’enseignement supérieur à finalité de formation des Techniciens Supérieurs. Elle a été créée en Août 2016 par le Ministère de l’Enseignement Supérieur, de la Formation des Cadres et de la Recherche Scientifique du Royaume du Maroc.", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-5", array( "default" => __( "L’Ecole Supérieure de Technologie Sidi Bennour est une composante de l’Université Chouaib Doukkali d’El Jadida. Sa vocation est de former des Techniciens Supérieurs polyvalents, hautement qualifiés et immédiatement opérationnels après leur sortie de l’Ecole en tant que collaborateurs d’ingénieurs et de managers. Sont admis à l’ESTSB.", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-6", array( "default" => __( "les bacheliers de l’enseignement secondaire technique, scientifique et tertiaire. L’admission à l’Ecole (au de Diplôme Universitaire de Technologie « DUT ») se fait par voie de sélection par ordre de mérite après une présélection sur la base des notes obtenues au baccalauréat. Les candidats doivent être âgés de 22 ans au plus au 31 Décembre de l’année du concours et doivent déposer leurs dossiers de pré-inscription avant le 30 Juin de chaque année universitaire", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-7", array( "default" => __( "Génie agroenvironment", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-8", array( "default" => __( "GA", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-9", array( "default" => __( "La formation génie agroenvironment. permet  d'appréhender et gérer la complexité du vivant : végétaux, animaux, en intervenant sur leur production, leur transformation.", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-10", array( "default" => __( "Les filières", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-11", array( "default" => __( "Génie Informatique", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-12", array( "default" => __( "GI", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-13", array( "default" => __( "La filières Génie Infomatique forme les professionels qui participent à la conception, la réalisation et la mise en oeuvre de solutions informatiques. ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-14", array( "default" => __( "Technique de Management", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-15", array( "default" => __( "TM", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-16", array( "default" => __( "La formation a pour projet de former des techniciens supérieurs en Techniques de management capables d’aider le responsable d’entreprise dans la gestion quotidienne de ses affaires", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-17", array( "default" => __( ".
              
              
              ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-18", array( "default" => __( "Baddi youssef", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-19", array( "default" => __( "Enseignant chercheur", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-20", array( "default" => __( "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-21", array( "default" => __( "ln", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-22", array( "default" => __( "Najib Saber", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-23", array( "default" => __( "Directeur", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-24", array( "default" => __( "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-25", array( "default" => __( "ln", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-26", array( "default" => __( "Saidi abdelali ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-27", array( "default" => __( "Enseignant chercheur", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-28", array( "default" => __( "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-29", array( "default" => __( "ln", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-30", array( "default" => __( "Toumi Hicham", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-31", array( "default" => __( "Enseignant chercheur", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-32", array( "default" => __( "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-33", array( "default" => __( "ln", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-34", array( "default" => __( "Mabrouk abdelfettah ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-35", array( "default" => __( "Enseignant chercheur", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-36", array( "default" => __( "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-37", array( "default" => __( "ln", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-38", array( "default" => __( "LOCATION", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );$wp_customize->add_setting( "tgtext-39", array( "default" => __( "Copyright © 2020  Ecole Supérieure de Technologie Sidi Bennour ", "estsbtheme" ), "sanitize_callback" => "sanitize_text"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-1", array( "label"    => __( "Text 1", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-1", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-2", array( "label"    => __( "Text 2", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-2", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-3", array( "label"    => __( "Text 3", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-3", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-4", array( "label"    => __( "Text 4", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-4", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-5", array( "label"    => __( "Text 5", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-5", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-6", array( "label"    => __( "Text 6", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-6", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-7", array( "label"    => __( "Text 7", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-7", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-8", array( "label"    => __( "Text 8", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-8", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-9", array( "label"    => __( "Text 9", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-9", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-10", array( "label"    => __( "Text 10", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-10", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-11", array( "label"    => __( "Text 11", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-11", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-12", array( "label"    => __( "Text 12", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-12", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-13", array( "label"    => __( "Text 13", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-13", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-14", array( "label"    => __( "Text 14", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-14", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-15", array( "label"    => __( "Text 15", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-15", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-16", array( "label"    => __( "Text 16", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-16", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-17", array( "label"    => __( "Text 17", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-17", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-18", array( "label"    => __( "Text 18", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-18", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-19", array( "label"    => __( "Text 19", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-19", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-20", array( "label"    => __( "Text 20", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-20", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-21", array( "label"    => __( "Text 21", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-21", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-22", array( "label"    => __( "Text 22", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-22", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-23", array( "label"    => __( "Text 23", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-23", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-24", array( "label"    => __( "Text 24", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-24", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-25", array( "label"    => __( "Text 25", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-25", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-26", array( "label"    => __( "Text 26", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-26", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-27", array( "label"    => __( "Text 27", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-27", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-28", array( "label"    => __( "Text 28", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-28", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-29", array( "label"    => __( "Text 29", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-29", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-30", array( "label"    => __( "Text 30", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-30", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-31", array( "label"    => __( "Text 31", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-31", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-32", array( "label"    => __( "Text 32", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-32", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-33", array( "label"    => __( "Text 33", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-33", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-34", array( "label"    => __( "Text 34", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-34", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-35", array( "label"    => __( "Text 35", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-35", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-36", array( "label"    => __( "Text 36", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-36", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-37", array( "label"    => __( "Text 37", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-37", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-38", array( "label"    => __( "Text 38", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-38", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtgtextAll-39", array( "label"    => __( "Text 39", "estsbtheme" ), "section"  => "customtgtext-9999", "settings" => "tgtext-39", "type"     => "text" ) ));
}
add_action( "customize_register", "themegenchild_register_theme_customizer2" ); function themegenchild_register_theme_customizer2( $wp_customize ) { $wp_customize->add_panel( "featured_images", array("priority" => 70, "theme_supports" => "","title" => __( "Images", "estsbtheme" ), "description" => __( "Set images", "estsbtheme" ), ) );
$wp_customize->add_section( "customtgimg-1" , array("title" => __("Change Image 1","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-1", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/57358123_683129582118854_216901580511353-2cd.jpg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-1", array( "label"    => __( "Image 1", "estsbtheme" ), "section"  => "customtgimg-1", "settings" => "tgimg-1" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-1", array("selector" => "#tgimg-1",));

$wp_customize->add_section( "customtgimg-2" , array("title" => __("Change Image 2","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-2", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/1290406-1a4.svg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-2", array( "label"    => __( "Image 2", "estsbtheme" ), "section"  => "customtgimg-2", "settings" => "tgimg-2" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-2", array("selector" => "#tgimg-2",));

$wp_customize->add_section( "customtgimg-3" , array("title" => __("Change Image 3","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-3", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/icone-ordinateur-962.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-3", array( "label"    => __( "Image 3", "estsbtheme" ), "section"  => "customtgimg-3", "settings" => "tgimg-3" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-3", array("selector" => "#tgimg-3",));

$wp_customize->add_section( "customtgimg-4" , array("title" => __("Change Image 4","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-4", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/2058276-715.svg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-4", array( "label"    => __( "Image 4", "estsbtheme" ), "section"  => "customtgimg-4", "settings" => "tgimg-4" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-4", array("selector" => "#tgimg-4",));

$wp_customize->add_section( "customtgimg-5" , array("title" => __("Change Image 5","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-5", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/0-349.jpg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-5", array( "label"    => __( "Image 5", "estsbtheme" ), "section"  => "customtgimg-5", "settings" => "tgimg-5" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-5", array("selector" => "#tgimg-5",));

$wp_customize->add_section( "customtgimg-6" , array("title" => __("Change Image 6","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-6", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/directeur-aac.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-6", array( "label"    => __( "Image 6", "estsbtheme" ), "section"  => "customtgimg-6", "settings" => "tgimg-6" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-6", array("selector" => "#tgimg-6",));

$wp_customize->add_section( "customtgimg-7" , array("title" => __("Change Image 7","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-7", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/01-283.jpg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-7", array( "label"    => __( "Image 7", "estsbtheme" ), "section"  => "customtgimg-7", "settings" => "tgimg-7" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-7", array("selector" => "#tgimg-7",));

$wp_customize->add_section( "customtgimg-8" , array("title" => __("Change Image 8","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-8", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/proftoumi-c2d.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-8", array( "label"    => __( "Image 8", "estsbtheme" ), "section"  => "customtgimg-8", "settings" => "tgimg-8" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-8", array("selector" => "#tgimg-8",));

$wp_customize->add_section( "customtgimg-9" , array("title" => __("Change Image 9","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-9", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/profmebrouk-94e.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-9", array( "label"    => __( "Image 9", "estsbtheme" ), "section"  => "customtgimg-9", "settings" => "tgimg-9" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-9", array("selector" => "#tgimg-9",));

$wp_customize->add_section( "customtgimg-10" , array("title" => __("Change Image 10","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-10", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/Asset2-ac6.svg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-10", array( "label"    => __( "Image 10", "estsbtheme" ), "section"  => "customtgimg-10", "settings" => "tgimg-10" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-10", array("selector" => "#tgimg-10",));

$wp_customize->add_section( "customtgimg-11" , array("title" => __("Change Image 11","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-11", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/Asset1-97f.svg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-11", array( "label"    => __( "Image 11", "estsbtheme" ), "section"  => "customtgimg-11", "settings" => "tgimg-11" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-11", array("selector" => "#tgimg-11",));

$wp_customize->add_section( "customtgimg-12" , array("title" => __("Change Image 12","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-12", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/Fichier1estsblogo-33c.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-12", array( "label"    => __( "Image 12", "estsbtheme" ), "section"  => "customtgimg-12", "settings" => "tgimg-12" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-12", array("selector" => "#tgimg-12",));

$wp_customize->add_section( "customtgimg-13" , array("title" => __("Change Image 13","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-13", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/Asset1-97f.svg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-13", array( "label"    => __( "Image 13", "estsbtheme" ), "section"  => "customtgimg-13", "settings" => "tgimg-13" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-13", array("selector" => "#tgimg-13",));

$wp_customize->add_section( "customtgimg-14" , array("title" => __("Change Image 14","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-14", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/Asset2-ac6.svg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-14", array( "label"    => __( "Image 14", "estsbtheme" ), "section"  => "customtgimg-14", "settings" => "tgimg-14" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-14", array("selector" => "#tgimg-14",));

$wp_customize->add_section( "customtgimg-15" , array("title" => __("Change Image 15","estsbtheme"),	"panel"    => "featured_images","priority" => 20) );
$wp_customize->add_setting( "tgimg-15", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/Fichier2estsblogo2-9d0.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgimg-15", array( "label"    => __( "Image 15", "estsbtheme" ), "section"  => "customtgimg-15", "settings" => "tgimg-15" ) ));
$wp_customize->selective_refresh->add_partial("tgimg-15", array("selector" => "#tgimg-15",));
}
add_action( "customize_register", "themegenchild_register_theme_customizerLinks" ); function themegenchild_register_theme_customizerLinks( $wp_customize ) { $wp_customize->add_panel( "featured_links", array("priority" => 70, "theme_supports" => "","title" => __( "Links", "estsbtheme" ), "description" => __( "Set links", "estsbtheme" ), ) );
$wp_customize->add_section( "customtglink-1" , array("title" => __("Change Link 1","estsbtheme"),	"panel"    => "featured_links","priority" => 20) );
$wp_customize->add_setting( "tglink-1", array( "sanitize_callback" => "esc_attr", "default" => "https://estsbtheme.com/?editmode=ok"));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglink-1", array( "label"    => __( "Link 1", "estsbtheme" ), "section"  => "customtglink-1", "settings" => "tglink-1", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tglink-1", array("selector" => "#tglink-1",));

$wp_customize->add_section( "customtglink-2" , array("title" => __("Change Link 2","estsbtheme"),	"panel"    => "featured_links","priority" => 20) );
$wp_customize->add_setting( "tglink-2", array( "sanitize_callback" => "esc_attr", "default" => "https://www.facebook.com/ESTSidiBennour/"));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglink-2", array( "label"    => __( "Link 2", "estsbtheme" ), "section"  => "customtglink-2", "settings" => "tglink-2", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tglink-2", array("selector" => "#tglink-2",));

$wp_customize->add_section( "customtglink-3" , array("title" => __("Change Link 3","estsbtheme"),	"panel"    => "featured_links","priority" => 20) );
$wp_customize->add_setting( "tglink-3", array( "sanitize_callback" => "esc_attr", "default" => "https://www.instagram.com"));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglink-3", array( "label"    => __( "Link 3", "estsbtheme" ), "section"  => "customtglink-3", "settings" => "tglink-3", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tglink-3", array("selector" => "#tglink-3",));

$wp_customize->add_section( "customtglink-4" , array("title" => __("Change Link 4","estsbtheme"),	"panel"    => "featured_links","priority" => 20) );
$wp_customize->add_setting( "tglink-4", array( "sanitize_callback" => "esc_attr", "default" => "https://www.linkedin.com/in/youssefbaddi/"));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglink-4", array( "label"    => __( "Link 4", "estsbtheme" ), "section"  => "customtglink-4", "settings" => "tglink-4", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tglink-4", array("selector" => "#tglink-4",));

$wp_customize->add_section( "customtglink-5" , array("title" => __("Change Link 5","estsbtheme"),	"panel"    => "featured_links","priority" => 20) );
$wp_customize->add_setting( "tglink-5", array( "sanitize_callback" => "esc_attr", "default" => "https://www.linkedin.com/in/najib-saber-44850414a/"));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglink-5", array( "label"    => __( "Link 5", "estsbtheme" ), "section"  => "customtglink-5", "settings" => "tglink-5", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tglink-5", array("selector" => "#tglink-5",));

$wp_customize->add_section( "customtglink-6" , array("title" => __("Change Link 6","estsbtheme"),	"panel"    => "featured_links","priority" => 20) );
$wp_customize->add_setting( "tglink-6", array( "sanitize_callback" => "esc_attr", "default" => "https://www.linkedin.com/in/abdelali-saidi-72a17a14/"));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglink-6", array( "label"    => __( "Link 6", "estsbtheme" ), "section"  => "customtglink-6", "settings" => "tglink-6", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tglink-6", array("selector" => "#tglink-6",));

$wp_customize->add_section( "customtglink-7" , array("title" => __("Change Link 7","estsbtheme"),	"panel"    => "featured_links","priority" => 20) );
$wp_customize->add_setting( "tglink-7", array( "sanitize_callback" => "esc_attr", "default" => "https://www.linkedin.com/in/hicham-toumi-35baa977/"));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglink-7", array( "label"    => __( "Link 7", "estsbtheme" ), "section"  => "customtglink-7", "settings" => "tglink-7", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tglink-7", array("selector" => "#tglink-7",));

$wp_customize->add_section( "customtglink-8" , array("title" => __("Change Link 8","estsbtheme"),	"panel"    => "featured_links","priority" => 20) );
$wp_customize->add_setting( "tglink-8", array( "sanitize_callback" => "esc_attr", "default" => "https://www.linkedin.com/in/abdelfettah-mabrouk-24b288113/"));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglink-8", array( "label"    => __( "Link 8", "estsbtheme" ), "section"  => "customtglink-8", "settings" => "tglink-8", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tglink-8", array("selector" => "#tglink-8",));

$wp_customize->add_section( "customtglink-9" , array("title" => __("Change Link 9","estsbtheme"),	"panel"    => "featured_links","priority" => 20) );
$wp_customize->add_setting( "tglink-9", array( "sanitize_callback" => "esc_attr", "default" => "https://www.instagram.com"));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglink-9", array( "label"    => __( "Link 9", "estsbtheme" ), "section"  => "customtglink-9", "settings" => "tglink-9", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tglink-9", array("selector" => "#tglink-9",));

$wp_customize->add_section( "customtglink-10" , array("title" => __("Change Link 10","estsbtheme"),	"panel"    => "featured_links","priority" => 20) );
$wp_customize->add_setting( "tglink-10", array( "sanitize_callback" => "esc_attr", "default" => "https://www.facebook.com/ESTSidiBennour/"));
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglink-10", array( "label"    => __( "Link 10", "estsbtheme" ), "section"  => "customtglink-10", "settings" => "tglink-10", "type"     => "text" ) ));
$wp_customize->selective_refresh->add_partial("tglink-10", array("selector" => "#tglink-10",));

$wp_customize->add_section( "customtglink-9999" , array("title" => __("See all","estsbtheme"),	"panel"    => "featured_links","priority" => 1) );
$wp_customize->add_setting( "tglink-1", array( "default" => __( "https://estsbtheme.com/?editmode=ok", "estsbtheme" ), "sanitize_callback" => "esc_attr"	) );$wp_customize->add_setting( "tglink-2", array( "default" => __( "https://www.facebook.com/ESTSidiBennour/", "estsbtheme" ), "sanitize_callback" => "esc_attr"	) );$wp_customize->add_setting( "tglink-3", array( "default" => __( "https://www.instagram.com", "estsbtheme" ), "sanitize_callback" => "esc_attr"	) );$wp_customize->add_setting( "tglink-4", array( "default" => __( "https://www.linkedin.com/in/youssefbaddi/", "estsbtheme" ), "sanitize_callback" => "esc_attr"	) );$wp_customize->add_setting( "tglink-5", array( "default" => __( "https://www.linkedin.com/in/najib-saber-44850414a/", "estsbtheme" ), "sanitize_callback" => "esc_attr"	) );$wp_customize->add_setting( "tglink-6", array( "default" => __( "https://www.linkedin.com/in/abdelali-saidi-72a17a14/", "estsbtheme" ), "sanitize_callback" => "esc_attr"	) );$wp_customize->add_setting( "tglink-7", array( "default" => __( "https://www.linkedin.com/in/hicham-toumi-35baa977/", "estsbtheme" ), "sanitize_callback" => "esc_attr"	) );$wp_customize->add_setting( "tglink-8", array( "default" => __( "https://www.linkedin.com/in/abdelfettah-mabrouk-24b288113/", "estsbtheme" ), "sanitize_callback" => "esc_attr"	) );$wp_customize->add_setting( "tglink-9", array( "default" => __( "https://www.instagram.com", "estsbtheme" ), "sanitize_callback" => "esc_attr"	) );$wp_customize->add_setting( "tglink-10", array( "default" => __( "https://www.facebook.com/ESTSidiBennour/", "estsbtheme" ), "sanitize_callback" => "esc_attr"	) );
$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglinkAll-1", array( "label"    => __( "Link 1", "estsbtheme" ), "section"  => "customtglink-9999", "settings" => "tglink-1", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglinkAll-2", array( "label"    => __( "Link 2", "estsbtheme" ), "section"  => "customtglink-9999", "settings" => "tglink-2", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglinkAll-3", array( "label"    => __( "Link 3", "estsbtheme" ), "section"  => "customtglink-9999", "settings" => "tglink-3", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglinkAll-4", array( "label"    => __( "Link 4", "estsbtheme" ), "section"  => "customtglink-9999", "settings" => "tglink-4", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglinkAll-5", array( "label"    => __( "Link 5", "estsbtheme" ), "section"  => "customtglink-9999", "settings" => "tglink-5", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglinkAll-6", array( "label"    => __( "Link 6", "estsbtheme" ), "section"  => "customtglink-9999", "settings" => "tglink-6", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglinkAll-7", array( "label"    => __( "Link 7", "estsbtheme" ), "section"  => "customtglink-9999", "settings" => "tglink-7", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglinkAll-8", array( "label"    => __( "Link 8", "estsbtheme" ), "section"  => "customtglink-9999", "settings" => "tglink-8", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglinkAll-9", array( "label"    => __( "Link 9", "estsbtheme" ), "section"  => "customtglink-9999", "settings" => "tglink-9", "type"     => "text" ) ));$wp_customize->add_control( new WP_Customize_Control( $wp_customize, "customtglinkAll-10", array( "label"    => __( "Link 10", "estsbtheme" ), "section"  => "customtglink-9999", "settings" => "tglink-10", "type"     => "text" ) ));
}





add_action( "customize_register", "themegenchild_register_theme_customizer3" ); function themegenchild_register_theme_customizer3( $wp_customize ) { $wp_customize->add_panel( "featured_backgrounds", array("priority" => 70, "theme_supports" => "","title" => __( "Backgrounds", "estsbtheme" ), "description" => __( "Set background image.", "estsbtheme" ), ) );
$wp_customize->add_section( "customtgback-1" , array("title" => __("Change Image 1","estsbtheme"),	"panel"    => "featured_backgrounds","priority" => 20) );
$wp_customize->add_setting( "tgback-1", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/estsbfinal-b1c.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgback-1", array( "label"    => __( "Image 1", "estsbtheme" ), "section"  => "customtgback-1", "settings" => "tgback-1" ) ));
$wp_customize->selective_refresh->add_partial("tgback-1", array("selector" => "#tgback-1",));

$wp_customize->add_section( "customtgback-2" , array("title" => __("Change Image 2","estsbtheme"),	"panel"    => "featured_backgrounds","priority" => 20) );
$wp_customize->add_setting( "tgback-2", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/pattern3-ddf.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgback-2", array( "label"    => __( "Image 2", "estsbtheme" ), "section"  => "customtgback-2", "settings" => "tgback-2" ) ));
$wp_customize->selective_refresh->add_partial("tgback-2", array("selector" => "#tgback-2",));

$wp_customize->add_section( "customtgback-3" , array("title" => __("Change Image 3","estsbtheme"),	"panel"    => "featured_backgrounds","priority" => 20) );
$wp_customize->add_setting( "tgback-3", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/parallax2-9de.jpg"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgback-3", array( "label"    => __( "Image 3", "estsbtheme" ), "section"  => "customtgback-3", "settings" => "tgback-3" ) ));
$wp_customize->selective_refresh->add_partial("tgback-3", array("selector" => "#tgback-3",));

$wp_customize->add_section( "customtgback-4" , array("title" => __("Change Image 4","estsbtheme"),	"panel"    => "featured_backgrounds","priority" => 20) );
$wp_customize->add_setting( "tgback-4", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/pattern3-ddf.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgback-4", array( "label"    => __( "Image 4", "estsbtheme" ), "section"  => "customtgback-4", "settings" => "tgback-4" ) ));
$wp_customize->selective_refresh->add_partial("tgback-4", array("selector" => "#tgback-4",));

$wp_customize->add_section( "customtgback-5" , array("title" => __("Change Image 5","estsbtheme"),	"panel"    => "featured_backgrounds","priority" => 20) );
$wp_customize->add_setting( "tgback-5", array( "sanitize_callback" => "esc_attr", "default" => "".get_template_directory_uri()."/images/blue-low-opacity.png"));
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, "customtgback-5", array( "label"    => __( "Image 5", "estsbtheme" ), "section"  => "customtgback-5", "settings" => "tgback-5" ) ));
$wp_customize->selective_refresh->add_partial("tgback-5", array("selector" => "#tgback-5",));
}

