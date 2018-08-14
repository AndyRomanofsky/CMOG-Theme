<?php get_header(); ?>
<?php 
<p>[catGORY]</p>
 $query_type = get_post_type();

  $post_type = get_queried_object();

  $slug = property_exists($post_type,'rewrite' ) ? $post_type->rewrite['slug'] : $post_type->slug;
  $page = get_page_by_path( $slug , OBJECT , 'page' );

  if($page) {
    query_posts('post_type=page&p='.$page->ID);
  include get_template_directory() . '/inc/inline_bands.php';
  }
$debug_info =  "categorgy categorgy: ";
$debug_info .=  $is_category)

if ( $query_type ) :
  wp_reset_query();
    $post_type_data = get_post_type_object( $query_type );
    $post_type_slug = $post_type_data->rewrite['slug'];
    get_template_part( 'archive-content/archive',  $query_type  );
endif;
?>
<?php get_footer(); ?>