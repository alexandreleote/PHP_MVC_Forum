<?php
namespace App;

class Session{

    private static $categories = ['error', 'success'];

    /**
    *   ajoute un message en session, dans la catégorie $categ
    */
    public static function addFlash($categ, $msg){
        $_SESSION[$categ] = $msg;
    }

    /**
    *   renvoie un message de la catégorie $categ, s'il y en a !
    */
    public static function getFlash($categ){
        
        if(isset($_SESSION[$categ])){
            $msg = $_SESSION[$categ];  
            unset($_SESSION[$categ]);
        }
        else $msg = "";
        
        return $msg;
    }

    /**
    *   met un user dans la session (pour le maintenir connecté)
    */
    public static function setUser($user){
        $_SESSION["user"] = $user;
    }

    public static function getUser(){
        return (isset($_SESSION['user'])) ? $_SESSION['user'] : false;
    }

    public static function removeUser(){
        unset($_SESSION['user']);
    }
    
    public static function isAdmin(){
        // attention de bien définir la méthode "hasRole" dans l'entité User en fonction de la façon dont sont gérés les rôles en base de données
        if(self::getUser() && self::getUser()->hasRole("Admin")){
            return true;
        }
        return false;
    }

    public static function isModerator(){
        if(self::getUser() && self::getUser()->hasRole("Mod")){
            return true;
        }
        return false;
    }

    public static function isAuthor($postAuthorId) {
        // Vérifier qu'un utilisateur est connecté
        $currentUser = self::getUser();
        if (!$currentUser) {
            return false;
        }

        // Comparer l'ID de l'utilisateur connecté avec l'ID de l'auteur du post
        return $currentUser->getId() == $postAuthorId;
    }

    public static function isConnected() {
        return isset($_SESSION['user']);
    }
}