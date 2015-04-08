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
			<?php
			    // Число 96 замените на идентификатор вашей страницы, которую хотите загрузить:
			    $page_id = 100;
			    // Вы должны присвоить идентификатор переменной, иначе WordPress будет генерировать ошибку:
			    $page_data = get_page( $page_id );
			    // Выводим содержимое страницы, сохраняя стандартные фильтры WordPress:
			    print apply_filters('the_content', $page_data->post_content);
			    ?>

			<ul class="projects">
			<?php if (have_posts()) : while (have_posts()) : the_post();?>
			<?php if ( is_category( inspiration ) ) { ?>
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

		</section>
	</div>

</div>


<?php get_footer(); ?>