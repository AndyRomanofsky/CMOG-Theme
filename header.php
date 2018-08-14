<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php wp_title( '|', true, 'right' ); ?></title>
    <script async type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
    <?php include_once "inc/favicon_urls.php"; ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header id="masthead">
    <div class="site-header" >
        <div class="container">
            <div class="row">
            	<div class="col-sm-12 hidden-xs hidden-sm">
                    <nav class="top-nav-wrapper">
                        <?php get_search_form(); ?>
                        <?php wp_nav_menu( array( 'theme_location' => 'social-menu', 'container' => '', 'menu_id' => 'header-social-menu', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'walker'=> new Icon_Walker_Nav_Menu(), ) ); ?>
                        <?php wp_nav_menu( array( 'theme_location' => 'top-menu', 'container' => '', 'menu_id' => 'top-menu' ) ); ?>
                    </nav>
                </div>
                <div class="col-sm-12">
                    <div class="site-header-inner">
                        <div class="logo-wrapper">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
                                <img src="<?php echo get_template_directory_uri() . '/images/logo.png'; ?>">
                            </a>
                        </div>
                        <nav class="site-navigation">
                            <div class="site-navigation-primary hidden-xs hidden-sm">
                                <?php wp_nav_menu( array( 'theme_location' => 'primary','depth' => 2,'container' => 'div','menu_class' => 'nav navbar-nav','menu_id' => 'main-menu', ) ); ?>
                            </div>
                        </nav>
                        <button class="dl-trigger hidden-md hidden-lg">Open Menu</button>
                    </div>
                </div>
            </div>
        </div>
        <nav class="mobile-nav-wrapper hidden visible-xs visible-sm ">
         <?php wp_nav_menu( array( 'items_wrap' =>  '<ul class="%2$s">%3$s</ul>', 'theme_location' => 'mobile-menu', 'depth' => 3, 'container' => 'div', 'menu_class' => 'dl-menu', 'menu_id' => 'dl-menu', 'container_id' => 'dl-menu', 'container_class' => 'dl-menuwrapper', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'walker'=> new DL_Walker_Nav_Menu(), ) ); ?>
        </nav>
    </div>
</header>