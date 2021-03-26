<?php
header('Content-Type: application/json');

function get_combinations($arrays) {
    $arrays = array_filter($arrays);//for empty index case
	$result = array(array());
	foreach ($arrays as $property => $property_values) {
		$tmp = array();
		foreach ($result as $result_item) {
			foreach ($property_values as $property_value) {
				$result_item[$property] = $property_value;
                $tmp[] = $result_item;
			}
		}
		$result = $tmp;
	}
	return $result;
}

$variaveldeentrada = $_GET['produto'];
$c1 = $_GET['c1'];
$c2 = $_GET['c2'];
$c3 = $_GET['c3'];
//$skuList = preg_split("/\\r\\n|\\r|\\n/", $_POST['skuList']);

/*
$variaveldeentrada recebe um valor e passa automaticamente para o array

https://stackoverflow.com/questions/3997336/explode-php-string-by-new-line

Fazer explode() de um form com GET ou POST e cada item vindo de uma linha:
$skuList = preg_split('/\r\n|\r|\n/', $_POST['skuList']);
ou
$skuList = preg_split("/\\r\\n|\\r|\\n/", $_POST['skuList']);

*/

$combinations = get_combinations(
	array(
		'item' => (explode(',', $variaveldeentrada)),
		//'item' => (preg_split("/\\r\\n|\\r|\\n/", $variaveldeentrada)),
		'c1' => (explode(',', $c1)),
		'c2' => (explode(',', $c2)),
		'c3' => (explode(',', $c3)),	
	)
);

// $combinations = get_combinations(
// 	array(
// 		'item' => (explode(',', $variaveldeentrada)),
// 		//'item' => (preg_split("/\\r\\n|\\r|\\n/", $variaveldeentrada)),
// 		'c1' => array('128 GB', 'Vídeo 4K', 'Tela 5.8','Gorilla Glass 5','Bateria 3000 mAh'),
// 		'c2' => array('Snapdragon 845','4 GB RAM','Tela Super AMOLED','Câmera 12 Mp'),
// 		'c3' => array('Promoção','Oferta','Compre já','Aproveite'),		
// 	)
// );

//print_r(implode(" ",$combinations[1]).strlen($combinations[1]));

// $x = 2;
// for ($x = 0; $x = 79; $x++) {
// 	$meuTitulo[$x] = implode(" ",$combinations[$x]);	
// 	print_r(json_encode(array('titulo' => $meuTitulo[$x],'tamanho' => (strlen($meuTitulo[$x])-2))));
//  }


//print_r(json_encode(array('titulo' => $combinations[1],'tamanho' => (strlen($combinations[1])-2))));
//var_dump(json_encode(implode(" ",$combinations)));
print_r(json_encode($combinations));




// $filtered_array = array_filter($combinations, function ($item) {
//     return count($item) >= 1;
// });
// print_r(json_encode($filtered_array));






?>
