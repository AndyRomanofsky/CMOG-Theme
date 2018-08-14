<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            	<div class="band-top-bottom-padding">
                <header>
                    <h1 class="page-title">
                        <?php the_title(); ?>
                    </h1>
					<div class="article-tools"><?php live_link(); ?><?php cmog_post_info();?></div>
                </header>
                <!-- .entry-header -->
                <div class="entry-content">
                    <div class="entry-content-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div>
                    <?php the_content(); ?>
                </div>
                </div>
            </article>
            <!-- #post-## -->
        </div>
    </div>
</div>
