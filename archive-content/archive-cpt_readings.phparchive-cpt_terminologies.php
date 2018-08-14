<section class="section-terminologies">
<div class="container">
	<div class="row">
		<div class="col-sm-8"> 
			<dl class="terminologies-items-wrapper"> 
			<h1>Terminology</h1>  
			<?php $cat_title = single_cat_title() ;?>
			<h2><?php echo  $cat_title;?></h2>
			<br>
			<?php echo category_description(); ?> 
			


					<!-- pagination here -->

					<!-- the loop -->
					<ul>
					<?php  while ( have_posts() ) :the_post(); // standard WordPress loop. ?> 
						<li> <a href="<?php the_permalink(); ?>">
									<?php the_title(); ?> 
									</a> <?php the_excerpt(); ?></li>
					<?php endwhile; ?>
					</ul>
					<!-- end of the loop -->

					<!-- pagination here -->
					<?php	
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
					<?php wp_reset_postdata(); ?>



			</dl>
		</div>
		<div class="col-sm-4">
			<div class="sidebar">  
				<div class="widget-container">
	                <?php
	                if(is_active_sidebar('terminologies-widget')){
	                    dynamic_sidebar('terminologies-widget');
	                }
	                ?>
	            </div>
			</div>
		</div>
	</div>
</div>
</section> 
<?php wp_reset_postdata(); ?>
