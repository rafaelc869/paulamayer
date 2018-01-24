<?php
$thumb_size = 'gymedge-size2';
$args = array(
	'post_type'      => 'gym_class',
	'posts_per_page' => $slider_item_number,
);

if ( !empty( $cat ) ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'gym_class_category',
			'field' => 'term_id',
			'terms' => $cat,
		)
	);
}
$query = new WP_Query( $args );
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12">
		<div class="owl-wrap rt-owl-nav-1 rt-owl-dot-1 rt-owl-class-1">
			<div class="section-title">
				<h2 class="owl-custom-nav-title"><?php echo esc_html( $title );?></h2>
				<?php if ( $slider_nav === 'true' ): ?>
					<div class="owl-custom-nav">
						<div class="owl-prev"><i class="fa fa-angle-left"></i></div><div class="owl-next"><i class="fa fa-angle-right"></i></div>
					</div>
				<?php endif; ?>
				<div class="owl-custom-nav-bar"></div>
				<div class="clear"></div>
			</div>
			<div class="owl-theme owl-carousel rt-owl-carousel" data-carousel-options="<?php echo esc_attr( $owl_data );?>">
				<?php if ( $query->have_posts() ) :?>
					<?php while ( $query->have_posts() ) : $query->the_post();?>
						<?php
						$id = get_the_id();
						$schedule = get_post_meta( $id, 'gym_class_schedule', true );
						$schedule = ( $schedule != '' ) ? $schedule : array();
						$schedule_limit = apply_filters( 'gym_schedule_limit', false );
						if ( $schedule_limit ) {
							$schedule = array_slice( $schedule, 0, $schedule_limit );
						}
						$trainers = array();

						foreach ( $schedule as $trainer ) {
							$type = !empty( $trainer['trainer'] ) ? get_post_type( $trainer['trainer'] ) : '';
							// if trainer exists
							if ( $type == 'gym_trainer' ) {
								$trainers[] = get_the_title( $trainer['trainer'] );
							}
						}
						$trainers = array_unique( $trainers );
						$trainers_html = implode( ', ', $trainers );
						?>
						<div class="single-item">
							<div class="single-item-content">
								<div class="single-item-image"><?php the_post_thumbnail( $thumb_size );?></div>
								<div class="overly">
									<ul>
										<?php foreach ( $schedule as $time ): ?>
											<?php if ( !empty( $time['week'] ) && !empty( $time['start_time'] ) ): ?>
												<?php
												$start_time = !empty( $time['start_time'] ) ? strtotime( $time['start_time'] ) : false;

												if ( GymEdge::$options['class_time_format'] == '24' ) {
													$start_time = $start_time ? date( "H:i", $start_time ) : '';
												}
												else {
													$start_time = $start_time ? date( "g:ia", $start_time ) : '';
												}
												?>
												<li>
													<ul class="class-slider-ul-child">
														<li><?php echo esc_html( $weeknames[$time['week']] );?></li>
														<li><?php echo esc_html( $start_time );?></li>
													</ul>
												</li>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								</div>
							</div>
							<div class="single-item-meta">
								<h3><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
								<?php if ( !empty( $trainers ) ): ?>
									<span class="author"><i class="fa fa-user"></i><?php echo esc_html( $trainers_html );?></span>
								<?php endif; ?>
							</div>
						</div>
					<?php endwhile;?>
				<?php endif;?>
				<?php wp_reset_query();?>
			</div>
		</div>
	</div>
</div>