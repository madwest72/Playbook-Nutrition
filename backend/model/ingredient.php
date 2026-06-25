<?php
class Ingredient
{
    private $bdd;

    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }

    public function createIngredient($nom, $calorie, $protein, $lipide, $glucide)
    {
        $req = $this->bdd->prepare('INSERT INTO ingredient(nom, calorie, protein, lipide, glucide) VALUES(:nom, :calorie, :protein, :lipide, :glucide)');
        $req->bindParam(':nom', $nom);
        $req->bindParam(':calorie', $calorie);
        $req->bindParam(':protein', $protein);
        $req->bindParam(':lipide', $lipide);
        $req->bindParam(':glucide', $glucide);
        return $req->execute();
    }

    public function deleteIngredient($id)
    {
        $req = $this->bdd->prepare('DELETE FROM ingredient WHERE id=?');
        return $req->execute([$id]);
    }

    public function updateIngredient($id, $nom, $calorie, $protein, $lipide, $glucide)
    {
        $req = $this->bdd->prepare('UPDATE ingredient SET nom = :nom, calorie = :calorie, protein = :protein, lipide = :lipide, glucide = :glucide WHERE id=:id');
        $req->bindParam(':id', $id);
        $req->bindParam(':nom', $nom);
        $req->bindParam(':calorie', $calorie);
        $req->bindParam(':protein', $protein);
        $req->bindParam(':lipide', $lipide);
        $req->bindParam(':glucide', $glucide);
        return $req->execute();
    }

    public function selectAllIngredient()
    {
        $req = $this->bdd->prepare('SELECT * FROM ingredient');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectIngredient($id)
    {
        $req = $this->bdd->prepare('SELECT * FROM ingredient WHERE id=?');
        $req->execute([$id]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }
}
