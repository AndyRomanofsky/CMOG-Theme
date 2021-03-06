<?php
/*-----------------------------------------------
----------Books  Custom Post Type----------     
-----------------------------------------------*/
add_action( 'init', 'cpt_books' );
function cpt_books() {
    $labels = get_cpt_labels(array("Books", 'Book', 'books', 'book', 'cmog'));
    $icon = get_bloginfo ('template_directory') . '/img/books.png';
    $slug = 'books';
    $args = get_cpt_args($labels, $slug);
    $args['rewrite'] = array( 'slug' => $slug, 'with_front' => true );
    $args['taxonomies'] = array( 'books_categories');

    register_post_type( 'cpt_books', $args);
}

/*-----------------------------------------------
----------     Books Categories     ----------
-----------------------------------------------*/

// hook into the init action and call create_books_taxonomies when it fires
add_action( 'init', 'create_books_categories_taxonomies', 0 );


function create_books_categories_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Books Categories', 'taxonomy general name' , 'textdomain'),
		'singular_name'     => _x( 'Books Category', 'taxonomy singular name' , 'textdomain'),
		'search_items'      => __( 'Search Books Categories' , 'textdomain'),
		'all_items'         => __( 'All Books Categories' ),
		'parent_item'       => __( 'Parent Category' ),
		'parent_item_colon' => __( 'Parent Categories:' ),
		'edit_item'         => __( 'Edit Books Category' ),
		'update_item'       => __( 'Update Books Category' ),
		'add_new_item'      => __( 'Add New Books Category' ),
		'new_item_name'     => __( 'New Books Category Name' ),
		'menu_name'         => __( 'Books Category' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'books_category' ),
	);

	register_taxonomy( 'books_categories', 'cpt_books', $args );
	}
	
/*-----------------------------------------------
----------     create books_categories drop down filter    ----------
-----------------------------------------------*/
function add_cpt_books_filter() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'cpt_books' ) {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        //$filters = get_taxonomies();
       $filters = array('books_categories');
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

add_action( 'restrict_manage_posts', 'add_cpt_books_filter' );

/*-----------------------------------------------
----------        taxonomy columns   ----------
-----------------------------------------------*/
function books_custom_taxonomy_columns( $columns )
{
	 $columns['my_term_id'] = __('Term ID');
 unset($columns['description']);
	return $columns;
}
add_filter('manage_edit-books_categories_columns' , 'books_custom_taxonomy_columns');
//Note the pattern: manage_edit-{taxonomy}_columns

function books_custom_taxonomy_columns_content( $content, $column_name, $term_id )
{
    if ( 'my_term_id' == $column_name ) {
        $content = $term_id;
    }
	return $content;
}
add_filter( 'manage_books_categories_custom_column', 'books_custom_taxonomy_columns_content', 10, 3 );
//Note the pattern: manage_{taxonomy}_custom_column


?>