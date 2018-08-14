<?php
/*
Template Name: Sitemap
*/
?>
<?php get_header();?>
<?php 
include get_template_directory() . '/inc/inline_bands.php'; 
	if(!$has_band) :
		$content = '<h1>Sitemap</h1>';
		include get_template_directory() . '/inc/banded_content/hero_band.php';
	endif;
?>
<div class="band-top-bottom-padding">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
					<?php the_content(); ?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<?php wp_nav_menu( array( 'theme_location' => 'site-map','depth' => 3,'container' => 'div','menu_class' => 'site-map','menu_id' => 'site-map',) ); ?>		
			</div>
		</div>
	</div>
</div>	
<?php get_footer(); ?>