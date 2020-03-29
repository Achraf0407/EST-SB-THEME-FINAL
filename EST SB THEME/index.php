<?php

global $post;  
$todoslosthememods=get_theme_mods();
//print_r($todoslosthememods); 
$customheader=0;
foreach($todoslosthememods as $key =>
 $value)
	{
	   if(preg_match('/^nt_featured_pages/', $key))
	   {
		   if ($customheader==0){
				$menunumber=str_replace("nt_featured_pages","",$key);						
				if (in_array("123454321", $value)) { //Assigned to homepage
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
if ($customheader==0) get_header(); 
?>


<div class="wrap">

	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">


			
<div class="blockheader2">
</div>
<span id='tgback-1'>
</span>
 <?php if( get_theme_mod( "tgback-1") != "" ) echo "<style>
#headback-bottom-box{background-image:url(".get_theme_mod( "tgback-1").");} </style>
"?>
<div id="headback-bottom-box">
<div id="ic77sn5">
<div id="icmowj3">
<i id="ichp96i" title="EST SB ">
<span id="ieud6o">
<span id="tgtext-1">
<?php if( get_theme_mod( "tgtext-1") != "" ) {echo get_theme_mod( "tgtext-1");} else {echo "EST SIDI BENNOUR
        ";} ?>
</span>
</span>
<br id="i5huyl" />
</i>
</div>
<div id="ic9dlb" class="tganimate anim-vdrk6 fadeInLeft">
</div>
<i title="EST SB " id="is0fin">
<span id="ia0xfw">
<span id="tgtext-2">
<?php if( get_theme_mod( "tgtext-2") != "" ) {echo get_theme_mod( "tgtext-2");} else {echo "GI-TM-GA
      ";} ?>
</span>
</span>
<br id="if6jaz" />
</i>
<div id="ic70ks" class="tganimate fadeInUp anim-uqr4n">
</div>
</div>
</div>
<span id='tgback-2'>
</span>
 <?php if( get_theme_mod( "tgback-2") != "" ) echo "<style>
#ic2ymn2{background-image:url(".get_theme_mod( "tgback-2").");} </style>
"?>
<div id="ic2ymn2">
<div class="tganimate anim-jvbom fadeInRight">
<div id="ic06phx">
<div class="cor-autumn-about-image">
<span id="tgimg-1">
<img <?php if( get_theme_mod( "tgimg-1") != "" ) {echo "src='".get_theme_mod( "tgimg-1")."'";} else {echo " src='".get_template_directory_uri()."/images/57358123_683129582118854_216901580511353-2cd.jpg'";} ?>
 id="ic73zyf" />
</span>
</div>
<div class="cor-autumn-about-text">
<div id="ic0k4vv">
<span id="tgtext-3">
<?php if( get_theme_mod( "tgtext-3") != "" ) {echo get_theme_mod( "tgtext-3");} else {echo "À PROPOS DE NOUS ";} ?>
</span>
</div>
<span id="iokwmn">
</span>
<br class="Apple-interchange-newline" />
</div>
<div id="ijtn7h">
<span id="ibakiv">
<span id="tgtext-4">
<?php if( get_theme_mod( "tgtext-4") != "" ) {echo get_theme_mod( "tgtext-4");} else {echo "Ecole Supérieure de Technologie Sidi Bennour  est un établissement public d’enseignement supérieur à finalité de formation des Techniciens Supérieurs. Elle a été créée en Août 2016 par le Ministère de l’Enseignement Supérieur, de la Formation des Cadres et de la Recherche Scientifique du Royaume du Maroc.";} ?>
</span>
</span>
<div id="ibft7f">
<span id="tgtext-5">
<span id="tgtext-5">
<?php if( get_theme_mod( "tgtext-5") != "" ) {echo get_theme_mod( "tgtext-5");} else {echo "L’Ecole Supérieure de Technologie Sidi Bennour est une composante de l’Université Chouaib Doukkali d’El Jadida. Sa vocation est de former des Techniciens Supérieurs polyvalents, hautement qualifiés et immédiatement opérationnels après leur sortie de l’Ecole en tant que collaborateurs d’ingénieurs et de managers. Sont admis à l’ESTSB.";} ?>
</span>
</span>
</div>
<div id="ibnv2p" class="gjs-comp-selected">
<span id="tgtext-6">
<span id="tgtext-6">
<?php if( get_theme_mod( "tgtext-6") != "" ) {echo get_theme_mod( "tgtext-6");} else {echo "les bacheliers de l’enseignement secondaire technique, scientifique et tertiaire. L’admission à l’Ecole (au de Diplôme Universitaire de Technologie « DUT ») se fait par voie de sélection par ordre de mérite après une présélection sur la base des notes obtenues au baccalauréat. Les candidats doivent être âgés de 22 ans au plus au 31 Décembre de l’année du concours et doivent déposer leurs dossiers de pré-inscription avant le 30 Juin de chaque année universitaire";} ?>
</span>
</span>
</div>
</div>
<div id="icpil3l">
</div>
</div>
</div>
</div>
<section id="idybni" class="cor-flex-sect">
<div id="ixzzis" class="tganimate fadeInUp anim-g282d">
<div class="cor-containercards-width">
<div id="izzy0o" class="servicards">
<div class="servicard">
<span id="tgimg-2">
<img <?php if( get_theme_mod( "tgimg-2") != "" ) {echo "src='".get_theme_mod( "tgimg-2")."'";} else {echo " src='".get_template_directory_uri()."/images/1290406-1a4.svg'";} ?>
  class="servic17248" />
</span>
<div class="servicard-body">
<div class="servicard-title">
<div id="i1gr0x" class="servicard-title gjs-comp-selected">
<span id="tgtext-16">
<span id="tgtext-7">
<?php if( get_theme_mod( "tgtext-7") != "" ) {echo get_theme_mod( "tgtext-7");} else {echo "Génie agroenvironment";} ?>
</span>
</span>
</div>
</div>
<div class="servicard-sub-title">
<span id="tgtext-8">
<?php if( get_theme_mod( "tgtext-8") != "" ) {echo get_theme_mod( "tgtext-8");} else {echo "GA";} ?>
</span>
</div>
<div class="servicard-desc">
<span id="tgtext-9">
<?php if( get_theme_mod( "tgtext-9") != "" ) {echo get_theme_mod( "tgtext-9");} else {echo "La formation génie agroenvironment. permet  d'appréhender et gérer la complexité du vivant : végétaux, animaux, en intervenant sur leur production, leur transformation.";} ?>
</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="tganimate fadeInUp anim-g282d">
<div class="cor-containercards-width">
<div class="cor-flex-title">
<span id="tgtext-10">
<?php if( get_theme_mod( "tgtext-10") != "" ) {echo get_theme_mod( "tgtext-10");} else {echo "Les filières";} ?>
</span>
</div>
<div id="i9eozu">
</div>
<div class="servicards">
<div class="servicard">
<span id="tgimg-3">
<img <?php if( get_theme_mod( "tgimg-3") != "" ) {echo "src='".get_theme_mod( "tgimg-3")."'";} else {echo " src='".get_template_directory_uri()."/images/icone-ordinateur-962.png'";} ?>
  class="servic17248" />
</span>
<div class="servicard-body">
<div class="servicard-title">
<div class="servicard-title">
<span id="ixmt6b">
<span id="tgtext-11">
<?php if( get_theme_mod( "tgtext-11") != "" ) {echo get_theme_mod( "tgtext-11");} else {echo "Génie Informatique";} ?>
</span>
</span>
</div>
</div>
<div class="servicard-sub-title">
<span id="tgtext-12">
<?php if( get_theme_mod( "tgtext-12") != "" ) {echo get_theme_mod( "tgtext-12");} else {echo "GI";} ?>
</span>
</div>
<div class="servicard-desc">
<div class="servicard-title gjs-comp-selected">
<span id="i6lqs9">
<span id="tgtext-13">
<?php if( get_theme_mod( "tgtext-13") != "" ) {echo get_theme_mod( "tgtext-13");} else {echo "La filières Génie Infomatique forme les professionels qui participent à la conception, la réalisation et la mise en oeuvre de solutions informatiques. ";} ?>
</span>
</span>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="tganimate fadeInUp anim-g282d">
<div class="cor-containercards-width">
<div class="servicards">
<div class="servicard">
<span id="tgimg-4">
<img <?php if( get_theme_mod( "tgimg-4") != "" ) {echo "src='".get_theme_mod( "tgimg-4")."'";} else {echo " src='".get_template_directory_uri()."/images/2058276-715.svg'";} ?>
  class="servic17248" />
</span>
<div class="servicard-body">
<div class="servicard-title">
<div id="ij508j" class="servicard-title">
<span id="i4b3ct">
<span id="tgtext-14">
<?php if( get_theme_mod( "tgtext-14") != "" ) {echo get_theme_mod( "tgtext-14");} else {echo "Technique de Management";} ?>
</span>
</span>
</div>
</div>
<div class="servicard-sub-title">
<div>
<span id="iau93k">
<span id="tgtext-15">
<?php if( get_theme_mod( "tgtext-15") != "" ) {echo get_theme_mod( "tgtext-15");} else {echo "TM";} ?>
</span>
</span>
</div>
</div>
<div class="servicard-desc">
<div class="servicard-desc gjs-comp-selected">
<span id="i0y70k">
<span id="tgtext-16">
<?php if( get_theme_mod( "tgtext-16") != "" ) {echo get_theme_mod( "tgtext-16");} else {echo "La formation a pour projet de former des techniciens supérieurs en Techniques de management capables d’aider le responsable d’entreprise dans la gestion quotidienne de ses affaires";} ?>
</span>
</span>
<span id="tgtext-17">
<?php if( get_theme_mod( "tgtext-17") != "" ) {echo get_theme_mod( "tgtext-17");} else {echo ".
              
              
              ";} ?>
</span>
</div>
<span id="ip0eco">
</span>
</div>
</div>
</div>
</div>
</div>
</div>
<div>
</div>
<div>
</div>
</section>
<span id='tgback-3'>
</span>
 <?php if( get_theme_mod( "tgback-3") != "" ) echo "<style>
#icm9n9k{background-image:url(".get_theme_mod( "tgback-3").");} </style>
"?>
<div id="icm9n9k">
<section class="bdg-sect">
<div class="container-width">
<h1 class="bdg-title">
<h1 id="iugvih" data-highlightable="1" class="bdg-title gjs-comp-selected">
Corps pedagogique</h1>
</h1>
<div class="badges">
<div class="badge">
<span id='tgback-5'>
</span>
 <?php if( get_theme_mod( "tgback-5") != "" ) echo "<style>
.badge-header{background-image:url(".get_theme_mod( "tgback-5").");} </style>
"?>
<div class="badge-header">
</div>
<span id="tgimg-5">
<img <?php if( get_theme_mod( "tgimg-5") != "" ) {echo "src='".get_theme_mod( "tgimg-5")."'";} else {echo " src='".get_template_directory_uri()."/images/0-349.jpg'";} ?>
  class="badge-avatar" />
</span>
<div class="badge-body">
<div id="Baddi youssef" title="Baddi youssef" class="badge-name">
<span id="tgtext-18">
<?php if( get_theme_mod( "tgtext-18") != "" ) {echo get_theme_mod( "tgtext-18");} else {echo "Baddi youssef";} ?>
</span>
</div>
<div class="badge-role">
<span id="tgtext-19">
<?php if( get_theme_mod( "tgtext-19") != "" ) {echo get_theme_mod( "tgtext-19");} else {echo "Enseignant chercheur";} ?>
</span>
</div>
<div class="badge-desc">
<span id="tgtext-20">
<?php if( get_theme_mod( "tgtext-20") != "" ) {echo get_theme_mod( "tgtext-20");} else {echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ";} ?>
</span>
</div>
</div>
<div class="badge-foot" id="isbt3z">
<span class="badge-link">
<a href="<?php if( get_theme_mod( "tglink-4") != "" ) {echo get_theme_mod( "tglink-4");} else {echo "https://www.linkedin.com/in/youssefbaddi/";} ?>
" target="_blank" title="Baddi youssef" class="link">
<span id="tgtext-21">
<?php if( get_theme_mod( "tgtext-21") != "" ) {echo get_theme_mod( "tgtext-21");} else {echo "ln";} ?>
</span>
</a>
</span>
</div>
</div>
<div class="badge">
<div class="badge-header">
</div>
<span id="tgimg-6">
<img <?php if( get_theme_mod( "tgimg-6") != "" ) {echo "src='".get_theme_mod( "tgimg-6")."'";} else {echo " src='".get_template_directory_uri()."/images/directeur-aac.png'";} ?>
  class="badge-avatar" />
</span>
<div class="badge-body">
<div id="Najib Saber" title="Najib Saber" class="badge-name">
<span id="tgtext-22">
<?php if( get_theme_mod( "tgtext-22") != "" ) {echo get_theme_mod( "tgtext-22");} else {echo "Najib Saber";} ?>
</span>
</div>
<div class="badge-role">
<span id="tgtext-23">
<?php if( get_theme_mod( "tgtext-23") != "" ) {echo get_theme_mod( "tgtext-23");} else {echo "Directeur";} ?>
</span>
</div>
<div class="badge-desc">
<span id="tgtext-24">
<?php if( get_theme_mod( "tgtext-24") != "" ) {echo get_theme_mod( "tgtext-24");} else {echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ";} ?>
</span>
</div>
</div>
<div class="badge-foot">
<span class="badge-link">
<a href="<?php if( get_theme_mod( "tglink-5") != "" ) {echo get_theme_mod( "tglink-5");} else {echo "https://www.linkedin.com/in/najib-saber-44850414a/";} ?>
" id="idgwjv" target="_blank" title="Najib Saber" class="link gjs-comp-selected">
<span id="tgtext-25">
<?php if( get_theme_mod( "tgtext-25") != "" ) {echo get_theme_mod( "tgtext-25");} else {echo "ln";} ?>
</span>
</a>
</span>
</div>
</div>
<div class="badge">
<div class="badge-header">
</div>
<span id="tgimg-7">
<img <?php if( get_theme_mod( "tgimg-7") != "" ) {echo "src='".get_theme_mod( "tgimg-7")."'";} else {echo " src='".get_template_directory_uri()."/images/01-283.jpg'";} ?>
  class="badge-avatar" />
</span>
<div class="badge-body">
<div id="Saidi abdelali " title="Saidi abdelali " class="badge-name">
<span id="tgtext-26">
<?php if( get_theme_mod( "tgtext-26") != "" ) {echo get_theme_mod( "tgtext-26");} else {echo "Saidi abdelali ";} ?>
</span>
</div>
<div class="badge-role">
<span id="tgtext-27">
<?php if( get_theme_mod( "tgtext-27") != "" ) {echo get_theme_mod( "tgtext-27");} else {echo "Enseignant chercheur";} ?>
</span>
</div>
<div class="badge-desc">
<span id="tgtext-28">
<?php if( get_theme_mod( "tgtext-28") != "" ) {echo get_theme_mod( "tgtext-28");} else {echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ";} ?>
</span>
</div>
</div>
<div class="badge-foot">
<span class="badge-link">
<a href="<?php if( get_theme_mod( "tglink-6") != "" ) {echo get_theme_mod( "tglink-6");} else {echo "https://www.linkedin.com/in/abdelali-saidi-72a17a14/";} ?>
" target="_blank" title="Saidi abdelali " class="link">
<span id="tgtext-29">
<?php if( get_theme_mod( "tgtext-29") != "" ) {echo get_theme_mod( "tgtext-29");} else {echo "ln";} ?>
</span>
</a>
</span>
</div>
</div>
</div>
<div class="badges">
<div class="badge">
<div class="badge-header">
</div>
<span id="tgimg-8">
<img <?php if( get_theme_mod( "tgimg-8") != "" ) {echo "src='".get_theme_mod( "tgimg-8")."'";} else {echo " src='".get_template_directory_uri()."/images/proftoumi-c2d.png'";} ?>
  class="badge-avatar" />
</span>
<div class="badge-body">
<div title="Toumi Hicham" id="Toumi Hicham" class="badge-name">
<span id="tgtext-30">
<?php if( get_theme_mod( "tgtext-30") != "" ) {echo get_theme_mod( "tgtext-30");} else {echo "Toumi Hicham";} ?>
</span>
</div>
<div class="badge-role">
<span id="is1yb3">
<span id="tgtext-31">
<?php if( get_theme_mod( "tgtext-31") != "" ) {echo get_theme_mod( "tgtext-31");} else {echo "Enseignant chercheur";} ?>
</span>
</span>
</div>
<div class="badge-desc">
<span id="tgtext-32">
<?php if( get_theme_mod( "tgtext-32") != "" ) {echo get_theme_mod( "tgtext-32");} else {echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ";} ?>
</span>
</div>
</div>
<div class="badge-foot">
<span class="badge-link">
<a href="<?php if( get_theme_mod( "tglink-7") != "" ) {echo get_theme_mod( "tglink-7");} else {echo "https://www.linkedin.com/in/hicham-toumi-35baa977/";} ?>
" target="_blank" title="Toumi Hicham" class="link">
<span id="tgtext-33">
<?php if( get_theme_mod( "tgtext-33") != "" ) {echo get_theme_mod( "tgtext-33");} else {echo "ln";} ?>
</span>
</a>
</span>
</div>
</div>
<div class="badge">
<div class="badge-header">
</div>
<span id="tgimg-9">
<img <?php if( get_theme_mod( "tgimg-9") != "" ) {echo "src='".get_theme_mod( "tgimg-9")."'";} else {echo " src='".get_template_directory_uri()."/images/profmebrouk-94e.png'";} ?>
  class="badge-avatar" />
</span>
<div class="badge-body">
<div title="Mabrouk abdelfettah " id="Mabrouk abdelfettah " class="badge-name">
<span id="tgtext-34">
<?php if( get_theme_mod( "tgtext-34") != "" ) {echo get_theme_mod( "tgtext-34");} else {echo "Mabrouk abdelfettah ";} ?>
</span>
</div>
<div class="badge-role">
<span id="tgtext-35">
<?php if( get_theme_mod( "tgtext-35") != "" ) {echo get_theme_mod( "tgtext-35");} else {echo "Enseignant chercheur";} ?>
</span>
</div>
<div class="badge-desc">
<span id="tgtext-36">
<?php if( get_theme_mod( "tgtext-36") != "" ) {echo get_theme_mod( "tgtext-36");} else {echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore ipsum dolor sit ";} ?>
</span>
</div>
</div>
<div class="badge-foot">
<span class="badge-link">
<a href="<?php if( get_theme_mod( "tglink-8") != "" ) {echo get_theme_mod( "tglink-8");} else {echo "https://www.linkedin.com/in/abdelfettah-mabrouk-24b288113/";} ?>
" target="_blank" title="Mabrouk abdelfettah " class="link">
<span id="tgtext-37">
<?php if( get_theme_mod( "tgtext-37") != "" ) {echo get_theme_mod( "tgtext-37");} else {echo "ln";} ?>
</span>
</a>
</span>
</div>
</div>
</div>
</div>
</section>
<div id="iceqgxz">
</div>
<ul class="list">
</ul>
</div>
<span id='tgback-4'>
</span>
 <?php if( get_theme_mod( "tgback-4") != "" ) echo "<style>
.cor-bdg-sect{background-image:url(".get_theme_mod( "tgback-4").");} </style>
"?>
<section class="cor-bdg-sect">
<div id="imjwk3" class="cor-container-width">
<div class="tganimate fadeInUp anim-ixojo">
<div class="cor-flex-title">
<span id="tgtext-38">
<?php if( get_theme_mod( "tgtext-38") != "" ) {echo get_theme_mod( "tgtext-38");} else {echo "LOCATION";} ?>
</span>
</div>
</div>
<div id="ica8dyq">
</div>
<div class="tganimate fadeInUp anim-i6bv8">
<iframe frameborder="0" id="icx9xeg" src="https://maps.google.com/maps?&q=Facult�© des Lettres et des Sciences Humaines Avenue des Facult�©s, El Jadida 24000, Maroc&z=12&t=q&output=embed">
</iframe>
</div>
</div>
</section>


		</main>
<!-- #main -->

	</div>
<!-- #primary -->

	<?php get_sidebar(); ?>

</div>
<!-- .wrap -->


<?php 
 $customfooter=0;
 foreach($todoslosthememods as $key =>
 $value)
	{
	   if(preg_match('/^nt_featured_Foopages/', $key))
	   {
		   if ($customfooter==0){
				$menunumber=str_replace("nt_featured_Foopages","",$key);			
				$idpageactual=$post->
ID;			
				if (in_array($idpageactual, $value)) { //Assigned to this page
					get_footer("custom$menunumber");
					$customfooter=1;
				}
				if (in_array("123454321", $value)) { //Assigned to all pages
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
if ($customfooter==0) get_footer("");