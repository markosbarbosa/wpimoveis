<?php get_header(); ?>
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
<div id="main">
	<div id="content">
	
		<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>

		<div class='imovel'>
			<div class='destaque'>

				<div class='galeria_de_imagens'>
					<!-- Carrega todas as imagens vinculadas ao post -->	
					<?php the_gallery(); ?>
				</div>
				<div class='detalhes'>
          <?php $imovel_fields = get_post_custom(); ?>
          
					
				</div>
			</div>



		</div>



 
		<div class="entry-title"><?php the_title(); ?></div>
		<div class="entry-content"><?php the_content(); ?></div>
 
		<?php endwhile; endif; ?>		
		
	</div>
	<?php get_sidebar(); ?>
</div>
<div id="delimiter">
</div>
<?php get_footer(); ?>












