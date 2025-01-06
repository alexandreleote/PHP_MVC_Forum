<?php
namespace Controller;

use App\Session;
use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;
use Model\Managers\PostManager;
use Model\Managers\UserManager;

class ForumController extends AbstractController implements ControllerInterface{

    public function index() {
        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
        $postManager = new PostManager();
    
        // Récupérer les catégories principales
        $mainCategories = $categoryManager->getMainCategories() ?: [];
        
        // Récupérer les top catégories
        $topCategories = $categoryManager->getTopCategories(3) ?: [];
                
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

    // Afficher les catégories
    public function listCategories() {
        $categoryManager = new CategoryManager();
        $categories = $categoryManager->findAll(["id_category", ""]);
        
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    // Afficher les sujets par catégorie
    public function listTopicsByCategory($id) {
        $categoryManager = new \Model\Managers\CategoryManager();
        $topicManager = new \Model\Managers\TopicManager();
        
        $category = $categoryManager->findOneById($id);
        
        if (!$category) {
            Session::addFlash('error', 'Catégorie non trouvée');
            $this->redirectTo("forum", "listCategories");
            return null;
        }
        
        $topics = $topicManager->displayAllTopicsByCategory($id);
        $mostActiveUsers = $topicManager->getMostActiveUsersForCurrentMonth($id);
        
        return [
            "view" => VIEW_DIR."forum/listTopics.php",
            "meta_description" => "Sujets : ".$category,
            "data" => [
                "category" => $category,
                "topics" => $topics,
                "users" => $mostActiveUsers
            ]
        ];
    }

    /* Sujets */

    // Récupérer les messages d'une discussion
    public function discussionByTopic(int $id) {

        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $userManager = new UserManager();
    
        $topic = $topicManager->findOneById($id);
        $category = $categoryManager->findOneById($id);
        $posts = $postManager->displayAllPostsByTopic($id);

        // Récupérer les utilisateurs uniques qui ont posté dans ce sujet
        $users = $userManager->getUsersByTopic($id);

        if(!$topic) {
            $this->redirectTo("home", "index");
        } else {
            return [
                "view" => VIEW_DIR."forum/listMessages.php",
                "meta_description" => "Discussion : ".$topic,
                "data" => [
                    "category" => $category,
                    "topic" => $topic,
                    "posts" => $posts,
                    "users" => $users
                ]
            ];
        }
    }

    // Créer un nouveau sujet
    public function createTopic(int $category_id) {
        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
    
        // Vérifier la catégorie
        $category = $categoryManager->findOneById($category_id);
        
        // Vérifier si la catégorie est valide
        if (!$category) {
            // Enregistrer l'erreur
            error_log("Invalid category ID: " . $category_id);
            
            // Redirection ou gestion de l'erreur de mani re appropri e
            $this->redirectTo("forum", "index");
            return null;
        }
    
        if (isset($_POST["title"], $_POST["content"])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            // Vérifier si l'utilisateur est connect
            $author = Session::getUser();
            if (!$author) {
                // Redirection vers la page de login ou affichage d'une erreur
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
    
        // Si nous arrivons ici, afficher le formulaire de création de sujet
        return [
            "view" => VIEW_DIR."forum/createTopic.php",
            "meta_description" => "Créer un nouveau sujet",
            "data" => [
                "category" => $category
            ]
        ];
    }

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
        $postManager = new PostManager();
        $topicManager = new TopicManager();

        // Vérifier si le sujet existe
        $topic = $topicManager->findOneById($topic_id);
        if (!$topic) {
            Session::addFlash('error', 'Sujet non trouvé');
            return $this->redirectTo("forum", "index");
        }

        // Vérifier si le sujet est verrouillé
        if ($topic->getIsLocked()) {
            Session::addFlash('error', 'Ce sujet est verrouillé');
            return $this->redirectTo("forum", "discussionByTopic", $topic_id);
        }

        // Vérifier si l'utilisateur est connecté
        $user = Session::getUser();
        if (!$user) {
            Session::addFlash('error', 'Vous devez être connecté pour poster un message');
            return $this->redirectTo("security", "login");
        }

        // Traitement du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (empty($content)) {
                Session::addFlash('error', 'Le message ne peut pas être vide');
                return $this->redirectTo("forum", "discussionByTopic", $topic_id);
            }

            $dateTime = new \DateTime('now', new \DateTimeZone('Europe/Paris'));
            
            $postData = [
                'content' => $content,
                'user_id' => $user->getId(),
                'topic_id' => $topic_id,
                'creationDate' => $dateTime->format('Y-m-d H:i:s')
            ];

            // Ajouter le message
            $postId = $postManager->add($postData);

            if ($postId) {
                // Utiliser une session flash pour le message de succès
                // Session::addFlash('success', 'Message posté avec succès');
                
                // Redirection en utilisant POST-REDIRECT-GET
                header("Location: index.php?ctrl=forum&action=discussionByTopic&id=" . $topic_id);
                exit();
            } else {
                Session::addFlash('error', 'Erreur lors de la publication du message');
                return $this->redirectTo("forum", "discussionByTopic", $topic_id);
            }
        }

        // Si on arrive ici sans POST, rediriger vers la discussion
        return $this->redirectTo("forum", "discussionByTopic", $topic_id);
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
   