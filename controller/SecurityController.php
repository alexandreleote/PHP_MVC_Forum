<?php
namespace Controller;

use App\AbstractController;
use App\ControllerInterface;
use APP\Session;
use Model\Managers\UserManager;

class SecurityController extends AbstractController{
    // contiendra les méthodes liées à l'authentification : register, login et logout

    public function register () {
            
            $userManager = new UserManager();
            
            $nickName = filter_input(INPUT_POST, "nickName", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
            $pass1 = filter_input(INPUT_POST, "pass1", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pass2 = filter_input(INPUT_POST, "pass2", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            
            if($nickName && $email && $pass1 && $pass2) {

                if ($userManager->isEmailUsed($email)) {
                    // message indiquant que le pseudonyme ou l'e-mail est déjà utilisé
                    $this->redirectTo("security", "login");

                } else {
                    // Insertion des données de l'inscription en BDD
                    $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/"; 
                    if($pass1 === $pass2 && preg_match($password_regex, $pass1)) {

                        $hash = password_hash($pass1, PASSWORD_DEFAULT);

                        $data = [
                            "nickName" => $nickName,
                            "email" => $email,
                            "password" => $hash
                        ];

                        $userManager->add($data);

                        $this->redirectTo("security", "login");
                    } else {
                        // message indiquant que les mots de passe ne sont identiques OU que les règles de mot de passe fort ne sont pas respectés
                        Session::addFlash("error", "Les mots de passe ne sont pas identiques ou ne respectent pas les exigences de securité.");
                    }
                }
            }

        return [
            "view" => VIEW_DIR."security/register.php",
            "meta_description" => "Page d'inscription au forum"
        ];
    }

    public function login () {

        $userManager = new UserManager();

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if($email && $password) {
            $user = $userManager->findUserByEmail($email);
            if ($user) {
                $hash = $user->getPassword();
                if(password_verify($password, $hash)) {
                    Session::setUser($user);
                    $this->redirectTo("home", "index");
                } else {
                    $this->redirectTo("security", "login");
                }
            } else {
                $this->redirectTo("security", "login");
            }
        }

        return [
            "view" => VIEW_DIR."security/login.php",
            "meta_description" => "Page de connexion au forum"
        ];
    }

    public function logout () {

        $userManager = new UserManager();

        unset($_SESSION["user"]);

        $this->redirectTo("home", "index");
    }

    public function profile ($id = null) {
        $userManager = new UserManager();
        $categoryManager = new \Model\Managers\CategoryManager();

        // Si un ID est passé, chercher l'utilisateur par son ID
        if ($id !== null) {
            $user = $userManager->findOneById($id);
            
            if (!$user) {
                // Rediriger si l'utilisateur n'existe pas
                $this->redirectTo("home", "index");
            }
        } else {
            // Sinon, utiliser l'utilisateur connecté
            $user = Session::getUser();
            
            if (!$user) {
                $this->redirectTo("security", "login");
            }
        }

        // Récupérer les catégories
        $categories = $categoryManager->findAll(["id_category", ""]);

        return [
            "view" => VIEW_DIR."security/profile.php",
            "meta_description" => "Profil de : ".$user->getNickName(),
            "data" => [
                "user" => $user,
                "categories" => $categories,
                "isCurrentUser" => ($id === null || $id == Session::getUser()->getId())
            ]
        ];
    }
    public function modify() {
        $userManager = new UserManager();
        $user = Session::getUser();
        
        // Récupération et nettoyage des données du formulaire
        $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
        $emailConfirm = filter_input(INPUT_POST, "emailConfirm", FILTER_SANITIZE_EMAIL, FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $passwordConfirm = filter_input(INPUT_POST, "passwordConfirm", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
        // Si le formulaire est soumis
        if($username || $email || $password) {
            $data = [];
            $errors = [];
    
            // Validation du nom d'utilisateur
            if($username && $username !== $user->getNickName()) {
                $data["nickName"] = $username;
            }
    
            // Validation de l'email
            if($email) {
                if($email === $emailConfirm) {
                    if($email !== $user->getEmail()) {
                        // Vérifier si l'email n'est pas déjà utilisé par un autre utilisateur
                        if(!$userManager->isEmailUsed($email) || $email === $user->getEmail()) {
                            $data["email"] = $email;
                        } else {
                            $errors[] = "Cette adresse email est déjà utilisée";
                        }
                    }
                } else {
                    $errors[] = "Les adresses email ne correspondent pas";
                }
            }
    
            // Validation du mot de passe
            if($password) {
                // Même regex que dans register()
                $password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{12,}$/";
                
                if($password === $passwordConfirm) {
                    if(preg_match($password_regex, $password)) {
                        $data["password"] = password_hash($password, PASSWORD_DEFAULT);
                    } else {
                        $errors[] = "Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial";
                    }
                } else {
                    $errors[] = "Les mots de passe ne correspondent pas";
                }
            }
    
            // S'il y a des données à mettre à jour et aucune erreur
            if(!empty($data) && empty($errors)) {
                try {
                    // Mise à jour en base de données
                    $userManager->updateUser($user->getId(), $data);
                    
                    // Mise à jour de la session avec les nouvelles données
                    $updatedUser = $userManager->findOneById($user->getId());
                    Session::setUser($updatedUser);
                    
                    Session::addFlash("success", "Vos informations ont été mises à jour avec succès");
                } catch(\Exception $e) {
                    Session::addFlash("error", "Une erreur est survenue lors de la mise à jour");
                }
            } else if(!empty($errors)) {
                foreach($errors as $error) {
                    Session::addFlash("error", $error);
                }
            }
        }
    
        $this->redirectTo("security", "profile");
    }

    public function deleteUserProfile ($id) {
        $userManager = new UserManager();

        $user = Session::getUser();

        $userManager->deleteProfile($user->getId());

        Session::removeUser('user');

        $this->redirectTo("security", "login");
    }

}