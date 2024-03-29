<?php
//Configurações de Suporte do theme

//Adicionando suporte ao thumbnail
add_theme_support('post-thumbnails');


//Registrando Menu
add_action( 'init', 'register_menus' );

function register_menus() {
	register_nav_menus(
		array(
			'primary' => __( 'Menu Principal' ),
		)
	);

}


//Adicionando css e javascript
add_action( 'wp_enqueue_scripts', 'wptuts_scripts_basic' );
function wptuts_scripts_basic()
{

	//Jquery
	wp_register_script( 'jquery-lib', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js' );
	wp_enqueue_script( 'jquery-lib' );


	

	//galeria de Imagens
	wp_register_script( 'ad-gallery', get_template_directory_uri() . '/galeria/jquery.ad-gallery.js' );
	wp_enqueue_script( 'ad-gallery' );

	wp_register_script( 'ad-gallery.min', get_template_directory_uri() . '/galeria/jquery.ad-gallery.min.js' );
	wp_enqueue_script( 'ad-gallery.min' );


	wp_register_style( 'ad-gallery', get_template_directory_uri() . '/galeria/jquery.ad-gallery.css', array(), '20130803', 'all'  );
	wp_enqueue_style( 'ad-gallery' );



	//Google Font

	wp_register_style( 'google-font', 'http://fonts.googleapis.com/css?family=Open+Sans:400,300,600', 
		array(), '20130804', 'all'  );
	wp_enqueue_style( 'google-font' );

}




/*
 * Criando o tipo Imóvel
 */
add_action( 'init', 'create_post_types' );
function create_post_types() {
	//cria o tipo imóvel para ser utilizado nos themas
	register_post_type( 'imovel',
		array(
			'labels' => array(
				'name' => __( 'Imóveis' ),
				'singular_name' => __( 'Imóvel' ),
				'add_new'            => _x( 'Adicionar novo', 'imóvel' ),
				'add_new_item'       => __( 'Adicionar novo imóvel' ),
				'edit_item'          => __( 'Edit imóvel' ),
				'new_item'           => __( 'Novo imóvel' ),
				'all_items'          => __( 'Todos os imóveis' ),
				'view_item'          => __( 'Ver imóvel' ),
				'search_items'       => __( 'Procurar imóvel' ),
				'not_found'          => __( 'Nenhum imóvel encontrado' ),
				'not_found_in_trash' => __( 'Nenhum imóvel na lixeira' ), 
				'parent_item_colon'  => '',
				'menu_name'          => 'Imóveis'
			),
		'supports' => array( 'title', 'editor', 'thumbnail'),
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
    	'show_in_menu' => true,
    	'capability_type' => 'post',
    	'hierarchical' => false,
    	'menu_position' => 4,
		'has_archive' => true,
		'rewrite' => array('slug' => 'imoveis'),
		'taxonomies' => array('post_tag'),
		)
	);
}

//Criando a Taxonomia para imóveis
add_action( 'init', 'create_imovel_taxonomies', 0 );
function create_imovel_taxonomies() {
    register_taxonomy(
        'imovel_tipos',
        'imovel',
        array(
            'labels' => array(
                'name' => 'Tipos de Imóveis',
                'add_new_item' => 'Adicionar novo tipo de imóvel',
                'new_item_name' => "Novo tipo de Imóvel"
            ),
            'hierarchical' => true,
            'show_ui' => true,
        	'show_in_tag_cloud' => true,
	        'query_var' => true,
        )
    );
}



//Criando o widget para inserçnao dos dados adicionais do imóvel
add_action("admin_init", "admin_init");
add_action('save_post', 'save_imovelinfo');

function admin_init(){
	add_meta_box("imovelInfo-meta", "Opções do Imóvel", "meta_options", "imovel", "normal", "low");
}
	


//Cria formulário do imóvel	
function meta_options(){
	global $post;
	$custom = get_post_custom($post->ID);
	$preco = $custom["preco"][0];			
	$condominio = $custom["condominio"][0];		
	$bairro = $custom["bairro"][0];		
	$cidade = $custom["cidade"][0];		
	$estado = $custom["estado"][0];
	$tipo_operacao = $custom["tipo_operacao"][0];		
	$quartos = $custom["quartos"][0];
	$banheiros = $custom["banheiros"][0];
	$area_util = $custom["area_util"][0];
	$garagem = $custom["garagem"][0];
	?>
		<style type="text/css">

		.imovelinfo input{
			width: 150px;
			border:1px solid #ccc;
		}

		.imovelinfo select{
			width: 150px;
			border:1px solid #ccc;
		}


		</style>
		<div class='imovelinfo'>
		<table>
			<tr>
				<td>Tipo</td>
				<td>
					<select name='tipo_operacao'>
						<option value='Vender' <?php echo $tipo_operacao=='Vender'?'selected':''; ?> >Vender</option>
						<option value='Alugar' <?php echo $tipo_operacao=='Alugar'?'selected':''; ?>>Alugar</option>
						<option value='Temporada' <?php echo $tipo_operacao=='Temporada'?'selected':''; ?>>Temporada</option>
					</select>

				</td>
			</tr>
			<tr>
				<td>Valor</td>
				<td><input name="preco" value="<?php echo $preco; ?>"/><br/></td>
			</tr>
			<tr>
				<td>Condominio</td>
				<td><input name="condominio" value="<?php echo $condominio; ?>"/><br/></td>
			</tr>

			<tr>
				<td>Bairro</td>
				<td><input name="bairro" value="<?php echo $bairro; ?>"/><br/></td>
			</tr>
			<tr>
				<td>Cidade</td>
				<td><input name="cidade" value="<?php echo $cidade; ?>"/><br/></td>
			</tr>
			<tr>
				<td>Estado</td>
				<td><input name="estado" value="<?php echo $estado; ?>"/><br/></td>
			</tr>
			<tr>
				<td>Quartos</td>
				<td><input name="quartos" value="<?php echo $quartos; ?>"/><br/></td>
			</tr>
			<tr>
				<td>Banheiros</td>
				<td><input name="banheiros" value="<?php echo $banheiros; ?>"/><br/></td>
			</tr>
			<tr>
				<td>Área util</td>
				<td><input name="area_util" value="<?php echo $area_util; ?>"/>m² de área útil.<br/></td>
			</tr>
			<tr>
				<td>Garagem</td>
				<td><input name="garagem" value="<?php echo $garagem; ?>"/><br/></td>
			</tr>
			
		</table>
		
		</div>
	<?php
}

function save_imovelinfo(){
	//Função que salva os dados o widget de detalhes do imóvel
	global $post;
	update_post_meta($post->ID, "preco", $_POST["preco"]);
	update_post_meta($post->ID, "condominio", $_POST["condominio"]);
	update_post_meta($post->ID, "bairro", $_POST["bairro"]);
	update_post_meta($post->ID, "cidade", $_POST["cidade"]);
	update_post_meta($post->ID, "estado", $_POST["estado"]);
	update_post_meta($post->ID, "tipo_operacao", $_POST["tipo_operacao"]);
	update_post_meta($post->ID, "quartos", $_POST["quartos"]);
	update_post_meta($post->ID, "banheiros", $_POST["banheiros"]);
	update_post_meta($post->ID, "area_util", $_POST["area_util"]);
	update_post_meta($post->ID, "garagem", $_POST["garagem"]);
}





/**
 * Register our sidebars and widgetized areas.
 *
 */
function widgets_register() {

	//Widgets da Home
	register_sidebar( array(
		'name' => 'Destaque Home - Area 1',
		'id' => 'home_area_1',
	) );

	register_sidebar( array(
		'name' => 'Destaque Home - Area 2',
		'id' => 'home_area_2',
	) );

	register_sidebar( array(
		'name' => 'Destaque Home - Area 3',
		'id' => 'home_area_3',
	) );


	register_sidebar( array(
		'name' => 'Listagem de Imóveis',
		'id' => 'sidebar_categorias',
	) );

	register_sidebar( array(
		'name' => 'Rodapé',
		'id' => 'sidebar_rodape',
	) );
}
add_action( 'widgets_init', 'widgets_register' );








//Galeria de Imagens da tela do Imóvel
function the_gallery() {
	$attachments = get_children( array('post_parent' => get_the_ID(), 
										'post_type' => 'attachment', 
										'post_mime_type' => 'image') );
	?>
	<!-- Inicio da galeria de Imagens -->
	<div class="ad-gallery">
	  <div class="ad-image-wrapper">
	  </div>
	  <!-- <div class="ad-controls"></div> -->
	  <div class="ad-nav">
	    <div class="ad-thumbs">
	      <ul class="ad-thumb-list">
		<?php
		foreach ( $attachments as $attachment_id => $attachment ) {
			$image_attributes = wp_get_attachment_image_src( $attachment_id,'large' );
			?>
			<li>
	          		<a href="<?php echo $image_attributes[0]; ?>">
	            	<?php echo wp_get_attachment_image($attachment_id,array(75,75)); ?>	
	          		</a>
	        </li>
			<?php
		}
		?>
	      </ul>
	    </div>
	  </div>
	</div>
	<!-- Fim da galeria de Imagens -->
	<?php
}


//widgets


 
/** Register Widget **/
function load_widgets() {
	register_widget( 'Imovel_Search' );
	register_widget( 'Imovel_Carrossel' );
}


add_action( 'widgets_init', 'load_widgets' );
 
/** Criando widgets **/
class Imovel_Search extends WP_Widget {
	function Imovel_Search() {
		$widget_ops = array( 'classname' => 'widget_imovel_search', 'description' => 'Widget para busca de imóveis' );
		$control_ops = array( 'id_base' => 'imovel_search' );
 
		/* Create the widget. */
		$this->WP_Widget( 'imovel_search', 'Pesquisa de Imóveis', $widget_ops, $control_ops );
	}
 

	function widget( $args, $instance ) {
		
		$pesquisa_form=file_get_contents(get_template_directory_uri().'/templates/pesquisa_form.html');

		

		//Carregando variaveis do Thema
		$pesquisa_form=str_replace('{THEME_URL}', get_template_directory_uri(), $pesquisa_form);
		$pesquisa_form=str_replace('{OPERACAO}', $this->get_operations('tipo_operacao'), $pesquisa_form);

		echo $pesquisa_form;
	}

	function get_operations($meta_key){
	    global $wpdb;
	    $data   =   array();

	    $sql="
	        SELECT `meta_key`, `meta_value`
	        FROM $wpdb->postmeta
	        WHERE `meta_key`='$meta_key' GROUP BY `meta_value`
	    ";

	    $options='';
	    foreach($wpdb->get_results($sql) as $k => $v){
	        //$data[$v->meta_key][] = $v->meta_value;
	        $options.="<option value='$v->meta_value'>$v->meta_value</option>";
	    };


	    return $options;
	}
}


class Imovel_Carrossel extends WP_Widget {
	function Imovel_Carrossel() {
		$widget_ops = array( 'classname' => 'widget_imovel_carrossel', 'description' => 'Carrossel de imóveis' );
		$control_ops = array( 'id_base' => 'imovel_carrossel' );
 
		/* Create the widget. */
		$this->WP_Widget( 'imovel_carrossel', 'Carrossel de imóveis', $widget_ops, $control_ops );
	}


	// widget form creation
	function form($instance) {

		// Check values
		if( $instance) {
		     $title = esc_attr($instance['title']);
		     $text = esc_textarea($instance['text']);
		} else {
		     $title = '';
		     $text = '';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Título do Carrossel', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id('text'); ?>"><?php _e('Categoria dos imóveis que serão exibidos', 'wp_widget_plugin'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>" type="text" value="<?php echo $text; ?>" />
		</p>
	<?php
	}

	// widget update
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
      	// Fields
      	$instance['title'] = strip_tags($new_instance['title']);
      	$instance['text'] = strip_tags($new_instance['text']);
     	return $instance;
	}
 





	function widget( $args, $instance ) {
		$title = apply_filters('widget_title', $instance['title']);
		$taxonomia = apply_filters('widget_title', $instance['text']);
		

 		//Filtra posts com as informações
		query_posts(array(
		    'post_type' => 'imovel', // custom post type
		    'orderby' => $sort_by,
		    'tax_query' => array(
				array(
					'taxonomy' => 'imovel_tipos', //or tag or custom taxonomy
					'field' => 'slug',
					'terms' => array($taxonomia)
				)
			),
		    'order' => $sort_order,
			'limit' =>4,
		));		

		?>
			<h2><?php echo $title; ?></h2>
			<div class='carrossel_widget'>
				<ul class='imovel_lista'>
				<?php
				if(have_posts())
				{
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
				}
				?>
				</ul>
		</div>
		<?php
	}

}




























