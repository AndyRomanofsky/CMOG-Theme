<?php 
$content_cols = '12';
if ($form = get_field('resource_gated_gravity_form')) $content_cols = '8';
?>
<div class="container">
	<div class="row">
		<div class="col-sm-<?php echo $content_cols; ?>">
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
					<?php the_field("resources_main_text"); ?>
					<?php $file = get_field("resource_download"); ?>
					<?php if($file) : ?>
						<p><a target="_BLANK" class="btn-link" href="<?php echo  $file; ?>">Read More</a></p>
					<?php endif; ?>
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