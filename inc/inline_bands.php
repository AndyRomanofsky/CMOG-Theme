<?php 
$has_band = false;
while ( have_posts() ) : the_post();
	if( have_rows('banded_content') ):
		while ( have_rows('banded_content') ) : the_row();
			$class = "";
			if($class_value = get_sub_field("class")) $class = " " . trim($class_value);
			if($add_padding = get_sub_field("add_padding")) $class = " " . trim($add_padding) . " " . $class; 

			$file_path = get_template_directory() . "/inc/banded_content/". preg_replace("#\/#","_",get_row_layout()) . ".php";
			if(file_exists($file_path)) include $file_path;
			$has_band = true;
		endwhile;	
	else :
		    // no layouts found
	endif;
endwhile;
?>