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
}