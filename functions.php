<?php
include_once "inc/cpt.php"; // Custom Post Type Declarations
include_once "inc/taxonomy.php"; // Custom Taxonomy Declarations
include_once "inc/shortcodes.php"; // Custom Shortcode Declarations
include_once "inc/custom_walkers.php"; // Bootstrap based navigation and Custom Menu Walkers

//Add auto generated image sizes
//add_image_size( 'name-of-image-type', width, height );

//Setup Theme
if (!function_exists('cmog_setup')) :
    function cmog_setup()
    {
        global $cap;

        add_editor_style();
        add_theme_support('automatic-feed-links');
        add_theme_support('post-thumbnails');
        add_theme_support('post-formats', array('aside', 'image', 'video', 'quote', 'link'));

        load_theme_textdomain('cmog', get_template_directory() . '/languages');

        register_nav_menus(array(
            'top-menu' => __( 'Top Menu', 'cmog'),
            'social-menu' => __( 'Social Menu', 'cmog'),
            'primary' => __('Main Menu', 'cmog'),
            'mobile-menu' => __( 'Mobile Menu', 'cmog'),
            'articles-menu' => __( 'Articles Menu', 'cmog'),
            'glossery-menu' => __( 'Glossery Menu', 'cmog'),
            'history-menu' => __( 'History Menu', 'cmog'),
            'prayers-menu' => __( 'Prayers Menu', 'cmog'),
            'readings-menu' => __( 'Readings Menu', 'cmog'),
            'footer-menu-1' => __( 'Footer Menu Position 1', 'cmog'),
            'footer-menu-2' => __( 'Footer Menu Position 2', 'cmog'),
            'footer-menu-3' => __( 'Footer Menu Position 3', 'cmog'),
            'footer-menu-4' => __( 'Footer Menu Position 4', 'cmog'),
            'footer-copyright-menu' => __( 'Footer Copyright Menu', 'cmog'),
            'site-map' => __( 'Sitemap', 'cmog'),
        ));
    }
endif; // cmog_setup
add_action('after_setup_theme', 'cmog_setup');
//End Setup Theme


//Remove Unwanted Wordpress or Plugin Elements
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');
add_filter('wp_default_scripts', 'remove_jquery_migrate');

function remove_jquery_migrate(&$scripts)
{
    if (!is_admin()) {
        $scripts->remove('jquery');
        $scripts->add('jquery', false, array('jquery-core'), '1.2.1');
    }
}

//End Remove Unwanted Wordpress or Plugin Elements

//Attach CSS and JS to Theme
function cmog_scripts()
{
    if (file_exists(get_template_directory() . "/css/minified.css")) {
        wp_enqueue_style('cmog-minified-css', get_template_directory_uri() . '/css/minified.css');
    } else {
        wp_enqueue_style('cmog-fonts', get_template_directory_uri() . '/css/fonts.css');
        wp_enqueue_style('cmog-bootstrap', get_template_directory_uri() . '/css/bootstrap.css');
        wp_enqueue_style('cmog-normalize', get_template_directory_uri() . '/css/normalize.css');
        wp_enqueue_style('cmog-main', get_template_directory_uri() . '/css/main.css');
        wp_enqueue_style('cmog-style', get_stylesheet_uri()); // style.css
    }
    if (file_exists(get_template_directory() . "/js/minified.js")) {
        wp_enqueue_script('cmog-global-js', get_template_directory_uri() . '/js/minified.js', array('jquery'), '', false);
    } else {
        wp_enqueue_script('cmog-globaljs', get_template_directory_uri() . '/js/global.js', array('jquery'), '', true);
        wp_enqueue_script('cmog-dlmenujs', get_template_directory_uri() . '/js/jquery.dlmenu.js', array('jquery'), '', true);
        wp_enqueue_script('cmog-bootstrapjs', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '', false);
    }
}

add_action('wp_enqueue_scripts', 'cmog_scripts');
//End Attach CSS and JS to Theme

//Add AJAX location to header
function add_ajax_library() {
    $html  = '<script type="text/javascript">';
    $html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"';
    $html .= '</script>';
    echo $html;
}
add_action('wp_head', 'add_ajax_library');
//End Add AJAX location to header

//Miscellaneous Functions

//Get the id of a youtube video from a url
function getYouTubeVideoId($url)
{
    $video_id = false;
    $url = parse_url($url);
    if (!empty($url["path"])) {
        if (strcasecmp($url['host'], 'youtu.be') === 0) {
            $video_id = substr($url['path'], 1);
        } elseif (strcasecmp($url['host'], 'www.youtube.com') === 0) {
            if (isset($url['query'])) {
                parse_str($url['query'], $url['query']);
                if (isset($url['query']['v'])) {
                    $video_id = $url['query']['v'];
                }
            }
            if ($video_id == false) {
                $url['path'] = explode('/', substr($url['path'], 1));
                if (in_array($url['path'][0], array('e', 'embed', 'v'))) {
                    $video_id = $url['path'][1];
                }
            }
        }
    }
    return $video_id;
}
//End Miscellaneous Functions


