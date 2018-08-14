<section class="section-docs">
<div class="container">
	<div class="row">
		<div class="col-sm-8"> 
			<div class="docs-items-wrapper"> 
			<h1>Documents</h1>  
			<h2><?php single_cat_title();?></h2>  
			
			<?php echo category_description(); ?> 
			<ul>
			         
					<?php  while ( have_posts() ) :the_post(); // standard WordPress loop. ?>
				<?php //while ( have_posts() ) : the_post(); ?>
				<li><a href="<?php the_permalink(); ?>">
					<?php the_title(); ?>
					</a>
				</li>
				<?php endwhile; 
				$big = 999999999; // need an unlikely integer
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
			</ul>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="sidebar">  
				<div class="widget-container">
	                <?php
	                if(is_active_sidebar('documents-widget')){
	                    dynamic_sidebar('documents-widget');
	                }
	                ?>
	            </div>
			</div>
		</div>
	</div>
</div>
</section> 
<?php wp_reset_postdata(); ?>
