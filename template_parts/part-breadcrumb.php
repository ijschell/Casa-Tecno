<?php
$args = array(
    'container'       => 'div',
    'before'          => '',
    'after'           => '',
    'show_on_front'   => true,
    'network'         => false,
    'show_title'      => true,
    'show_browse'     => false,
    'post_taxonomy'   => array(),
    'echo'            => true
);
if(  !is_front_page()){
    ?>
    <div class="breadcrumbs-wapper">
        <div class="container-wapper"><?php smarket_breadcrumb($args); ?></div>
    </div>
    <?php

}
?>