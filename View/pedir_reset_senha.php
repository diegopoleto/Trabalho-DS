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
                <a href="">Digite o email cadastro no Portal <br> Você receberá um email para alterar sua senha</a>
                <input type="email" placeholder="Email" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
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
        pathData = 'http://165.227.86.76/projetoDS/API';

        pathServer = 'http://165.227.86.76/projetoDS/View/';

        function listenerAskPass(){
            $("form").on("submit", function(event){
                event.preventDefault();
                email = $("form input#email").val();
                if (email != ''){
                    body = {
                        "email": email
                    };

                    request('POST', null, email, pathData + '/usuario/password/ask/', body, function(resp) {

                        console.log("asked: " + resp.asked);
                        alert('Foi enviado um link de recuperação de senha para o email digitado. Confira sua caixa de entrada.');
                        window.location.replace(pathServer + "login.php");
                    }, function () {
                        alert("erro");
                    });
                }
                else{
                    alert("Preencha o formulário");
                }
            });
        }

        listenerAskPass();
    </script>
</body>
</html>
