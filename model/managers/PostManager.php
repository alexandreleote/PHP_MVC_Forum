<?php
namespace Model\Managers;

use App\Manager;    
use App\DAO;
use Model\Entities\Post;

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
                WHERE m.topic_id = :id";

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

    public static function getPostsByUser($userId) {
        $sql = "SELECT m.id_message,
                       m.content,
                       DATE_FORMAT(m.creationDate, '%d-%m-%Y %H:%i') AS creationDate,
                       m.user_id,
                       m.topic_id,
                       t.category_id
                FROM message m 
                LEFT JOIN topic t ON m.topic_id = t.id_topic
                LEFT JOIN category c ON t.category_id = c.id_category
                WHERE m.user_id = :userId 
                ORDER BY m.creationDate 
                DESC LIMIT 3";
        $results = DAO::select($sql, ['userId' => $userId]);
        
        $posts = [];
        if ($results) {
            foreach ($results as $result) {
                $posts[] = new Post($result);
            }
        }
        
        return $posts;
    }

    public static function countPostsByUser($userId) {
        $sql = "SELECT COUNT(*) as post_count 
                FROM message 
                WHERE user_id = :userId";
        $result = DAO::select($sql, ['userId' => $userId], false);
        return $result['post_count'];
    }

    public static function countPosts($topicId) {
        $sql = "SELECT COUNT(*) AS post_count
                FROM message 
                WHERE topic_id = :topicId";
        
        // Make sure the variable name matches
        $result = DAO::select($sql, ['topicId' => $topicId], false);
    
        // Check if the result is valid and return the count
        return $result['post_count'] ?? 0;  // Return 0 if no result is found
    }
    
    public function getLatestPosts($limit = 5) {
        $sql = "SELECT m.id_message, 
                        m.content, 
                        m.creationDate, 
                        m.topic_id,
                        t.title as topicTitle,
                        c.name as categoryName,
                        u.nickName as authorName
                FROM message m
                LEFT JOIN topic t ON m.topic_id = t.id_topic
                LEFT JOIN category c ON t.category_id = c.id_category
                LEFT JOIN user u ON m.user_id = u.id_user
                ORDER BY m.creationDate DESC
                LIMIT :limit";
        
        $results = DAO::select($sql, ['limit' => $limit]);
        
        $posts = [];
        foreach($results as $result) {
            $posts[] = new Post($result);
        }
    
        return $posts;
    }
}