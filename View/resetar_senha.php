<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pedir_Reset_Senha</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/templateCadastro.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('modules/header.php'); ?>

    <div class="container">
        <div class="card small shadow" id="templateCadastro">
            <img src="images/logo.jpg" alt="logo" id="logo">
            <form action="">
                <a href="">Digite sua nova senha!</a>
                <input type="password" placeholder="Nova senha" name="novaSenha" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="password">
                <input type="password" placeholder="Confirme sua nova senha" name="cNovaSenha" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" id="password2">
                <div class="container">
                </div>
                <button class="verde">Enviar</button>
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

        pathServer = 'http://165.227.86.76/projetoDS/View/';

        function ListenerResetarSenha(){
            $("form").on("submit", function (event) {
                event.preventDefault();
                $(this).seri
                novaSenha = $("form input#password").val(),
                validaNovaSenha = $("form input#password2").val()

                $(email = isset($_POST["email"]) ? addslashes(trim($_POST["email"]))) : FALSE;
                $(password = isset($_POST["password"]) ? md5(trim($_POST["password"]))) : FALSE;
                if(!$email || !$password)
                {
                    echo "Você deve digitar sua senha e login!";
                    exit;
                }

                if(novaSenha == validaNovaSenha){
                    body = {'password': ''}
                    request('POST', null, body, function (resp) {
                        console.log(resp);
                        window.location.replace(pathServer + "timeline.php");
                    });
                }else{
                    alert("Senhas diferentes! Tente novamente");
                }
            };
        };
    </script>
</body>
</html>
