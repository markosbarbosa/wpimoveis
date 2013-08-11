<?php get_header(); ?>
<div id="main">
	<div id="content" class="imovel_tipo_page">
		
		<h2>Listagem de Imóveis</h2>


		<?php if(have_posts())
		{
			?>
			<ul class='imovel_lista'>
			<?php
			while (have_posts()) : the_post(); ?>
				<li>
					<?php if ( has_post_thumbnail()) : ?>
   						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
   							<?php
								$url_thumbnail = wp_get_attachment_url( get_post_thumbnail_id($post->ID,array(200,200)) );
   							?>
   							<div 
   							class="foto" 
   							style="background:url('<?php echo $url_thumbnail; ?>') no-repeat center center;">
   							</div>
   						</a>
 					<?php endif; ?>
 					<?php $imovel_fields = get_post_custom(); ?>
					<div class='detalhes'>
						<div class='bairro'><?php echo $imovel_fields['bairro'][0] ?></div>
						<div class='cidade_estado'><?php echo $imovel_fields['cidade'][0] ?> / <?php echo $imovel_fields['estado'][0] ?></div>
						<div class='preco'><div><span>R$</span><?php echo $imovel_fields['preco'][0] ?></div></div>

						<div class='maisinfo'>
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
   								Mais detalhes
   							</a>
						</div>

					</div>
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
	<?php get_sidebar('listagemimoveis'); ?>
</div>
<div id="delimiter">
</div>
<?php get_footer(); ?>