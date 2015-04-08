<?php
/**
 * The WooCommerce pages template file.
 * @package PaperCuts
 * @since PaperCuts 1.1.0
*/
get_header(); ?>
    <article class="entry-content"> 
      <div class="entry-content-inner">
<?php papercuts_get_breadcrumb(); ?>
<?php woocommerce_content(); ?>
      </div>
    </article>
  </div> <!-- end of content -->
<?php get_sidebar(); ?>
  </div> <!-- end of main-content -->
</div> <!-- end of container -->
<?php get_footer(); ?>