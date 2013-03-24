<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Riverside.io 1.0
 */

/*
 * Add class to allow styling for toolbar.
 */
$html_class = ( is_admin_bar_showing() ) ? 'wp-toolbar' : '';

?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7 <?php echo $html_class; ?>" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8 <?php echo $html_class; ?>" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html class="<?php echo $html_class; ?>" <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />


	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin,latin-ext" rel="stylesheet">

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/bootstrap.css" />
	
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<![endif]-->
	<?php wp_head(); ?>

	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/changes.css" />
</head>

<body <?php body_class(); ?>>
	<div id="page" class="hfeed site">
		<header id="masthead" class="site-header" role="banner">

<!--
			<div style="max-width: 1600px;width: 100%;">
				<div style="clear: both;margin: 0 auto;max-width: 1040px;min-height: 45px;position: relative;">
					<img src="<?php echo get_template_directory_uri(); ?>/images/riverside-io.svg" style="height: auto;margin: 0 10px 0 0;max-width: 150px;float:left;" />			
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div>
			</div>
-->
<!--
			<div class="container-fluid">
				<div class="row-fluid">
					<div class="span2 offset2">
						<div class="site-logo">
							<img src="<?php echo get_template_directory_uri(); ?>/images/riverside-io.svg" />
						</div>
					</div>
					<div class="span6">
						<hgroup>
							<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
							<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
						</hgroup>
					</div>
				</div>
			</div>

-->

			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<hgroup>
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</hgroup>
			</a>

			<div id="navbar" class="navbar">
				<nav id="site-navigation" class="navigation main-navigation" role="navigation">
					<h3 class="menu-toggle"><?php _e( 'Menu', 'riversideio' ); ?></h3>
					<a class="assistive-text skip-link" href="#content" title="<?php esc_attr_e( 'Skip to content', 'riversideio' ); ?>"><?php _e( 'Skip to content', 'riversideio' ); ?></a>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
					<?php //get_search_form(); ?>
				</nav><!-- #site-navigation -->
			</div><!-- #navbar -->
		</header><!-- #masthead -->

		<div id="main" class="site-main">
