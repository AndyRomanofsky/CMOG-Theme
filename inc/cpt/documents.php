<?php
/*-----------------------------------------------
----------Documents Custom Post Type----------
-----------------------------------------------*/
add_action( 'init', 'cpt_documents' );
function cpt_documents() {
    $labels = get_cpt_labels(array("Documents", 'Document', 'documents', 'document', 'cmog'));
    $icon = get_bloginfo ('template_directory') . '/img/documents.png';
    $slug = 'documents';
    $args = get_cpt_args($labels, $slug);
    $args['rewrite'] = array( 'slug' => $slug, 'with_front' => true );
    $args['taxonomies'] = array( 'documents_categories');

    register_post_type( 'cpt_documents', $args);
}
  
 
function cpt_documents_column_names( $columns ) {
    $columns = array(
        'cb'        => '<input type="checkbox" />',
        'title'     => 'Title',
        'thumbnail' =>  'Thumbnail',
        'cat'     => 'Catergory',
		'topic'     => 'Topic', 
        'product'     => 'Product',
        'author'    =>  'Author',
        'date'      =>  'Date',
    );
     return $columns ;
}
function cpt_documents_column_data($column) {

    global $post;
    if($column == 'thumbnail')
    {
        $img = get_field('documents_image', $post->ID);
		if ( $img ) {
        echo wp_get_attachment_image($img['id'] , array(75,75) );
		}
    }
  if($column == 'topic')
    {   $field = get_field_object('documents_topic');
         $topics =  get_field('documents_topic');
	   	 if (!empty( $topics)) {	
			 if ( !is_array($topics)  ) $topics=array($topics);
			 foreach ($topics as $topic) { 
				 if (array_key_exists($topic, $field['choices']))  {
					 $holdp[] =  $field['choices'][ $topic ];
				 } else {
					 $holdp[] =  "(" . $topic . ")" ;  // just to show old data is in the field
				 }
			 }
		 echo implode(", ", $holdp);
		 }
    } 
  if($column == 'product')
    {   $field = get_field_object('documents_product');
         $products =  get_field('documents_product');
	   	 if (!empty( $products)) {	
			 if ( !is_array($products)  ) $products=array($products);
			 foreach ($products as $product) { 
				 if (array_key_exists($product, $field['choices']))  {
					 $holdp[] =  $field['choices'][ $product ];
				 } else {
					 $holdp[] =  "(" . $product . ")" ;  // just to show old data is in the field
				 }
			 }
		 echo implode(", ", $holdp);
		 }
    }
    if($column == 'cat')
    {     
		$taxonomy = 'documents_categories';
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
add_action("manage_posts_custom_column", "cpt_documents_column_data");
add_filter( 'manage_cpt_documents_posts_columns', 'cpt_documents_column_names');


/*-----------------------------------------------
----------     Documents Categories     ----------
-----------------------------------------------*/

// hook into the init action and call create_documents_categories_taxonomies when it fires
add_action( 'init', 'create_documents_categories_taxonomies', 0 );


function create_documents_categories_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Document types', 'taxonomy general name' , 'textdomain'),
		'singular_name'     => _x( 'Document type', 'taxonomy singular name' , 'textdomain'),
		'search_items'      => __( 'Search Document types' , 'textdomain'),
		'all_items'         => __( 'All Document types' ),
		'parent_item'       => __( 'Parent Document type' ),
		'parent_item_colon' => __( 'Parent Document types:' ),
		'edit_item'         => __( 'Edit Document type' ),
		'update_item'       => __( 'Update Document type' ),
		'add_new_item'      => __( 'Add New Document type' ),
		'new_item_name'     => __( 'New Document type Name' ),
		'menu_name'         => __( 'Document type' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'documents_types' ),
	);

	register_taxonomy( 'documents_categories', 'cpt_documents', $args );
	}
	

/*-----------------------------------------------
----------     create documents_categories drop down filter    ----------
-----------------------------------------------*/
function add_cpt_documents_filter() {

    // only display these taxonomy filters on desired custom post_type listings
    global $typenow;
    if ($typenow == 'cpt_documents' ) {

        // create an array of taxonomy slugs you want to filter by - if you want to retrieve all taxonomies, could use get_taxonomies() to build the list
        //$filters = array('plants', 'animals', 'insects');
        $filters = array('documents_categories');
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

add_action( 'restrict_manage_posts', 'add_cpt_documents_filter' );

/*-----------------------------------------------
----------        taxonomy columns   ----------
-----------------------------------------------*/
function documents_custom_taxonomy_columns( $columns )
{
	 $columns['my_term_id'] = __('Term ID');
 unset($columns['description']);
	return $columns;
}
add_filter('manage_edit-documents_categories_columns' , 'documents_custom_taxonomy_columns');
//Note the pattern: manage_edit-{taxonomy}_columns

function documents_custom_taxonomy_columns_content( $content, $column_name, $term_id )
{
    if ( 'my_term_id' == $column_name ) {
        $content = $term_id;
    }
	return $content;
}
add_filter( 'manage_documents_categories_custom_column', 'documents_custom_taxonomy_columns_content', 10, 3 );
//Note the pattern: manage_{taxonomy}_custom_column


?>