//Filtering <p> added by wordpress based on select elements
function filter_ptags_on_images($content)
{
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    $content = preg_replace('/(<img .*( \/)?>)/iU', '<div class="image-block">\1</div>', $content);
    $content = preg_replace('/(<img .*class=["\'])([^\'"]+)(["\'].*( \/)?>)/iU', '\1\2 img-responsive\3', $content);
    return $content;
}
add_filter('acf_the_content', 'filter_ptags_on_images');
add_filter('the_content', 'filter_ptags_on_images');
//End Filtering <p> added by wordpress based on select elements

//Create 2 BS columns based on specified size 
function content_block_html($content1, $content2, $first_block_cols = 12, $mobile_flip = false){
$html = "";
$push_columns = "";
$pull_columns = "";
$content_first = $content1;
$content_second = $content2;
$first_cols = $first_block_cols;
$second_cols = 12 - $first_block_cols;

if($mobile_flip && strlen(strip_tags($content2)) < 2) {
    $push_columns = "col-sm-push-" . $first_block_cols;
    $pull_columns =  "col-sm-pull-" . (12-$first_block_cols);
    $content_first = apply_filters('the_content', $content2);
    $content_second = apply_filters('the_content', $content1);

    $first_cols = 12 - $first_block_cols;
    $second_cols = $first_block_cols;
}
$html = <<< BOF
                <div class="col-sm-$first_cols $push_columns">
                    $content_first
                </div>
                <div class="col-sm-$second_cols $pull_columns">
                    $content_second
                </div>
BOF;
return $html;
}
//End Create 2 BS columns based on specified size


function pagination($ajax = false){
global $wp_query;
$big = 999999999; // need an unlikely integer
 $html =  ' 
    <div class="pagination">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">' .
                     paginate_links( array(
                        'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format' => '?paged=%#%',
                        'current' => max( 1, get_query_var('paged') ),
                        'total' => $wp_query->max_num_pages
                    ) )
                .
                '</div>  
            </div>
        </div>  
    </div>';
    return $html;
}

function wpdocs_excerpt_more( $more ) {
    return sprintf( '... <a class="read-more" href="%1$s">%2$s</a>',
        get_permalink( get_the_ID() ),
        __( 'Read More', '_cmog' )
    );
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );



/*
 function bandend($archive_file_name){
  $content = "";
  $content = requireToVar( $archive_file_name );

return $content;
}



function process_post() {

if(is_archive()){
  $post_type = get_queried_object();
  $page = get_page_by_path($post_type->rewrite['slug'],OBJECT,'page');

  if($page)
         var_dump($post_type->rewrite['slug']);
           var_dump($page);
  var_dump(get_page_template_slug( $page->ID ));

        wp_redirect( $post_type->rewrite['slug'] );

        exit();
}

$pid = url_to_postid( "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] );

if($pid){
$post = get_post($pid);
$slug = $post->post_name;
$cpt_name = 'cpt_' . $slug;
$archive_file_name = get_template_directory() . '/archive-'.$cpt_name.'.php';

    if(post_type_exists( $cpt_name ) && file_exists($archive_file_name)){
        echo $archive_file_name;


        add_filter( 'bands_end', function($param) use ($archive_file_name) {
            return bandend($archive_file_name);
        }   );

      
    }
}

}

add_action( 'parse_query', 'process_post' );




function requireToVar($file){
    ob_start();
    require($file);
    return ob_get_clean();
}
*/


function get_content_excerpt_words($content, $words = 35, $no_p_tag = true){
    
    $the_excerpt = $content;
    $excerpt_length = $words; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images
    $words = explode(' ', $the_excerpt, $excerpt_length + 1);

    if(count($words) > $excerpt_length) :
        array_pop($words);
        array_push($words, '…');
        $the_excerpt = implode(' ', $words);
    endif;

    if($no_p_tag)
     $the_excerpt = '<p>' . $the_excerpt . '</p>';
    else
     $the_excerpt =  $the_excerpt;

    return $the_excerpt;
}


function get_content_excerpt_chars($content, $chars = 190, $no_p_tag = true){
    
    $the_excerpt = $content;
    $excerpt_length = $chars - 1; //Sets excerpt length by word count
    $the_excerpt = strip_tags(strip_shortcodes($the_excerpt)); //Strips tags and images

    if(strlen($the_excerpt)) $the_excerpt = substr($the_excerpt,0, $excerpt_length) . '…';
 
    if($no_p_tag)
     $the_excerpt = '<p>' . $the_excerpt . '</p>';
    else
     $the_excerpt =  $the_excerpt;

    return $the_excerpt;
}


