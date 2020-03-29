<?php


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<html <?php language_attributes(); ?>
 class="no-js no-svg">

<head>

<meta charset="<?php bloginfo( 'charset' ); ?>
">

<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

<link rel="profile" href="http://gmpg.org/xfn/11">



<?php wp_head(); ?>




<link rel='stylesheet' id='dashicons-css'  href='<?php echo get_stylesheet_directory_uri()."/css/style.css";?>
' type='text/css' media='all' />


</head>

<span id='tgback-0'>
</span>

<body <?php body_class(); ?>
>

<div class="blockheader2">
</div>
<div class="blockheader2">
<div class="h2-topbar">
<div class="h2-topcontainer">
<div class="h2-topcolA">
<div class="h2-topdetails">
<b>
communication@ucd.ac.ma</b>
</div>
<div class="h2-topdetails">
<b id="iaw3lv">
05 23 34 44 4<a href="<?php if( get_theme_mod( "tglink-1") != "" ) {echo get_theme_mod( "tglink-1");} else {echo "https://estsbtheme.com/?editmode=ok";} ?>
" id="igv1i1">
</a>
7/05 23 34 44 48  </b>
</div>
</div>
<div class="h2-topcolB">
<a href="<?php if( get_theme_mod( "tglink-2") != "" ) {echo get_theme_mod( "tglink-2");} else {echo "https://www.facebook.com/ESTSidiBennour/";} ?>
" title="Facebook" target="_blank" class="h2-toplink">
<span id="tgimg-13">
<img <?php if( get_theme_mod( "tgimg-13") != "" ) {echo "src='".get_theme_mod( "tgimg-13")."'";} else {echo " src='".get_template_directory_uri()."/images/Asset1-97f.svg'";} ?>
  class="h2-topsocialicons" />
</span>
</a>
<a href="<?php if( get_theme_mod( "tglink-3") != "" ) {echo get_theme_mod( "tglink-3");} else {echo "https://www.instagram.com";} ?>
" title="Instagram" target="_blank" class="h2-toplink">
<span id="tgimg-14">
<img <?php if( get_theme_mod( "tgimg-14") != "" ) {echo "src='".get_theme_mod( "tgimg-14")."'";} else {echo " src='".get_template_directory_uri()."/images/Asset2-ac6.svg'";} ?>
  class="h2-topsocialicons" />
</span>
</a>
</div>
<div id="ih1xg">
</div>
</div>
</div>
<div class="h2-bar">
<div class="h2-barcontainer">
<div class="h2-barcolA">
<span id="tgimg-15">
<img <?php if( get_theme_mod( "tgimg-15") != "" ) {echo "src='".get_theme_mod( "tgimg-15")."'";} else {echo " src='".get_template_directory_uri()."/images/Fichier2estsblogo2-9d0.png'";} ?>
 id="izs4fl" />
</span>
</div>
<div class="h2-barcolB">
</div>
<div id="ilemv">
</div>
</div>
</div>
</div>
</div>
<div id="page" class="site">

	<a class="skip-link screen-reader-text" href="#content">
<?php _e( 'Skip to content', 'estsbtheme' ); ?>
</a>


	<header id="masthead" class="site-header" role="banner">


		<?php get_template_part( 'template-parts/header/header', 'image' ); ?>


		<?php if ( has_nav_menu( 'top' ) ) : ?>

			<div class="navigation-top">

				<div class="wrap">

					<?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>

				</div>
<!-- .wrap -->

			</div>
<!-- .navigation-top -->

		<?php endif; ?>


	</header>
<!-- #masthead -->


	<?php

	/*
	 * If a regular post or page, and not the front page, show the featured image.
	 * Using get_queried_object_id() here since the $post global may not be set before a call to the_post().
	 */
	if ( ( is_single() || ( is_page() && ! estsbtheme_is_frontpage() ) ) && has_post_thumbnail( get_queried_object_id() ) ) :
		echo '<div class="single-featured-image-header">
';
		echo get_the_post_thumbnail( get_queried_object_id(), 'estsbtheme-featured-image' );
		echo '</div>
<!-- .single-featured-image-header -->
';
	endif;
	?>


	<div class="site-content-contain">

		<div id="content" class="site-content">

