<?php
//Responsável por filtrar os argumentos e retornar os valores do proximo Campo

include_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php' );
?>
<option value=''>Selecione</option>
<?php
	global $wpdb;
	$sizeGET=sizeof($_GET);
	switch ($sizeGET) {
		case 1:
			echo filtrarTipoImoveis($_GET['tipo_operacao']);
			break;
		case 2:
			echo get_filter('estado',$_GET);
			break;
		case 3:
			echo get_filter('cidade',$_GET);
			break;
		case 4:
			echo get_filter('bairro',$_GET);
			break;
		
		default:
			# code...
			break;
	}


	function filtrarTipoImoveis($operacao){
		global $wpdb;
	    $data   =   array();
	    $categorias=array();

	    $sql="
	    	SELECT `post_id`
	        FROM $wpdb->postmeta
	        WHERE `meta_key`='tipo_operacao' AND `meta_value`='$operacao'  GROUP BY `post_id` 
	        ";

	    foreach($wpdb->get_results($sql) as $k => $v){
	    	$terms = get_the_terms($v->post_id, 'imovel_tipos' );
			if ( !empty( $terms ) ) {
				$out = array();
				foreach ( $terms as $term )
					$categorias[$term->term_id]=$term->name;
			}

	    };

	    foreach($categorias as $key=>$value){
	    	$options.='<option value="'.$key.'">'.$value.'</option>';		
	    }

	    return $options;
	}


	function get_filter($meta_key,$filter){
	    $data   =   array();
	    $meta_queries = array();
	    $array_meta_key=array();
	    
	    //Monta filtro com as informações enviadas
	    foreach ($filter as $key => $value) {
	    	if ( $key!='tipo' ) {	//Não faz filtro na for a categoria 
			    $meta_queries[] = array(
			        'key' => $key,
			        'value' => $value,
			        'compare' => '=',
			    );
			}	
	    }

	    //Filtra posts com as informações
		query_posts(array(
		    'post_type' => 'imovel', // custom post type
		    'orderby' => $sort_by,
		    'tax_query' => array(
				array(
					'taxonomy' => 'imovel_tipos', //or tag or custom taxonomy
					'field' => 'id',
					'terms' => array($filter['tipo'])
				)
			),
		    'order' => $sort_order,
		    'meta_query' => $meta_queries,
		));


		$options='';
		if(have_posts()) : while(have_posts()) : the_post();
			$imovel_fields = get_post_custom($post->post_ID);
			
			
			if(!in_array($imovel_fields[$meta_key][0], $array_meta_key)){
				
				$info=$imovel_fields[$meta_key][0];

				$array_meta_key[]=$info;	

				$options.='<option value="'.$info.'">'.$info.'</option>';	
			}
			
		endwhile;
		endif;
			
			
		



	    return $options;
	}
		

