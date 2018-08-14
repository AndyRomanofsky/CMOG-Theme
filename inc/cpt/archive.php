<?php get_header(); ?>
<?php 
 $query_type = get_post_type();

  $post_type = get_queried_object();

  $slug = property_exists($post_type,'rewrite' ) ? $post_type->rewrite['slug'] : $post_type->slug;
  $page = get_page_by_path( $slug , OBJECT , 'page' );

  if($page) { ?>
	<div class="container">
<?php   query_posts('post_type=page&p='.$page->ID); 
		include get_template_directory() . '/inc/inline_bands.php';
?>
	</div >
<?php  }
if ( $query_type ) {echo $query_type;
  wp_reset_query();
    $post_type_data = get_post_type_object( $query_type );
   //echo "<div class='archive_empty'><h2>Archive</h2><br>'" . $query_type . "' Archive items found<br>";
    $post_type_slug = $post_type_data->rewrite['slug'];
	//echo "<br>'" .  $post_type_slug ."'<br></div>";
    get_template_part( 'archive-content/archive',  $query_type  );
	}else{
   echo "<div class='archive_empty'><h2>Archive</h2><br>Archive items not found<br></div>";
	}
?>
<?php get_footer(); ?>
