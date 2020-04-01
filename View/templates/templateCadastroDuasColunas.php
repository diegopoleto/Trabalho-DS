<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Template</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/templateCadastro.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('modules/header.php'); ?>

    <div class="container">
        <div class="card shadow" id="templateCadastro">
            <img src="images/logo.jpg" alt="logo" id="logo">
            <form action="">
                <div class="cols">
                    <div class="col" id="col1">
                        <input type="email" placeholder="Email" name="email">
                        <input type="password" placeholder="Senha" name="password">
                    </div>
                    <div class="col" id="col2">
                        <input type="email" placeholder="Email" name="email">
                        <input type="password" placeholder="Senha" name="password">
                    </div>
                </div>
                <button class="verde">Cadastrar</button>
            </form>
        </div>
    </div>

    <?php require('modules/footer.php'); ?>
</body>
</html>
