<?php
namespace Model\Entities;

use App\Entity;

final class Post extends Entity{

    private $id;
    private $content;
    private $creationDate;
    private $user;
    private $topic;

    public function __construct($data){         
        $this->hydrate($data);        
    }
    
    // Get the value of id
    public function getId()
    {
        return $this->id;
    }

    // Set the value of id
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    // Get the value of content
    public function getContent()
    {
        return $this->content;
    }

    // Set the value of content
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    // Get the value of creationDate
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    // Set the value of creationDate
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;
        return $this;
    }

    // Get the value of user
    public function getUser()
    {
        return $this->user;
    }

    // Set the value of user
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    // Get the value of topic
    public function getTopic()
    {
        return $this->topic;
    }

    // Set the value of topic
    public function setTopic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    // Affiche le contenu avec des balises <p> pour faciliter la lecture
    public function __toString(){
        return $this->content;
    }

}