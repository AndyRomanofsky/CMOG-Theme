<?php get_header(); ?>
<?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
        <?php
        /*get_template_part( 'content', get_post_format() );*/
        get_template_part( 'content', 'blog' );
        ?>
    <?php endwhile; ?>
<?php else : ?>
    <?php get_template_part( 'no-results', 'index' ); ?>
<?php endif; ?>
<?php get_footer(); ?>