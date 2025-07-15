<?php
require_once 'models/Usuario.php';

class AuthController {
    private $usuarioModel;
    
    public function __construct() {
        $this->usuarioModel = new Usuario();
    }
    
    public function login() {
        $error = null;
        
        if ($_POST) {
            $email = $_POST['usuario'];
            $password = $_POST['password'];
            $tipo = $_POST['rol'];
            
            $user = $this->usuarioModel->authenticate($email, $password, $tipo);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['tipo'] = $user['tipo'];
                $_SESSION['estudiante_id'] = $user['estudiante_id'];
                $_SESSION['padre_id'] = $user['padre_id'];
                $_SESSION['profesor_id'] = $user['profesor_id'];
                
                switch($tipo) {
                    case 'estudiante':
                        header('Location: /englishdemo/?controller=student&action=dashboard');
                        break;
                    case 'profesor':
                        header('Location: /englishdemo/?controller=teacher&action=dashboard');
                        break;
                    case 'padre':
                        header('Location: /englishdemo/?controller=parent&action=dashboard');
                        break;
                }
                exit();
            } else {
                $error = "Invalid credentials";
            }
        }
        
        $this->loadView('auth/login', ['error' => $error]);
    }
    
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: /englishdemo/?controller=auth&action=login');
        exit();
    }
    
    private function loadView($view, $data = []) {
        extract($data);
        require_once "views/$view.php";
    }
}
?>