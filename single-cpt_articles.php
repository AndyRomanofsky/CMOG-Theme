<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php //to display a post use content-single.php  ?>
    <?php get_template_part( 'content', 'articles' ); ?>
<?php endwhile; // end of the loop. ?>

<?php get_footer(); ?>