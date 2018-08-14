<?php 
	if(!$mobile_flip = get_sub_field("mobile_flip")) $mobile_flip = false;
	$left_columns = 6;
	$left_columns = get_sub_field("left_content_columns");
?>
<div class="container">
	<div class="band band-2-col <?php echo $class; ?>">
	
		<div class="row">
			<?php echo content_block_html(get_sub_field("content_blocks_left_content"), get_sub_field("content_blocks_right_content"), $left_columns, $mobile_flip); ?>
		</div>
	</div>
</div>