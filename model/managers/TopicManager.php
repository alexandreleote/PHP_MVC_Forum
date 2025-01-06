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
                       DATE_FORMAT(t.creationDate, '%d-%m-%Y à %H:%i') AS creationDate,
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
                       DATE_FORMAT(t.creationDate, '%d-%m-%Y à %H:%i') AS creationDate,
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

    public static function getTopicsByCategory($categoryId) {
        $sql = "SELECT t.id_topic,
                       t.title,
                       t.creationDate,
                       t.isLocked,
                       t.user_id,
                       t.category_id,
                       COUNT(m.id_message) as post_count
                FROM topic t
                LEFT JOIN message m ON t.id_topic = m.topic_id
                WHERE t.category_id = :id
                GROUP BY t.id_topic, t.title, t.creationDate, t.isLocked, t.user_id, t.category_id
                ORDER BY t.creationDate DESC";
        
        $results = DAO::select($sql, ['id' => $categoryId]);
        
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

    public function getMostActiveUsersForCurrentMonth($categoryId = null) {
        $currentYear = date('Y');
        $currentMonth = date('m');
    
        $sql = "SELECT u.id_user, u.nickname, 
                COUNT(DISTINCT m.id_message) as month_messages
                FROM user u
                INNER JOIN message m ON m.user_id = u.id_user
                INNER JOIN topic t ON m.topic_id = t.id_topic
                WHERE YEAR(m.creationDate) = :year 
                AND MONTH(m.creationDate) = :month";
    
        $params = [
            'year' => $currentYear,
            'month' => $currentMonth
        ];
    
        if ($categoryId) {
            $sql .= " AND t.category_id = :categoryId";
            $params['categoryId'] = $categoryId;
        }
    
        $sql .= " GROUP BY u.id_user, u.nickname
                  HAVING month_messages > 0
                  ORDER BY month_messages DESC
                  LIMIT 5";
    
        $results = DAO::select($sql, $params);
        
        $activeUsers = [];
        foreach ($results ?? [] as $result) {
            $user = new \Model\Entities\User($result);
            $user->setMessageCount($result['month_messages']);
            $activeUsers[] = $user;
        }
    
        return $activeUsers;
    }   
}