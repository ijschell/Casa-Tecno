<?php
// Setting

$data_reponsive = array(
	'0'    => array(
		'items' => 1,
	),
	'480'  => array(
		'items' => 1,
	),
	'768'  => array(
		'items' => 2,
	),
	'992'  => array(
		'items' => 3,
	),
	'1200' => array(
		'items' => 4,
	),
);
$data_reponsive = json_encode( $data_reponsive );
$loop           = false;

$categories = get_the_terms( get_the_ID(), 'portfolio_category' );

if ( $categories ) :
	$category_ids = array();
	foreach ( $categories as $individual_category ) {
		$category_ids[] = $individual_category->term_id;
	}

	$args      = array(
		'post_type'           => 'portfolio',
		'tax_query'           => array(
			array(
				'taxonomy' => 'portfolio_category',
				'field'    => 'term_id',
				'terms'    => $category_ids,
			),
		),
		'post__not_in'        => array( get_the_ID() ),
		'posts_per_page'      => 10,
		'ignore_sticky_posts' => 1,
		'orderby'             => 'rand',
	);
	$new_query = new wp_query( $args );
	$count     = $new_query->post_count;
	if ( $count > 4 ) {
		$loop = true;
	}
	?>
	<?php if ( $new_query->have_posts() ) : ?>
    <div class="related post">
        <h2 class="related-title smarket-title style-2"><?php echo esc_html__( 'related work', 'smarket' ); ?></h2>
        <div class="portfolio-related owl-carousel nav-awesome" data-dots="false" data-nav="true"
             data-loop="<?php echo esc_attr( $loop ); ?>" data-margin="30"
             data-loop="true" data-responsive='<?php echo esc_attr( $data_reponsive ); ?>'>
			<?php while ( $new_query->have_posts() ): $new_query->the_post(); ?>
				<?php get_template_part( 'templates/portfolio/content-style/style', '1' ); ?>
			<?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>
<?php endif;
wp_reset_postdata();