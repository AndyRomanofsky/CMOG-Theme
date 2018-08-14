<?php 
$content_cols = '12';
//if ($form = get_field('resource_gated_gravity_form')) $content_cols = '8';
?>
<div class="terminoglies-content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-<?php echo $content_cols; ?>">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header>
						<h1 class="page-title">
							<?php the_title(); ?>(singles)
						</h1>
					</header>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
			</div>
		</div>
	</div>
</div>