<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class UserManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\User";
    protected $tableName = "user";

    public function __construct(){
        parent::connect();
    }

    // Rechercher un utilisateur inscrit en BDD
    public function findUserByEmail($email) {
        $sql = "SELECT *
                FROM user
                WHERE email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false),
            $this->className
        );
    }

    // Vérifier si email déjà utilisé
    public function isEmailUsed($email) {
        $sql = "SELECT *
                FROM user
                WHERE email = :email";

        return $this->getMultipleResults(
            DAO::select($sql, ['email' => $email]),
            $this->className
        );
    }

    // Vérifier si pseudonyme déjà utilisé
    public function isNickNameUsed($nickName) {
        $sql = "SELECT *
                FROM user
                WHERE nickName = :nickName";
        
        return $this->getMultipleResults(
            DAO::select($sql, ['nickName' => $nickName]),
            $this->className
        );
    }

    public function deleteProfile($id) {
        // Créer l'utilisateur anonyme s'il n'existe pas
        if (empty($this->findOneById(1))) {
            $data = [
                'id_user' => 1,
                'nickName' => 'anonyme',
                'password' => '',
                'email' => ''
            ];
            $this->add($data);
        }

        // Mettre à jour les posts de l'utilisateur
        $sqlPosts = "UPDATE message 
                     SET user_id = 1 
                     WHERE user_id = :id";
        DAO::update($sqlPosts, ['id' => $id]);

        // Mettre à jour les topics de l'utilisateur
        $sqlTopics = "UPDATE topic 
                      SET user_id = 1 
                      WHERE user_id = :id";
        DAO::update($sqlTopics, ['id' => $id]);

        // Supprimer l'utilisateur
        $sqlDelete = "DELETE FROM user 
                      WHERE id_user = :id";
        return DAO::delete($sqlDelete, ['id' => $id]);
    }
}