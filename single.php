<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); ?>
    <?php //to display a post use content-single.php  ?>
    <?php get_template_part( 'content', 'single' ); ?>
<?php endwhile; // end of the loop. ?>
<div class="container">
     <?php comments_template(); ?>
</div>

<?php get_footer(); ?>