<?php
function get_cpt_labels($names){
    $name = $names;
    $labels  = array(
        'name'               => _x( $name[0], 'post type general name', $name[4] ),
        'singular_name'      => _x( $name[1], 'post type singular name',  $name[4] ),
        'menu_name'          => _x( $name[0], 'admin menu',  $name[4] ),
        'name_admin_bar'     => _x( $name[1], 'add new on admin bar',  $name[4] ),
        'add_new'            => _x( 'Add New '. $name[1], $name[4] ),
        'add_new_item'       => __( 'Add New '. $name[1], $name[4] ),
        'new_item'           => __( 'New '. $name[1], $name[4] ),
        'edit_item'          => __( 'Edit '. $name[1], $name[4] ),
        'view_item'          => __( 'View '. $name[1], $name[4] ),
        'all_items'          => __( 'All '. $name[0], $name[4] ),
        'search_items'       => __( 'Search ' . $name[0], $name[4] ),
        'parent_item_colon'  => __( 'Parent '. $name[0] .':', $name[4] ),
        'not_found'          => __( 'No '. $name[2] .' found.', $name[4] ),
        'not_found_in_trash' => __( 'No '. $name[2] .' found in Trash.', $name[4] )
    );
    return  $labels;
}

function get_cpt_args($labels, $archive_slug){
    $args = array(
        'labels'              => $labels,
        'exclude_from_search' => false,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'capability_type'     => 'post',
        'has_archive'         => true,//__( $archive_slug, 'cmog' ),
        'hierarchical'        => false,
        'show_in_nav_menus'   => false,
		'taxonomies'		  => array( 'post-tag'),
        'supports'            => array( 'title', 'editor', 'has_archive', 'show_in_nav_menus', 'thumbnail', 'custom-fields',  'revisions','post-formats' ),
    );
    return $args;
}




// Pages
// add Template Column to page listing
 
function my_custom_pages_columns( $columns ) {
 	$myCustomColumns = array(
		'template' =>  __( 'Template')
	);
	$columns = array_merge( $columns, $myCustomColumns );

	unset(
		$columns['comments']
	);
	return $columns;
}
function custom_admin_css() {	
echo '<style type="text/css">	
	td.column-template { width: 150px; }
	th.column-template { width: 150px; }
</style>
';
}
add_action('admin_head', 'custom_admin_css');

function custom_page_column_content( $column_name, $post_id ) {
	if ( $column_name == 'template' ) {
		$page_template = get_field( '_wp_page_template' );
		if ( $page_template) {
			$page_template = str_replace ( "default" , " " , $page_template );
			$page_template = str_replace ( "template-" , "(" , $page_template );
			$page_template = str_replace ( ".php" , ")" , $page_template );
			echo $page_template;
		}
	}
}

add_filter( 'manage_pages_columns', 'my_custom_pages_columns' );
add_action( 'manage_pages_custom_column', 'custom_page_column_content', 10, 2 );




foreach (glob(get_template_directory() . "/inc/cpt/*.php") as $filename) {
  include $filename;
}
// Mix some post types when getting tags
// Show posts of 'post', 'page' and 'cpt_histories' 'cpt_articles' 'cpt_readings' post types on home page
add_action( 'pre_get_posts', 'add_my_post_types_to_query' );
//
function add_my_post_types_to_query( $query ) {
  if ( is_tag() && $query->is_main_query() )
    $query->set( 'post_type', array( 'post', 'page', 'cpt_histories' ,'cpt_articles', 'cpt_readings', 'cpt_terminologies', 'cpt_prayers') );
  return $query;
}
?>