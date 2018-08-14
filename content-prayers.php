
<section class="section-prayers">
<div class="container">
	<div class="row">
		<div class="col-sm-8"> 
			<div class="prayers-items-wrapper"> 
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header>
                    <h1 class="page-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<div class="article-tools"><?php live_link(); ?><?php cmog_post_info();?></div>
                </header><!-- .entry-header -->

                <?php if ( is_search() || is_archive() ) : // Only display Excerpts for Search and Archive Pages ?>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div><!-- .entry-summary -->
                <?php else : ?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div><!-- .entry-content -->
                <?php endif; ?>
            </article><!-- #post-## -->
			</div>
		</div>
		<div class="col-sm-4">
			<div class="sidebar">  
				<div class="widget-container">
	                <?php
	                if(is_active_sidebar('prayers-widget')){
	                    dynamic_sidebar('prayers-widget');
	                }
	                ?>
	            </div>
			</div>
		</div>
	</div>
</div>
</section> 
<?php wp_reset_postdata(); ?>
