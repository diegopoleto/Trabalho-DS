<?php
    require_once("../vendor/autoload.php");
    require_once("Controllers/AuthenticationController.php");
    require_once("Controllers/ConversaController.php");
    require_once("Controllers/CursoController.php");
    require_once("Controllers/EntidadeController.php");
    require_once("Controllers/PostController.php");
    require_once("Controllers/RevisaoController.php");
    require_once("Controllers/UsuarioController.php");
    require_once("Controllers/UsuarioEntidadeController.php");
    
    use \Slim\App;

    $app = new App();

    // Rotas Autenticação
    $app->get('/auth/{userId}', '\AuthenticationController:validateTokenByURL');
    $app->post('/login/', '\AuthenticationController:login');
    
    // Rotas Conversa
    $app->get('/conversa/', '\ConversaController:listAll');
    $app->get('/conversas/{usuarioId}', '\ConversaController:recentConversations');
    $app->get('/conversas/{usuarioId}/usuarios/', '\ConversaController:findConversationWithUser');
    $app->get('/conversas/{usuario1}/{usuario2}', '\ConversaController:viewConversation');
    $app->post('/conversas/{usuario1}/{usuario2}', '\ConversaController:createConversation');
    $app->post('/conversas/{usuario1}/{usuario2}/mensagem/', '\ConversaController:sendMenssageInConversation');
    $app->post('/conversas/{usuario1}/{usuario2}/revisao', '\ConversaController:sendConversationToRevision');
    $app->post('/conversa/', '\ConversaController:createConversa');

    // Rotas Curso
    $app->get('/curso/', '\CursoController:listAll');
    $app->post('/curso/', '\CursoController:createCurso');
    $app->put('/curso/{codigoCurso}', '\CursoController:updateCurso');
    $app->delete('/curso/{codigoCurso}', '\CursoController:deleteCurso');

    // Rotas Entidade
    $app->get('/entidade/', '\EntidadeController:listAll');
    $app->post('/entidade/', '\EntidadeController:createEntidade');
    $app->put('/entidade/{codigoEntidade}', '\EntidadeController:updateEntidade');
    $app->delete('/entidade/{codigoEntidade}', '\EntidadeController:deleteEntidade');

    // Rotas Posts
    $app->get('/post/', '\PostController:listAll');
    $app->post('/post/', '\PostController:createPost');
    $app->post('/post/{usuarioID}/{entidade}', '\PostController:createPostAsEntity');
    $app->post('/post/{post}/resposta/', '\PostController:createResponseToPost');
    $app->put('/post/{codigoPost}', '\PostController:updatePost');
    $app->delete('/post/{codigoPost}','\PostController:deletePost');

    // Rotas Revisão
    $app->get('/revisao/{coordenador}/', '\RevisaoController:viewRevision');
    $app->post('/revisao/{usuario1}/{usuario2}', '\RevisaoController:seeConversationToRevision');
    $app->post('/revisao/{coordenador}/{usuario1}/{usuario2}', '\RevisaoController:sendRevision');
    //$app.get('/revisaoAdmin/:admin', ); 

    // Rotas Usuário
    $app->get('/usuario/', '\UsuarioController:listAll');
    $app->get('/usuario/{email}', '\UsuarioController:getPerfilInfos');
    $app->post('/usuario/timeline/', '\UsuarioController:timeline');
    $app->post('/usuario/password/ask/', '\UsuarioController:requestNewPassword');
    $app->post('/usuario/password/reset/{hash}', '\UsuarioController:resetPassword');
    $app->post('/usuario/', '\UsuarioController:createUsuario');
    $app->put('/usuario/{email}', '\UsuarioController:updateUsuario');
    $app->delete('/usuario/{email}', '\UsuarioController:banUsuario');

    // Rotas Usuario Entidade
    $app->get('/usuarioEntidade/', '\UsuarioEntidadeController:listAll');
    $app->post('/usuarioEntidade/', '\UsuarioEntidadeController:createNewResponsible');
    $app->post('/usuarioEntidade/update/', '\UsuarioEntidadeController:updateResponsible');


    $app->run();

?>