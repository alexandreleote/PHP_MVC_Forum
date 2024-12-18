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
                       DATE_FORMAT(t.creationDate, '%d-%m-%Y') AS creationDate,
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

    // Verrouiller un sujet
    public function lockTopic($isAdmin = false) {
        // Vérifier si l'utilisateur est administrateur
        if (!$isAdmin) {
            return false;
        }

        // Récupérer l'état actuel du verrouillage
        $checkLockSql = "SELECT isLocked
                        FROM ".$this->tableName;

        $isLocked = DAO::select($checkLockSql, [], false);

        // Inverser l'état du verrouillage (0 -> 1 ou 1 -> 0)
        $newLockState = !$isLocked['isLocked'];

        // Mettre à jour l'état de verrouillage
        $lockSql = "UPDATE ".$this->tableName."
                   SET isLocked = :newLockState";

        return DAO::update($lockSql, [
            'newLockState' => $newLockState ? 1 : 0
        ]);
        
    }
}