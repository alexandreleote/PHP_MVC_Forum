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

        $sql = "SELECT * 
                FROM ".$this->tableName." m 
                WHERE m.topic_id = :id
                ";

        return  $this->getMultipleResults(
            DAO::select($sql, ['id' => $id]), 
            $this->className
        );        
    }
}