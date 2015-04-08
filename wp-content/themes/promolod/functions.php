<?php
/* загрузка стилей и скритпов */
function load_style_script (){
 wp_enqueue_style('style', get_template_directory_uri() . '/style.css');

/*wp_enqueue_script ('useragent', get_template_directory_uri() . '/js/'useragent.js);*/

wp_enqueue_script('jquery');
}
/* загрузка стилей и скритпов */
add_action('wp_enqueue_scripts', 'load_style_script');

/*Поддержка миниаюр*/
add_theme_support('post-thumbnails'); /* 166 x 124*/

/**
 * Register our menus.
 *
 */
function papercuts_register_my_menus() {
  register_nav_menus(
    array(
      'main-navigation' => __( 'Main Header Menu', 'papercuts' ),
      'top-navigation' => __( 'Top Projects Menu', 'papercuts' )
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
}
add_action( 'widgets_init', 'papercuts_widgets_init' );

/* Вторая миниатюра */
if (class_exists('MultiPostThumbnails')) {
    new MultiPostThumbnails(array(
        'label' => 'Secondary Image',
        'id' => 'secondary-image',
        'post_type' => 'post'
    ) );
};


function my_formatter($content) {
$new_content = '';
$pattern_full = '{(\[raw\].*?\[/raw\])}is';
$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
 
foreach ($pieces as $piece) {
if (preg_match($pattern_contents, $piece, $matches)) {
$new_content .= $matches[1];
} else {
$new_content .= wptexturize(wpautop($piece));
}
}
 
return $new_content;
}
 
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
 
add_filter('the_content', 'my_formatter', 99);

/*
Shortcod in heder.php
*/
add_filter( 'bgmp_map-shortcode-called', '__return_true' );

/*
FORM ADD IDIA
*/
// function wpcf7_do_something_else(&$wpcf7_data) {
//     // Here is the variable where the data are stored!
//     var_dump($wpcf7_data);
//     // If you want to skip mailing the data, you can do it...
//     $wpcf7_data->skip_mail = true;
// }
//add_action("wpcf7_before_send_mail", "wpcf7_do_something_else");


// function cwc_rss_post_thumbnail($content) {
//     global $post;
//     if(has_post_thumbnail($post->ID)) {
//         $content = '<p>' . get_the_post_thumbnail($post->ID) .
//         '</p>' . get_the_content();
//     }

//     return $content;
// }
// add_filter('the_excerpt_rss', 'cwc_rss_post_thumbnail');
// add_filter('the_content_feed', 'cwc_rss_post_thumbnail');

?>