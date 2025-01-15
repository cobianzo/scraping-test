<?php
require './functions.php';
?>
<html>
	<head>
		<link rel="stylesheet" id="styles" href="style.css">
	</head>
<body>
<?php
if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	$url = filter_input( INPUT_POST, 'url', FILTER_SANITIZE_URL );
	$attr_src = filter_input( INPUT_POST, 'attr', FILTER_SANITIZE_URL );

	echo "<p>Examinando attributo <b>$attr_src</b> en <b>$url</b></p>";

	if ( ! filter_var( $url, FILTER_VALIDATE_URL ) ) {
		die( 'URL inválida.' );
	}

	// Procesar la URL y descargar las imágenes
	echo '<h1>Resultados</h1>';
	echo "<p>Extrayendo imágenes de: <a href='$url' target='new'>$url</a></p>";

	$directorio = 'imagenes_descargadas';
	if ( ! file_exists( $directorio ) ) {
		mkdir( $directorio, 0777, true );
	}

	$imagenes = extraerImagenes( $url, $attr_src );
	$html = @file_get_contents($url);
	if ($html === false) {
			die("No se pudo acceder a la URL.");
	}
	$imagenesCSS = extraerImagenesCSS($html, $url);


	echo '<p>Imagenes dentro del HTML.</p>';
	if ( count( $imagenes ) > 0 ) {
		foreach ( $imagenes as $imagen ) {
			echo "<br/>Descargando ". basename($imagen) . " ... ";
			descargarImagen( $imagen, $directorio );
		}
	} else {
		echo '<p>No se encontraron imágenes en el HTML.</p>';
	}

	echo '<p>Imagenes en CSS Inline.</p>';
	if ( count( $imagenesCSS ) > 0 ) {
		foreach ( $imagenesCSS as $imagen ) {
			echo "<br/>Descargando ". basename($imagen) . " ... ";
			descargarImagen( $imagen, $directorio );
		}
	} else {
		echo '<p>No se encontraron imágenes en el HTML.</p>';
	}



	echo "<p><a href='index.php'>Volver</a></p>";
} else {
	header( 'Location: index.php' );
}
?>

</body>
</html>