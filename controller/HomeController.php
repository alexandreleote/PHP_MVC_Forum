<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use Model\Managers\UserManager;
use Model\Managers\CategoryManager;
use Model\Managers\TopicManager;

class HomeController extends AbstractController implements ControllerInterface {

    public function index(){
        
        $id = isset($_GET['id']) ? $_GET['id'] : null;

        $categoryManager = new CategoryManager();
        $topicManager = new TopicManager();
        $categories = $categoryManager->findAll(["id_category", ""]);

        if ($id !== null) {
            $topics = $topicManager->findTopicsByCategory($id);
        } else {
            $topics = [];
        }

        return [
            "view" => VIEW_DIR."home.php",
            "meta_description" => "Page d'accueil du forum",
            "data" => [
                "categories" => $categories,
                "topics" => $topics
            ]
        ];
    }
        
    public function users(){
        $this->restrictTo("ROLE_USER");

        $manager = new UserManager();
        $users = $manager->findAll(['register_date', 'DESC']);

        return [
            "view" => VIEW_DIR."security/users.php",
            "meta_description" => "Liste des utilisateurs du forum",
            "data" => [ 
                "users" => $users 
            ]
        ];
    }
}
