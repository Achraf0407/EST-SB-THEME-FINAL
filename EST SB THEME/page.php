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
				$idpageactual=$post->ID;			
				if (in_array($idpageactual, $value)) { //Assigned to this page
					get_header("custom$menunumber");
					$customheader=1;
				}
				if (in_array("123456789", $value)) { //Assigned to all pages
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

$metabox=estsbtheme_metabox_get_meta( 'custom_metabox_show_title' );
if (!empty($metabox)) {
		wp_register_style( 'tgdummy-handle', false );
		wp_enqueue_style( 'tgdummy-handle' );
		wp_add_inline_style( 'tgdummy-handle', ".entry-title{display: $metabox!important;}" );	
	} else {
		wp_register_style( 'tgdummy-handle', false );
		wp_enqueue_style( 'tgdummy-handle' );
		wp_add_inline_style( 'tgdummy-handle', ".entry-title{display: block!important;}" );							
	}

?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post();
			?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
				
				
				
				<?php if( ! empty( $post->post_title ) ) : ?>
					<header class="entry-header">
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
						<?php /*estsbtheme_edit_link( get_the_ID() );*/?>
					</header><!-- .entry-header -->					
				<?php endif; ?>
				
				
				
				
				
					
					<div class="entry-content">
						<?php
							the_content();

							wp_link_pages( array(
								'before' => '<div class="page-links">' . __( 'Pages:', 'estsbtheme' ),
								'after'  => '</div>',
							) );
						?>
					</div><!-- .entry-content -->
				</article><!-- #post-## -->

			<?php		
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->
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
				if (in_array("123456789", $value)) { //Assigned to all pages
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
if (($customfooter==0)&&(!is_front_page())) get_footer("int"); 
if (($customfooter==0)&&(is_front_page())) get_footer();