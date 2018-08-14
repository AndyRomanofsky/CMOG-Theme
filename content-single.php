<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            	<div class="band-top-bottom-padding">
                <header>
                    <h1 class="page-title"><?php the_title(); ?></h1>
					<div class="article-tools"><?php live_link(); ?></div>
					<div class="infobox"> 
					
<?php the_category( '&gt; ','multiple' ); ?>


					</div>
                </header><!-- .entry-header -->
				<?php $args = array (
					//'before'            => '<div class="page-links-box"><span class="page-link-text">' . __( 'This has more pages: ', 'textdomain' ) . '</span>',
					//'after'             => '</div>',
					//'link_before'       => '<span class="page-link">',
					//'link_after'        => '</span>',
					  'next_or_number'    => 'next',
					 'separator'         => ' | ',
					 'nextpagelink'      => __( 'Next ', 'textdomain' ),
					 'previouspagelink'  => __( ' Previous', 'textdomain' ),
				);
				?>
				<?php wp_link_pages($args); ?> 			
                <div class="entry-content">
                    <div class="entry-content-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <?php the_content(); ?>
                </div><!-- .entry-content -->
			<?php
			if(get_the_tag_list()) {
				echo get_the_tag_list('<p>This blog entry has Tags: ',', ','</p>');
			}
			?>
				<?php
				$args = array (
					'before'            => '<div class="page-links-box"><span class="page-link-text">' . __( 'This has more pages: ', 'textdomain' ) . '</span>',
					'after'             => '</div>',
					'link_before'       => '<span class="page-link">',
					'link_after'        => '</span>',
					// 'next_or_number'    => 'next',
					 'separator'         => ' | ',
					//'nextpagelink'      => __( 'Next &raquo', 'textdomain' ),
					//'previouspagelink'  => __( '&laquo Previous', 'textdomain' ),
				);
				?>
				<?php wp_link_pages($args); ?> 
                </div> 
            </article><!-- #post-## -->
        </div>
    </div>
</div>