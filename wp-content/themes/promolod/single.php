<?php
/**
 * The post template file.
 * @package promolod
 * @since promolod 1.0.0
*/
get_header(); ?>
	<div class="row">
		<?php get_sidebar(); ?>

		 <?php if (have_posts()) : while (have_posts()) : the_post();?>
			<!-- Catagory prodjects -->
			<?php if ( in_category('4') ) { ?>
			<section class="content">
				<div class="proj-head">
					<div class="proj-head-logo">
						<?php the_post_thumbnail('full'); ?>
					</div>
					<article class="proj-head-text">
						<h3><?php the_title();?></h3>
						
							<?php the_excerpt(); ?>
						
					</article>
					<div class="proj-head-photo">
						<?php if (class_exists('MultiPostThumbnails')) :
							MultiPostThumbnails::the_post_thumbnail(get_post_type(), 'secondary-image');
	 						endif; ?>
					</div>
				</div>	

				<article>
					<?php the_content(); ?>
				</article>
				<div class="row"><a href="/category/projects/" class="projects_link">Інші проекти</a></div>
			</section>
			<?php } else { ?> 
		 	<!-- END Catagory prodjects -->
		 	<!-- Enother Catagory -->
		 	<section class="content">
				<div class="promotion-head">
					<article class="promotion-head-text">
						<h3><?php the_title();?></h3>
						<?php the_excerpt(); ?>
					</article>

					<div class="promotion-head-logo">
						<?php the_post_thumbnail('full'); ?>	
					</div>
				</div>
				<article>
					<?php the_content(); ?>
				</article>

			</section>

			<?php }; ?>	
			<!-- END Enother Catagory -->
		<?php endwhile;?>
		<!--post navigation-->
		<?php endif; ?>

			

</div>

</div>


<?php get_footer(); ?>