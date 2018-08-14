<?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <?php echo '<h2 class="search-query">' . sprintf( esc_html__( 'Search Results for: %s', '_aac' ), '<span>' . get_search_query() . '</span>' ) . '</h2>'; ?>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <div class="search-result-wrapper">
                     <header class="entry-header">
                         <?php the_title( sprintf( '<div class="entry-title"><h3><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3></div>' ); ?>
                     </header><!-- .entry-header -->
                      <div class="entry-summary">
                        <?php $excerpt = aac_get_post_excerpt($post->ID); ?>
                        <?php echo $excerpt; ?>
                      </div><!-- .entry-summary -->
                    </div>
                </article><!-- #post-## -->
            <?php endwhile; ?>
            <?php else : ?>
                    <p>
                     <?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', '_aac' ); ?>
                    </p>
                    <?php get_search_form(); ?>
                    <p>
                     <?php _e( 'Or try one of these pages:', '_aac' ); ?>
                    </p>
                    <?php wp_nav_menu( array( 'theme_location' => 'sitemap-menu','depth' => 1,'container' => 'div','menu_class' => 'nav navbar-nav sitemap-content','menu_id' => 'sitemap-menu', ) ); ?>
            <?php endif; ?>
        </div>
    </div>
</div>
    <?php echo pagination(false); ?>
</div>
<?php get_footer(); ?>