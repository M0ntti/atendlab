<?php

require_once __DIR__ . '/app/Controllers/authController.php';
require_once __DIR__ . '/app/Controllers/UsuariosController.php';
require_once __DIR__ . '/app/Middleware/auth.php';

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

switch ($controller) {
    case 'auth':
        $authController = new authController();


        switch($action) {

            case 'login':
                $authController->exibirLogin();
                break;

            case 'entrar':
                $authController->entrar();
                break;

            case 'logout':
                $authController->logout();
                break;

            default:
                http_response_code(404);
                echo 'Acao de autenticacao nao encontrada.';
        }
        break;

    case 'usuarios':
        exigirAutenticacao();
        $usuaiosController = new UsuarioController();
        
        switch ($action) {

            case 'listar':
                $usuaiosController->listar();
                break;

            case 'buscar':
                $usuaiosController->buscarPorId();
                break;

            case 'criar':
                $usuaiosController->criar();
                break;
                        
            case 'atualizar':
                $usuaiosController->atualizar();
                break;
                    
            case 'excluir':
                $usuaiosController->excluir();
                break;

            default:
                http_response_code(404);
                echo 'Acao de usuarios nao encontrada.';
        }
        break;
        
    default:
        http_response_code(404);
        echo 'Controller nao encontrado.';
        
        
}
