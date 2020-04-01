<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Post</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/post.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('modules/header.php'); ?>
    <div id="post">
        <div class="container" id="container">
            <div class="card shadow" id="card">
                <h2>Post</h2>
                <h3 id="usuario"></h3>
                <div id="data"></div>
                <div id="entidade"></div>
                <p></p>
            </div>
            <div class="card shadow" id="card">
                <div id="resposta">
                    <h2>Resposta Oficial</h2>
                    <h3 id="entidade"></h3>
                    <div id="dataResposta"></div>
                    <p id="resposta"></p>
                </div>
            </div>

        </div>
    </div>
    <form action="" id="responderEntidades">
        <textarea name="resposta" rows="8" cols="80"></textarea>
        <br><input type="submit" name="" value="Responder">
    </form>

    <?php require('modules/footer.php'); ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/api.js"></script>
    <script src="js/utils.js"></script>
    <script>
        //pathData = 'http://localhost:3000';
        pathData = 'http://165.227.86.76:3000';
        //pathData = 'http://localhost:3000';

        pathServer = 'http://165.227.86.76/projetoDS/View/';

        var getUrlParameter = function getUrlParameter(sParam) {
            var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

            for (i = 0; i < sURLVariables.length; i++) {
                sParameterName = sURLVariables[i].split('=');

                if (sParameterName[0] === sParam) {
                    return sParameterName[1] === undefined ? true : sParameterName[1];
                }
            }
        };
        var postId = getUrlParameter('postId');

        function listenerResponderEntidade(postId) {
            $('form#responderEntidades').on('submit', function (event) {
                event.preventDefault();
                var paramObj = pegarDadosForm('form#responderEntidades');
                console.log(paramObj);
                body = {'email': window.localStorage.getItem("emailPortal"), 'mensagem': paramObj.resposta};
                request('POST', token, pathData + '/post/' + postId + '/resposta/', body, function (resp) {
                    validateToken(resp.tokenPortal, resp, function (data) {
                        console.log(data);
                    }, function () {
                        window.location.replace(pathServer + "welcome.php");
                    });
                });
            });
        }
        function formatarPost(dados, postId) {
            console.log(dados);
            if (dados.criador == ''){
                $("div#post h3#usuario").text('Anônimo');
            }
            else{
                $("div#post h3").text(dados.criador);
            }
            $("div#post div#data").text(dados.data);
            $("div#post div#entidade").text(dados.entidade.nome);
            $("div#post p").text(dados.texto);

            if(dados.entidade.resposta.texto != ''){
                $("div#post h3#entidade").text(dados.entidade.nome);
                $("div#post div#resposta div#dataResposta").text(dados.entidade.resposta.data);
                $("div#post div#resposta p#resposta").text(dados.entidade.resposta.texto);
            }
            else{
                $("div#post div#resposta").hide();
            }

            entidades = JSON.parse(window.localStorage.getItem("entidadesPortal"));

            for (var i = 0; i < entidades.length; i++) {
                if(entidades[i].id == dados.entidade.id){
                    $('form#responderEntidades').show();
                    listenerResponderEntidade(postId);
                    break;
                }
            }

        }
        function init(postId) {
            if(!$('form#responderEntidades').hasClass("active")){
                $('form#responderEntidades').hide();
            }

            token = window.localStorage.getItem("tokenPortal");
            email = window.localStorage.getItem("emailPortal");

            if(postId != null && postId != ''){
                request('GET', token, pathData + '/post/' + postId, null, function (resp) {
                    validateToken(resp.tokenPortal, resp, function (data) {
                        formatarPost(data, postId);
                    }, function () {
                        window.location.replace(pathServer + "welcome.php");
                    });
                });
            }
            else{
                //window.location.replace(pathServer + "welcome.php");
                history.back();
            }
            /*if (token != null && email != null) { //usuario logado
                console.log('logado');
                console.log('token', token);

                //valida token
                request('GET', token, pathData + '/auth/' + email, null, function (resp) {
                    validateToken(resp.tokenPortal, resp, function (data) {
                        console.log(data)
                        if(resp.logado) {
                            storeUserData(data);
                            window.location.replace(pathServer + "timeline.php");
                        }
                        else{
                            console.log('nao logado');
                        }
                    });
                });
            }
            else { //usuario nao logado
                console.log('nao logado');
            }*/
        }

        init(postId);
    </script>
</body>
</html>
