<?php
namespace Model\Managers;

use App\Manager;
use App\DAO;

class TopicManager extends Manager{

    // on indique la classe POO et la table correspondante en BDD pour le manager concerné
    protected $className = "Model\Entities\Topic";
    protected $tableName = "topic";

    public function __construct(){
        parent::connect();
    }

    // récupérer tous les topics d'une catégorie spécifique (par son id)
    public function findTopicsByCategory($id) {

        $sql = "SELECT t.id_topic,
                       t.title,
                       DATE_FORMAT(t.creationDate, '%d-%m-%Y à %H:%i') AS creationDate,
                       t.isLocked,
                       t.user_id,
                       t.category_id 
                FROM ".$this->tableName." t 
                WHERE t.category_id = :id
                ORDER BY t.creationDate DESC";
       
        // la requête renvoie plusieurs enregistrements --> getMultipleResults
        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );
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
}