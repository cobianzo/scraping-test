<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Descargar Imágenes</title>
		<link rel="stylesheet" id="styles" href="style.css">
</head>
<body>
    <h1>Descargar Imágenes</h1>
		<div class="wrapper-centered">
			<form action="procesar.php" method="post">
					<label for="url">Introduce la URL:</label>
					<input type="url" name="url" id="url" placeholder="https://example.com" required style="width:90%">
					<label for="url">Attr con la url de la imagen a descargar</label>
					<div style="display:flex; gap:1rem;">
						<input type="text" name="attr" id="attr" placeholder="src" value="src" style="width:100px">
						<span style="font-size:0.8rem; align-self:center;"> usar
							<a href="#" onclick="document.querySelector('#attr').value='nitro-lazy-src';">nitro-lazy-src</a>
						</span>
					</div>
					<button type="submit">Descargar Imágenes</button>
	    </form>
		</div>
</body>
</html>
