<?php
/**
 * PaperCuts functions and definitions.
 * @package PaperCuts
 * @since PaperCuts 1.0.0
*/

/**
 * PaperCuts theme variables.
 *  
*/    
$papercuts_themename = "PaperCuts";			//Theme Name
$papercuts_themever = "1.2.2";									//Theme version
$papercuts_shortname = "papercuts";							//Shortname 
$papercuts_manualurl = get_template_directory_uri() . '/docs/documentation.html';	//Manual Url
// Set path to PaperCuts Framework and theme specific functions
$papercuts_be_path = get_template_directory() . '/functions/be/';									//BackEnd Path
$papercuts_fe_path = get_template_directory() . '/functions/fe/';									//FrontEnd Path 
$papercuts_be_pathimages = get_template_directory_uri() . '/functions/be/images';		//BackEnd Path
$papercuts_fe_pathimages = get_template_directory_uri() . '';	//FrontEnd Path
//Include Framework [BE] 
require_once ($papercuts_be_path . 'fw-options.php');	 	 // Framework Init  
// Include Theme specific functionality [FE] 
require_once ($papercuts_fe_path . 'headerdata.php');		 // Include css and js
require_once ($papercuts_fe_path . 'library.php');	       // Include library, functions
require_once ($papercuts_fe_path . 'widget-posts-list.php');// Posts-List Widget

/**
 * PaperCuts theme basic setup.
 *  
*/
function papercuts_setup() {
	// Makes PaperCuts available for translation.
	load_theme_textdomain( 'papercuts', get_template_directory() . '/languages' );
  // This theme styles the visual editor to resemble the theme style.
  add_editor_style( 'editor-style.css' );
	// Adds RSS feed links to <head> for posts and comments.  
	add_theme_support( 'automatic-feed-links' );
	// This theme supports custom background color and image.
	$defaults = array(
	'default-color' => '', 
  'default-image' => '',
	'wp-head-callback' => '_custom_background_cb',
	'admin-head-callback' => '',
	'admin-preview-callback' => '' );  
  add_theme_support( 'custom-background', $defaults );
	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 958, 9999 );
  // This theme uses a custom header background image.
  $args = array(
	'width'          => 658,
  'flex-width'     => true,
  'flex-height'    => true,
  'header-text'    => false,
  'random-default' => true,);
  add_theme_support( 'custom-header', $args );
  add_theme_support( 'woocommerce' );
  global $content_width;
  if ( ! isset( $content_width ) ) { $content_width = 658; }
}
add_action( 'after_setup_theme', 'papercuts_setup' );

