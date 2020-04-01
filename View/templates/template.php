<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template</title>
    <link rel="stylesheet" href="../css/global.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('../modules/header.php'); ?>

    <div class="container">
        <div class="card shadow" id="esseCard">
            <h2>Lorenzo</h2>
        </div>
        <div class="card shadow" id="esseCard">
            <h2>Creude</h2>
            <form action="">
                <input type="text" placeholder="Nome" name="nome">
                <button class="verde">Verde</button>
                <button class="vermelho">Vermelho</button>
                <button class="amarelo">Amarelo</button>
            </form>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facere accusamus, suscipit explicabo blanditiis, eum deleniti nostrum optio dignissimos dolore earum
                accusantium voluptatem amet rerum, <a href="">alias illo dolor numquam quam vero.</a></p>
        </div>
    </div>

    <?php require('../modules/footer.php'); ?>

    <script src="js/jquery.min.js"></script>
    <script src="../js/api.js"></script>
    <script>
        pathData = 'http://localhost:3000';
        pathServer = 'http://localhost/projetoDS/v2/View/';

        localStorage.setItem("tokenPortal", '1234567890');
        token = localStorage.getItem("tokenPortal");

        /*userId = 'lorenzo'
        body = {'email': ''}
        request('POST', token, pathData + '/auth/' + userId, body, function (resp) {
            console.log(resp);
        });

        request('GET', null, pathData + '/cursos/', body, function (resp) {
            console.log(resp);
        });


        body = {
          "email": "fantunes.lorenzo@gmail.com",
          "cpf": "034.517.580-83",
          "password": "sdsdsd",
          "passwordConfirm": "dsds",
          "tipoUsuario": "aluno",
          "sobrenome": "ANTUNES",
          "matricula": "213425",
          "curso": "fdsgdsf",
          "siepe": "",
          "dataNascimento": "2018-12-31",
          "id": 2
        };
        request('POST', token, pathData + '/usuario/', body, function (resp) {
            console.log(resp);
        });


        body = {'email': 'lroenzo@mfil.com', 'senha': 'dborbadsa'};
        request('GET', null, pathData + '/login/', body, function (resp) {
            console.log(resp);
        });

        body = {'email': ''}
        request('POST', null, pathData + '/usuario/pasword/ask/', body, function (resp) {
            console.log(resp);
        });

        body = {'email': '', 'password': ''}
        request('POST', null, pathData + '/usuario/pasword/reset/', body, function (resp) {
            console.log(resp);
        });

        body = {'email': ''}
        request('GET', token, pathData + '/usuario/', body, function (resp) {
            console.log(resp);
        });

        body = null
        request('GET', token, pathData + '/entidades/', body, function (resp) {
            console.log(resp);
        });

        body = {'mensagem': '','entidadeId': '','anonimo': '', 'usuarioId': ''}
        request('POST', token, pathData + '/post/', body, function (resp) {
            console.log(resp);
        });

        body = null;
        postId = '123';
        request('GET', token, pathData + '/post/' + postId, body, function (resp) {
            console.log(resp)
        });

        body = {'usuarioId': '', 'idUltimoPost': '', 'tipoUsuario': ''}
        request('GET', token, pathData + '/usuario/timeline/', body, function (resp) {
            console.log(resp)
        });

        body = null
        usuarioId = 'lorenzofantunes';
        request('GET', token, pathData + '/conversa/' + usuarioId, body, function (resp) {
            console.log(resp)
        });

        usuarioId = 'lorenzofantunes';
        body = {'pesquisa': ''}
        request('GET', token, pathData + '/conversa/' + usuarioId + '/usuarios', body, function (resp) {
            console.log(resp)
        });

        usuario1 = 'lorenzo';
        usuario2 = 'matheus';

        body = {'anonima': ''}
        request('POST', token, pathData + '/conversa/' + usuario1 + '/' + usuario2, body, function (resp) {
            console.log(resp);
        });

        usuario1 = 'lorenzo';
        usuario2 = 'matheus';
        body = {'ultimaMensagem': '', 'limite': ''}
        request('GET', token, pathData + '/conversa/' + usuario1 + '/' + usuario2, body, function (resp) {
            console.log(resp);
        });

        usuario1 = 'lorenzo';
        usuario2 = 'matheus';
        body = {'mensagem': ''}
        request('POST', token, pathData + '/conversa/' + usuario1 + '/' + usuario2 + '/mensagem/', body, function (resp) {
            console.log(resp);
        });

        body = null;
        request('POST', token, pathData + '/conversa/' + usuario1 + '/' + usuario2 + '/revisao/', body, function (resp) {
            console.log(resp);
        });

        coordenador = 'craudio';
        body = null;
        request('GET', token, pathData + '/revisao/' + coordenador, body, function (resp) {
            console.log(resp);
        });

        usuario1 = 'lorenzo';
        usuario2 = 'matheus';
        body = {'ultimaMensagem': '', 'limite': ''};
        request('GET', token, pathData + '/revisao/' + usuario1 + '/' + usuario2, body, function (resp) {
            console.log(resp);
        });

        usuario1 = 'lorenzo';
        usuario2 = 'matheus';
        body = {'motivo': '', 'gravidade': ''};
        request('POST', token, pathData + '/revisao/' + usuario1 + '/' + usuario2, body, function (resp) {
            console.log(resp);
        });

        usuario1 = 'lorenzo';
        ent1 = 'coordencao1';
        body = {'mensagem': ''};
        request('POST', token, pathData + '/post/' + usuario1 + '/' + ent1, body, function (resp) {
            console.log(resp);
        });

        //responder como entidade
        post1 = '1234135';
        body = {'email': '', 'mensagem': ''};
        request('POST', token, pathData + '/post/' + post1 + '/resposta/', body, function (resp) {
            console.log(resp);
        });

        usuario1 = 'lorenzo';
        usuario2 = 'matheus';
        idCoord = '123fasd';
        body = null;
        request('GET', token, pathData + '/revisao/' + idCoord + '/' + usuario1 + '/' + usuario2, body, function (resp) {
            console.log(resp);
        });*/

        usuario1 = 'lorenzo';
        usuario2 = 'matheus';
        idCoord = '123fasd';
        body = {'banir': ''};
        request('POST', token, pathData + '/revisao/' + idCoord + '/' + usuario1 + '/' + usuario2, body, function (resp) {
            console.log(resp);
        });

    </script>
</body>
</html>
