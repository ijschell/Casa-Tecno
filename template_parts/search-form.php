<?php
$smarket_used_header = smarket_option( 'smarket_used_header', 'style-01' );
$selected = '';
if( isset( $_GET['product_cat']) && $_GET['product_cat'] ){
    $selected = $_GET['product_cat'];
}
$args = array(
    'show_option_none' => esc_html__( 'Todas las categorías', 'smarket' ),
    'taxonomy'          => 'product_cat',
    'class'             => 'categori-search-option',
    'hide_empty'        => 1,
    'orderby'           => 'name',
    'order'             => "asc",
    'tab_index'         => true,
    'hierarchical'      => true,
    'id'                => rand(),
    'name'              => 'product_cat',
    'value_field'       => 'slug',
    'selected'          => $selected,
    'option_none_value' => '0',
);

if( in_array($smarket_used_header,array())){

}else{
    ?>
    <form method="get" action="<?php echo esc_url( home_url( '/' ) ) ?>" class="form-search form-search-width-category">

        <div class="form-content">
            <div class="inner">
                <input type="text" class="input" name="s" value ="<?php echo esc_attr( get_search_query() );?>" placeholder="<?php esc_html_e('Search entire store here...','smarket');?>">

            </div>
        </div>
        <?php if( class_exists( 'WooCommerce' ) ): ?>
            <input type="hidden" name="post_type" value="product" />
            <input type="hidden" name="taxonomy" value="product_cat">
            <div class="category">
                <?php wp_dropdown_categories( $args ); ?>
            </div>
        <?php endif; ?>
        <button class="btn-search" type="submit"><?php esc_html_e('Search','smarket');?></button>
    </form><!-- block search -->
    <?php
}
