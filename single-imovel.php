<?php get_header(); ?>
<!-- Script para galeria de Imagens :: Comeco -->
<script type="text/javascript">
  $(function() {
    $('img.image1').data('ad-desc', 'Whoa! This description is set through elm.data("ad-desc") instead of using the longdesc attribute.<br>And it contains <strong>H</strong>ow <strong>T</strong>o <strong>M</strong>eet <strong>L</strong>adies... <em>What?</em> That aint what HTML stands for? Man...');
    $('img.image1').data('ad-title', 'Title through $.data');
    $('img.image4').data('ad-desc', 'This image is wider than the wrapper, so it has been scaled down');
    $('img.image5').data('ad-desc', 'This image is higher than the wrapper, so it has been scaled down');
    var galleries = $('.ad-gallery').adGallery();
    
    
    $('#switch-effect').change(
      function() {
        galleries[0].settings.effect = $(this).val();
        return false;
      }
    );
    $('#toggle-slideshow').click(
      function() {
        galleries[0].slideshow.toggle();
        return false;
      }
    );
    $('#toggle-description').click(
      function() {
        if(!galleries[0].settings.description_wrapper) {
          galleries[0].settings.description_wrapper = $('#descriptions');
        } else {
          galleries[0].settings.description_wrapper = false;
        }
        return false;
      }
    );
  });
  </script>
  <!-- Script para galeria de Imagens :: Fim -->
<div id="main">
	<div id="content">
	
		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

		<div class='imovel'>
      
      <h2><?php the_title(); ?></h2>

			<div class='destaque'>
        <div class='detalhes'>
          <?php $imovel_fields = get_post_custom(); ?>
          
          <div class='operacao'>
            Imóvel para <?php echo $imovel_fields['tipo_operacao'][0] ?>
          </div>
          <div class='bairro'>
            <?php echo $imovel_fields['bairro'][0] ?>
          </div>
          <div class='cidade_estado'>
            <?php echo $imovel_fields['cidade'][0] ?> / <?php echo $imovel_fields['estado'][0] ?>
          </div>
          
          <div class='preco'>
            <div><span>R$</span><?php echo $imovel_fields['preco'][0] ?></div>
            <div class='condominio'><span>R$</span><?php echo $imovel_fields['condominio'][0] ?></div>
          </div>
          

          <div class='quartos'>
            <?php echo $imovel_fields['quartos'][0] ?> quarto(s)
          </div>
          <div class='banheiros'>
            <?php echo $imovel_fields['banheiros'][0] ?> banheiro(s)
          </div>
          <div class='area_util'>
            <?php echo $imovel_fields['area_util'][0] ?>m² de área útil
          </div>
          <div class='garagem'>
            <?php echo $imovel_fields['garagem'][0] ?> vaga(s)
          </div>
  

        </div>



				<div class='galeria_de_imagens'>
					<!-- Carrega todas as imagens vinculadas ao post -->	
					<?php the_gallery(); ?>
				</div>
				
			</div>
		</div>

  
    <div class='observacoes'>
    <h2>Mais Informações</h2>
    <div class='content'>
      <?php the_content(); ?>
    </div>
    </div>

		<?php endwhile; endif; ?>		
		
	</div>
	<?php get_sidebar('imovel'); ?>
</div>
<div id="delimiter">
</div>
<?php get_footer(); ?>












