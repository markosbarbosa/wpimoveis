<?php

/*
 * Tipo cistpmizado - Imóvel
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
				'edit_item'          => __( 'Edit Product' ),
				'new_item'           => __( 'Novo imóvel' ),
				'all_items'          => __( 'Todos os imóveis' ),
				'view_item'          => __( 'Ver imóvel' ),
				'search_items'       => __( 'Procurar imóvel' ),
				'not_found'          => __( 'Nenhum imóvel encontrado' ),
				'not_found_in_trash' => __( 'Nenhum imóvel na liveixa' ), 
				'parent_item_colon'  => '',
				'menu_name'          => 'Imóveis'
			),
		'public' => true,
		'has_archive' => true,
		'supports' => array( 'title', 'editor', 'thumbnail' ),
		'rewrite' => array('slug' => 'imoveis'),
		'taxonomies' => array('post_tag'),
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


add_action( 'init', 'create_imovel_taxonomies', 0 );
function create_imovel_taxonomies() {
    register_taxonomy(
        'imovel_tipo',
        'imovel',
        array(
            'labels' => array(
                'name' => 'Tipos de Imóvel',
                'add_new_item' => 'Adicionar novo tipo de imóvel',
                'new_item_name' => "Novo tipo de imóvel"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );


    register_taxonomy(
        'imovel_categorias',
        'imovel',
        array(
            'labels' => array(
                'name' => 'Categorias de Imóvel',
                'add_new_item' => 'Adicionar nova categoria de imóvel',
                'new_item_name' => "Novo Categoria"
            ),
            'show_ui' => true,
            'show_tagcloud' => false,
            'hierarchical' => true
        )
    );
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