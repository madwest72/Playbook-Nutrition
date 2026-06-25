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
require_once '../model/Ingredient.php';

$ingredientModel = new Ingredient($pdo);
$id = $_GET['id'];
$method = $_SERVER['REQUEST_METHOD'];  // GET ? POST ?
$data   = json_decode(file_get_contents("php://input"), true);  // ce que le frontend envoie json_decode sert a decoder le json ,json_encode sert a encoder en json

switch ($method) {

    case 'GET':
        $ingredient = $ingredientModel->selectIngredient($id);
        if ($ingredient) {
            echo json_encode($ingredient);
        } else {
            http_response_code(404); // 404 = introuvable
            echo json_encode(["erreur" => "Ingrédient introuvable"]);
        }
        break;
    case 'PUT':
        if (!isset($data['nom'], $data['calorie'], $data['protein'], $data['lipide'], $data['glucide'])) {
            http_response_code(400);
            echo json_encode(["erreur" => "Données manquantes"]);
            break;
        }
        $ingredientModel->updateIngredient($id, $data['nom'], $data['calorie'], $data['protein'], $data['lipide'], $data['glucide']);
        echo json_encode(["message" => "Ingrédient modifié !"]);
        break;
    case 'DELETE':
        $ingredientModel->deleteIngredient($id);
        echo json_encode(["message" => "Ingrédient supprimé !"]);
        break;
    default:
        http_response_code(405);
        echo json_encode(["erreur" => "Méthode non autorisée"]);
}