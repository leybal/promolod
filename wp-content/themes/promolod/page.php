<?php
/**
 * The post template file.
 * @package promolod
 * @since promolod 1.0.0
*/
get_header(); ?>
		<div class="row">
			<?php get_sidebar(); ?>

		<section class="content">

			<?php if (have_posts()) : while (have_posts()) : the_post();?>
										
					<?php the_content(); ?>

			<?php endwhile;?>
			<!--post navigation-->
			<?php endif; ?>

		</section>
	</div>

</div>


<?php get_footer(); ?>