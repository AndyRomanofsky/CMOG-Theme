<?php 
if(get_sub_field("title")) {
	$content =  get_sub_field("title");
$content = '<' . get_sub_field('title_type') .'>' . $content . '</' . get_sub_field('title_type').'>' ;
}
elseif(!isset($content) ) {
	$content = '<h1>' . apply_filters( 'aac_hero_heading', get_the_title() ) . '</h1>';
}
elseif(isset($content) && $content) {
	$title =  $content;
}
?>
<?php if( $img = get_sub_field("image")) : ?>
	<div class="band band-hero <?php echo $class; ?>" style="background-image: url('<?php echo $img['url']; ?>');">
<?php endif; ?>
<?php $excerpt = get_sub_field("excerpt"); ?>
	<?php if($content || $excerpt) : ?>
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
	            	<div class="hero-text-wrapper">
	            		<?php if($content) : ?>
							<?php echo $content; ?>
						<?php endif; ?>
	            		<?php if($excerpt) : ?>
							<?php echo $excerpt; ?>
						<?php endif; ?>
	            	</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</div>