<?php
// Función para descargar una imagen y guardarla localmente
function descargarImagen($urlImagen, $directorio)
{
	$nombreArchivo = basename(parse_url($urlImagen, PHP_URL_PATH));
	$rutaArchivo = $directorio . DIRECTORY_SEPARATOR . $nombreArchivo;

	// Usamos file_get_contents para descargar la imagen
	$contenido = @file_get_contents($urlImagen);

	if ($contenido !== false) {
		file_put_contents($rutaArchivo, $contenido);
		echo "<br/>✅Imagen descargada: $rutaArchivo\n";
	} else {
		echo "<br/>❌Error descargando: $urlImagen\n";
	}
}

// Función para obtener todas las etiquetas <img> de una URL
function extraerImagenes($url, $attr_src = 'src')
{
	// Obtiene el contenido HTML de la URL
	$html = @file_get_contents($url);

	if ($html === false) {
		die("No se pudo acceder a la URL: $url\n");
	}

	// Usamos DOMDocument para parsear el HTML
	$doc = new DOMDocument();
	@$doc->loadHTML($html);

	// Extraer todas las etiquetas <img>
	$imagenes = [];
	$etiquetasImg = $doc->getElementsByTagName('img');

	foreach ($etiquetasImg as $img) {
		$src = $img->getAttribute($attr_src);
		// Convertimos rutas relativas a absolutas
		$imagenes[] = (filter_var($src, FILTER_VALIDATE_URL)) ? $src : urlCompleta($url, $src);
	}

	return $imagenes;
}

// Función para extraer URLs de imágenes en estilos CSS inline
function extraerImagenesCSS($html, $url) {
	$imagenes = [];
	preg_match_all('/<style[^>]*>(.*?)<\/style>/is', $html, $matches);

	foreach ($matches[1] as $bloqueEstilo) {
			preg_match_all('/url\((["\']?)(.*?)\1\)/i', $bloqueEstilo, $urls);
			foreach ($urls[2] as $imgUrl) {
					// Ignorar fuentes
					if (!preg_match('/\.(woff|woff2|ttf|otf|eot|svg)$/i', $imgUrl)) {
							$imagenes[] = filter_var($imgUrl, FILTER_VALIDATE_URL) ? $imgUrl : urlCompleta($url, $imgUrl);
					}
			}
	}

	return $imagenes;
}

// Función para convertir una URL relativa a una absoluta
function urlCompleta($base, $relativo)
{
	$parsedBase = parse_url($base);
	$baseUrl = "{$parsedBase['scheme']}://{$parsedBase['host']}";
	$ruta = $baseUrl . '/' . ltrim($relativo, '/');
	return $ruta;
}
