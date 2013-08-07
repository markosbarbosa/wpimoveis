<?php
/*
 * Template Name: Página Principal
 */
?>

<?php get_header(); ?>
<div id="main">
	<div id="content" class="home">
		<div class="widget area_1">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home_area_1') ) : ''; endif; ?>
		</div>
		

		<div class="widget area_2">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home_area_2') ) : ''; endif; ?>
		</div>

		<div class="widget area_3">
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('home_area_3') ) : ''; endif; ?>

		</div>













	</div>
</div>
<div id="delimiter">
</div>
<?php get_footer(); ?>