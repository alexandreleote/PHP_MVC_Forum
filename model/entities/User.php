<?php
namespace Model\Entities;

use App\Entity;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class User extends Entity {
    const ROLE_ADMIN = 'Admin';
    const ROLE_MOD = 'Mod';
    const ROLE_MEMBER = 'Membre';

    private $id;
    private $nickName;
    private $email;
    private $password;
    private $subscriptionDate;
    private $userRole;
    private $messageCount;

    public function __construct($data){         
        $this->hydrate($data);        
    }

    /**
     * Get the value of id
     */ 
    public function getId(){
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id){
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of nickName
     */ 
    public function getNickName(){
        return $this->nickName;
    }

    /**
     * Set the value of nickName
     *
     * @return  self
     */ 
    public function setNickName($nickName){
        $this->nickName = $nickName;

        return $this;
    }

    /**
     * Get the value of email
     */
    public function getEmail() {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @return  self
     */ 
    public function setEmail($email) {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @return  self
     */
    public function setPassword($password) {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of subscriptionDate
     */
    public function getSubscriptionDate () {

        $date = new \DateTime($this->subscriptionDate);
        $formatter = new \IntlDateFormatter(
            'fr_FR', 
            \IntlDateFormatter::FULL, 
            \IntlDateFormatter::NONE
        );
        $formatter->setPattern('d/M/Y');
        return $formatter->format($date);
        
    }

    /**
     * Set the value of subscriptionDate
     *
     * @return  self
     */
    public function setSubscriptionDate($subscriptionDate) {
        $this->subscriptionDate = $subscriptionDate;

        return $this;
    }

    /**
     * Get the value of userRole
     */
    public function getUserRole () {
        return $this->userRole;
    }

    /**
     * Set the value of userRole
     *
     * @return  self
     */
    public function setUserRole ($userRole) {
        $this->userRole = $userRole;

        return $this;
    }

    /**
     * Get the message count
     */
    public function getMessageCount() {
        return $this->messageCount;
    }

    /**
     * Set the message count
     *
     * @return self
     */
    public function setMessageCount($messageCount) {
        $this->messageCount = $messageCount;
        return $this;
    }

    public function isAdmin() {
        return $this->userRole === self::ROLE_ADMIN;
    }

    public function isMod() {
        return $this->userRole === self::ROLE_MOD;
    }

    public function hasRole($role) {
        return $this->userRole === $role;
    }

    public function getCategories() {
        return CategoryManager::getCategoriesByUser($this->id);
    }

    public function getCreatedTopics() {
        return TopicManager::getTopicsByUser($this->id);
    }

    public function countCreatedTopics() {
        return TopicManager::countTopicsByUser($this->id);
    }

    public function getCreatedPosts() {
        return PostManager::getPostsByUser($this->id);
    }

    public function countCreatedPosts() {
        return PostManager::countPostsByUser($this->id);
    }
    
    public function __toString() {
        return $this->nickName;
    }
}