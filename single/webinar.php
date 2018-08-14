<?php 
$content_cols = '12';
if ($form = get_field('resource_gated_gravity_form')) $content_cols = '8';
?>
<div class="resource-content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-sm-<?php echo $content_cols; ?>">
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header>
						<h1 class="page-title">
							<?php the_title(); ?>
						</h1>
					</header>
					<div class="entry-content">
						<?php the_content(); ?>
					</div>
				</article>
				<?php if($external_url = get_field('resource_external_url')) : ?>
				    <div class="external-url-wrapper">
				        <a target='_BLANK' href='<?php echo $external_url;?>'>Watch Webinar</a>
				    </div>
				<?php endif; ?>
			</div>
		    <?php if ( $form ) : ?>
		        <div class="col-sm-<?php echo (12-$content_cols);?>">
		        	<?php echo do_shortcode($form); ?>
		        </div>
		    <?php endif; ?>
		</div>
	</div>
</div>