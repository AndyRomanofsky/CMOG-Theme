<?php
/*-----------------------------------------------
----------Prayers of the Church Custom Post Type----------   
-----------------------------------------------*/
add_action( 'init', 'cpt_prayers' );
function cpt_prayers() {
    $labels = get_cpt_labels(array("Prayers of the Church", 'Prayer', 'prayers', 'prayer', 'cmog'));
    $icon = get_bloginfo ('template_directory') . '/img/prayers.png';
    $slug = 'prayers';
    $args = get_cpt_args($labels, $slug);
    $args['rewrite'] = array( 'slug' => $slug, 'with_front' => true );
    $args['taxonomies'] = array( 'prayers_categories','post_tag');

    register_post_type( 'cpt_prayers', $args);
}
  
  /*-----------------------------------------------
----------      columns     ----------  no column stuff needed
-----------------------------------------------
 
function cpt_prayers_column_names( $columns ) {
    $columns = array(
        'cb'        => '<input type="checkbox" />',
        'title'     => 'Title',
        'cat'     => 'Catergory',
        'author'    =>  'Author',
        'date'      =>  'Date',
    );
     return $columns ;
}
function cpt_prayers_column_data($column) {

    global $post;
    if($column == 'cat')
    {     
		$taxonomy = 'prayers_categories';
		// get the term IDs assigned to post.
		$post_terms = wp_get_object_terms( $post->ID, $taxonomy, array( 'fields' => 'ids' ) );
		// separator between links 
		$separator = ', ';
		if ( !empty( $post_terms ) && !is_wp_error( $post_terms ) ) {
			$term_ids = implode( ',' , $post_terms );
			$terms = wp_list_categories( 'title_li=&style=none&echo=0&taxonomy=' . $taxonomy . '&include=' . $term_ids );
			$terms = rtrim( trim( str_replace( '<br />',  $separator, $terms ) ), $separator );
			// display post categories
		echo  $terms;
		}
    }
}
add_action("manage_posts_custom_column", "cpt_prayers_column_data");
add_filter( 'manage_cpt_prayers_posts_columns', 'cpt_prayers_column_names');

*/
/*-----------------------------------------------
----------     Prayers of the Church  Categories     ----------
-----------------------------------------------*/

// hook into the init action and call create_readings_taxonomies when it fires
add_action( 'init', 'create_prayers_categories_taxonomies', 0 );


function create_prayers_categories_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Prayers of the Church Categories', 'taxonomy general name' , 'textdomain'),
		'singular_name'     => _x( 'Prayers of the Church Category', 'taxonomy singular name' , 'textdomain'),
		'search_items'      => __( 'Search Prayers of the Church Categories' , 'textdomain'),
		'all_items'         => __( 'All Prayers of the Church Categories' ),
		'parent_item'       => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Categories:' ),
		'edit_item'         => __( 'Edit Prayers of the Church Category' ),
		'update_item'       => __( 'Update Prayers of the Church Category' ),
		'add_new_item'      => __( 'Add New Prayers of the Church Category' ),
		'new_item_name'     => __( 'New Prayers of the Church Name' ),
		'menu_name'         => __( 'Prayers of the Church Category' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'prayers_category' ),
	);

	register_taxonomy( 'prayers_categories', 'cpt_prayers', $args );
	}
	
/*-----------------------------------------------
----------     create prayers_categories drop down filter    ----------
-----------------------------------------------*/
function add_cpt_prayers_filter() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'cpt_prayers' ) {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        //$filters = get_taxonomies();
       $filters = array('prayers_categories');
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

add_action( 'restrict_manage_posts', 'add_cpt_prayers_filter' );

/*-----------------------------------------------
----------        taxonomy columns   ----------
-----------------------------------------------*/
function prayers_custom_taxonomy_columns( $columns )
{
	 $columns['my_term_id'] = __('Term ID');
 unset($columns['description']);
	return $columns;
}
add_filter('manage_edit-prayers_categories_columns' , 'prayers_custom_taxonomy_columns');
//Note the pattern: manage_edit-{taxonomy}_columns

function prayers_custom_taxonomy_columns_content( $content, $column_name, $term_id )
{
    if ( 'my_term_id' == $column_name ) {
        $content = $term_id;
    }
	return $content;
}
add_filter( 'manage_prayers_categories_custom_column', 'prayers_custom_taxonomy_columns_content', 10, 3 );
//Note the pattern: manage_{taxonomy}_custom_column


?>