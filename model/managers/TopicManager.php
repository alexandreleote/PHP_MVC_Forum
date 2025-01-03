<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;
use Model\Entities\Category;
use Model\Entities\Topic;
use Model\Entities\User;

class TopicManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct(){
        parent::connect();
    }

    public function displayAllTopicsByCategory($id) {
        $sql = "SELECT t.id_topic,
                       t.title,
                       DATE_FORMAT(t.creationDate, '%d-%m-%Y %H:%i') AS creationDate,
                       t.creationDate AS sortTopic,
                       t.isLocked,
                       t.user_id,
                       t.category_id,
                       (SELECT COUNT(*) FROM message p WHERE p.topic_id = t.id_topic) as postsCount
                FROM ".$this->tableName." t
                WHERE category_id = :id
                ORDER BY sortTopic DESC";
        
        $results = DAO::select($sql, ['id' => $id]);
        
        // Initialize empty array for topics
        $topics = [];
        
        // Only process results if they exist
        if ($results) {
            foreach($results as $result) {
                $topics[] = new Topic($result);
            }
        }
    
        return $topics;
    }

    // Verrouiller le sujet
    public function lock($id) {
        $sql = "UPDATE ".$this->tableName." 
                SET isLocked = 1
                WHERE id_topic = :id";
        return DAO::update($sql, ['id' => $id]);
    }

    // Déverrouiller le sujet
    public function unlock($id) {    
        $sql = "UPDATE ".$this->tableName." 
                SET isLocked = 0
                WHERE id_topic = :id";
        return DAO::update($sql, ['id' => $id]);
    }

    public static function getTopicsByUser($userId) {
        $sql = "SELECT t.id_topic,
                       t.title,
                       DATE_FORMAT(t.creationDate, '%d-%m-%Y %H:%i') AS creationDate,
                       t.category_id,
                       c.name
                FROM topic t
                LEFT JOIN category c ON t.category_id = c.id_category
                WHERE t.user_id = :userId
                ORDER BY t.creationDate DESC LIMIT 3";
        $results = DAO::select($sql, ['userId' => $userId]);
        
        $topics = [];
        if ($results) {
            foreach ($results as $result) {
                $topics[] = new Topic($result);
            }
        }
        
        return $topics;
    }

    public static function countTopicsByUser($userId) {
        $sql = "SELECT COUNT(*) as topic_count
                FROM topic
                WHERE user_id = :userId";
        $result = DAO::select($sql, ['userId' => $userId], false);
        return $result['topic_count'];
    }

    public function getLatestTopics($limit = 3) {
        $sql = "SELECT t.*, 
                GREATEST(t.creationDate, 
                        COALESCE((SELECT MAX(m.creationDate) 
                                 FROM message m 
                                 WHERE m.topic_id = t.id_topic), 
                                 t.creationDate)
                ) as lastActivity
                FROM topic t
                ORDER BY lastActivity DESC
                LIMIT :limit";
        
        $results = DAO::select($sql, ['limit' => $limit], true);
        
        $topics = [];
        if ($results) {
            foreach($results as $result) {
                $topics[] = new Topic($result);
            }
        }
    
        return $topics;
    }

    public static function countTopicsByCategory($categoryId) {
        $sql = "SELECT COUNT(*) as topic_count
                FROM topic
                WHERE category_id = :categoryId";
        $result = DAO::select($sql, ['categoryId' => $categoryId], false);
        return $result['topic_count'];
    }

    public static function getTopicsByCategory($categoryId) {
        $sql = "SELECT t.*, 
                GREATEST(t.creationDate, 
                        COALESCE((SELECT MAX(m.creationDate) 
                                 FROM message m 
                                 WHERE m.topic_id = t.id_topic), 
                                 t.creationDate)
                ) as lastActivity
                FROM topic t
                WHERE t.category_id = :categoryId 
                ORDER BY lastActivity DESC";
        
        $results = DAO::select($sql, ['categoryId' => $categoryId]);
        
        $topics = [];
        if ($results) {
            foreach($results as $result) {
                $topics[] = new Topic($result);
            }
        }
    
        return $topics;
    }
}