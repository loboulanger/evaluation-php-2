<?php

// Connexion à la base de données
require_once 'connect.php';

// Si le formulaire a été soumis
if(!empty($_POST)){

	// On crée un tableau pour recevoir les données que l'on va "nettoyer" en utilisant :
    // trim() qui supprime les espaces en début et fin de chaîne
    // strip_tags() qui supprime les balises HTML et PHP d'une chaîne
	$post = [];
    foreach ($_POST as $key => $value) {
        $post[$key] = trim(strip_tags($value));
	}
	
	// On crée également un tableau pour contenir les notifications d'erreurs sur le formulaire
    $errors = [];

	//------------------------------------------------------------------------------------
    // Début des vérifications sur le formulaire
    //
    // Note : 
	// Il serait possible  de faire des vérifications plus poussées (genre année ne pouvant
	// être antérieure à telle année, couleur devant être repertoriée dans un tableau 
	// de couleurs possibles, etc.)
    // Mais bon, hein, comme ce n'est pas spécifiquement demandé...
    //------------------------------------------------------------------------------------

	if(empty($post['brand'])){
		$errors[] = 'Vous devez renseigner une marque de véhicule';
	}

	if(empty($post['model'])){
		$errors[] = 'Vous devez renseigner un modèle de véhicule';
	}

	if(empty($post['year']) || !is_numeric($post['year'])){
		$errors[] = 'Vous devez renseigner une année valide';
	}

	if(empty($post['color'])){
		$errors[] = 'Vous devez renseigner une couleur de véhicule';
	}

	// Après vérifications, si le tableau est vide
    // (c'est-à-dire que le comptage des tous les éléments du tableau errors vaut 0)
	if(count($errors) === 0){
		// On peut donc faire la requête SQL pour enregistrer dans la base le nouveau véhicule
		// Ici on va enregistrer des données envoyées par l'utilisateur donc on fait une requête préparée
		$insert = $dbh->prepare('INSERT INTO vehicles(brand, model, year, color) VALUES(:brand, :model, :year, :color)');
		$insert->bindValue(':brand', $post['brand']);
		$insert->bindValue(':model', $post['model']);
		$insert->bindValue(':year', $post['year'], PDO::PARAM_INT);
		$insert->bindValue(':color', $post['color']);

		// Si l'exécution de la requête préparée s'est bien passée
		if($insert->execute()){
			// Création d'un tableau permettant la gestion, puis l'affichage, des différents messages
			$json = [
				'code'  => 'success',
				'msg'	=> 'Le véhicule a été ajouté avec succès',
			];
		}
		else {
			var_dump($insert->errorInfo());
			// Pas mal PDO::errorInfo, qui retourne les infos associées à l'erreur
            // quand on a foiré la syntaxe SQL
		}
	}	
	else {
		$json = [
			'code' => 'errors', 
			'msg'  => implode('<br>', $errors),
		];
	}

	// Au final, envoi du résultat (erreurs ou succès) en JSON
	echo json_encode($json);

}