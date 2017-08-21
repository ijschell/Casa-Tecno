<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package KuteTheme
 * @subpackage smarket
 * @since smarket 1.0
 */

get_header();
?>
<div class="main-container no-sidebar">
    <?php get_template_part( 'template_parts/part', 'breadcrumb' ); ?>
    <div class="container-wapper">
        <div class="row">
            <div class="main-content col-sm-12">
                <?php while ( have_posts() ): the_post() ?>
                    <div <?php post_class( 'post-item' ); ?>>
                        <div class="post-header">
                            <h3 class="post-name">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <div class="post-metas">
                                <span class="author">
                                    <img src="<?php echo get_template_directory_uri() . '/images/user.png' ?>"
                                         alt="">
                                    <?php esc_html_e( 'By:', 'smarket' ); ?> <?php the_author(); ?>
                                </span>
                                <span class="time">
                                    <img src="<?php echo get_template_directory_uri() . '/images/calendar.png' ?>"
                                         alt=""><?php echo get_the_date( 'M, d, Y' ); ?>
                                </span>
                            </div>
                        </div>
                        <div class="post-thumb">
                            <?php the_post_thumbnail( 'full' ); ?>
                        </div>
                        <div class="post-detail">
                            <div class="post-content"><?php the_content(); ?></div>
                        </div>
                        <div class="post-footer">
                            <?php get_template_part( 'templates/blogs/blog', 'share' ); ?>
                            <?php
                            the_post_navigation( array(
                                    'prev_text' => '<span class="screen-reader-text"><i class="fa fa-caret-left"></i>' . esc_html__( 'Previous', 'smarket' ) . '</span>',
                                    'next_text' => '<span class="screen-reader-text">' . esc_html__( 'Next', 'smarket' ) . '<i class="fa fa-caret-right"></i></span>',
                                )
                            );
                            ?>
                        </div>
                    </div>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>