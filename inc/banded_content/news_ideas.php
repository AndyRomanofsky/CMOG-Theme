<?php if(!$mobile_flip = get_sub_field("mobile_flip")) $mobile_flip = false; ?>
<div class="band band-news <?php echo $class; ?>">
	<div class="container">
		<div class="row">
			<?php echo content_block_html(get_sub_field("content_blocks_left_content"), get_sub_field("content_blocks_right_content"), 6, $mobile_flip); ?>
		</div>
	</div>
</div>