<?php

/*
 * Débugage
 * Il est important de bien indenter mais aussi de commenter le code,
 * pour permettre une meilleure lecture et un accès plus facile pour la maintenance ultérieure.
 */

// Il faut ici inclure le bon fichier, à savoir connect.php (et non connection.php)
require_once 'connect.php';

// Instancier toutes les variables pour éviter des erreurs de type 'Notice'
$order = '';
$errors = [];

// Attention à bien ouvrir/refermer les parenthèses ou accolades
if(isset($_GET['order']) && isset($_GET['column'])){

	// Attention aux fautes de frappes ('colum' à la place de 'column' reverra une erreur...)
	if($_GET['column'] == 'lastname'){
		$order = ' ORDER BY lastname';
	}

	// Petit rappel :
	// == compare l'égalité entre deux données
	// = définit une valeur à une variable
	elseif($_GET['column'] == 'firstname'){
		$order = ' ORDER BY firstname';
	}

	elseif($_GET['column'] == 'birthdate'){
		$order = ' ORDER BY birthdate';
	}

	if($_GET['order'] == 'asc'){
		$order.= ' ASC';
	}
	elseif($_GET['order'] == 'desc'){
		$order.= ' DESC';
	}
}

if(!empty($_POST)){
	// Nettoyage des données reçues que l'on envoie dans le tableau $post
	foreach($_POST as $key => $value){
		$post[$key] = strip_tags(trim($value));
	}

	// Pour les vérifications des champs du formulaire, on utilise strlen qui retourne la taille d'une chaîne
	// C'est ce retour que l'on va vérifier... Donc attention à l'ordre et à la répartition des parenthèses
	if(strlen($post['firstname']) < 3){
		$errors[] = 'Le prénom doit comporter au moins 3 caractères';
	}

	if(strlen($post['lastname']) < 3){
		$errors[] = 'Le nom doit comporter au moins 3 caractères';
	}

	// La fonction pour filtrer une variable est 'filter_var' (et pas 'filter_variable')
	if(!filter_var($post['email'], FILTER_VALIDATE_EMAIL)){
		$errors[] = 'L\'adresse email est invalide';
	}

	if(empty($post['birthdate'])){
		$errors[] = 'La date de naissance doit être complétée';
	}

	if(empty($post['city'])){
		$errors[] = 'La ville ne peut être vide';
	}

	// Si le tableau $errors (avec un 's' !) est vide, c'est donc qu'il n'y a pas d'erreur...
	if(empty($errors)){
		// ... et on va pouvoir faire la requête à la base
		$insertUser = $db->prepare('INSERT INTO users (gender, firstname, lastname, email, birthdate, city) VALUES(:gender, :firstname, :lastname, :email, :birthdate, :city)');
		$insertUser->bindValue(':gender', $post['gender']);
		$insertUser->bindValue(':firstname', $post['firstname']);
		$insertUser->bindValue(':lastname', $post['lastname']);
		$insertUser->bindValue(':email', $post['email']);
		$insertUser->bindValue(':birthdate', date('Y-m-d', strtotime($post['birthdate'])));
		$insertUser->bindValue(':city', $post['city']);

		// Si la requête s'est bien exécutée
		if($insertUser->execute()){
			// On crée une variable pour affichage du message de réussite
			$createUser = true;
		}
		else {
			// Sinon, c'est qu'une erreur est apparue dans la requête
			$errors[] = 'Erreur SQL';
		}
	}
}

// Requête pour récupérer la liste des utilisateurs 
$queryUsers = $db->prepare('SELECT * FROM users'.$order);
if($queryUsers->execute()){
	$users = $queryUsers->fetchAll();
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Exercice 1</title>
	<meta charset="utf-8">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">

	<h1>Liste des utilisateurs</h1>
	
	<p>Trier par : 
		<a href="index.php?column=firstname&order=asc">Prénom (croissant)</a> |
		<a href="index.php?column=firstname&order=desc">Prénom (décroissant)</a> |
		<a href="index.php?column=lastname&order=asc">Nom (croissant)</a> |
		<a href="index.php?column=lastname&order=desc">Nom (décroissant)</a> |
		<a href="index.php?column=birthdate&order=desc">Âge (croissant)</a> |
		<a href="index.php?column=birthdate&order=asc">Âge (décroissant)</a>
	</p>
	<br>

	<div class="row">
		<?php
		// Si la variable est définie et vaut true, on affiche le message de confirmation
		if(isset($createUser) && $createUser == true){
			echo '<div class="col-md-6 col-md-offset-3">';
			echo '<div class="alert alert-success">Le nouvel utilisateur a été ajouté avec succès.</div>';
			echo '</div><br>';
		}

		// Si le tableau $errors n'est pas vide, c'est qu'il y a des erreurs que l'on affiche
		if(!empty($errors)){
			echo '<div class="col-md-6 col-md-offset-3">';
			echo '<div class="alert alert-danger">'.implode('<br>', $errors).'</div>';
			echo '</div><br>';
		}
		?>

		<div class="col-md-7">
			<table class="table">
				<thead>
					<tr>
						<th>Civilité</th>
						<th>Prénom</th>
						<th>Nom</th>
						<th>Email</th>
						<th>Age</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($users as $user):?>
					<tr>
						<td><?php echo $user['gender'];?></td>
						<td><?php echo $user['firstname'];?></td>
						<td><?php echo $user['lastname'];?></td>
						<td><?php echo $user['email'];?></td>
						<td><?php echo DateTime::createFromFormat('Y-m-d', $user['birthdate'])->diff(new DateTime('now'))->y;?> ans</td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>

		<div class="col-md-5">

			<form method="post" class="form-horizontal well well-sm">
				<fieldset>

					<legend>Ajouter un utilisateur</legend>

					<div class="form-group">
						<label class="col-md-4 control-label" for="gender">Civilité</label>
						<div class="col-md-8">
							<select id="gender" name="gender" class="form-control input-md" required>
								<option value="Mlle">Mademoiselle</option>
								<option value="Mme">Madame</option>
								<option value="M">Monsieur</option>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="firstname">Prénom</label>
						<div class="col-md-8">
							<input id="firstname" name="firstname" type="text" class="form-control input-md" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="lastname">Nom</label>  
						<div class="col-md-8">
							<input id="lastname" name="lastname" type="text" class="form-control input-md" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="email">Email</label>  
						<div class="col-md-8">
							<input id="email" name="email" type="email" class="form-control input-md" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="city">Ville</label>  
						<div class="col-md-8">
							<input id="city" name="city" type="text" class="form-control input-md" required>
						</div>
					</div>

					<div class="form-group">
						<label class="col-md-4 control-label" for="birthdate">Date de naissance</label>  
						<div class="col-md-8">
							<input id="birthdate" name="birthdate" type="text" placeholder="JJ-MM-AAAA" class="form-control input-md" required>
							<span class="help-block">au format JJ-MM-AAAA</span>  
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-4 col-md-offset-4">
							<button type="submit" class="btn btn-primary">Envoyer</button>
						</div>
					</div>

				</fieldset>
			</form>
		</div>
	</div>
</div>

</body>
</html>