<?php
/**
 * Template Name: Page without Title
 * The template file for pages without the page title.
 * @package PaperCuts
 * @since PaperCuts 1.0.2
*/
get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <article class="entry-content"> 
      <div class="entry-content-inner">
<?php papercuts_get_breadcrumb(); ?>
<?php papercuts_get_display_image_page(); ?>
<?php the_content(); ?>
<?php edit_post_link( __( '(Edit)', 'papercuts' ), '<p>', '</p>' ); ?>
<?php endwhile; endif; ?>
<?php comments_template( '', true ); ?>
      </div>
    </article>
  </div> <!-- end of content -->
<?php get_sidebar(); ?>
  </div> <!-- end of main-content -->
</div> <!-- end of container -->
<?php get_footer(); ?>