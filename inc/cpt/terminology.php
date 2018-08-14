<?php
/*-----------------------------------------------
----------Terminology Custom Post Type----------    terminology   terminologies Terminologies
-----------------------------------------------*/
add_action( 'init', 'cpt_terminologies' );
function cpt_terminologies() {
    $labels = get_cpt_labels(array("Terminologies", 'Terminology', 'terminologies', 'terminology', 'cmog'));
    $icon = get_bloginfo ('template_directory') . '/img/terminologies.png';
    $slug = 'terminologies';
    $args = get_cpt_args($labels, $slug);
    $args['rewrite'] = array( 'slug' => $slug, 'with_front' => true );
    $args['taxonomies'] = array( 'terminologies_categories','post_tag');

    register_post_type( 'cpt_terminologies', $args);
}
    /*-----------------------------------------------
----------      columns     ----------  no column stuff needed
-----------------------------------------------*/
 
function cpt_terminologies_column_names( $columns ) {
    $columns['id'] = 'ID';
     return $columns ;
}
function cpt_terminologies_column_data($column) {

    global $post;
	if($column == 'id') the_ID();
}
add_action("manage_posts_custom_column", "cpt_terminologies_column_data");
add_filter( 'manage_cpt_terminologies_posts_columns', 'cpt_terminologies_column_names');

/*-----------------------------------------------
----------    Sortable columns     ----------
-----------------------------------------------*/
add_filter( 'manage_edit-cpt_terminologies_sortable_columns', 'my_sortable_terminology_column' );
function my_sortable_terminology_column( $columns ) {
      $columns['id'] = 'id';
    $columns['author'] = 'author';

    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}
/*-----------------------------------------------
----------     Terminologies Categories     ----------
-----------------------------------------------*/

// hook into the init action and call create_technologies_taxonomies when it fires
add_action( 'init', 'create_terminologies_categories_taxonomies', 0 );


function create_terminologies_categories_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Terminology Categories', 'taxonomy general name' , 'textdomain'),
		'singular_name'     => _x( 'Terminology Category', 'taxonomy singular name' , 'textdomain'),
		'search_items'      => __( 'Search Terminology Categories' , 'textdomain'),
		'all_items'         => __( 'All Terminology Categories' ),
		'parent_item'       => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Categories:' ),
		'edit_item'         => __( 'Edit Terminology Category' ),
		'update_item'       => __( 'Update Terminology Category' ),
		'add_new_item'      => __( 'Add New Terminology Terminologies Category' ),
		'new_item_name'     => __( 'New Terminology Category Name' ),
		'menu_name'         => __( 'Terminology Category' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'terminologies_category' ),
	);

	register_taxonomy( 'terminologies_categories', 'cpt_terminologies', $args );
	}
	
/*-----------------------------------------------
----------     create terminologies_categories drop down filter    ----------
-----------------------------------------------*/
function add_cpt_terminologies_filter() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'cpt_terminologies' ) {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        //$filters = get_taxonomies();
       $filters = array('terminologies_categories');
        foreach ($filters as $tax_slug) {
            // retrieve the taxonomy object
            $tax_obj = get_taxonomy($tax_slug);
            $tax_name = $tax_obj->labels->name;
            $tax_sing_name = $tax_obj->labels->singular_name;
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
	/*		echo "<option value='NOT IN " . get_terms('terminologies_categories', array(
		'fields' => 'ids'  )) ."'>Not in a  $tax_sing_name</option>";
    */
            echo "</select>";
			


        }
    }
}

add_action( 'restrict_manage_posts', 'add_cpt_terminologies_filter' );

/*-----------------------------------------------
/---          display contextual help 
/-----------------------------------------------*/
 
function terminology_add_help_text( $contextual_help, $screen_id, $screen ) {
  //  $contextual_help .= "br" .$screen->id . "br" ;//var_dump( $screen ); // use this to help determine $screen->id
  if ( 'cpt_terminologies' == $screen->id ) {
    $contextual_help =
      '<p>' . __('Things to remember when adding or editing a terminology:', 'cmog') . '</p>' .
      '<ul>' .
      '<li>' . __('Keep it short', 'cmog') . '</li>' .
      '<li>' . __('(More to come.)', 'cmog') . '</li>' .
      '</ul>'  ;

  } elseif ( 'edit-cpt_terminologies' == $screen->id ) {
    $contextual_help =
      '<p>' . __('This is the help screen displaying the list of terminologies.', 'cmog') . '</p>' ;
  }
  return $contextual_help;
}
add_action( 'contextual_help', 'terminology_add_help_text', 10, 3 );
	
	
	
function terminology_custom_help_tab() {

  $screen = get_current_screen();

  // Return early if we're not on the book post type.
  if ( 'cpt_terminologies' != $screen->post_type )
    return;

  // Setup help tab args.
  $args = array(
    'id'      => 'cpt_terminologies_tab', //unique id for the tab
    'title'   => 'Terminology Help', //unique visible title for the tab
    'content' => '<h3>Terminology</h3><p>Help content</p>',  //actual help text
  );
  
  // Add the help tab.
  $screen->add_help_tab( $args );

}

add_action('admin_head', 'terminology_custom_help_tab');
?>
