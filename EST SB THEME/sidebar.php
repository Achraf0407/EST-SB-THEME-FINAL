<?php


if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
<div id="sidebar" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
<!-- #secondary -->
</div>