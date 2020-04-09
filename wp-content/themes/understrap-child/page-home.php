<?php 
/*
Template Name: Шаблон для Главной страницы
*/

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

$template_directory = get_template_directory_uri();
get_header();
$container = get_theme_mod( 'understrap_container_type' ); 
?>

<div class="wrapper" id="page-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">


			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">
				<div class="main-page-content row">
					<div class="container">

					<?php while ( have_posts() ) : the_post(); ?>

						<?php get_template_part( 'loop-templates/content', 'page' ); ?>

					<?php endwhile; // end of the loop. ?>
					</div>
				</div>
				
				<?php
                //Получаем последние объекты недвижимости
                $lastPosts = get_posts([
                	'post_type' => 'apartments',
                    'numberposts' => 4,
                    'orderby'     => 'date',
                    'order'       => 'DESC',
                    'include'     => array(),
                    'exclude'     => array(),
                    'meta_key'    => '',
                    'meta_value'  =>'',
                    'suppress_filters' => true, 
                ]);
                if (!empty($lastPosts)): ?>
                	<div class="last-posts-list row">
						<div class="container">
							<h2>Недвижимость</h2>
							<div class="row no-gutters">
							<?php foreach( $lastPosts as $post ):
								setup_postdata($post); 
        					?>
								<div class="last-post-single col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="last-post-single-top">
									    <?php if(get_the_post_thumbnail_url($post->ID)): ?>
										    <img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>">
										<?php endif; ?>
									</div>
									<div class="last-product-single-bottom">
										<h4>
											<a href="<?php echo $post->guid; ?>"><?php echo $post->post_title; ?></a>
										</h4>
										<span class="last-product-single-city"><?php echo get_the_title(get_field('cities', $post->ID)[0]); ?></span>
										<?php
										$custom_fields = get_fields($post->ID);
										if (!empty($custom_fields)):
										?>
										<table class="custom-info-table custom-info-table--list">
											<?php foreach($custom_fields as $key => $value): ?>
												<?php if ($value && substr($key, 0, 3) !== 'img'): ?>
													<?php if($key != 'cities'): ?>
													<tr>
														<td><?php echo get_field_object($key)['label']; ?></td>
														<td><?php echo $value.($key == 'price' ? ' ₽' : ''); ?></td>
													</tr>	
													<?php endif; ?>	
											<?php endif; endforeach; endif; ?>
										</table>
									</div>
								</div>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
					<a href="/apartments" class="more-posts-btn">Смотреть все объекты</a>
				<?php endif; ?>


				<?php
                //Получаем города
                $cities = get_posts([
                	'post_type' => 'cities',
                    'numberposts' => 4,
                    'orderby'     => 'date',
                    'order'       => 'DESC',
                    'include'     => array(),
                    'exclude'     => array(),
                    'meta_key'    => '',
                    'meta_value'  =>'',
                    'suppress_filters' => true, 
                ]);
                if (!empty($cities)): ?>
                	<div class="last-posts-list row">
						<div class="container">
							<h2>Города</h2>
							<div class="row no-gutters">
							<?php foreach( $cities as $city ):
								setup_postdata($city); 
        					?>
								<div class="last-post-single col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="last-post-single-top">
										<img src="<?php echo get_the_post_thumbnail_url($city->ID); ?>">
									</div>
									<div class="last-product-single-bottom">
										<h4>
											<a href="<?php echo $city->guid; ?>"><?php echo $city->post_title; ?></a>
										</h4>
									</div>
								</div>
							<?php endforeach; ?>
							</div>
						</div>
					</div>
					<a href="/cities" class="more-posts-btn">Смотреть все города</a>
				<?php endif; ?>

				<div class="add-post">
					<h3>Добавить недвижимость</h3>
					<form id="add-post-form" method="post" action="<?php bloginfo('template_url'); ?>/../understrap-child/handler.php" class="form-horizontal form-row" enctype="multipart/form-data">
						<div class="form-group col-md-4">
							<label for="formTitle">Название</label>
							<input name="title" type="text" class="form-control" id="formTitle" placeholder="Введите название объявления" required>
						</div>
						<?php 
						$formCities = get_posts([
		                	'post_type' => 'cities',
		                    'numberposts' => -1,
		                    'orderby'     => 'date',
		                    'order'       => 'DESC',
		                    'include'     => array(),
		                    'exclude'     => array(),
		                    'meta_key'    => '',
		                    'meta_value'  =>'',
		                    'suppress_filters' => true, 
		                ]);
                		if (!empty($formCities)): ?>
						<div class="form-group col-md-4">
							<label for="formCity">Населенный пункт</label>
							<select name="city" class="form-control" id="formCity" required>
								<option value="none" selected disabled>Выберите населенный пункт</option>
								<?php foreach($formCities as $city): setup_postdata($city); ?>
									<option value="cityId_<?php echo $city->ID; ?>"><?php echo $city->post_title; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<?php endif; ?>
						<div class="form-group col-md-4">
							<label for="formAddress">Адрес</label>
							<input name="address" type="text" class="form-control" id="formAddress" placeholder="Введите адрес недвижимости" required>
						</div>
						<?php 
						$formTypes = get_terms('ap_type', 'orderby=name&hide_empty=0');
                		if (!empty($formTypes)): ?>
						<div class="form-group col-md-4">
							<label for="formType">Тип недвижимости</label>
							<select name="ac_type" class="form-control" id="formType" required>
								<option value="none" selected disabled>Выберите тип</option>
								<?php foreach($formTypes as $type): ?>
									<option value="typeId_<?php echo $type->term_id; ?>"><?php echo $type->name; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<?php endif; ?>
						<div class="form-group col-md-4">
							<label for="formArea">Площадь</label>
							<input name="area" type="text" class="form-control" id="formArea" placeholder="Введите общую площадь">
						</div>
						<div class="form-group col-md-4">
							<label for="formLivingArea">Жилая площадь</label>
							<input name="livingArea" type="text" class="form-control" id="formLivingArea" placeholder="Введите жилую общую площадь">
						</div>
						<div class="form-group col-md-4">
							<label for="formFloor">Этаж</label>
							<input name="floor" type="number" min="0" class="form-control" id="formFloor" placeholder="Введите этаж">
						</div>
						<div class="form-group col-md-4">
							<label for="formPrice">Стоимость</label>
							<input name="price" type="number" min="0" class="form-control" id="formPrice" placeholder="Введите стоимость" required>
						</div>
						<div class="form-group col-md-12">
							<label for="formContent">Описание</label>
							<textarea name="description" class="form-control" id="formContent" rows="3"></textarea>
						</div>
						<div class="form-group col-md-12 form-group-file">
							<input type="file" name="img_1" class="custom-file-input" id="formImg1">
							<label class="custom-file-label" for="formImg1">Загрузите фотографию</label>
						</div>
						<div class="form-group col-md-12 form-group-file" style="display:none;">
							<input type="file" name="img_2" class="custom-file-input" id="formImg2">
							<label class="custom-file-label" for="formImg2">Загрузите фотографию</label>
						</div>
						<div class="form-group col-md-12 form-group-file" style="display:none;">
							<input type="file" name="img_3" class="custom-file-input" id="formImg3">
							<label class="custom-file-label" for="formImg3">Загрузите фотографию</label>
						</div>
						<div class="form-group col-md-12 form-group-file" style="display:none;">
							<input type="file" name="img_4" class="custom-file-input" id="formImg4">
							<label class="custom-file-label" for="formImg4">Загрузите фотографию</label>
						</div>
						<div class="form-group col-md-12 form-group-file" style="display:none;">
							<input type="file" name="img_5" class="custom-file-input" id="formImg5">
							<label class="custom-file-label" for="formImg5">Загрузите фотографию</label>
						</div>
						<div class="form-group col-md-12 form-group-file" style="display:none;">
							<input type="file" name="img_6" class="custom-file-input" id="formImg6">
							<label class="custom-file-label" for="formImg6">Загрузите фотографию</label>
						</div>
						<div class="form-group col-md-12 form-group-file" style="display:none;">
							<input type="file" name="img_7" class="custom-file-input" id="formImg7">
							<label class="custom-file-label" for="formImg7">Загрузите фотографию</label>
						</div>
						<div class="form-group col-md-12 form-group-file" style="display:none;">
							<input type="file" name="img_8" class="custom-file-input" id="formImg8">
							<label class="custom-file-label" for="formImg8">Загрузите фотографию</label>
						</div>
						<div class="form-group col-md-12 form-group-file" style="display:none;">
							<input type="file" name="img_9" class="custom-file-input" id="formImg9">
							<label class="custom-file-label" for="formImg9">Загрузите фотографию</label>
						</div>
						<div class="form-group col-md-12 form-group-file" style="display:none;">
							<input type="file" name="img_10" class="custom-file-input" id="formImg10">
							<label class="custom-file-label" for="formImg10">Загрузите фотографию</label>
						</div>
						<a href="#" id="add-img-btn">Добавить еще изображение</a>

						<div class="form-group col-md-12">
							<input type="hidden" name="sended" value="1">
							<button id="add-post-btn" type="submit" class="btn btn-primary">Добавить</button>
						</div>
					</form>
					<p class="success-message" style="display:none;">Ваше заявка отправлена и ждет модерацию, спасибо!</p>
				</div>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #page-wrapper -->

<?php get_footer(); ?>
