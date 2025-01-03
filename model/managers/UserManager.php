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
        $sql = "SELECT id_user, 
                       nickName, 
                       email,
                       password,
                       DATE_FORMAT(subscriptionDate, '%d-%m-%Y') AS subscriptionDate,
                       userRole
                FROM ".$this->tableName." 
                WHERE email = :email";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['email' => $email], false),
            $this->className
        );
    }

    // Vérifier si email déjà utilisé
    public function isEmailUsed($email) {
        $sql = "SELECT id_user, 
                       nickName, 
                       email,
                       password,
                       DATE_FORMAT(subscriptionDate, '%d-%m-%Y') AS subscriptionDate,
                       userRole
                FROM ".$this->tableName." 
                WHERE email = :email";

        return $this->getMultipleResults(
            DAO::select($sql, ['email' => $email]),
            $this->className
        );
    }

    // Vérifier si pseudonyme déjà utilisé
    public function isNickNameUsed($nickName) {
        $sql = "SELECT id_user, 
                       nickName, 
                       email,
                       password,
                       DATE_FORMAT(subscriptionDate, '%d-%m-%Y') AS subscriptionDate,
                       userRole
                FROM ".$this->tableName." 
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

    public static function getUserById($userId) {
        $sql = "SELECT id_user, 
                        nickName, 
                        email,
                        DATE_FORMAT(subscriptionDate, '%d-%m-%Y') AS subscriptionDate,
                        userRole
                FROM user 
                WHERE id_user = :userId";

        $result = DAO::select($sql, ['userId' => $userId], false);
        
        return $result ? new \Model\Entities\User($result) : null;
    }

    public function updateUser($userId, array $data) {
        if (empty($data)) {
            return false;
        }
    
        $sql = "UPDATE ".$this->tableName." SET ";
        $updateFields = [];
        $params = [];
        
        foreach($data as $key => $value) {
            $updateFields[] = "$key = :$key";
            $params[$key] = $value;
        }
        
        $sql .= implode(', ', $updateFields);
        $sql .= " WHERE id_user = :userId";
        $params['userId'] = $userId;
    
        // Debug
        error_log("SQL Query: " . $sql);
        error_log("Params: " . print_r($params, true));
    
        return DAO::update($sql, $params);
    }

    
    // Récupérer les utilisateurs qui ont posté dans un sujet
    public function getUsersByTopic(int $topicId) {
        $sql = "SELECT DISTINCT u.* 
                FROM user u
                JOIN message m ON u.id_user = m.user_id
                WHERE m.topic_id = :topicId";
        
        return $this->getMultipleResults(
            DAO::select($sql, ['topicId' => $topicId], true),
            $this->className
        );
    }
}