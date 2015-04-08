<?php
/**
 * Home page template file.
 * @package promolod
 * @since promolod 1.0.0
*/
get_header(); ?>
		<div class="row">
			<?php get_sidebar(); ?>
				
				<?php
				 // Число 96 замените на идентификатор вашей страницы, которую хотите загрузить:
			    $page_id = 69;
			    // Вы должны присвоить идентификатор переменной, иначе WordPress будет генерировать ошибку:
			    $page_data = get_page( $page_id );
			    // Выводим содержимое страницы, сохраняя стандартные фильтры WordPress:
			    print apply_filters('the_content', $page_data->post_content);
			    ?>

</div>  <!-- END wrapper -->


<?php get_footer(); ?>