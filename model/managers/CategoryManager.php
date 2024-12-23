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

    public function getActiveCategories() {
        $sql = "SELECT m.id_message,
                       m.content,
                       DATE_FORMAT(m.creationDate, '%d-%m-%Y') AS creationDate,
                       m.user_id,
                       m.topic_id,
                       t.id_topic,
                       t.title,
                       t.category_id,
                       c.name
                FROM message m 
                LEFT JOIN topic t ON m.topic_id = t.id_topic
                LEFT JOIN category c ON t.category_id = c.id_category
                WHERE m.creationDate < CURRENT_TIMESTAMP";
        return $this->getOneOrNullResult(
            DAO::select($sql, [], false), 
            $this->className
        );
    }

}