<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Faisons le ménage !</title>
	<link rel="stylesheet" href="css/app.css">
</head>
<body>

	<h1>Ajout d'un véhicule</h1>
	<form method="POST">

		<!-- .div pour affichage des messages renvoyés par ajax -->
		<div id="resultForm">	
		</div>

		<div>
			<label for="brand">Marque :</label>
			<input type="text" name="brand" id="brand" required>
		</div>
		<div>
			<label for="model">Modèle :</label>
			<input type="text" name="model" id="model" required>
		</div>

		<div>
			<label for="year">Année :</label>
			<input type="text" name="year" id="year" required>
		</div>

		<div>
			<label for="color">Couleur :</label>
			<input type="text" name="color" id="color" required>
		</div>

		<div>
			<input type="submit" value="Ajouter un véhicule">
	</form>

<!-- jQuery CDN – Latest Stable Version -->
<script
    src="http://code.jquery.com/jquery-3.3.1.min.js"
    integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous">
</script>

<!-- Custom JS for Ajax -->
<script src="js/app.js"></script>

</body>
</html>