<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Timeline</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/timeline.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('modules/header.php'); ?>
    <div class="container" id="container">
        <div class="card shadow" id="container">
            <form action="" id="criarPost">
                <textarea name="mensagem" rows="8" cols="80"></textarea>
                <br>
                <select id="entidade" name="entidade">
                    <option value="">Nenhuma</option>
                </select>
                <div id="anonimo">
                    <input type="radio" name="anonimo" value="false" checked> Público<br>
                    <input type="radio" name="anonimo" value="true"> Anônimo<br>
                </div>
                    <br><input type="submit" value="Criar Post">
            </form>
        </div>
    </div>
    <!--<div class="container" id="container">
        <div class="card shadow" id="rightcard">
                <button class="cinza" id="bot2">     Timeline    </button>
                <button class="cinza" id="bot2">Timeline Entidade</button>
        </div>
    </div>-->
    <div class="container" id="container">
        <div class="" id="container">
            <h1>Posts</h1>
            <div class="">
                <ul id="posts">

                </ul>
            </div>
        </div>
    </div>


    </div>
    <?php require('modules/footer.php'); ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/api.js"></script>
    <script src="js/utils.js"></script>
    <script>
        //pathData = 'http://localhost:3000';
        //pathData = 'http://165.227.86.76:3000';
        pathData = 'http://165.227.86.76/projetoDS/API';
        pathServer = 'http://165.227.86.76/projetoDS/View/';


        function listenerCriarPost(token) {
            $("form#criarPost").on("submit", function (event) {
                event.preventDefault();
                var paramObj = {};
                $.each($("form#criarPost").serializeArray(), function(_, kv) {
                    if (paramObj.hasOwnProperty(kv.name)) {
                        paramObj[kv.name] = $.makeArray(paramObj[kv.name]);
                        paramObj[kv.name].push(kv.value);
                    }
                    else {
                        paramObj[kv.name] = kv.value;
                    }
                });

                body = {};

                if(paramObj.anonimo == 'true'){
                    paramObj.anonimo = true;
                }
                else {
                    paramObj.anonimo = false;
                }

                if(paramObj.entidade == ''){
                    body = {'mensagem': paramObj.mensagem,'anonimo': paramObj.anonimo, 'email': window.localStorage.getItem("emailPortal")};
                }
                else{
                    body = {'mensagem': paramObj.mensagem, 'codigoEntidadeMarcada': paramObj.entidade, 'anonimo': paramObj.anonimo, 'email': window.localStorage.getItem("emailPortal")};
                }

                request('POST', token, window.localStorage.getItem("emailPortal"), pathData + '/post/', body, function (resp) {
                    console.log(resp);

                    validateToken(resp.tokenPortal, resp, function (data) {
                        window.location.reload();
                    }, function () {
                        //aconteceu algo errado
                        alert(resp.error);
                    });
                });
            });
        }
        function formatarForm(tipo, token, email) {
            $("form#criarPost select").hide();
            if(tipo != 'ALUNO'){
                $("form#criarPost div#anonimo").hide();
            }

            entidades = [];
            request('GET', token, email, pathData + '/entidade/', null, function (resp) {
                console.log(resp);
                validateToken(resp.tokenPortal, resp, function (data) {
                    entidades = data.entidades;
                    if(entidades.length > 0){
                        for (var i = 0; i < entidades.length; i++) {
                            $("form#criarPost select").append('<option value="' + entidades[i].codigoEntidade + '">' + entidades[i].nome + '</option>');
                        }
                        $("form#criarPost select").show();
                    }
                    if(tipo == 'aluno'){ //add opcao de ser anonimo
                        $("form#criarPost input").show();
                    }
                    listenerCriarPost(token);
                });
            }, function functionName() {
                //aconteceu algo errado
                window.location.replace(pathServer + "welcome.php");
            });
        }
        function montaPost(dados) {
            //criador = dados.criador;
            emailUsuarioCriador = dados.emailUsuarioCriador;
            criador = dados.nome + " " + dados.sobrenome;
            date = dados.dataCriacao;
            //entidade = dados.entidade;
            entidade = dados.nomeEntidadeMarcada;
            mensagem = dados.mensagem;
            postId = emailUsuarioCriador + ';' + date;
            post = '<li class="card shadow" data-id=' + postId + '><a href="post.php?postId=' + postId + '">';
            if (dados.anonimo == 0){
                post += '<h3>' + criador + '</h3>';
            }
            else{
                post += '<h3>Anônimo</h3>';
            }
            post += '<div class="data">' + date + '</div>';

            if (typeof(dados.nomeEntidadeMarcada) != "undefined"){
                post += '<div class="entidade">' + entidade + '</div>';
            }
            post += '<p>' + mensagem + '</p>';
            post += '</li>';
            return post;
        }
        function carregarPosts(email, idUltimoPost, tipo, token) {
            if (token != null && email != null) { //usuario logado
                body = {'usuarioId': email, 'idUltimoPost': idUltimoPost, 'tipoUsuario': tipo};
                request('POST', token, email, pathData + '/usuario/timeline/', body, function (resp) {
                    console.log(resp);
                    validateToken(resp.tokenPortal, resp, function (data) {
                        console.log(data.posts.length);
                        for (var i = 0; i < data.posts.length; i++) {
                            post = montaPost(data.posts[i]);
                            $("ul#posts").append(post);
                        }
                        /*if (idUltimoPost == null || idUltimoPost == ''){
                            $("ul#posts").after(
                                '<button id="carregarMais">Carregar Mais</button>'
                            );
                            listenerCarregarMais();
                        }*/
                    });
                }, function () {
                    console.log("error");
                });
            }
            else { //usuario nao logado
                alert("Você não está logado");
                window.location.replace(pathServer + "welcome.php");
            }
        }
        function listenerCarregarMais() {
            $("button#carregarMais").on("click", function () {
                token = window.localStorage.getItem("tokenPortal");
                email = window.localStorage.getItem("emailPortal");
                tipo = window.localStorage.getItem("tipoPortal");

                carregarPosts(email, $("ul#posts li:last-of-type").data("id"), tipo, token);
            });
        }
        function init () {
            token = window.localStorage.getItem("tokenPortal");
            email = window.localStorage.getItem("emailPortal");
            tipo = window.localStorage.getItem("tipoPortal");

            carregarPosts(email, '', tipo, token);
            formatarForm(tipo, token, email);
        }

        init();
    </script>
</body>
</html>
