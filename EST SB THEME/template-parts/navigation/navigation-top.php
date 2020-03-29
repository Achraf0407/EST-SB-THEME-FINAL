<?php
/**
 * Displays top navigation
 */

?>
<nav id="site-navigation" class="main-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Top Menu', 'estsbtheme' ); ?>">
	<button class="menu-toggle" aria-controls="top-menu" aria-expanded="false">
		<?php
		echo estsbtheme_get_svg( array( 'icon' => 'bars' ) );
		echo estsbtheme_get_svg( array( 'icon' => 'close' ) );
		_e( 'Menu', 'estsbtheme' );
		?>
	</button>

	<?php wp_nav_menu( array(
		'theme_location' => 'top',
		'menu_id'        => 'top-menu',
	) ); ?>

	<?php if ( ( estsbtheme_is_frontpage() || ( is_home() && is_front_page() ) ) && has_custom_header() ) : ?>
		<a href="#content" class="menu-scroll-down"><?php echo estsbtheme_get_svg( array( 'icon' => 'arrow-right' ) ); ?><span class="screen-reader-text"><?php _e( 'Scroll down to content', 'estsbtheme' ); ?></span></a>
	<?php endif; ?>
</nav><!-- #site-navigation -->
