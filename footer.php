<footer>
    <div class="container">
        <div class="row">
        	<div class="footer-submenu-wrapper">
	            <div class="col-sm-3 widget-container">
	                <?php
	                if(is_active_sidebar('footer-widget-1')){
	                    dynamic_sidebar('footer-widget-1');
	                }
	                ?>
	            </div>
	            <div class="col-sm-3 widget-container">
	                <?php
	                if(is_active_sidebar('footer-widget-2')){
	                    dynamic_sidebar('footer-widget-2');
	                }
	                ?>
	            </div>
	            <div class="col-sm-3 widget-container">
	                <?php
	                if(is_active_sidebar('footer-widget-3')){
	                    dynamic_sidebar('footer-widget-3');
	                }
	                ?>
	            </div>
	            <div class="col-sm-3 widget-container">
	                <?php
	                if(is_active_sidebar('footer-widget-4')){
	                    dynamic_sidebar('footer-widget-4');
	                }
	                ?>
	             <?php wp_nav_menu( array( 'theme_location' => 'social-menu', 'container' => '', 'menu_id' => 'footer-social-menu', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'walker'=> new Icon_Walker_Nav_Menu(), ) ); ?>
	            </div>
            </div>
        </div>
		<div class="row">
            <div class="col-sm-12">
	            <div class="footer-copyright-wrapper">
	                <?php
	                if(is_active_sidebar('footer-widget-copyright')){
	                    dynamic_sidebar('footer-widget-copyright');
	                }
	                ?>
	            </div>
       		</div>
        </div>
    </div>
</footer>
<div class="debug"><br><?php wp_footer(); ?><br></div>
</body></html>