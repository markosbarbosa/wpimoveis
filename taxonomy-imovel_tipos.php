<?php get_header(); ?>
<div id="main">
	<div id="content">
		
		<h1>Listagem de Imóveis</h1>


		<?php if(have_posts())
		{
			?>
			<ul class='imovel_lista'>
			<?php
			while (have_posts()) : the_post(); ?>
				<li>
					<?php if ( has_post_thumbnail()) : ?>
   						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
   							<?php the_post_thumbnail(); ?>
   						</a>
 					<?php endif; ?>
					<h2><?php the_title(); ?></h2>
					<h4>Posted on <?php the_time('F jS, Y') ?></h4>
					<p><?php the_content(__('(more...)')); ?></p>
				</li>
			<?php
			endwhile;
			?>
			</ul>
			<?php
		}else{
			?>
				<p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
			<?php
		}
		?>
		
	</div>
	<?php get_sidebar(); ?>
</div>
<div id="delimiter">
</div>
<?php get_footer(); ?>