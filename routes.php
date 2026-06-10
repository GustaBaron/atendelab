<?php
//Carrega o controller responsavel pelos endpoints de usuarios.
// Observação: o arquivo no projeto está no singular (UsuarioController.php)
require_once __DIR__ . '/app/Controllers/UsuarioController.php';

$controller = $_GET['controller'] ?? 'home';
$action = $_GET['action'] ??'index';

if ($controller === 'usuarios') {
    $usuariosController = new UsuariosController();

    //Escolhe método do Controller executar.
    switch($action){
        case 'listar':
            $usuariosController->listar();
            break;

        case 'buscar':
            $usuariosController->buscarPorId();
            break;

        case 'criar':
            $usuariosController->criar();
            break;

        case 'atualizar':
            $usuariosController->atualizar();
            break;

        case 'excluir':
            $usuariosController->excluir();
            break;
        
        default:
            //Retorno Padrão para action inválida.
            echo 'Ação de usuários não entrada.';
            break;
    
    }
} else{
    //Resposta básica para indicar que a aplicação está no ar.
    echo '<h1>AtendeLab</h1>';
    echo '<p>Projeto em execução. Use ?controller=usuarios&action=listar para testar.</p>';
}
