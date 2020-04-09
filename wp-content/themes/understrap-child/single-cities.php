<?php
/**
 * The template for displaying all single posts.
 *
 * @package understrap
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

get_header();
$container = get_theme_mod( 'understrap_container_type' );
?>

<div class="wrapper" id="single-wrapper">

	<div class="<?php echo esc_attr( $container ); ?>" id="content" tabindex="-1">

		<div class="row">

			<!-- Do the left sidebar check -->
			<?php get_template_part( 'global-templates/left-sidebar-check' ); ?>

			<main class="site-main" id="main">

				<?php while ( have_posts() ) : the_post(); ?>
					<?php $city_id = get_the_ID(); ?>

					<?php get_template_part( 'loop-templates/content', 'single' ); ?>

					<?php understrap_post_nav(); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>

				<?php
                //Получаем последние объекты недвижимости
                $lastPosts = get_posts([
                	'post_type' => 'apartments',
                    'numberposts' => -1,
                    'orderby'     => 'date',
                    'order'       => 'DESC',
                    'include'     => array(),
                    'exclude'     => array(),
                    'meta_key'    => '',
                    'meta_value'  =>'',
                    'suppress_filters' => true, 
                ]);
                //var_dump($lastPosts);
                if (!empty($lastPosts)): $flag = 0; ?>
                	<div class="last-posts-list row">
						<div class="container">
							<h2>Недвижимость в этом городе</h2>
							<div class="row no-gutters">
							<?php foreach( $lastPosts as $post ):
								global $city_id;
								setup_postdata($post);
								if(get_field('cities', $post->ID)[0] == $city_id): 
        					?>
								<div class="last-post-single col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="last-post-single-top">
										<img src="<?php echo get_the_post_thumbnail_url($post->ID); ?>">
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
							<?php $flag++; endif; endforeach; ?>
							<?php if ($flag == 0): ?>
								<h4>В данном городе пока нет объявлений</h4>
							<?php endif; ?>
							</div>
						</div>
					</div>
				<?php endif; ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php get_footer(); ?>
