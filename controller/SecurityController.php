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

                        $this->redirectTo("home", "index");
                    } else {
                        // message indiquant que les mots de passe ne sont identiques OU que les règles de mot de passe fort ne sont pas respectés
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

    public function logout () {}
}