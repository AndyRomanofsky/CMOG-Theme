<?php
		$col_offset_html = '';
		$col_offset =  get_sub_field('column_offset');
		if( $col_offset ) $col_offset_html = 'col-sm-offset-' . $col_offset . ' ';

		$bs_col = '12';
		if( $col_offset != '0' )	$bs_col = $bs_col - ( $col_offset * 2 );
?>
<div class="band-caption <?php echo $class; ?>">
	<div class="container">
		<div class="row">
			<div class="<?php echo $col_offset_html; ?>col-sm-<?php echo $bs_col; ?>">
				<?php the_sub_field('content'); ?>
			</div>
		</div>
	</div>
</div>