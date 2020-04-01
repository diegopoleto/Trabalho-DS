<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PC - Cadastro</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/templateCadastro.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('modules/header_welcome.php'); ?>

    <div class="container">
        <div class="card shadow" id="templateCadastro">
            <img src="images/logo.jpg" alt="logo" id="logo">
            <form>
                <div class="cols">
                    <div class="col1" id="col">
                            <input type="text" placeholder="Nome" name="nome" required>
                            <input type="email" placeholder="Email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                            <input type="text" placeholder="CPF: 000.000.000-00"  maxlength="14">
                            <input type="password" placeholder="Senha" name="senha" required>
                            <input type="password" placeholder="Confirme sua senha" name="senhaConfirm" required>
                            <br>
                            <select id="dropdown" onchange="showOpt()" id="selectt" name="tipoUsuario">
                                <option value="aluno">Aluno</option>
                                <option value="funcionario">Funcionário</option>
                            </select>
                    </div>
                    <div class="col2" id="col">
                        <input type="text" placeholder="Sobrenome" name="sobrenome" required>
                        <input id="matricula" type="text" placeholder="Matrícula" name="matricula" pattern="[0-9]{8}" required>
                        <select id="curso" name="curso"></select>
                        <input id="siepe" style="display:none" type="text" placeholder="Siepe" name="siepe" required>
                        <input type="date" name="dataNascimento" required>
                    </div>
                </div>
                <button class="verde">Cadastrar</button>
            </form>
        </div>
    </div>

    <?php require('modules/footer.php'); ?>
    <script src="js/jquery.min.js"></script>
    <script src="js/api.js"></script>
    <script src="js/utils.js"></script>
    <script>
        //pathData = 'http://165.227.86.76:3000';
        pathData = 'http://165.227.86.76/projetoDS/API';
        //pathData = 'http://localhost:3000';

        //pathServer = 'http://localhost/trabalhoDSDemo/View/';
        pathServer = 'http://165.227.86.76/projetoDS/View/';

        cursos = [];

        //nao logar
        //removeUserData();

        //logar
        //storeUserData({"id": "lorenzofantunes@gmail.com", "email": "lorenzofantunes@gmail.com","nome": "Lorenzo","sobrenome": "Antunes","tipo": "coordenador","entidades": [{"nome": "Coordenacao Secretaria","id": 1}],"tokenPortal": "123","logado": true});
        /*function validaCPF($cpf) {
            $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

            if (strlen($cpf) != 11) {
                return false;
            }
            if (preg_match('/(\d)\1{10}/', $cpf)) {
                return false;
            }
            for ($t = 9; $t < 11; $t++) {
                for ($d = 0, $c = 0; $c < $t; $c++) {
                    $d += $cpf{$c} * (($t + 1) - $c);
                }
                $d = ((10 * $d) % 11) % 10;
                if ($cpf{$c} != $d) {
                    return false;
                }
            }
            return true;
        }*/

        function showOpt(){
            var selectOpt = document.getElementById("dropdown").value;
            if(selectOpt=="aluno"){
                document.getElementById("matricula").style.display="block";
                document.getElementById("curso").style.display="block";
                document.getElementById("siepe").style.display="none";
            } else{
                document.getElementById("matricula").style.display="none";
                document.getElementById("curso").style.display="none";
                document.getElementById("siepe").style.display="block";
            }
        }
        function listenerCadastrar() {
            $("form button").on("click", function (event) {
                event.preventDefault();

                var paramObj = pegarDadosForm('form');
                paramObj['tipoDeUsuario'] = paramObj['tipoUsuario'].toUpperCase();
                console.log(paramObj);

                body = paramObj;
                request('POST', null, null, pathData + '/usuario/', body, function (resp) {
                    console.log(resp);
                    if(resp.criado == true){
                        storeUserData(resp);
                        window.location.replace(pathServer + "login.php");
                    }
                    else {
                        alert(resp.erro);
                    }
                    /*validateToken(resp.tokenPortal, resp, function (data) {
                        storeUserData(data);
                    });*/
                }, function () {
                    alert("Hummm, aconteceu um erro, tente novamente");
                })
            });
        }
        function init() {
            token = window.localStorage.getItem("tokenPortal");
            email = window.localStorage.getItem("emailPortal");

            if (token != null && email != null) { //usuario logado
                console.log('logado');
                console.log('token', token);

                //valida token
                request('GET', token, email, pathData + '/auth/' + email, null, function (resp) {
                    console.log(resp);
                    if(resp.logado == true) {
                        storeUserData(resp);
                        window.location.replace(pathServer + "timeline.php");
                    }
                    else{
                        alert(resp.erro);
                    }
                });
            }
            else { //usuario nao logado
                console.log('nao logado');

                request('GET', null, null, pathData + '/curso/', null, function (resp) {
                    console.log(resp);
                    for (var i = 0; i < resp.length; i++) {
                        $("form select#curso").append(
                            '<option value="' + resp[i].codigoCurso + '">' + resp[i].nome + '</option>'
                        );
                    }
                });
                listenerCadastrar();
                showOpt();
            }
        }

        init();
    </script>
</body>
</html>
