<?php
/*-----------------------------------------------
----------Scripture Readings  Custom Post Type----------    Scripture Readings    scripture readings  
-----------------------------------------------*/
add_action( 'init', 'cpt_readings' );
function cpt_readings() {
    $labels = get_cpt_labels(array("Scripture Readings", 'Scripture Reading', 'readings', 'reading', 'cmog'));
    $icon = get_bloginfo ('template_directory') . '/img/readings.png';
    $slug = 'readings';
    $args = get_cpt_args($labels, $slug);
    $args['rewrite'] = array( 'slug' => $slug, 'with_front' => true );
    $args['taxonomies'] = array( 'readings_categories','post_tag');

    register_post_type( 'cpt_readings', $args);
}
  
  /*-----------------------------------------------
----------      columns     ----------  no column stuff needed
-----------------------------------------------
 
function cpt_readings_column_names( $columns ) {
    $columns = array(
        'cb'        => '<input type="checkbox" />',
        'title'     => 'Title',
        'cat'     => 'Catergory',
        'author'    =>  'Author',
        'date'      =>  'Date',
    ); 
 
	return $columns ;
}
function cpt_readings_column_data($column) {

    global $post;
    if($column == 'cat')
    {     
		$taxonomy = 'readings_categories';
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
add_action("manage_posts_custom_column", "cpt_readings_column_data");
add_filter( 'manage_cpt_readings_posts_columns', 'cpt_readings_column_names');


 -----------------------------------------------
----------    Sortable columns     ----------
-----------------------------------------------

add_filter( 'manage_edit-cpt_readings_sortable_columns', 'my_sortable_readings_column' );
function my_sortable_readings_column( $columns ) { 
    $columns['author'] = 'author';

    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 var_dump($columns);
    return $columns;
}
*/
/*-----------------------------------------------
----------     Readings Categories     ----------
-----------------------------------------------*/

// hook into the init action and call create_readings_taxonomies when it fires
add_action( 'init', 'create_readings_categories_taxonomies', 0 );


function create_readings_categories_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Scripture Reading Categories', 'taxonomy general name' , 'textdomain'),
		'singular_name'     => _x( 'Scripture Reading Category', 'taxonomy singular name' , 'textdomain'),
		'search_items'      => __( 'Search Scripture Reading Categories' , 'textdomain'),
		'all_items'         => __( 'All Scripture Reading Categories' ),
		'parent_item'       => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Categories:' ),
		'edit_item'         => __( 'Edit Scripture Reading Category' ),
		'update_item'       => __( 'Update Scripture Reading Category' ),
		'add_new_item'      => __( 'Add New Scripture Reading Category' ),
		'new_item_name'     => __( 'New Scripture Reading Category Name' ),
		'menu_name'         => __( 'Scripture Reading Category' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'readings_category' ),
	);

	register_taxonomy( 'readings_categories', 'cpt_readings', $args );
	}
	
/*-----------------------------------------------
----------     create readings_categories drop down filter    ----------
-----------------------------------------------*/
function add_cpt_readings_filter() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'cpt_readings' ) {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        //$filters = get_taxonomies();
       $filters = array('readings_categories');
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

add_action( 'restrict_manage_posts', 'add_cpt_readings_filter' );

/*-----------------------------------------------
----------        taxonomy columns   ----------
-----------------------------------------------*/
function readings_custom_taxonomy_columns( $columns )
{
	 $columns['my_term_id'] = __('Term ID');
 unset($columns['description']);
	return $columns;
}
add_filter('manage_edit-readings_categories_columns' , 'readings_custom_taxonomy_columns');
//Note the pattern: manage_edit-{taxonomy}_columns

function readings_custom_taxonomy_columns_content( $content, $column_name, $term_id )
{
    if ( 'my_term_id' == $column_name ) {
        $content = $term_id;
    }
	return $content;
}
add_filter( 'manage_readings_categories_custom_column', 'readings_custom_taxonomy_columns_content', 10, 3 );
//Note the pattern: manage_{taxonomy}_custom_column


?>