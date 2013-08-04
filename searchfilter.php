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
			echo filtrarTipoImoveis($_GET['operacao']);
			break;
		case 2:
			echo get_filter('estado','');
			break;
		case 3:
			echo get_filter('cidade','');
			break;
		case 4:
			echo get_filter('bairro','');
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
	    	$options.='<option value="'.$key.'"">'.$value.'</option>';		
	    }

	    return $options;
	}


	function get_filter($meta_key,$parametros){
	    global $wpdb;
	    $data   =   array();

	    $sql="
	        SELECT `meta_key`, `meta_value`
	        FROM $wpdb->postmeta
	        WHERE `meta_key`='$meta_key' GROUP BY `meta_value`
	    ";

	    foreach($wpdb->get_results($sql) as $k => $v){
	        $options.="<option value='$v->meta_value'>$v->meta_value</option>";
	    };


	    return $options;
	}
		

