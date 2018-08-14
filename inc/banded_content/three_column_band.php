<div class="band band-3-col <?php echo $class; ?>">
	<div class="container">
		<div class="row">
			<?php if($title = the_sub_field("title")) : ?>
			<div class="col-sm-12">
				<?php echo $title; ?>
			</div>
			<?php endif; ?>
			<div class="col-sm-4">
				<?php the_sub_field("content_blocks_left_content"); ?>
			</div>
			<div class="col-sm-4">
				<?php the_sub_field("content_blocks_middle_content"); ?>
			</div>
			<div class="col-sm-4">
				<?php the_sub_field("content_blocks_right_content"); ?>
			</div>
		</div>
	</div>
</div>