<div class="band band-key-features">
	<div class="container">
		<div class="row">
			<div class="col-sm-12">
				<h2><?php the_sub_field("title"); ?></h2>
				<div class="col-sm-6 key-features">
					<?php while ( have_rows('icons_left') ) : the_row(); ?>
						<div class="icon"><span class="<?php the_sub_field("icon_type");?>"></span></div>
						<div class="text-block"><?php the_sub_field("text");?></div>
					<?php endwhile; ?>
				</div>
				<div class="col-sm-6 key-features">
					<?php while ( have_rows('icons_right') ) : the_row(); ?>
						<div class="icon"><span class="<?php the_sub_field("icon_type");?>"></span></div>
						<div class="text-block"><?php the_sub_field("text");?></div>
					<?php endwhile; ?>
				</div>
			</div>
		</div>
	</div>
</div>