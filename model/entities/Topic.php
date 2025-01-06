<?php
namespace Model\Entities;

use App\Entity;

/*
    En programmation orientée objet, une classe finale (final class) est une classe que vous ne pouvez pas étendre, c'est-à-dire qu'aucune autre classe ne peut hériter de cette classe. En d'autres termes, une classe finale ne peut pas être utilisée comme classe parente.
*/

final class Topic extends Entity{

    private $id;
    private $title;
    private $user;
    private $category;
    private $creationDate;
    private $isLocked;
    private $posts;
    private $lastActivity;

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
     * Get the value of title
     */ 
    public function getTitle(){
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title){
        $this->title = $title;
        return $this;
    }

    /**
     * Get the value of user
     */ 
    public function getUser(){
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @return  self
     */ 
    public function setUser($user){
        $this->user = $user;
        return $this;
    }

    /**
     * Get the value of creationDate
     *
     */ 
    public function getCreationDate() {
        return $this->creationDate;
    }

    /**
     * Set the value of creationDate
     *
     * @return  self
     */ 
    public function setCreationDate($creationDate){
        $this->creationDate = $creationDate;
        return $this;
    }
    
    /**
     * Get the value of category
     */ 
    public function getCategory(){
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @return  self
     */ 
    public function setCategory($category){
        $this->category = $category;
        return $this;
    }

    /**
     * Get the value of isLocked
     */ 
    public function getIsLocked(){
        return $this->isLocked;
    }

    /**
     * Set the value of isLocked
     *
     * @return  self
     */ 
    public function setIsLocked($isLocked){
        $this->isLocked = $isLocked;
        return $this;
    }

    public function getLocked() {
        return $this->isLocked;
    }  

    public function setLocked($locked) {
        $this->isLocked = $locked;
        return $this;
    }

    public function getPosts() {
        $postManager = new \Model\Managers\PostManager();
        return $postManager->displayAllPostsByTopic($this->id);
    }

    public function getPostsCount() {
        $postManager = new \Model\Managers\PostManager();
        return $postManager->countPosts($this->id);
    }

    public function setPostsCount($count) {
        $this->posts = $count;
        return $this;
    }


    public function getLastActivity() {
        // Si lastActivity est null, retourner la date de création
        return $this->lastActivity 
            ? date('d-m-Y à H:i', strtotime($this->lastActivity)) 
            : $this->getCreationDate();
    }

    public function setLastActivity($lastActivity) {
        $this->lastActivity = $lastActivity;
        return $this;
    }


    public function __toString(){
        return $this->title;
    }
}