<?php
// 1. On charge la connexion à la base et ton modèle POO
require_once '../bdd/bdd.php';
require_once '../model/Ingredient.php';

// 2. On instancie la classe Ingredient avec la connexion PDO
$ingredientModel = new ingredient($pdo);

// 3. Le nom de ton fichier CSV (qui est dans le même dossier)
$fichierNom = 'ingredients.csv';

// 4. On ouvre le fichier en mode "lecture seule" (r)
if (($poignee = fopen($fichierNom, "r")) !== FALSE) {

    // On lit la toute première ligne dans le vide pour sauter les en-têtes (Nom, Calories...)
    fgetcsv($poignee, 1000, ",");

    $compteur = 0;

    // 5. La boucle magique : PHP va lire le fichier ligne par ligne jusqu'à la fin
    while (($ligne = fgetcsv($poignee, 1000, ",")) !== FALSE) {

        // $ligne est un tableau. Chaque numéro correspond à une colonne de ton CSV.
        // On stocke chaque colonne dans une variable propre.
        $nom      = $ligne[1];
        $calorie  = (float)$ligne[3];
        $proteine = (float)$ligne[4];
        $lipide   = (float)$ligne[5];
        $glucide  = (float)$ligne[6];

        // 6. On tente l'insertion en base de données
        try {
            // On appelle la fonction de ton modèle avec les variables récupérées
            $ingredientModel->createIngredient($nom, $calorie, $proteine, $lipide, $glucide);
            $compteur++;
        } catch (PDOException $e) {
            // Grâce à ça, si un ingrédient est en doublon (erreur SQL), 
            // le script affiche l'erreur mais continue d'importer le reste !
            echo "Impossible d'ajouter '$nom' : " . $e->getMessage() . "<br>";
        }
    }

    // 7. On ferme le fichier proprement pour libérer la mémoire
    fclose($poignee);
    echo "<h3>Importation terminée avec succès !</h3>";
    echo "<p><strong>$compteur</strong> ingrédients ont été insérés dans ta table.</p>";
} else {
    echo "Erreur critique : Impossible de trouver ou de lire le fichier $fichierNom.";
}