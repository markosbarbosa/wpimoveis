TELA DO IMOVEL

<?php if ( have_posts() ) : while( have_posts() ) : the_post(); ?>
 
<div class="entry-title"><?php the_title(); ?></div>
<div class="entry-content"><?php the_content(); ?></div>
 
<?php endwhile; endif; ?>