function get_rss_feed( $feed_url = "", $words = 0, $chars = 0, $items = 3, $page = 0, $pages = 3, $shortcode = true, $ajax = false){
$maxitems = 0;
$rss = fetch_feed( $feed_url );
    if ( ! is_wp_error( $rss ) ) : // Checks that the object is created correctly
        // Figure out how many total items there are, but limit it to 3. 
        $maxitems = $rss->get_item_quantity( $items );
        $return_pages = $rss->get_item_quantity( 0 ) % $items; 
        if($return_pages > $pages )
            $return_pages = $pages;
        // Build an array of all the items, starting with element 0 (first element).
        $start = $page;
        if($page > 0) $start = $page -1;
        $rss_items = $rss->get_items( ($start * $items) , $maxitems );
    endif;

$html = "";
    if ( $maxitems == 0 ) : 
      $html .=  "<p>".  _e( 'No items', 'cmog' ) . "</p>";
    else :
        foreach ( $rss_items as $item ) :  
        $content = "";
            if($words) :
                $content = get_content_excerpt_words(strip_tags ( $item->get_description() ), $words);
            elseif($chars):
                $content = get_content_excerpt_chars(strip_tags ( $item->get_description() ), $chars);
            else :
                $content = $item->get_description();
            endif;

            $html .= "<article class='loop'>".mysql2date("m.d.y",$item->get_date()) . " - ". esc_html( $item->get_title() ) .
            "<a target='_blank' href='".  esc_url( $item->get_permalink() ) ."'>Read More &gt;</a>
            </article>";

        $html .=  "<article class='loop'>" .
                  "<a target='_blank' href='" .
                  esc_url( $item->get_permalink() ) .
                  "'title='" . esc_html( $item->get_title() ) ."'>" .
                  esc_html( $item->get_title() ) .
                  "</a>".
                  "<div>" . $content . "</div>" .
                  "</article>";
        endforeach; 
    endif; 
    if($ajax) 
        return $html;
    elseif($shortcode)
        return $html;
    else
        return array("html" => $html, "pages" => $rss_items);
}



//Add class gravity-form to gravity forms form tag
add_filter( 'gform_pre_render', 'gravity_forms_add_form_class' );
function gravity_forms_add_form_class( $form ) {
$form["cssClass"] = trim($form["cssClass"] . ' ' . 'gravity-form');
return $form;
    }
//End Add class gravity-form to gravity forms form tag

//Get post excerpt from wp-editor or custom field
function aac_get_post_excerpt($post_id) {
    global $post;
    $meta = get_post_meta($post_id); 
    if($current_excerpt = get_the_excerpt()) return $current_excerpt;

    $search_term = get_search_query();
    $match_found = false;
    $excerpt = false;
    foreach($meta as $key => $val) :
        if($match_found) break;
        $meta_field = get_post_meta($post_id, $key,true);
            foreach($val as $val_key => $value) :

if(preg_match('#^_#i', $key) || preg_match('#^a\:\d*\:#i', $value)) continue;
var_dump($key);
                $text = strip_tags($value);
                   if(preg_match('#'. $search_term .'#i', $text)) :
                       $excerpt = wp_trim_words($text,55,' […]') ;//  '<a class="moretag" href="'. get_permalink($post->ID) . '">&nbsp;Read More</a>';;
                      var_dump($excerpt);
                       $match_found = true;
                       break;
                   endif;
            endforeach;
    endforeach;
    if(!$match_found) $excerpt = get_the_excerpt();
return $excerpt;
}
//End Get post excerpt from wp-editor or custom field


function add_theme_caps() {
    // gets the author role
    $role = get_role( 'editor' );

    $role->add_cap( 'edit_theme_options' ); 
$role->add_cap( 'gravityforms_edit_forms' ); 
$role->add_cap( 'gravityforms_delete_forms' ); 
$role->add_cap( 'gravityforms_create_form' ); 
$role->add_cap( 'gravityforms_view_entries' ); 
$role->add_cap( 'gravityforms_edit_entries' ); 
$role->add_cap( 'gravityforms_delete_entries' ); 
$role->add_cap( 'gravityforms_view_settings' ); 
$role->add_cap( 'gravityforms_edit_settings' ); 
$role->add_cap( 'gravityforms_export_entries' ); 
$role->add_cap( 'gravityforms_view_entry_notes' ); 
$role->add_cap( 'gravityforms_edit_entry_notes' ); 
$role->add_cap( 'gravityforms_view_updates' ); 
$role->add_cap( 'gravityforms_preview_forms' ); 
$role->add_cap( 'wpseo_bulk_edit' ); 
$role->add_cap( 'manage_options' ); 

}
add_action( 'admin_init', 'add_theme_caps');



