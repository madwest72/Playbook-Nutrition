<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../bdd/bdd.php';       // donne accès à $pdo
require_once '../model/Recette.php';

$recetteModel = new Recette($pdo);

$method = $_SERVER['REQUEST_METHOD'];  // GET ? POST ?
$data   = json_decode(file_get_contents("php://input"), true);  // ce que le frontend envoie json_decode sert a decoder le json ,json_encode sert a encoder en json

switch ($method) {

    case 'GET':
        echo json_encode($recetteModel->selectAllRecette());
        break;

    case 'POST':
        if (!isset($data['nom'], $data['information'], $data['instrution'])) {
            http_response_code(400); //code de statut HTTP que ton serveur renvoie au frontend.Le frontend peut alors savoir si ça s'est bien passé ou pas sans lire le message
            echo json_encode(["erreur" => "Données manquantes"]);
            break;
        }
        $recetteModel->createRecette($data['nom'], $data['information'], $data['instrution']);
        http_response_code(201);
        echo json_encode(["message" => "Recette créé !"]);
        break;

    default:
        http_response_code(405);
        echo json_encode(["erreur" => "Méthode non autorisée"]);
}