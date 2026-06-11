<?php

require_once __DIR__ . '/app/Controllers/UsuariosController.php'
$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ?? 'index';

if ($controller == 'usuarios') {
    $usuaiosController = new UsuarioController();

    switch($action) {
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
            $usuaiosController->excluir()
            break;

        default:
        echo 'Ação de usuários não encontrada.';
        break;
    }
} else {

    echo '<h1>AtendLab</h1>';
    echo '<p>Projeto em execução. Use ?controller=usuarios&action=listar para testar.</p>';
}