function cmog_widgets_init() {

    register_sidebar( array(
        'name'          => __( 'Footer 1', 'cmog' ),
        'id'            => 'footer-widget-1',
        'description'   => __( '1st Footer Widget Position From the Left', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer 2', 'cmog' ),
        'id'            => 'footer-widget-2',
        'description'   => __( '2nd Footer Widget Position From the Left', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer 3', 'cmog' ),
        'id'            => 'footer-widget-3',
        'description'   => __( '3rd Footer Widget Position From the Left', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer 4', 'cmog' ),
        'id'            => 'footer-widget-4',
        'description'   => __( '4th Footer Widget Position From the Left', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Footer Copyright', 'cmog' ),
        'id'            => 'footer-widget-copyright',
        'description'   => __( 'Bottom Copyright Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Articles Sidebar', 'cmog' ),
        'id'            => 'articles-widget',
        'description'   => __( 'Articles Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Salvation History Sidebar', 'cmog' ),
        'id'            => 'history-widget',
        'description'   => __( 'Salvation History Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Prayers of the Church Sidebar', 'cmog' ),
        'id'            => 'prayers-widget',
        'description'   => __( 'Prayers of the Church Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Scripture Readings Sidebar', 'cmog' ),
        'id'            => 'readings-widget',
        'description'   => __( 'Scripture Readings Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Terminologies Sidebar', 'cmog' ),
        'id'            => 'terminologies-widget',
        'description'   => __( 'Terminologies Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Books Sidebar', 'cmog' ),
        'id'            => 'books-widget',
        'description'   => __( 'Books Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Organizations Sidebar', 'cmog' ),
        'id'            => 'organizations-widget',
        'description'   => __( 'Organizations Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Calendars Sidebar', 'cmog' ),
        'id'            => 'calendars-widget',
        'description'   => __( 'Calendars Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Documents Sidebar', 'cmog' ),
        'id'            => 'documents-widget',
        'description'   => __( 'Documents Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Tags Sidebar', 'cmog' ),
        'id'            => 'tags-widget',
        'description'   => __( 'Tags Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Posts Sidebar', 'cmog' ),
        'id'            => 'posts-widget',
        'description'   => __( 'Posts Widget Position', 'cmog' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<div class="widget-title">',
        'after_title'   => '</div>',
    ) );
}
add_action( 'widgets_init', 'cmog_widgets_init' );


// sort order

//add_filter('posts_orderby', 'glossary_alphabetical' );

add_action( 'pre_get_posts', 'glossary_alphabetical' );
 function glossary_alphabetical( $orderby ) {
  global $gloss_category;
  if( !is_admin() ) {
     // alphabetical order by post title
     return "post_title ASC";
  }

  // not in glossary category, return default order by
  return $orderby;
}

/*function glossary_alphabetical( $orderby ) {
  global $gloss_category;
  if( !is_admin() &&  is_post_type_archive( 'cpt_terminologies' )&& ! empty( $query->query['post_type']  == 'my_custom_post_type' )) {
     // alphabetical order by post title
     return "post_title ASC";
  }

  // not in glossary category, return default order by
  return $orderby;
}*/


/*


function cpt_terminologies_sort_order( $wp_query ) {
    global $post;
echo 'wp_query <br>ispost = ' . isset($post) . ' and post_type = ' . $post->post_type . '<br> isAdmin = ' . is_admin() . '  is_archive( cpt_terminologies ) ' . is_archive( 'cpt_terminologies' ) . '<br>';
    if(isset($post) && $post->post_type == 'cpt_terminologies'){
       $wp_query->set( 'orderby', 'post_title' );
       $wp_query->set( 'order', 'ASC' );
    }


}
add_action( 'pre_get_posts', 'cpt_terminologies_sort_order' );
*/

function exclude_tags($query) {
    global $post;
  if (is_tag()  ){
    $query->set('orderby', 't.count');
  }
}

add_action('pre_get_posts', 'exclude_tags');

function live_link( ) {
	$meta_type = 'post';
	$object_id = get_the_ID();
	$meta_key = '_fgj2wp_old_id';
	$single = true;
	$old_id = get_metadata($meta_type, $object_id, $meta_key, $single);
	if (!empty($old_id)) {
		echo "<dev class='debug'>";
		echo " (<a class ='button' href='https://churchmotherofgod.org/" . $old_id . "' target='_blank'>Live site link</a>)<br /> " ; 
		echo "</dev>";
	}
}
function cmog_post_info(){
	$args = array(
		//default to current post
		'post' => 0,
		'before' => '',
		'sep' => '<br />',
		'after' => '',
		//'template' => '%s: %l.'
	);
	echo "<dev class='cmog-info'>";
	the_taxonomies($args );
	echo "<br />Posted by: ";
    the_author(); 
	the_meta();
	echo "</dev>";
}
