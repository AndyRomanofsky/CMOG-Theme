<?php $layout = get_sub_field("content_layout"); ?>
<?php if(!$mobile_flip = get_sub_field("mobile_flip")) $mobile_flip = false; ?>
<div class="band band-key-features-combo <?php echo $class; ?>">
	<div class="container">
		<?php if($title = get_sub_field("title")) : ?>
			<div class="row">
				<div class="col-sm-12">
					<h2><?php echo $title; ?></h2>
				</div>
			</div>
		<?php endif; ?>
		<div class="row">
			<?php echo content_block_html(get_sub_field("content_blocks_left_content"), get_sub_field("content_blocks_right_content"), $layout, $mobile_flip); ?>
		</div>
		<div class="row">
			<div class="col-sm-6 key-features">
				<?php while ( have_rows('icons_left') ) : the_row(); ?>
				<div class="icon"><span class="<?php the_sub_field("icon_type");?>"></span></div>
				<div class="text-block"><?php the_sub_field("text");?></div>
			<?php endwhile; ?>
		</div>
		<div class="col-sm-6 key-features">
			<?php while ( have_rows('icons_right') ) : the_row(); ?>
			<div class="icon"><span class="<?php the_sub_field("icon_type");?>"></span></div>
			<div class="text-block"><?php the_sub_field("text");?></div>
		<?php endwhile; ?>
	</div>
</div>
</div>
</div>