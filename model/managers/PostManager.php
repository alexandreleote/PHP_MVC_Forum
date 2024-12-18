<?php
namespace Model\Managers;

use App\Manager;    
use App\DAO;

class PostManager extends Manager{

    protected $className = "Model\Entities\Post";
    protected $tableName = "message";

    // Création de la classe POO et la table correspondante
    public function __construct(){
        parent::connect();
    }

    public function displayAllPostsByTopic($id){

        $sql = "SELECT m.id_message,
                       m.content,
                       DATE_FORMAT(m.creationDate, '%d-%m-%Y à %H:%i') AS creationDate,
                       m.user_id,
                       m.topic_id
                FROM ".$this->tableName." m 
                WHERE m.topic_id = :id
                ";

        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );        
    }

    // Suppression d'un message
    public function deletePost($postId, $userId, $isAdmin = false) {
        // D'abord, vérifier que le message existe et en obtenir l'auteur
        $sql = "SELECT user_id 
                FROM ".$this->tableName." 
                WHERE id_message = :postId";

        $result = DAO::select($sql, ['postId' => $postId], false);
        
        // Si le post n'existe pas, return false
        if (!$result) {
            return false;
        }
        
        // Vérifier si l'utilisateur est l'auteur du post ou un administrateur
        if ($isAdmin || $result['user_id'] == $userId) {
            $deleteSql = "DELETE FROM ".$this->tableName." 
                          WHERE id_message = :postId";
            return DAO::delete($deleteSql, ['postId' => $postId]);
        }
        
        // Si pas autorisé, return false
        return false;
    }

    // Recherche d'un message par son ID
    public function findOneMessageById($id) {
        $sql = "SELECT * 
                FROM ".$this->tableName." m 
                INNER JOIN user u ON m.user_id = u.id_user
                INNER JOIN topic t ON m.topic_id = t.id_topic
                WHERE m.id_message = :id";

        return $this->getOneOrNullResult(
            DAO::select($sql, ['id' => $id], false), 
            $this->className
        );
    }


}