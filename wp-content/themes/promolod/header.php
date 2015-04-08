<?php
/**
 * The header template file.
 * @package promolod
 * @since promolod 1.0.0
*/
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <script src="<?php echo get_template_directory_uri() ?>/js/useragent.js" type="text/javascript"></script>
  <!--[if lt IE 9]>
  <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <?php wp_head(); ?>  
  <script type="text/javascript">
    jQuery(document).ready(function(){
      
      jQuery(document).mouseup(function (e){ // событие клика по веб-документу
      var div = jQuery(".dialog-content"); // тут указываем ID элемента
      if (!div.is(e.target) // если клик был не по нашему блоку 
          && div.has(e.target).length === 0) { // и не по его дочерним элементам
            jQuery(".back-dialog").fadeOut(); // скрываем его
          }
        });

      jQuery(document).mouseup(function (e){ // событие клика по веб-документу
      var div = jQuery("#popup"); // тут указываем ID элемента
      if (!div.is(e.target) // если клик был не по нашему блоку
          && div.has(e.target).length === 0) { // и не по его дочерним элементам
            jQuery("#popup, .blocker").fadeOut(); // скрываем его
          }
        });

      });
    

      function opendialog_mail(){
          jQuery("#dialog_mail").fadeIn(); 
      }

      function closedialog_mail(){
          jQuery("#dialog_mail").fadeOut(); 
      }

  </script> 
</head>
<body>
<!-- PopUp -->
<div class="back-dialog" id="dialog_mail">
    <div class="wrap_popup">
      <a class='close-dialog' href='javascript: closedialog_mail()'></a>
      <div class="dialog-content">
          <?php echo do_shortcode( '[contact-form-7 id="219" title="Форма зворотного звязку"]' ); ?>
      </div>
    </div>
  </div>
  
<!-- END PopUp -->
  <div class="wrapper">
    <header>
      <h1>
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
          <img src="<?php echo bloginfo('template_url'); ?>/img/logo.png" alt="<?php bloginfo( 'name' ); ?>">Промолодь</a>
      </h1>

      <?php echo do_shortcode( ' [uji_popup class="news" id="214"]<button class="signup">Отримувати новини</button>[/uji_popup] ' ); ?>

      <nav class="main"> 
        <?php wp_nav_menu( array( 'menu_id'=>'nav', 'theme_location'=>'main-navigation' ) ); ?>
      </nav>

      <!-- <nav class="main">
        <a class="active" href="index.html">Головна</a>
        <a href="about.html">Хто ми</a>
        <a href="projects.html">Проекти</a>
        <a href="promotion.html">Сприяння</a>
        <a href="inspiration.html">Натхнення</a>
      </nav> -->
      <ul class="social-links header-social-links">
        <li class="tw">
          <a href="https://twitter.com/Promolod" target="_blank">twitter</a>
        </li>
        <li class="fb" >
          <a href="https://www.facebook.com/promolod" target="_blank">facebook</a>
        </li>
        <li class="vk">
          <a href="https://vk.com/promolod" target="_blank">vk</a>
        </li>
        <li onClick='opendialog_mail()' class="mail">
          <a href="#">mail</a>
        </li>
      </ul>
    </header>
