<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Revisao Conversas</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/revisao_conversas.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('modules/header.php'); ?>
    <div class="container">
        <ul id="conversas">
        </ul>
        <div id="conversa">
            <div id="mensagens">
                 <ul></ul>
            </div>
            <div id="enviarMensagem">
                <h3 id="usuario"></h3>
                <h3 id="gravidade"></h3>
                <p></p>
                <div id="botoes">
                    <button class="vermelho" id="enviarBanir">Banir</button>
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
        pathData = 'http://localhost:3000';
        pathServer = 'http://165.227.86.76/projetoDS/View/';

        function listenerEnviarParaRevisao(token, email){
            $("div#enviarMensagem button#enviarBanir").on("click", function () {
                quem = $(this).attr("data-banir");
                id1 = $("ul#conversas a.active").attr("data-id1");
                id2 = $("ul#conversas a.active").attr("data-id2");
                coord = $("ul#conversas a.active").attr("data-coord");

                if(quem != null && quem != '' && id1 != null && id1 != '' && id2 != null && id2 != '' && id1 != id2 && coord != '' && coord != null){
                    body = {'banir': true, 'quem': quem};
                    request('POST', token, pathData + '/revisao/' + coord + '/' + id1 + '/' + id2, body, function (resp) {
                        console.log(resp);
                        validateToken(resp.tokenPortal, resp, function (data) {
                            if(data.tokenPortal == token){
                                alert("Usuário banido");
                                location.reload();
                            }
                            else{
                                alert("Ocorreu um problema, contate os administradores");
                            }
                        });
                    });
                }
                else{
                    alert("Algum erro ocorreu");
                }
            });
        }
        function carregarConversa(email, id1, id2, nome1, nome2, coordenador) {
            body = {'ultimaMensagem': '', 'limite': ''};

            request('GET', token, pathData + '/revisao/' + coordenador + '/' + id1 + '/' + id2 , body, function (resp) {
                validateToken(resp.tokenPortal, resp, function (data) {
                    console.log(data);
                    if(data.mensagens.length > 0){
                        $("div#conversa div#mensagens ul").empty();
                        for (var i = 0; i < data.mensagens.length; i++) {
                            mensagem = '';
                            if(data.mensagens[i].usuarioId == id1){
                                //eh da prorpia pessoa
                                mensagem = '<li class="voce"><div class="container">';
                            }
                            else{
                                //eh do outro
                                mensagem = '<li class="outro"><div class="container">';
                            }

                            if(data.mensagens[i].nome == '' || data.mensagens[i].nome == null){
                                mensagem += '<div class="nome">Anônimo</div>';
                            }
                            else{
                                mensagem += '<div class="nome">' + data.mensagens[i].nome + " " + data.mensagens[i].sobrenome + '</div>';
                            }
                            mensagem += '<div class="data">' + data.mensagens[i].data + '</div>';
                            mensagem += '<p class="texto">' + data.mensagens[i].mensagem + '</p></div></li>';

                            $("div#conversa div#mensagens ul").append(mensagem);
                        }
                        $("div#enviarMensagem h3#usuario").text(data.usuarioNome + " " + data.usuarioSobrenome);
                        $("div#enviarMensagem h3#gravidade").text(data.gravidade);
                        $("div#enviarMensagem p").text(data.comentario);
                        $("div#enviarMensagem button#enviarBanir").attr('data-banir', data.usuarioId);
                    }

                });
            }, function () {
                console.log("error");
            });

        }
        function listenerConversas(email) {
            $("ul#conversas a").on('click', function (event) {
                event.preventDefault();
                id1 = $(this).data('id1');
                id2 = $(this).data('id2');
                nome1 = $(this).data('nome1');
                nome2 = $(this).data('nome2');
                coord = $(this).data('coord');
                carregarConversa(email, id1, id2, nome1, nome2, coord);
                $("ul#conversas a.active").removeClass('active');
                $("ul#conversas a[data-id1='" + id1 + "'][data-id2='" + id2 + "']").addClass('active');
            });
        }
        function carregarConversas(token, email, tipo) {
            if (token != null && email != null) { //usuario logado
                request('GET', token, pathData + '/revisaoAdmin/' + email, null, function (resp) {
                    validateToken(resp.tokenPortal, resp, function (data) {
                        console.log(data);
                        for (var i = 0; i < data.conversas.length; i++) {
                            //conversa = '<a  data-id1="' + data.conversas[i].usuario1.id + '" data-id2="' + data.conversas[i].usuario2.id + '" data-anonima="' + data.conversas[i].anonima + '">';
                            nome1 = data.conversas[i].usuario1.nome + ' ' + data.conversas[i].usuario1.sobrenome;
                            nome2 = data.conversas[i].usuario2.nome + ' ' + data.conversas[i].usuario2.sobrenome;
                            conversa = '<a  data-id1="' + data.conversas[i].usuario1.id + '" data-id2="' + data.conversas[i].usuario2.id + '" data-coord="' + data.conversas[i].coordenadorId + '"';
                            conversa += ' data-nome1="' + nome1 + '" data-nome2="' + nome2 + '">';
                            conversa += '<li>' + nome1 + ' - ' + nome2 + '</li></a>';
                            console.log(conversa);

                            $("ul#conversas").append(conversa);
                            if(i == 0){
                                $("ul#conversas a:nth-of-type(1)").addClass('active');
                                coordenador = data.conversas[i].coordenadorId;
                                //anonima = data.conversas[i].anonima;
                                carregarConversa(email, data.conversas[i].usuario1.id, data.conversas[i].usuario2.id, nome1, nome2, coordenador);
                            }
                        }
                        listenerConversas(email);
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

            if(tipo == 'coordenador'){
                carregarConversas(token, email, tipo);
                //listenerEnviarMensagem(token, email);
                listenerEnviarParaRevisao(token, email);
                //listenerModalConversa(token, email, tipo);
            }
            else{
                window.location.replace(pathServer + "welcome.php");
            }

        }
        init();
    </script>
</body>
</html>
