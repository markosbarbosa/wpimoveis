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
			?>
				<option value='1'>Filtrar tipo</option>
			<?php
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
		

