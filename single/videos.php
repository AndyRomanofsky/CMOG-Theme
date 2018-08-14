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
					<div class="entry-content resource-video-container">
					<?php the_content(); ?>
					<?php if($video_id = getYouTubeVideoId(get_field('resource_video_url'))) : ?>
					    <div class="main-video-wrapper">
					        <div class="embed-responsive embed-responsive-16by9">
					            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $video_id; ?>?rel=0&amp;showinfo=0" width="100%" height="100%" frameborder="0" allowfullscreen></iframe>
					        </div>
					    </div>
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
</div>