<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<h1>The page cannot be found</h1>
			<p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
			<ul class="sitemap-content">
				<?php wp_nav_menu(array('theme_location' => 'main-menu')); ?>
			</ul>
		</div>
	</div>
</div>
<?php get_footer(); ?>