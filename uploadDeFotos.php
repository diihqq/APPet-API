<?php
function uploadDeFotos($arquivo){
	
	$url = "http://www.appet.hol.es/fotos/";
	$image_name = "img_".date("Y-m-d-H-m-s")."_".uniqid().".jpg";
	$path = $url .$image_name;

	$arquivo = str_replace(' ', '+', $arquivo);
	$arquivo = str_replace('\n', '', $arquivo);

	$binary = base64_decode($arquivo);
	
	file_put_contents("/home/u119210980/public_html/fotos/" . $image_name, $binary);
	
	return $path;
}

function uploadDeQRCode($arquivo){
	
	$url = "http://www.appet.hol.es/qrcodes/";
	$image_name = "img_".date("Y-m-d-H-m-s")."_".uniqid().".jpg";
	$path = $url .$image_name;

	$arquivo = str_replace(' ', '+', $arquivo);
	$arquivo = str_replace('\n', '', $arquivo);

	$binary = base64_decode($arquivo);
	
	file_put_contents("/home/u119210980/public_html/qrcodes/" . $image_name, $binary);
	
	return $path;
}
?>