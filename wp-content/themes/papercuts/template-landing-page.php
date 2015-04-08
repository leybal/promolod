<?php
/**
 * Template Name: Landing Page
 * The template file for displaying a landing page without the menus, right sidebar and footer widget areas.
 * @package PaperCuts
 * @since PaperCuts 1.0.2
*/
get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article class="entry-content"> 
      <div class="entry-content-inner">
        <h1 class="content-headline"><?php the_title(); ?></h1>
<?php papercuts_get_display_image_page(); ?>
<?php the_content(); ?>
<?php edit_post_link( __( '(Edit)', 'papercuts' ), '<p>', '</p>' ); ?>
<?php endwhile; endif; ?>
      </div>
    </article>
  </div> <!-- end of content -->
  </div> <!-- end of main-content -->
</div> <!-- end of container -->
<?php get_footer(); ?>