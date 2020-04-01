<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/templateAdminCurso.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('modules/header.php'); ?>
        <div class="container " id= "templateAdminCurso">
            <div  class="card" id="leftcard">
                <!-- Substituir com a foto do usuário !-->
                <!--<img src="images/default-user.png" alt="default-user" id="default-user" width="128" height="128">-->
                <!-- Preencher os "h5" com os dados do usuário !-->
                <h3>Nome do usuário</h3>
                <div id="nome"></div>
                <h4>Data de Nascimento:</h4>
                <div id="dataNasc"> </div>
                <h4>Email:</h4>
                <div id="email"></div>
                <h4>Matrícula/Siape:</h4>
                <div id="matricula"></div>
                <!--<h4>Celular:</h4>
                <div id="telefone">Mostrar celular do usuário</div>-->
            </div>

            <!--<div class="card" id="rightcard">

                <div class="container" id="templateAdminCurso">
                    <div class="card" id="rigthcardson">
                        <!- Substituir com a foto do usuário !->
                        <img src="images/default-user.png" alt="default-user" id="default-user" width="50" height="50">
                        <button class="cinza" id="bot3">Editar imagem</button>
                    </div>
                </div>
                <form id="formulario" action="">
                    <!- Preencher os "placeholders" com os dados atuais do usuário !->
                    <div id="nomeInput"> </div>
                    <div id="sobrenomeInput"> </div>
                    <div id="cpfInput"> </div>
                    <div id="passwordInput"> </div>
                    <div id="telefoneInput"> </div>
                </form>
                <button class="cinza" id="bot1">Editar</button>
                <button class="vermelho" id="botDelete">Deletar Conta</button>
            </div>-->

        </div>
    <?php require('modules/footer.php'); ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/api.js"></script>
    <script src="js/utils.js"></script>
    <script>
        //pathData = 'http://165.227.86.76:3000';
        //pathData = 'http://localhost:3000';
        //pathServer = 'http://localhost/trabalhoDSDemo/View/';

        pathData = 'http://165.227.86.76/projetoDS/API';

        pathServer = 'http://165.227.86.76/projetoDS/View/';


        function carregarProfile(token, email, tipo) {
            if (token != null && email != null) { //usuario logado
                //body = {'usuarioId': email};
                request('GET', token, email, pathData + '/usuario/' + email, null, function (resp) {
                    validateToken(resp.tokenPortal, resp, function (data) {
                        console.log(data);
                        emailUsuario = '<div class="email">' + data.email + '</div>'
                        $("div#email").append(emailUsuario);
                        nomeUsuario = '<div class="nome">' + data.nome + " " + data.sobrenome + '</div>'
                        $("div#nome").append(nomeUsuario);
                        dataNascUsuario = '<div class="dataNasc">' + data.dataNascimento + '</div>'
                        $("div#dataNasc").append(dataNascUsuario);
                        if (data.tipoUsuario == 'ALUNO'){
                            matriculaUsuario = '<div class="matricula">' + data.matricula + '</div>'
                            $("div#matricula").append(matriculaUsuario);
                        } else {
                            matriculaUsuario = '<div class="matricula">' + data.siape + '</div>'
                            $("div#matricula").append(matriculaUsuario);
                        }
                        nomeUsuarioInput = '<input type="text" id="nomeUsuarioInp" ' + ' placeholder="' + data.sobrenome +'" name="nome">'
                        $("div#nomeInput").append(nomeUsuarioInput);
                        sobrenomeUsuarioInput = '<input type="text" id="sobrenomeUsuarioInp" ' + ' placeholder="' + data.sobrenome +'" name="sobrenome">'
                        $("div#nomeInput").append(sobrenomeUsuarioInput);
                        cpfUsuario = '<input type="text" id="cpfUsuarioInp" ' + ' placeholder="' + data.cpf +'" name="cpf">'
                        $("div#cpfInput").append(cpfUsuario);
                        /*passwordUsuario = '<input type="text" id="passwordUsuarioInp" ' + ' placeholder="' + data.password +'" name="password">'
                        $("div#passwordInput").append(passwordUsuario);
                        telefoneUsuario = '<input type="text" id="telefoneUsuarioInp" ' + ' placeholder="' + data.cpf +'" name="cpf">'
                        $("div#telefoneInput").append(telefoneUsuario);*/

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

        function listenerEditar(email, token, tipo) {
            $("button#bot1").on('click', function (event) {
                event.preventDefault();
                nome = document.getElementById('nomeUsuarioInp');
                sobrenome = document.getElementById('sobrenomeUsuarioInp');
                cpf = document.getElementById('cpfUsuarioInp');
                password = document.getElementById('passwordUsuarioInp');
                telefone = document.getElementById('telefoneUsuarioInp');

                editar(nome.value, sobrenome.value, cpf.value, password.value, telefone.value, email, token, tipo);
            });
        }

        function listenerDeletar(email, token, tipo) {

            $("button#botDelete").on("click", function (event) {
                event.preventDefault();
                deletar(email, token, tipo);
                });
        }


        function editar(nome, sobrenome, cpf, password, telefone, email, token, tipo) {
            $.ajax({
                method: "PUT",
                url: "/usuario/" + email,
                data: {
                    nome: nome,
                    sobrenome: sobrenome,
                    cpf: cpf,
                    password: password,
                    telefone: telefone
                }
            })
            .done(function(result) {
                console.log("sucesso: ", result);
                alert("Alterado com sucesso");
                $("form#formulario").empty();
                init();
            }).fail(function (error) {
                console.log("error", error);
            });
        }

        function deletar(email, token, tipo) {
            $.ajax({
                method: "DELETE",
                url: "/usuario/" + email
            })
            .done(function(result) {
                console.log("sucesso: ", result);
                init();
            }).fail(function (error) {
                console.log("error", error);
            });
        }




        function init() {
            token = window.localStorage.getItem("tokenPortal");
            //email = '<div class="email">' + window.localStorage.getItem("emailPortal") + '</div>';
            //$("div#email").append(email);
            tipo = window.localStorage.getItem("tipoPortal");
            email = window.localStorage.getItem("emailPortal");
            //nome = '<div class="nome">' + window.localStorage.getItem("nomePortal") + ' ' + window.localStorage.getItem("sobrenomePortal") +'</div>'
            //$("div#nome").append(nome);

            carregarProfile(token,email,tipo);
            listenerEditar(email, token, tipo);
            listenerDeletar(email, token, tipo);

        }
        init();

/*retorno = {
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
      "id": 2,
      'tokenPortal': '123'
    } */

    </script>
</body>
</html>
