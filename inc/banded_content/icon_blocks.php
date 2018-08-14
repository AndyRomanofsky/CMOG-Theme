<?php 
$cols = count(get_sub_field('icon_blocks'));
$dynamic = get_sub_field('dynamic_width'); 
$width = 4;
$offset = "";
$link = '';
if(!$dynamic){
	if($cols == 1){
		$width = 12;
	}
	elseif($cols == 2){
		$width = 6;
	}
	elseif($cols == 3){
		$width = 4;
	}
	elseif($cols == 4){
		$width = 3;
	}
}
else{
	if($cols == 1){
		$offset = ' col-sm-offset-4';
	}
	elseif($cols == 2){
		$offset = ' col-sm-offset-2';
	}
}
?>
<div class="band band-icon-blocks <?php echo $class; ?>">
	<div class="container">
		<div class="row">
				<?php while ( have_rows('icon_blocks') ) : the_row(); ?>
				<?php if($link = get_sub_field('icon_link')) : ?>
					<a href="<?php echo $link; ?>">
				<?php endif; ?>
					<div class="col-sm-<?php echo $width; echo $offset;?>">
							<div class="item-wrapper <?php the_sub_field('icon_color');?>">
								<span class="<?php the_sub_field('icon_type');?>"></span>
								<?php the_sub_field('icon_content'); ?>
							</div>
					</div>
				<?php if($link) : ?>
					</a>
				<?php endif; ?>
				<?php $offset = ""; endwhile; ?>
		</div>
	</div>
</div>