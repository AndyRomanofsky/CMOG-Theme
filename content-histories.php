
<section class="section-histories">
<div class="container">
	<div class="row">
		<div class="col-sm-8"> 
			<div class="histories-items-wrapper"> 
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header>
                    <h1 class="page-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?> 
					<?php global $page, $numpages, $multipage, $more; ?>
					<?php if ($multipage) {
					echo "(Page " . $page . " of " . $numpages .")";
					}
					?></a></h1>
					<div class="article-tools"><?php live_link(); ?><?php cmog_post_info();?></div>
                </header><!-- .entry-header -->

                <?php if ( is_search() || is_archive() ) : // Only display Excerpts for Search and Archive Pages ?>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div><!-- .entry-summary -->
                <?php else : ?>
					<?php wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'cmog' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'separator'   => ' | ',
						) );
					?>			
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->
					<?php wp_link_pages('next_or_number=next&before=&separator= | '); ?>
                <?php endif; ?>
            </article><!-- #post-## -->
			</div>
		</div>
		<div class="col-sm-4">
			<div class="sidebar">  
				<div class="widget-container">
	                <?php
	                if(is_active_sidebar('history-widget')){
	                    dynamic_sidebar('history-widget');
	                }
	                ?>
	            </div>
			</div>
		</div>
	</div>
</div>
</section> 
<?php wp_reset_postdata(); ?>
