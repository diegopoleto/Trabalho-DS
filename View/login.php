<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/templateCadastro.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('modules/header_welcome.php'); ?>

    <div class="container">
        <div class="card small shadow" id="templateCadastro">
            <img src="images/logo.jpg" alt="logo" id="logo">
            <form action="">
                <input type="email" placeholder="Email" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
                <input type="password" placeholder="Senha" name="password" id="password" required>
                <div class="container">
                    <a href="pedir_reset_senha.php">Esqueceu a senha?</a>
                </div>
                <button class="verde">Logar</button>
            </form>
        </div>
    </div>
    <?php require('modules/footer.php'); ?>

    <script src="js/jquery.min.js"></script>
    <script src="js/api.js"></script>
    <script src="js/utils.js"></script>
    <script>
        pathData = 'http://165.227.86.76:3000';
        //pathData = 'http://localhost:3000';
        pathData = 'http://165.227.86.76/projetoDS/API';


        pathServer = 'http://165.227.86.76/projetoDS/View/';

        //nao logar
        //removeUserData();

        //logar
        //storeUserData({"id": "lorenzofantunes@gmail.com", "email": "lorenzofantunes@gmail.com","nome": "Lorenzo","sobrenome": "Antunes","tipo": "coordenador","entidades": [{"nome": "Coordenacao Secretaria","id": 1}],"tokenPortal": "123","logado": true});

        function listenerLogar() {
            $("form").on("submit", function (event) {
                event.preventDefault();
                //$(this).seri

                /*email = $("form input#email").val(),
                password = $("form input#password").val()
                $email = isset($_POST["email"]) ? addslashes(trim($_POST["email"])) : FALSE;
                $password = isset($_POST["password"]) ? md5(trim($_POST["password"])) : FALSE;
                if(!$email || !$password)
                {
                    echo "Você deve digitar sua senha e login!";
                    exit;
                }
                */

                body = {
                    "email": $("form input#email").val(),
                    "senha": $("form input#password").val()
                };
                console.log(body);
                request('POST', null, null, pathData + '/login/', body, function (resp) {
                    console.log(resp);
                    if(resp.logado == false){
                        alert(resp.erro);
                    }
                    else{
                        validateToken(resp.tokenPortal, resp, function (data) {
                            storeUserData(data);
                            window.location.replace(pathServer + "timeline.php");
                        });
                    }
                }, function (){
                    alert("Hummm, aconteceu um erro, tente novamente");
                });
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
                    validateToken(resp.tokenPortal, resp, function (data) {
                        console.log(data)
                        if(resp.logado == true) {
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
                listenerLogar();
            }
        }

        init();
    </script>
</body>
</html>
