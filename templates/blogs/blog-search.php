<?php
if( have_posts()){
	?>
	<div class="blogs-search">
		<?php
		while( have_posts()){
			the_post();
			?>
			<div <?php post_class('blog-item');?>>
				<h3 class="post-title" style="font-size: 16px; margin-bottom: 10px;"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	smarket_paging_nav();
}else{
	get_template_part('content','none');
}