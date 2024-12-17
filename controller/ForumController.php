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
        
        // créer une nouvelle instance de CategoryManager
        $categoryManager = new CategoryManager();
        // récupérer la liste de toutes les catégories grâce à la méthode findAll de Manager.php (triés par nom)
        $categories = $categoryManager->findAll(["name", "DESC"]);

        // le controller communique avec la vue "listCategories" (view) pour lui envoyer la liste des catégories (data)
        return [
            "view" => VIEW_DIR."forum/listCategories.php",
            "meta_description" => "Liste des catégories du forum",
            "data" => [
                "categories" => $categories
            ]
        ];
    }

    public function listTopicsByCategory($id) {

        $topicManager = new TopicManager();
        $categoryManager = new CategoryManager();
        $category = $categoryManager->findOneById($id);
        $topics = $topicManager->findTopicsByCategory($id);

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

    public function createTopic(int $id) {

        if (isset($_POST["title"], $_POST["content"], $_POST["category_id"])) {
            $title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $category_id = filter_input(INPUT_POST, "category_id", FILTER_SANITIZE_NUMBER_INT);

            $topicManager = new TopicManager();
            $postManager = new PostManager();
            
            // Auteur du topic
            $author = Session::getUser()->getId();

            if ($title && $content && $category_id) {

                $topicData = [
                    "title" => $title,
                    "category_id" => $category_id,
                    "user_id" => $author
                ];

                $topicId = $topicManager->add($topicData);
                
                $postData = [
                    "content" => $content,
                    "user_id" => $author,
                    "topic id" => $topic_id
                ];

                $postManager->add($postData);

                $this->redirectTo("forum", "discussionByTopic", $topicId);
            }
        }
    }


    public function createPost(int $id) {
        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $categoryManager = new CategoryManager();
        
        if (isset($_POST["content"], $_POST["topic_id"])) {
            $content = filter_input(INPUT_POST, "content", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $topic_id = filter_input(INPUT_POST, "topic_id", FILTER_SANITIZE_NUMBER_INT);
    
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

    // Suppression d'un message si on en est l'auteur
    public function deletePost(int $id) {
        $topicManager = new TopicManager();
        $postManager = new PostManager();
        $categoryManager = new CategoryManager();

        $user = Session::getUser()->getId();
        $author = $postManager->getUser()->getId();

        if($user === $author) {
            $postData = [
                "content" => $content,
                "user_id" => $author,  
                "topic_id" => $topic_id
            ];
            
            $postManager->delete($postData);
        }
    }

}