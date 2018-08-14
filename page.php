<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php //to display a page use content-page.php  ?>
    <?php get_template_part( 'content', 'page' ); ?>

<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>
