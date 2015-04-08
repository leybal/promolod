<?php
/**
 * The main template file.
 * @package PaperCuts
 * @since PaperCuts 1.0.0
*/
get_header(); ?>
		<div class="row">
			<?php get_sidebar(); ?>

		<section class="content">
			<div class="row">
				<div class="categories">
        			<?php wp_nav_menu( array( 'menu_id'=>'nav', 'theme_location'=>'top-navigation' ) ); ?>
				</div>
				
				<a href="/add-idea/" class="add_project">Додати ідею</a>
			</div>

			<ul class="projects">
			<?php if (have_posts()) : while (have_posts()) : the_post();?>
			<?php if ( is_category( volunteer ) ) { ?>
				<li>
					<a href="<?php the_permalink(); ?>" class="project-wrap">
						<div class="project-img">
							<?php the_post_thumbnail('full'); ?></div>
						<div class="project-text">
							<h3><?php the_title();?></h3>
							<p>
								<?php the_excerpt(); ?>
							</p>
						</div>
					</a>
				</li>
			
			<?php } ?>
			<?php endwhile; else: ?>
				<p><?php _e('Вибачте, записів поки що немає.'); ?></p>
				<!--post navigation-->
			<?php endif; ?>
			</ul>

			<a href="/add-idea/" class="add_project add_project-center">Додати ідею</a>
		</section>
	</div>

</div>


<?php get_footer(); ?>