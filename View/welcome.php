<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bem vindo</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/templateCadastro.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">

    <style>
        a {
        color:black;
        text-decoration: none
        }
    </style>

</head>
<body>
    <?php require('modules/header_welcome.php'); ?>

    <div class="container">
        <div class="card small shadow" id="templateCadastro">
            <img src="images/logo.jpg" alt="logo" id="logo">
            <h2>Seja bem vindo ao maior Portal da Computação!</h2>
            <a href="cadastro.php"><button class="verde">Cadastrar</button></a>
            <a href="login.php"><button class="verde">Logar</button></a>
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

        pathServer = 'http://165.227.86.76/projetoDS/View/';


        //nao logar
        //removeUserData();

        //logar
        //storeUserData({"id": "lorenzofantunes@gmail.com", "email": "lorenzofantunes@gmail.com","nome": "Lorenzo","sobrenome": "Antunes","tipo": "coordenador","entidades": [{"nome": "Coordenacao Secretaria","id": 1}],"tokenPortal": "123","logado": true});

        function init() {
            token = window.localStorage.getItem("tokenPortal");
            email = window.localStorage.getItem("emailPortal");

            if (token != null && email != null) { //usuario logado
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
            }
        }

        init();
    </script>
</body>
</html>
