
<section class="section-organizations">
<div class="container">
	<div class="row">
		<div class="col-sm-8"> 
			<dl class="organizations-items-wrapper"> 
			<h1>Organizations</h1>  
			<h2><?php single_cat_title() ;?></h2>
			<br>
			<?php echo category_description(); ?> 
			 <?php  while ( have_posts() ) :the_post(); // standard WordPress loop. ?>
				<?php //while ( have_posts() ) : the_post(); ?>
				<dt><a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
					</a></dt>
				<dd><?php the_excerpt(); ?>
				</dd>
				<?php 
				endwhile; 
				$big = 999999999;
				?>
				<div class="pagination">
					<div class="row">
						<div class="col-sm-8"><?php 
							  echo paginate_links( array(
								'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total' => $wp_query->max_num_pages,
							) );
						?>
						</div>  
					</div>
				</div>
			</dl>
		</div>
		<div class="col-sm-4">
			<div class="sidebar">  
				<div class="widget-container">
	                <?php
	                if(is_active_sidebar('organizations-widget')){
	                    dynamic_sidebar('organizations-widget');
	                }
	                ?>
	            </div>
			</div>
		</div>
	</div>
</div>
</section> 
<?php wp_reset_postdata(); ?>

