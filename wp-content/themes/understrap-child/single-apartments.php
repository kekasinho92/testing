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
					<?php $aparmentId = get_the_ID(); ?>

					<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
						<header class="entry-header">

							<?php
							the_title(
								sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ),
								'</a></h2>'
							);
							?>

							<?php if ( 'post' == get_post_type() ) : ?>

								<div class="entry-meta">
									<?php understrap_posted_on(); ?>
								</div><!-- .entry-meta -->

							<?php endif; ?>

						</header><!-- .entry-header -->

						<?php echo get_the_post_thumbnail( $post->ID, 'large' ); ?>

						<div class="entry-content">

							<?php the_content(); ?>

							<?php
							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . __( 'Pages:', 'understrap' ),
									'after'  => '</div>',
								)
							);
							?>

						</div><!-- .entry-content -->

						<div class="entry-custom-info">
							<?php
							$custom_fields = get_fields(get_the_ID());
							global $aparmentId;
							if (!empty($custom_fields)):
							?>
							<table class="custom-info-table">
								<?php foreach($custom_fields as $key => $value): ?>
									<?php if ($value && substr($key, 0, 3) !== 'img'): ?>
										<?php if($key != 'cities'): ?>
										<tr>
											<td><?php echo get_field_object($key)['label']; ?></td>
											<td><?php echo $value.($key == 'price' ? ' ₽' : ''); ?></td>
										</tr>
										<?php else: ?>
										<tr>
											<td><?php echo get_field_object($key)['label']; ?></td>
											<td><?php echo get_the_title(get_field('cities', $aparmentId)[0]); ?></td>
										</tr>	
										<?php endif; ?>	
								<?php endif; endforeach; ?>
							</table>
							<div class="swiper-container">
								<div class="swiper-wrapper">
									<?php
										$imgArray = []; 
										foreach($custom_fields as $key => $value) {
											if (substr($key, 0, 3) == 'img' && $value) {
												array_push($imgArray, $value);
											}
										}
									?>
									<?php foreach($imgArray as $path): ?>
											<div class="swiper-slide">
												<a href="<?php echo $path; ?>" data-fancybox="gallery">
													<img src="<?php echo $path; ?>">
												</a>
											</div>
									<?php endforeach; ?>
								</div>
								<!-- If we need pagination -->
							    <div class="swiper-pagination"></div>

							    <!-- If we need navigation buttons -->
							    <div class="swiper-button-prev"></div>
							    <div class="swiper-button-next"></div>
							</div>
						<?php endif; ?>
						</div>

						<footer class="entry-footer">

							<?php understrap_entry_footer(); ?>

						</footer><!-- .entry-footer -->

					</article><!-- #post-## -->

					<?php understrap_post_nav(); ?>

					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
					?>

				<?php endwhile; // end of the loop. ?>

			</main><!-- #main -->

			<!-- Do the right sidebar check -->
			<?php get_template_part( 'global-templates/right-sidebar-check' ); ?>

		</div><!-- .row -->

	</div><!-- #content -->

</div><!-- #single-wrapper -->

<?php get_footer(); ?>
