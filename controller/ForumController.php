<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
        $postManager = new PostManager();
    
        // Récupérer les 3 dernières catégories
        $mainCategories = $categoryManager->getMainCategories() ?: [];
        
        // Récupérer le top 10 des catégories
        $topCategories = $categoryManager->getTopCategories(10) ?: [];
        
        // Récupérer les derniers sujets
        $latestTopics = $topicManager->getLatestTopics(3) ?: [];
        
        // Récupérer les derniers messages
        $latestPosts = $postManager->getLatestPosts(3) ?: [];
    
        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Page d'accueil du forum",
            "data" => [
                "mainCategories" => $mainCategories,
                "topCategories" => $topCategories,
                "latestTopics" => $latestTopics,
                "latestPosts" => $latestPosts
            ]
        ];
    }

    /* Catégorie */

    // Afficher les sujets par catégorie
    public function listTopicsByCategory($id) {

        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
        
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->displayAllTopicsByCategory($id);

        if(!$category) {
            $this->redirectTo("home", "index");
        } else {
            return [
                "view" => VIEW_DIR."forum/listTopics.php",
                "meta_description" => "Liste des topics par catégorie : ".$category,
                "data" => [
                    "category" => $category,
                    "topics" => $topics
                ]
            ];
        }
    }

    /* Sujets */

    // Récupérer les messages d'une discussion
    public function discussionByTopic(int $id) {

        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
        $postManager = new PostManager();
        
        $topic = $topicManager->findOneById($id);
        $category = $categoryManager->findOneById($id);
        $posts = $postManager->displayAllPostsByTopic($id);

        if(!$topic) {
            $this->redirectTo("home", "index");
        } else {
            return [
                "view" => VIEW_DIR."forum/listMessages.php",
                "meta_description" => "Discussion : ".$topic,
                "data" => [
                    "category" => $category,
                    "topic" => $topic,
                    "posts" => $posts
                ]
            ];
        }
    }

    // Créer un nouveau sujet
    public function createTopic(int $category_id) {
        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
    
        // Validate category
        $category = $categoryManager->findOneById($category_id);
        
        // Check if category is valid
        if (!$category) {
            // Log the error
            error_log("Invalid category ID: " . $category_id);
            
            // Redirect or handle the error appropriately
            $this->redirectTo("forum", "index");
            return null;
        }
    
        if (isset($_POST["title"], $_POST["content"])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            // Ensure user is logged in
            $author = Session::getUser();
            if (!$author) {
                // Redirect to login or show error
                $this->redirectTo("security", "login");
                return null;
            }
    
            if ($title && $content && $category_id) {
                $dateTime = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
                
                $topicData = [
                    "title" => $title,
                    "category_id" => $category_id,
                    "user_id" => $author->getId(),
                    "creationDate" => $dateTime->format('Y-m-d H:i:s')
                ];
        
                $topicId = $topicManager->add($topicData);
                
                $postData = [
                    "content" => $content,
                    "user_id" => $author->getId(),
                    "topic_id" => $topicId,
                    "creationDate" => $dateTime->format('Y-m-d H:i:s')
                ];
        
                $postManager = new PostManager();
                $postManager->add($postData);
    
                $this->redirectTo("forum", "discussionByTopic", $topicId);
                return null;
            }
        }
    
        // If we reach here, show the create topic form
        return [
            "view" => VIEW_DIR."forum/createTopic.php",
            "meta_description" => "Créer un nouveau sujet",
            "data" => [
                "category" => $category
            ]
        ];
    }

    // Verrouiler le sujet
    
    // Verrouiller le sujet
    public function lockTopic(int $id) {
        $topicManager = new TopicManager();
        if (Session::isAdmin()) {
            $topicManager->lock($id);
        }
        $this->redirectTo("forum", "discussionByTopic", $id);
    }

    // Déverrouiller le sujet
    public function unlockTopic(int $id) {
        $topicManager = new TopicManager();
        if (Session::isAdmin()) {
            $topicManager->unlock($id);
        }
        $this->redirectTo("forum", "discussionByTopic", $id);
    }

    /* Messages */

    // Créer un message
    public function createPost(int $topic_id) {
        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $categoryManager = new CategoryManager();
        
        if (isset($_POST["content"])) {
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            // Auteur du message
            $author = Session::getUser()->getId();
    
            if ($content && $topic_id) {
                $postData = [
                    "content" => $content,
                    "user_id" => $author,  
                    "topic_id" => $topic_id
                ];
    
                $postManager->add($postData);
    
                // Récupérer le topic
                $topic = $topicManager->findOneById($topic_id);
                
                // Récupérer la catégorie du topic
                $category = $categoryManager->findOneById($topic->getCategory()->getId());
    
                return [
                    "view" => VIEW_DIR."forum/listMessages.php",
                    "meta_description" => "Discussion : ".$topic,
                    "data" => [
                        "category" => $category,
                        "topic" => $topic, 
                        "posts" => $postManager->displayAllPostsByTopic($topic_id)
                    ]
                ];
            }
        }
    
        // Gestion du cas où aucun post n'est créé
        return [
            "view" => VIEW_DIR."forum/listMessages.php",
            "meta_description" => "Erreur de création de message",            
            "data" => []
        ];
    }

    // Suppression d'un message si on en est l'auteur ou admin
    public function deletePost(int $id) {
        $postManager = new PostManager();

        // Vérification si l'utilisateur est bien connecté
        if (!Session::getUser()) {
            Session::addFlash('error', 'Vous devez être connecté pour supprimer un message');
            return $this->redirectTo("forum", "listMessages");
        }

        // On récupère l'id du message et si différent -> message erreur
        $postId = $postManager->findOneMessageById($id);
        if (!$postId) {
            Session::addFlash('error', 'Message non trouvé');
            return $this->redirectTo("forum", "listMessages");
        }

        // Si l'utilisateur correspond à celui qui a créé le message OU si l'utilisateur est admin -> suppression
        if ($postManager->deletePost($id, Session::getUser()->getId(), Session::isAdmin())) {
            Session::addFlash('success', 'Message supprimé avec succès');
        } else {
            Session::addFlash('error', 'Vous n\'êtes pas autorisé à supprimer ce message');
        }

        return $this->redirectTo("forum", "discussionByTopic", $postId->getTopic()->getId());
    }
    
}
   