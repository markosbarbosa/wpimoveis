<?php
//Configurações de Suporte do theme

//Adicionando suporte ao thumbnail
add_theme_support('post-thumbnails');


//Registrando Menu
add_action( 'init', 'register_menus' );

function register_menus() {
	register_nav_menus(
		array(
			'menu_header' => __( 'Menu Header' ),
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
	
	

	//Css dos imóveis
	wp_register_style( 'style-imoveis', get_template_directory_uri() . '/css/imoveis.css', array(), '20130803', 'all'  );
	wp_enqueue_style( 'style-imoveis' );


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
	?>
		<style type="text/css">

		.imovelinfo input{
			width: 150px;
			border:1px solid #ccc;
		}


		</style>
		<div class='imovelinfo'>
		<table>
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
}





/**
 * Register our sidebars and widgetized areas.
 *
 */
function imoveis_widgets_init() {

	register_sidebar( array(
		'name' => 'banner_homme',
		'id' => 'home_right',
	) );
}
add_action( 'widgets_init', 'imoveis_widgets_init' );






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
	  <div class="ad-controls">
	  </div>
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




































