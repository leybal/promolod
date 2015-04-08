<?php
/**
 * The header template file.
 * @package PaperCuts
 * @since PaperCuts 1.0.0
*/
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<?php global $papercuts_options_db; ?>
  <meta charset="<?php bloginfo( 'charset' ); ?>" /> 
  <meta name="viewport" content="width=device-width" />  
  <title><?php wp_title( '|', true, 'right' ); ?></title>  
<?php if ($papercuts_options_db['papercuts_favicon_url'] != ''){ ?>
	<link rel="shortcut icon" href="<?php echo esc_url($papercuts_options_db['papercuts_favicon_url']); ?>" />
<?php } ?>
<?php wp_head(); ?>  
</head>
 
<body <?php body_class(); ?> id="wrapper">
<?php if ( !is_page_template('template-landing-page.php') ) { ?>
<?php if ( has_nav_menu( 'top-navigation' ) || $papercuts_options_db['papercuts_header_facebook_link'] != '' || $papercuts_options_db['papercuts_header_twitter_link'] != '' || $papercuts_options_db['papercuts_header_google_link'] != '' || $papercuts_options_db['papercuts_header_rss_link'] != '' ) {  ?> 
<div id="top-navigation-wrapper">
  <div class="top-navigation">
<?php if ( has_nav_menu( 'top-navigation' ) ) { wp_nav_menu( array( 'menu_id'=>'top-nav', 'theme_location'=>'top-navigation' ) ); } ?>
      
    <div class="header-icons">
<?php if ($papercuts_options_db['papercuts_header_facebook_link'] != ''){ ?>
      <a class="social-icon facebook-icon" href="<?php echo esc_url($papercuts_options_db['papercuts_header_facebook_link']); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon-facebook.png" alt="Facebook" /></a>
<?php } ?>
<?php if ($papercuts_options_db['papercuts_header_twitter_link'] != ''){ ?>
      <a class="social-icon twitter-icon" href="<?php echo esc_url($papercuts_options_db['papercuts_header_twitter_link']); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon-twitter.png" alt="Twitter" /></a>
<?php } ?>
<?php if ($papercuts_options_db['papercuts_header_google_link'] != ''){ ?>
      <a class="social-icon google-icon" href="<?php echo esc_url($papercuts_options_db['papercuts_header_google_link']); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon-google.png" alt="Google +" /></a>
<?php } ?>
<?php if ($papercuts_options_db['papercuts_header_rss_link'] != ''){ ?>
      <a class="social-icon rss-icon" href="<?php echo esc_url($papercuts_options_db['papercuts_header_rss_link']); ?>"><img src="<?php echo esc_url(get_template_directory_uri()); ?>/images/icon-rss.png" alt="RSS" /></a>
<?php } ?>
    </div>
  </div>
</div>
<?php }} ?>

<header id="wrapper-header">  
  <div id="header">
  <div class="header-content-wrapper">
    <div class="header-content">
<?php if ( $papercuts_options_db['papercuts_logo_url'] == '' ) { ?>
      <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></p>
<?php if ( $papercuts_options_db['papercuts_display_site_description'] != 'Hide' ) { ?>
      <p class="site-description"><?php bloginfo( 'description' ); ?></p>
<?php } ?>
<?php } else { ?>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img class="header-logo" src="<?php echo esc_url($papercuts_options_db['papercuts_logo_url']); ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
<?php } ?>
<?php if ( $papercuts_options_db['papercuts_display_search_form'] != 'Hide' && !is_page_template('template-landing-page.php') ) { ?>
<?php get_search_form(); ?>
<?php } ?>
    </div>
  </div>
<?php if ( has_nav_menu( 'main-navigation' ) && !is_page_template('template-landing-page.php') ) { ?>
  <div class="menu-box-wrapper">
    <div class="menu-box">
<?php wp_nav_menu( array( 'menu_id'=>'nav', 'theme_location'=>'main-navigation' ) ); ?>
    </div>
  </div>
<?php } ?>
  </div> <!-- end of header -->
</header> <!-- end of wrapper-header -->

<div id="container">
  <div id="main-content">
  <div id="content">
  
<?php if ( is_home() || is_front_page() ) { ?>
<?php if ( get_header_image() != '' && $papercuts_options_db['papercuts_display_header_image'] != 'Everywhere except Homepage' ) { ?>
  <div class="header-image-wrapper"><div class="header-image"><img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" /></div></div>
<?php } ?> 
<?php } else { ?>
<?php if ( get_header_image() != '' && $papercuts_options_db['papercuts_display_header_image'] != 'Only on Homepage' ) { ?>
    <div class="header-image-wrapper"><div class="header-image"><img src="<?php header_image(); ?>" alt="<?php bloginfo( 'name' ); ?>" /></div></div>
<?php } ?>
<?php } ?> 