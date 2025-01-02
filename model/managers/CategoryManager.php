<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class CategoryManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Category";
    protected $tableName = "category";

    public function __construct(){
        parent::connect();
    }

    // Pour les 3 premières catégories
    public function getMainCategories() {
        $sql = "SELECT * FROM category
                ORDER BY id_category DESC 
                LIMIT 3";
        
        return $this->getMultipleResults(
            DAO::select($sql),
            $this->className
        );
    }

    // Pour le top 10 des catégories les plus actives
    public function getTopCategories($limit = 10) {
        $sql = "SELECT c.*,
                COUNT(DISTINCT t.id_topic) as topic_count,
                COUNT(p.id_message) as post_count,
                (COUNT(DISTINCT t.id_topic) + COUNT(p.id_message)) as total_activity
                FROM category c
                LEFT JOIN topic t ON c.id_category = t.category_id
                LEFT JOIN message p ON t.id_topic = p.topic_id
                GROUP BY c.id_category
                ORDER BY total_activity DESC
                LIMIT :limit";
        
        return $this->getMultipleResults(
            DAO::select($sql, ['limit' => $limit]),
            $this->className
        );
    }
}