<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once '../bdd/bdd.php';       // donne accès à $pdo
require_once '../model/Recette.php';

$recetteModel = new Recette($pdo);
$id = $_GET['id'];
$method = $_SERVER['REQUEST_METHOD'];  // GET ? POST ?
$data   = json_decode(file_get_contents("php://input"), true);  // ce que le frontend envoie json_decode sert a decoder le json ,json_encode sert a encoder en json

switch ($method) {

    case 'GET':
        $recette = $recetteModel->selectRecette($id);
        if ($recette) {
            echo json_encode($recette);
        } else {
            http_response_code(404); // 404 = introuvable
            echo json_encode(["erreur" => "recette introuvable"]);
        }
        break;
    case 'PUT':
        if (!isset($data['nom'], $data['information'], $data['instrution'])) {
            http_response_code(400);
            echo json_encode(["erreur" => "Données manquantes"]);
            break;
        }
        $recetteModel->updateRecette($id, $data['nom'], $data['information'], $data['instrution']);
        echo json_encode(["message" => "recette modifié !"]);
        break;
    case 'DELETE':
        $recetteModel->deleteRecette($id);
        echo json_encode(["message" => "recette supprimé !"]);
        break;
    default:
        http_response_code(405);
        echo json_encode(["erreur" => "Méthode non autorisée"]);
}