<?php
/*
Template Name: Contact Us
(style and js - can be moved to other files)
*/
get_header();

?>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
<script type="text/javascript">
(function($) {

/*
*  new_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/

function new_map( $el ) {
	
	// var
	var $markers = $el.find('.marker');
	
	
	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP
	};
	
	
	// create map	        	
	var map = new google.maps.Map( $el[0], args);
	
	
	// add a markers reference
	map.markers = [];
	
	
	// add markers
	$markers.each(function(){
		
    	add_marker( $(this), map );
		
	});
	
	
	// center map
	center_map( map );
	
	
	// return
	return map;
	
}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker( $marker, map ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

	// create marker
	var marker = new google.maps.Marker({
		position	: latlng,
		map			: map
	});

	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});

		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {

			infowindow.open( map, marker );

		});
	}

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map( map ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/
// global var
var map = null;

$(document).ready(function(){

	$('.acf-map').each(function(){

		// create map
		map = new_map( $(this) );

	});

});

})(jQuery);
</script>
<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<h1>
				<?php the_title(); ?>
			</h1>
			<?php if(get_field('page_sub_heading')): ?>
			<p class="subhead">
				<?php the_field('page_sub_heading'); ?>
			</p>
			<?php endif; ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-7">
			<div class="gravity-form">
				<?php $formcode = get_field('page_contact_us_form_id');?>
				<?php if ($formcode) {
				echo do_shortcode($formcode);
			}?>
			</div>
		</div>
		<div class="col-md-5">
			<?php the_field('page_contact_us_information' ); ?>
		</div>
	</div>
</div>
<?php if( have_rows('page_contact_us_locations') ): ?>
<div class="container">
	<div class="acf-map">
		<?php while ( have_rows('page_contact_us_locations') ) : the_row(); 

			$location = get_sub_field('location');

			?>
		<div class="marker" data-lat="<?php echo $location['lat']; ?>" data-lng="<?php echo $location['lng']; ?>">
			<h4>
				<?php the_sub_field('title'); ?>
			</h4>
			<p class="address"><?php echo $location['address']; ?></p>
			<p>
				<?php the_sub_field('description'); ?>
			</p>
		</div>
		<?php endwhile; ?>
	</div>
</div>
<?php endif; ?>
<?php $bimg = get_field(  'page_contact_us_bottom_image' );  
 if ($bimg) { ?>
<img class="divider-image" src="<?php echo $bimg['url']; ?>" alt="">
<?php } ?>
<?php get_footer(); ?>
