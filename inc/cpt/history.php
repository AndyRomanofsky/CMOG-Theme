<?php
/*-----------------------------------------------
----------History Custom Post Type----------    history   histories Histories
-----------------------------------------------*/
add_action( 'init', 'cpt_histories' );
function cpt_histories() {
    $labels = get_cpt_labels(array("Salvation History", 'Salvation History', 'histories', 'history', 'cmog'));
    $icon = get_bloginfo ('template_directory') . '/img/histories.png';
    $slug = 'histories';
    $args = get_cpt_args($labels, $slug);
    $args['rewrite'] = array( 'slug' => $slug, 'with_front' => true );
    $args['taxonomies'] = array( 'histories_categories','post_tag');

    register_post_type( 'cpt_histories', $args);
}
  /*-----------------------------------------------
----------      columns     ----------  no column stuff needed     author_alias
----------------------------------------------- */

function cpt_histories_column_names( $columns ) {
 
        $columns['authora']  =  'Writer';
 
     return $columns ;
}
function cpt_histories_column_data($column) {

    global $post;
    if($column == 'authora')
    {     
		
		the_field('author_alias');
		
    }
}
add_action("manage_posts_custom_column", "cpt_histories_column_data"); 
add_filter( 'manage_cpt_histories_posts_columns', 'cpt_histories_column_names');

/*-----------------------------------------------
----------    Sortable columns     ----------
----------------------------------------------- */
add_filter( 'manage_edit-cpt_histories_sortable_columns', 'my_sortable_histories_column' );
function my_sortable_histories_column( $columns ) {
 	$columns['authora'] = 'Writer';

    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
    return $columns;
}
function cmog_sort_authora( $vars ) {
      if( array_key_exists('orderby', $vars )) {
           if('Writer' == $vars['orderby']) {
                $vars['orderby'] = 'meta_value';
                $vars['meta_key'] = 'author_alias';
           }
      }
      return $vars;
}
add_filter('request', 'cmog_sort_authora');

//the ASC and DESC part of ORDER BY is handled automatically

/*-----------------------------------------------
----------     Histories Categories     ----------
-----------------------------------------------*/


add_action( 'init', 'create_histories_categories_taxonomies', 0 );


function create_histories_categories_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'History Categories', 'taxonomy general name' , 'textdomain'),
		'singular_name'     => _x( 'History Category', 'taxonomy singular name' , 'textdomain'),
		'search_items'      => __( 'Search History Categories' , 'textdomain'),
		'all_items'         => __( 'All History Categories' ),
		'parent_item'       => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Categories:' ),
		'edit_item'         => __( 'Edit History Category' ),
		'update_item'       => __( 'Update History Category' ),
		'add_new_item'      => __( 'Add New History Category' ),
		'new_item_name'     => __( 'New History Category Name' ),
		'menu_name'         => __( 'Salvation History Category' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'histories_category' ),
	);
	register_taxonomy( 'histories_categories', 'cpt_histories', $args );
	}
	

/*-----------------------------------------------
----------     create histories_categories drop down filter    ----------
-----------------------------------------------*/
function add_cpt_histories_filter() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'cpt_histories' ) {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        //$filters = array('plants', 'animals', 'insects');
        $filters = array('histories_categories');
        foreach ($filters as $tax_slug) {
            // retrieve the taxonomy object
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            // retrieve array of term objects per taxonomy
            $terms = get_terms($tax_slug);

			$_GET += array($tax_slug => null); // define
            // output html for taxonomy dropdown filter
            echo "<select name='$tax_slug' id='$tax_slug' class='postform'>";
            echo "<option value=''>Show All $tax_name</option>";
            foreach ($terms as $term) {
                // output each select option line, check against the last $_GET to show the current option selected
                echo '<option value='. $term->slug, $_GET[$tax_slug] == $term->slug ? ' selected="selected"' : '','>' . $term->name .' (' . $term->count .')</option>';
            }
            echo "</select>";
        }
    }
}

add_action( 'restrict_manage_posts', 'add_cpt_histories_filter' );

/*-----------------------------------------------
----------        taxonomy columns   ----------
-----------------------------------------------*/
function histories_custom_taxonomy_columns( $columns )
{
	 $columns['my_term_id'] = __('Term ID');
 unset($columns['description']);
	return $columns;
}
add_filter('manage_edit-histories_categories_columns' , 'histories_custom_taxonomy_columns');
//Note the pattern: manage_edit-{taxonomy}_columns

function histories_custom_taxonomy_columns_content( $content, $column_name, $term_id )
{
    if ( 'my_term_id' == $column_name ) {
        $content = $term_id;
    }
	return $content;
}
add_filter( 'manage_histories_categories_custom_column', 'histories_custom_taxonomy_columns_content', 10, 3 );
//Note the pattern: manage_{taxonomy}_custom_column


?>