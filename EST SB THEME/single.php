<?php

 
 
global $post;  
$todoslosthememods=get_theme_mods();
//print_r($todoslosthememods); 
$customheader=0;
foreach($todoslosthememods as $key => $value)
	{
	   if(preg_match('/^nt_featured_pages/', $key))
	   {
		   if ($customheader==0){
				$menunumber=str_replace("nt_featured_pages","",$key);						
				if (in_array("987654321", $value)) { //Assigned to all pages
					get_header("custom$menunumber");
					$customheader=1;
				}
				if (in_array("0", $value)) { //Assigned to no pages
					//get_header("custom$menunumber");
					$customheader=0;
				}
		   } 			
	   }
	}	
if ($customheader==0) get_header("int"); 

$metabox=estsbtheme_metabox_get_meta( 'custom_metabox_show_titlepost' );
if (!empty($metabox)) {
		wp_register_style( 'tgdummy-handle', false );
		wp_enqueue_style( 'tgdummy-handle' );
		wp_add_inline_style( 'tgdummy-handle', ".entry-title{display: $metabox!important;}" );	
	}  else {
		wp_register_style( 'tgdummy-handle', false );
		wp_enqueue_style( 'tgdummy-handle' );
		wp_add_inline_style( 'tgdummy-handle', ".entry-title{display: block!important;}" );							
	}
$metabox2=estsbtheme_metabox_get_meta( 'custom_metabox_show_metapost');
if (!empty($metabox2)) {
		wp_register_style( 'tgdummy-handle2', false );
		wp_enqueue_style( 'tgdummy-handle2' );
		wp_add_inline_style( 'tgdummy-handle2', ".entry-meta{display: $metabox2!important;}" );	
	}  else {
		wp_register_style( 'tgdummy-handle2', false );
		wp_enqueue_style( 'tgdummy-handle2' );
		wp_add_inline_style( 'tgdummy-handle2', ".entry-meta{display: block!important;}" );							
	}
?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/post/content', get_post_format() );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
					echo "<div id='optional-comments-style' style='display:none;'>";
						comment_form();
						wp_list_comments();
						paginate_comments_links();
					echo "</div>";
				endif;

				the_post_navigation( array(
					'prev_text' => '<span class="screen-reader-text">' . __( 'Previous Post', 'estsbtheme' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Previous', 'estsbtheme' ) . '</span> <span class="nav-title"><span class="nav-title-icon-wrapper">' . estsbtheme_get_svg( array( 'icon' => 'arrow-left' ) ) . '</span>%title</span>',
					'next_text' => '<span class="screen-reader-text">' . __( 'Next Post', 'estsbtheme' ) . '</span><span aria-hidden="true" class="nav-subtitle">' . __( 'Next', 'estsbtheme' ) . '</span> <span class="nav-title">%title<span class="nav-title-icon-wrapper">' . estsbtheme_get_svg( array( 'icon' => 'arrow-right' ) ) . '</span></span>',
				) );

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
	<?php get_sidebar(); ?>
</div><!-- .wrap -->

<?php 
 $customfooter=0;
 foreach($todoslosthememods as $key => $value)
	{
	   if(preg_match('/^nt_featured_Foopages/', $key))
	   {
		   if ($customfooter==0){
				$menunumber=str_replace("nt_featured_Foopages","",$key);			
				$idpageactual=$post->ID;			
				if (in_array($idpageactual, $value)) { //Assigned to this page
					get_footer("custom$menunumber");
					$customfooter=1;
				}
				if (in_array("987654321", $value)) { //Assigned to all pages
					get_footer("custom$menunumber");
					$customfooter=1;
				}
				if (in_array("0", $value)) { //Assigned to no pages
					//get_footer("custom$menunumber");
					$customfooter=0;
				}
		   } 			
	   }
	}	
if ($customfooter==0) get_footer("int");
