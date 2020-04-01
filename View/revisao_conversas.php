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
                <textarea id="mensagem" name="anotacao" rows="3"></textarea>
                <div id="botoes">
                    <select id="gravidade" name="gravidade">
                        <option value="baixa">Baixa</option>
                        <option value="media">Media</option>
                        <option value="alta">Alta</option>
                    </select>
                    <button class="verde" id="enviarRevisao1"></button>
                    <button class="verde" id="enviarRevisao2"></button>
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
            $("div#enviarMensagem button#enviarRevisao1, div#enviarMensagem button#enviarRevisao2").on("click", function () {
                id1 = $("ul#conversas a.active").data('id1');
                id2 = $("ul#conversas a.active").data('id2');
                anotacao = $("div#enviarMensagem textarea").val();
                gravidade = $( "div#enviarMensagem select option:selected" ).val();

                if(id1 != null && id1 != '' && id2 != null && id2 != '' && id1 != id2 && gravidade != '' && gravidade != null){
                    body = {'motivo': anotacao, 'gravidade': gravidade, 'usuarioId': $(this).data('id')};
                    request('POST', token, pathData + '/revisao/' + email + '/' + id1 + '/' + id2, body, function (resp) {
                        validateToken(resp.tokenPortal, resp, function (data) {
                            if(data.tokenPortal == token){
                                alert("Conversa enviada para revisão.");
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
        function carregarConversa(email, id1, id2, nome1, nome2) {
            body = {'ultimaMensagem': '', 'limite': ''};

            //request('GET', token, pathData + '/revisao/' + id1 + '/' + id2 , body, function (resp) {
            request('GET', token, pathData + '/conversa/' + id1 + '/' + id2 , body, function (resp) {
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
                                mensagem += '<div class="nome">' + data.mensagens[i].nome + '</div>';
                            }
                            mensagem += '<div class="data">' + data.mensagens[i].data + '</div>';
                            mensagem += '<p class="texto">' + data.mensagens[i].mensagem + '</p></div></li>';

                            $("div#conversa div#mensagens ul").append(mensagem);
                        }
                        $("div#enviarMensagem button#enviarRevisao1").text('Avaliar ' + nome1);
                        $("div#enviarMensagem button#enviarRevisao2").text('Avaliar ' + nome2);
                        $("div#enviarMensagem button#enviarRevisao1").attr('data-id', id1);
                        $("div#enviarMensagem button#enviarRevisao2").attr('data-id', id2);

                    }
                });
            }, function () {
                console.log("error");
            });

        }
        function listenerConversas(email, nome1, nome2) {
            $("ul#conversas a").on('click', function (event) {
                event.preventDefault();
                id1 = $(this).data('id1');
                id2 = $(this).data('id2');
                carregarConversa(email, id1, id2, nome1, nome2);
                $("ul#conversas a.active").removeClass('active');
                $("ul#conversas a[data-id1='" + id1 + "'][data-id2='" + id2 + "']").addClass('active');
            });
        }
        function carregarConversas(token, email, tipo) {
            if (token != null && email != null) { //usuario logado
                request('GET', token, pathData + '/revisao/' + email, null, function (resp) {
                    validateToken(resp.tokenPortal, resp, function (data) {
                        console.log(data);
                        for (var i = 0; i < data.conversas.length; i++) {
                            nome1 = data.conversas[i].usuario1.nome + ' ' + data.conversas[i].usuario1.sobrenome;
                            nome2 = data.conversas[i].usuario2.nome + ' ' + data.conversas[i].usuario2.sobrenome;
                            conversa = '<a  data-id1="' + data.conversas[i].usuario1.id + '" data-id2="' + data.conversas[i].usuario2.id + '"';
                            conversa += ' data-nome1="' + nome1 + '" data-nome2="' + nome2 + '">';
                            conversa += '<li>' + nome1 + ' - ' + nome2 + '</li></a>';

                            console.log(conversa);
                            $("ul#conversas").append(conversa);
                            if(i == 0){
                                $("ul#conversas a:nth-of-type(1)").addClass('active');
                                carregarConversa(email, data.conversas[i].usuario1.id, data.conversas[i].usuario2.id, nome1, nome2);
                            }
                        }
                        listenerConversas(email, nome1, nome2);
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
