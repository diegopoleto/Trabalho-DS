<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/conversas.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('modules/header.php'); ?>
    <div id="modalCriarConversa">
        <div class="container">
            <ul>
            </ul>
        </div>
    </div>
    <div class="container">
        <ul id="conversas">
            <a id="nova" href=""><li>Criar Conversa &#10133;</li></a>
        </ul>
        <div id="conversa">
            <div id="mensagens">
                 <ul></ul>
            </div>
            <div id="enviarMensagem">
                <textarea id="mensagem" name="mensagem" rows="3"></textarea>
                <div id="botoes">
                    <!--<button class="amarelo" id="enviarRevisao">Revisão</button>-->
                    <button class="verde" id="enviarMensagem">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <?php require('modules/footer.php'); ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/api.js"></script>
    <script src="js/utils.js"></script>
    <script>
        //pathData = 'http://165.227.86.76:3000';
        //pathData = 'http://165.227.86.76:3000';
        //pathData = 'http://localhost:3000';
        pathData = 'http://165.227.86.76/projetoDS/API';

        //pathServer = 'http://165.227.86.76/projetoDS/View/';
        pathServer = 'http://165.227.86.76/projetoDS/View/';

        interval = null;

        function listenerModalConversa(token, email, tipo) {
            $("ul#conversas a#nova").on("click", function (event) {
                event.preventDefault();

                body = {'pesquisa': ''};
                request('GET', token, email, pathData + '/conversas/' + email + '/usuarios/', body, function (resp) {
                    console.log(resp);
                    validateToken(resp.tokenPortal, resp, function (data) {
                        if(data.usuarios.length > 0){
                            $("div#modalCriarConversa ul").empty();
                            $("div#modalCriarConversa ul").append('<button type="button" id="fechar">Fechar</button>');
                            listenerCriarConversaFechar();

                            for (var i = 0; i < data.usuarios.length; i++) {

                                usuario = '<li><div class="nome">' + data.usuarios[i].nome + " " + data.usuarios[i].sobrenome + '</div>';
                                usuario += '<div class="tipo">' + data.usuarios[i].tipoDeUsuario + '</div>';
                                //usuario += '<button data-outro="' + data.usuarios[i].usuarioId + '" class="criarConversa vermelho normal">Criar Conversa Anônima</button></li>';
                                usuario += '<button data-outro="' + data.usuarios[i].email + '" class="criarConversa amarelo normal">Criar Conversa</button></li>';

                                $("div#modalCriarConversa ul").append(usuario);
                            }
                        }
                        $("div#modalCriarConversa").addClass("active");
                        listenerCriarConversa(token, email, tipo);
                    });
                });
            });
        }
        function listenerCriarConversaFechar() {
            $("div#modalCriarConversa ul button#fechar").on("click", function () {
                $("div#modalCriarConversa").removeClass("active");
            });
        }
        function listenerCriarConversa(token, email, tipo) {
            $("div#modalCriarConversa ul li button.criarConversa").on("click", function () {
                outro = $(this).data('outro');
                body = {};
                if($(this).hasClass("normal")){
                    body['anonima'] = 0;
                }
                else{
                    body['anonima'] = 1;
                }
                console.log("here");
                request('POST', token, email, pathData + '/conversas/' + email + '/' + outro, body, function (resp) {
                    if(resp.criado == false){
                        alert(resp.erro);
                    }
                    else{
                        validateToken(resp.tokenPortal, resp, function (data) {
                            $("ul#conversas").empty();
                            $("ul#conversas").append('<a id="nova" href=""><li>Criar Conversa &#10133;</li></a>');
                            $("div#modalCriarConversa").removeClass("active");
                            //$("ul#conversas").empty();
                            carregarConversas(token, email, tipo);

                            listenerModalConversa(token, email, tipo);
                        });
                    }
                }, function () {
                    console.log("error");
                });
            });
        }
        function listenerEnviarMensagem(token, email){
            $("div#enviarMensagem button#enviarMensagem").on("click", function () {
                outro = $("ul#conversas a.active").data('outro');
                mensagem = $("div#enviarMensagem textarea#mensagem").val();
                console.log(outro);
                console.log(mensagem);
                console.log(email);
                if(outro != null && outro != ''){
                    if(mensagem != null && mensagem != ''){
                        body = {'mensagem': mensagem, 'anonima': false};
                        request('POST', token, email, pathData + '/conversas/' + email + '/' + outro + '/mensagem/', body, function (resp) {
                            validateToken(resp.tokenPortal, resp, function (data) {
                                console.log(data);
                                carregarConversa(email, outro);
                                $("div#enviarMensagem textarea#mensagem").val('');
                            }, function () {
                                console.log('error');
                            });
                        });
                    }
                    else{
                        alert("Mensagem vazia");
                    }
                }
                else{
                    alert("Nenhuma conversa selecionada");
                }
            });
        }
        function listenerEnviarParaRevisao(token, email, tipo){
            $("div#enviarMensagem button#enviarRevisao").on("click", function () {
                outro = $("ul#conversas a.active").data('outro');
                body = {}
                if($(this).hasClass("normal")){
                    body['anonima'] = 'normal';
                }
                else{
                    body['anonima'] = 'anonima';
                }
                if(outro != null && outro != ''){
                    var confirmar;
                    var r = confirm("Você tem certeza que quer enviar essa mensagem para revisão para o coordenador do curso?");
                    if (r == true) {
                        request('POST', token, pathData + '/conversa/' + email + '/' + outro + '/revisao/', {}, body, function (resp) {
                            validateToken(resp.tokenPortal, resp, function (data) {
                                if(data.tokenPortal == token){
                                    alert("Conversa enviada para revisão.");
                                }
                                else{
                                    alert("Ocorreu um problema, contate os administradores");
                                }
                            });
                        }, function () {
                            console.log('error');
                        });
                    }
                }
                else{
                    alert("Nenhuma conversa selecionada");
                }
            });
        }
        function carregarConversa(email, outro) {
            console.log(pathData + '/conversas/' + email + '/' + outro);
            //body = {'ultimaMensagem': '', 'limite': '', 'isAnonima': 0};
            request('GET', token, email, pathData + '/conversas/' + email + '/' + outro, null, function (resp) {
                console.log(resp);
                validateToken(resp.tokenPortal, resp, function (data) {
                    if(data.mensagens.length > 0){
                        console.log(data);
                        $("div#conversa div#mensagens ul").empty();
                        for (var i = 0; i < data.mensagens.length; i++) {
                            mensagem = '';
                            if(data.mensagens[i].autor == email){
                                //eh da prorpia pessoa
                                mensagem = '<li class="voce"><div class="container">';
                                nome = window.localStorage.getItem("nomePortal") + " " + window.localStorage.getItem("sobrenomePortal");
                                mensagem += '<div class="nome">' + nome + '</div>';

                            }
                            else{
                                //eh do outro
                                mensagem = '<li class="outro"><div class="container">';
                                nome = $("ul#conversas a.active li").text();
                                mensagem += '<div class="nome">' + nome + '</div>';
                            }

                            /*if(data.mensagens[i].nome == '' || data.mensagens[i].nome == null){
                                mensagem += '<div class="nome">Anônimo</div>';
                            }
                            else{
                                mensagem += '<div class="nome">' + data.mensagens[i].nome + '</div>';
                            }*/
                            mensagem += '<div class="data">' + data.mensagens[i].dataCriacao + '</div>';
                            mensagem += '<p class="texto">' + data.mensagens[i].texto + '</p></div></li>';

                            $("div#conversa div#mensagens ul").append(mensagem);
                        }
                    }
                });
            }, function () {
                console.log("error");
            });
        }
        function listenerConversas(email) {
            $("ul#conversas a").on('click', function (event) {
                event.preventDefault();
                if($(this).attr('id') == 'nova'){
                    //ativa modal
                }
                else{
                    outro = $(this).attr('data-outro');
                    console.log('outro');
                    $("div#conversa div#mensagens ul").empty();
                    window.clearInterval(interval);
                    interval = setInterval(function(){
                        //console.log("hre");
                        carregarConversa(email, outro);
                    }, 5000);
                    $("ul#conversas a.active").removeClass('active');
                    $("ul#conversas a[data-outro='" + outro + "']").addClass('active');
                }
            });
        }
        function carregarConversas(token, email, tipo) {
            if (token != null && email != null) { //usuario logado
                body = null
                request('GET', token, email, pathData + '/conversas/' + email, body, function (resp) {
                    console.log(resp);
                    validateToken(resp.tokenPortal, resp, function (data) {
                        console.log(data);
                        if(data.usuarios.length > 0){
                            for (var i = 0; i < data.usuarios.length; i++) {
                                if(data.usuarios[i].nome == '' || data.usuarios[i].nome == null){
                                    conversa = '<a data-outro="' + data.usuarios[i].usuarioId + '"><li> Anônimo </li></a>';
                                }
                                else{
                                    conversa = '<a data-outro="' + data.usuarios[i].usuarioId + '"><li>' + data.usuarios[i].nome + '</li></a>';
                                }
                                $("ul#conversas").append(conversa);
                                if(i == 0){
                                    $("ul#conversas a:nth-of-type(2)").addClass('active');
                                    interval = setInterval(function(){
                                        //console.log("hre");
                                        //carregarConversa(email, outro);
                                        carregarConversa(email, $("ul#conversas a:nth-of-type(2)").data('outro'));
                                    }, 1000);
                                }
                            }
                            listenerConversas(email);
                        }
                    });
                }, function () {
                    console.log('error');
                });
            }
            else{
                console.log("nao logado")
                window.location.replace(pathServer + "welcome.php");
            }
        }
        function init() {
            token = window.localStorage.getItem("tokenPortal");
            email = window.localStorage.getItem("emailPortal");
            tipo = window.localStorage.getItem("tipoPortal");

            //$("ul#conversas a#nova").hide();
            /*if(tipo == 'ALUNO' || tipo == 'COORDENADOR' || tipo == 'ADMIN'){
                //if(tipo == 'aluno' || tipo == 'admin'){
            }*/
            $("ul#conversas a#nova").show();

            carregarConversas(token, email, tipo);
            listenerEnviarMensagem(token, email);
            //listenerEnviarParaRevisao(token, email);
            listenerModalConversa(token, email, tipo);
        }
        init();
    </script>
</body>
</html>
