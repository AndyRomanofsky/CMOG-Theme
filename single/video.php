<?php 
$content_cols = '12';
if ($form = get_field('resource_gated_gravity_form')) $content_cols = '8';
?>
<div class="container">
	<div class="row">
		<div class="col-sm-<?php echo $content_cols; ?>">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header>
					<h1 class="page-title">
						<?php the_title(); ?>
					</h1>
				</header>
				<div class="entry-content resource-video-container">
					<?php the_content(); ?>
				</div>
			</article>
		</div>
	    <?php if ( $form ) : ?>
	        <div class="col-sm-<?php echo (12-$content_cols);?>">
	        	<?php echo do_shortcode($form); ?>
	        </div>
	    <?php endif; ?>
	</div>
</div>