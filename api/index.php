<?php

require 'vendor/autoload.php';

$options = new ZipStream\Option\Archive();
$options->setSendHttpHeaders(true);

//$url = $_GET['url'];


/*if(!empty($idNormal)) {
    //$id = $idNormal;
    $urlBase = 'https://api.mercadolibre.com/items/MLB'.$idNormal;
    $str_replace = "'\-O\.'";
}
elseif (!empty($idCatalogo)) {
   //$id = $idCatalogo;
   $urlBase = 'https://api.mercadolibre.com/products/MLB'.$idCatalogo;
   $str_replace = "'\-F\.'";
}
else {
    exit("O endereço não pode ser vazio");
 }*/

$urlBase = 'https://produto.mercadolivre.com.br/MLB-1765165751-adaptador-dvd-para-hd-ou-ssd-notebook-drive-caddy-95mm-_JM';
$str_replace = "'\-O\.'";

$acessarUrlBase = file_get_contents($urlBase); //acessa o link no ML
$arrayImagens = json_decode($acessarUrlBase, true);
$valorAleatorio = uniqid(rand(), true); // cria um valor aleatório usado para todos os itens
//mkdir('items/'.$valorAleatorio); // cria uma pasta com o valor aleatório
$totalDeImagens = count($arrayImagens['pictures']); //conta o número de imagens no array do produto
$zip = new ZipStream\ZipStream($valorAleatorio.'.zip', $options); //cria o arquivo zip com o valor aleatório

$urls = array();
/* Repetição for para obter todas as imagens que contém em um anúncio. */
 for($numeroImagem = 0; $numeroImagem < $totalDeImagens; $numeroImagem++) {
     //$urls = array($arrayImagens['pictures'][$numeroImagem]['url']);
     
     //array_push($urls,str_replace($str_replace,'-B.',$arrayImagens['pictures'][$numeroImagem]['url']));
     array_push($urls,preg_replace($str_replace, '-B.', $arrayImagens['pictures'][$numeroImagem]['url']));
     
     
     
     

//print_r($urls);

};
// executa o arquivo zip
//$zip->finish();  

// add a lot of http urls



foreach($urls as $url) {
  // Create Temp File
  $fp = tmpfile();

  // Download File
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_FILE, $fp);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_exec($ch);

  // Force to write all data
  fflush($fp);

  // Rewind to the beginning, otherwise the stream is at the end from the start
  rewind($fp);

  // Find out a file name from url
  // In this case URL http://img31.mtime.cn/pi/2014/10/22/092931.12614666_1000X1000.jpg will yield
  // /pi/2014/10/22/092931.12614666_1000X1000.jpg as file path
  $filename = parse_url($url, PHP_URL_PATH);

  // Add File
  $zip->addFileFromStream($filename, $fp);

  // Close the Temp File
  fclose($fp);
}

// Finish ZIP
$zip->finish();









?>