/**
 * Enqueues scripts and styles for front-end.
 *
*/
function papercuts_scripts_styles() {
	global $wp_styles, $wp_scripts;
	// Adds JavaScript
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
    wp_enqueue_script( 'papercuts-placeholders', get_template_directory_uri() . '/js/placeholders.js', array(), '2.1.0', true );
    wp_enqueue_script( 'papercuts-scroll-to-top', get_template_directory_uri() . '/js/scroll-to-top.js', array( 'jquery' ), '1.0', true );
    wp_enqueue_script( 'papercuts-selectnav', get_template_directory_uri() . '/js/selectnav.js', array(), '0.1', true );
    wp_enqueue_script( 'papercuts-responsive', get_template_directory_uri() . '/js/responsive.js', array(), '1.0', true );
    wp_enqueue_script( 'papercuts-html5-ie', get_template_directory_uri() . '/js/html5.js', array(), '3.6', false );
    $wp_scripts->add_data( 'papercuts-html5-ie', 'conditional', 'lt IE 9' );
	// Loads the main stylesheet.
	  wp_enqueue_style( 'papercuts-style', get_stylesheet_uri() );
    if ( class_exists( 'woocommerce' ) ) { wp_enqueue_style( 'papercuts-woocommerce-custom', get_template_directory_uri() . '/css/woocommerce-custom.css' ); }
}
add_action( 'wp_enqueue_scripts', 'papercuts_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text.
 *  
*/
function papercuts_wp_title( $title, $sep ) {
	if ( is_feed() )
		return $title;
	$title .= get_bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";
	return $title;
}
add_filter( 'wp_title', 'papercuts_wp_title', 10, 2 );

/**
 * Register our menus.
 *
 */
function papercuts_register_my_menus() {
  register_nav_menus(
    array(
      'main-navigation' => __( 'Main Header Menu', 'papercuts' ),
      'top-navigation' => __( 'Top Header Menu', 'papercuts' )
    )
  );
}
add_action( 'after_setup_theme', 'papercuts_register_my_menus' );

/**
 * Register our sidebars and widgetized areas.
 *
*/
function papercuts_widgets_init() {
  register_sidebar( array(
		'name' => __( 'Right Sidebar', 'papercuts' ),
		'id' => 'sidebar-1',
		'description' => __( 'Right sidebar which appears on all posts and pages.', 'papercuts' ),
		'before_widget' => '<div id="%1$s" class="sidebar-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => ' <p class="sidebar-headline">',
		'after_title' => '</p>',
	) );
  register_sidebar( array(
		'name' => __( 'Footer left widget area', 'papercuts' ),
		'id' => 'sidebar-2',
		'description' => __( 'Left column with widgets in footer.', 'papercuts' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<p class="footer-headline">',
		'after_title' => '</p>',
	) );
  register_sidebar( array(
		'name' => __( 'Footer middle widget area', 'papercuts' ),
		'id' => 'sidebar-3',
		'description' => __( 'Middle column with widgets in footer.', 'papercuts' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<p class="footer-headline">',
		'after_title' => '</p>',
	) );
  register_sidebar( array(
		'name' => __( 'Footer right widget area', 'papercuts' ),
		'id' => 'sidebar-4',
		'description' => __( 'Right column with widgets in footer.', 'papercuts' ),
		'before_widget' => '<div id="%1$s" class="footer-widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<p class="footer-headline">',
		'after_title' => '</p>',
	) );
  register_sidebar( array(
		'name' => __( 'Footer notices', 'papercuts' ),
		'id' => 'sidebar-5',
		'description' => __( 'The line for copyright and other notices below the footer widget areas. Insert here one Text widget. The "Title" field at this widget should stay empty.', 'papercuts' ),
		'before_widget' => '<div class="footer-signature"><div class="footer-signature-content">',
		'after_widget' => '</div></div>',
		'before_title' => '',
		'after_title' => '',
	) );
  register_sidebar( array(
		'name' => __( 'Latest Posts Homepage widget area', 'papercuts' ),
		'id' => 'sidebar-6',
		'description' => __( 'The area for any PaperCuts Posts Widgets, which display latest posts from a specific category below the default Latest Posts area.', 'papercuts' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'papercuts_widgets_init' );

/**
 * Post excerpt settings.
 *
*/
function papercuts_custom_excerpt_length( $length ) {
return 40;
}
add_filter( 'excerpt_length', 'papercuts_custom_excerpt_length', 20 );
function papercuts_new_excerpt_more( $more ) {
global $post;
return '...<br /><a class="read-more-button" href="'. esc_url( get_permalink($post->ID) ) . '">' . __( 'Read more', 'papercuts' ) . '</a>';}
add_filter( 'excerpt_more', 'papercuts_new_excerpt_more' );

if ( ! function_exists( 'papercuts_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
*/
function papercuts_content_nav( $html_id ) {
	global $wp_query;
	$html_id = esc_attr( $html_id );
	if ( $wp_query->max_num_pages > 1 ) : ?>
		<div id="<?php echo $html_id; ?>" class="navigation" role="navigation">
    <div class="navigation-inner">
			<h2 class="navigation-headline section-heading"><?php _e( 'Post navigation', 'papercuts' ); ?></h2>
      <div class="nav-wrapper">
			 <p class="navigation-links">
<?php $big = 999999999;
echo paginate_links( array(
	'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format' => '?paged=%#%',
	'current' => max( 1, get_query_var('paged') ),
  'prev_text' => __( '&larr; Previous', 'papercuts' ),
	'next_text' => __( 'Next &rarr;', 'papercuts' ),
	'total' => $wp_query->max_num_pages
) );
?>
        </p>
      </div>
		</div>
    </div>
	<?php endif;
}
endif;

/**
 * Displays navigation to next/previous posts on single posts pages.
 *
*/
function papercuts_prev_next($nav_id) { ?>
<?php $papercuts_previous_post = get_adjacent_post( false, "", true );
$papercuts_next_post = get_adjacent_post( false, "", false ); ?>
<div id="<?php echo $nav_id; ?>" class="navigation" role="navigation">
	<div class="nav-wrapper">
<?php if ( !empty($papercuts_previous_post) ) { ?>
  <p class="nav-previous"><a href="<?php echo esc_url(get_permalink($papercuts_previous_post->ID)); ?>" title="<?php echo esc_attr($papercuts_previous_post->post_title); ?>"><?php _e( '&larr; Previous post', 'papercuts' ); ?></a></p>
<?php } if ( !empty($papercuts_next_post) ) { ?>
	<p class="nav-next"><a href="<?php echo esc_url(get_permalink($papercuts_next_post->ID)); ?>" title="<?php echo esc_attr($papercuts_next_post->post_title); ?>"><?php _e( 'Next post &rarr;', 'papercuts' ); ?></a></p>
<?php } ?>
   </div>
</div>
<?php }  

if ( ! function_exists( 'papercuts_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
*/
function papercuts_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'papercuts' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'papercuts' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="comment-meta comment-author vcard">
				<?php
					echo get_avatar( $comment, 44 );
					printf( '<span><b class="fn">%1$s</b> %2$s</span>',
						get_comment_author_link(),
						( $comment->user_id === $post->post_author ) ? '<span>' . __( '(Post author)', 'papercuts' ) . '</span>' : ''
					);
					printf( '<time datetime="%2$s">%3$s</time>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						// translators: 1: date, 2: time
						sprintf( __( '%1$s at %2$s', 'papercuts' ), get_comment_date(''), get_comment_time() )
					);
				?>
			</div><!-- .comment-meta -->

			<?php if ( '0' == $comment->comment_approved ) : ?>
				<p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'papercuts' ); ?></p>
			<?php endif; ?>

			<div class="comment-content comment">
				<?php comment_text(); ?>
			 <div class="reply">
			   <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'papercuts' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
			   <?php edit_comment_link( __( 'Edit', 'papercuts' ), '<p class="edit-link">', '</p>' ); ?>
			</div><!-- .comment-content -->
		</div><!-- #comment-## -->
	<?php
		break;
	endswitch;
}
endif;

/**
 * Function for rendering CSS3 features in IE.
 *
*/
add_filter( 'wp_head' , 'papercuts_pie' );
function papercuts_pie() { ?>
<!--[if IE]>
<style type="text/css" media="screen">
#wrapper-header, #wrapper-footer, #top-navigation-wrapper, .header-image-wrapper, .entry-content, .home-list-posts, .post-entry, .sidebar-widget, .sidebar-headline, .footer-signature, #nav-below, #papercuts-post-nav, .search .navigation {
        behavior: url("<?php echo get_template_directory_uri() . '/css/pie/PIE.php'; ?>");
        zoom: 1;
}
</style>
<![endif]-->
<?php }

/**
 * Function for adding custom classes to the menu objects.
 *
*/
add_filter( 'wp_nav_menu_objects', 'papercuts_filter_menu_class', 10, 2 );
function papercuts_filter_menu_class( $objects, $args ) {

    $ids        = array();
    $parent_ids = array();
    $top_ids    = array();
    foreach ( $objects as $i => $object ) {

        if ( 0 == $object->menu_item_parent ) {
            $top_ids[$i] = $object;
            continue;
        }
 
        if ( ! in_array( $object->menu_item_parent, $ids ) ) {
            $objects[$i]->classes[] = 'first-menu-item';
            $ids[]          = $object->menu_item_parent;
        }
 
        if ( in_array( 'first-menu-item', $object->classes ) )
            continue;
 
        $parent_ids[$i] = $object->menu_item_parent;
    }
 
    $sanitized_parent_ids = array_unique( array_reverse( $parent_ids, true ) );
 
    foreach ( $sanitized_parent_ids as $i => $id )
        $objects[$i]->classes[] = 'last-menu-item';
 
    return $objects; 
}

/**
 * Include the TGM_Plugin_Activation class.
 *  
*/
require_once get_template_directory() . '/class-tgm-plugin-activation.php'; 
add_action( 'tgmpa_register', 'papercuts_my_theme_register_required_plugins' );

function papercuts_my_theme_register_required_plugins() {

$plugins = array(
		array(
			'name'     => 'Breadcrumb NavXT',
			'slug'     => 'breadcrumb-navxt',
			'required' => false,
		),
);
 
 
$config = array(
		'domain'       => 'papercuts',
    'menu'         => 'install-my-theme-plugins',
		'strings'    	 => array(
		'page_title'             => __( 'Install Recommended Plugins', 'papercuts' ),
		'menu_title'             => __( 'Install Plugins', 'papercuts' ),
		'instructions_install'   => __( 'The %1$s plugin is required for this theme. Click on the big blue button below to install and activate %1$s.', 'papercuts' ),
		'instructions_activate'  => __( 'The %1$s is installed but currently inactive. Please go to the <a href="%2$s">plugin administration page</a> page to activate it.', 'papercuts' ),
		'button'                 => __( 'Install %s Now', 'papercuts' ),
		'installing'             => __( 'Installing Plugin: %s', 'papercuts' ),
		'oops'                   => __( 'Something went wrong with the plugin API.', 'papercuts' ), // */
		'notice_can_install'     => __( 'This theme requires the %1$s plugin. <a href="%2$s"><strong>Click here to begin the installation process</strong></a>. You may be asked for FTP credentials based on your server setup.', 'papercuts' ),
		'notice_cannot_install'  => __( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'papercuts' ),
		'notice_can_activate'    => __( 'This theme requires the %1$s plugin. That plugin is currently inactive, so please go to the <a href="%2$s">plugin administration page</a> to activate it.', 'papercuts' ),
		'notice_cannot_activate' => __( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'papercuts' ),
		'return'                 => __( 'Return to Recommended Plugins Installer', 'papercuts' ),
),
); 
papercuts_tgmpa( $plugins, $config ); 
} 


/*----------------------------------------------*/
function projects_post_type() {

	$labels = array(
		'name'                => _x( 'Проекти', 'Post Type General Name', 'projects' ),
		'singular_name'       => _x( 'Проект', 'Post Type Singular Name', 'projects' ),
		'menu_name'           => __( 'Проекти', 'projects' ),
		'parent_item_colon'   => __( 'Parent Item:', 'projects' ),
		'all_items'           => __( 'Проекти', 'projects' ),
		'view_item'           => __( 'Проект', 'projects' ),
		'add_new_item'        => __( 'Додати Новий Проект', 'projects' ),
		'add_new'             => __( 'Додати Проект', 'projects' ),
		'edit_item'           => __( 'Змiнити Проект', 'projects' ),
		'update_item'         => __( 'Оновити Проект', 'projects' ),
		'search_items'        => __( 'Пошук Проекту', 'projects' ),
		'not_found'           => __( 'Не знайдено проектiв', 'projects' ),
		'not_found_in_trash'  => __( 'Нiчого немає ', 'projects' ),
	);
	$args = array(
		'label'               => __( 'projects', 'projects' ),
		'description'         => __( 'Створити Проект', 'projects' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'page-attributes', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-welcome-widgets-menus',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => true,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'projects', $args );

}

// Hook into the 'init' action
add_action( 'init', 'projects_post_type', 0 );
/*----------------------------------------------*/
?>