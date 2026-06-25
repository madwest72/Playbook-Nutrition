<?php
class recette
{
    private $bdd;
    public function __construct($bdd)
    {
        $this->bdd = $bdd;
    }
    public function createRecette($nom, $information, $instrution)
    {
        $req = $this->bdd->prepare('INSERT INTO recette(nom, information, instrution) values(:nom, :information, :instrution');
        $req->bindparam(':nom', $nom);
        $req->bindparam(':information', $information);
        $req->bindparam(':instrution', $instrution);
        return $req->execute();
    }
    public function deleteRecette($id)
    {
        $req = $this->bdd->prepare('DELETE FROM recette where id=?');
        return $req->execute([$id]);
    }
    public function updateRecette($id, $nom, $information, $instrution)
    {
        $req = $this->bdd->prepare('UPDATE recette SET nom = :nom, information = :information, instrution = :instrution WHERE id=:id');
        $req->bindparam(':id', $id);
        $req->bindparam(':nom', $nom);
        $req->bindparam(':information', $information);
        $req->bindparam(':instrution', $instrution);
        return $req->execute();
    }
    public function selectALLRecette()
    {
        $req = $this->bdd->prepare('SELECT *FROM recette');
        $req->execute();
        return $req->fetchall(PDO::FETCH_ASSOC);
    }
    public function selectRecette($id)
    {
        $req = $this->bdd->prepare('SELECT *FROM recette where id =?');
        $req->execute([$id]);
        return $req->fetch(PDO::FETCH_ASSOC);
    }
}
