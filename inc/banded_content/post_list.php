<?php
$cat_id = get_sub_field('post_category');
$items = get_sub_field('items_to_display');
$layout = get_sub_field('layout');
$hide_date = get_sub_field('hide_date');
$first = true;
if(empty($items) || !is_numeric($items)) $items = 2;
$mypages = get_pages( array( 'parent' => $cat_id->term_id, 'hierarchical' => 0, 'sort_column' => 'post_date', 'sort_order' => 'desc', 'number' => $items  ) );
$mypages  = get_posts(array(
	'category'		=> $cat_id->term_id,
	'post_type'	=> 'post',
	'post_status'	=> 'publish',
	'orderby'		=> 'date',
	'order'            => 'DESC',
	'posts_per_page' => $items 
	));
	?>
	<?php 
	$count = 0;
	$title = get_sub_field('title');
	if(empty($title)) $title = $cat_id->name;
	?>
	<div class="band band-post-list <?php echo $class; ?>">
		<div class="container">
			<?php if ($title <> "none"){ ?>
			<div class="row">
				<div class="col-xs-12">
					<h2><?php echo $title; ?></h2>
				</div>
			</div>
			<?php }?>
				<?php if($layout == "Box") { ?>
						<div class="row">		
						<div class="col-sm-6 post-list-item">
					<?php } ?>	
				<?php foreach( $mypages as $page ): ?>
				<?php $count = $count + 1; ?>
				
				<?php $link =  get_field("external_link", $page->ID);?>
				<?php $post_date = get_the_date( null ,$page->ID ); ?>
				<?php $window = ""; $no_follow = ""?>
				<?php if(empty($link)) :
						$link = get_permalink( $page->ID );  
				      else :
						$window =' target="_blank"';
						$no_follow =' rel="nofollow"';
					  endif;?>
					  
					  
					  
					  
				<?php if($layout == "Box") : ?>
						
						<h3 class="post-item-heading">
							<?php echo $post_date; ?> &ndash; <a href="<?php echo $link;?>"<?php echo $window; echo $no_follow;?>><?php echo $page->post_title; ?></a>
						</h3>
						<p><?php echo get_excerpt_by_id($page->ID); ?></p>
						
						
					<?php $half = intval($items / 2);	?>
					<?php if ($count == $half) { 	?>
					</div>
					<div class="col-sm-6 post-list-item">
					<?php } ?>
					
					
					
				<?php elseif($layout == "List") : ?> 
					<div class="row">		
						<div class="post-list-item">
						<?php if ($hide_date)  { ?>
						<div class="col-sm-12">
						<?php } else { ?>
						<div class="col-sm-3 col-md-2"><p><?php echo $post_date; ?></p></div>
						<div class="col-sm-9 col-md-10">
						<?php } ?>
						<h3><a href="<?php echo $link;?>"<?php echo $window; echo $no_follow; ?>><?php echo $page->post_title; ?></a></h3>
						<p><?php echo get_excerpt_by_id($page->ID); ?></p></div>
						</div>
					</div>		
				<?php endif; ?>
				
				
				
			<?php endforeach; ?>

	
				<?php if($layout == "Box") { ?>
						</div>
					<?php } ?>	
			
				
		</div>
		<?php if($show_more = get_sub_field('show_more_link')) : ?>
			<div class="row show-more">
				<div class="col-sm-12 news-events-btn">
					<a class="btn" href="<?php echo $show_more;?>">Show More</a>
				</div>
			</div>
		<?php endif; ?>
</div>
</div>