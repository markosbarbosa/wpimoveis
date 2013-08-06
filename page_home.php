<?php
/*
 * Template Name: Página Principal
 */
?>

<?php get_header(); ?>
<div id="main">
	<div id="content" class="home">
		
		<h1>Bem vindo, você esta na página principal do site</h1>

		<div>
			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar_destaque_home') ) : ''; endif; ?>
		</div>













	</div>
</div>
<div id="delimiter">
</div>
<?php get_footer(); ?>