<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin_usuario</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/templateAdminUsuario.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
    
    <style>
        h2,h4 {
            text-align: left;
        }
    </style>
    
</head>
<body>
    <?php require('modules/header.php'); ?>
        <div class="container " id= "templateAdminCurso">  
            <div  class="card" id="leftcard">
                <h2>Usuários</h2>
                <button class="cinza" id="bot1">Huguinho</button>
                <button class="cinza" id="bot1">Zezinho</button>
                <button class="cinza" id="bot1">Luisinho</button>
            </div>
        
            <div class="card" id="rightcard">
                
                <div class="container" id="templateAdminCurso">
                    <div class="card" id="rigthcardson">
                        <button class="cinza" id="bot2">Curso</button>
                        <button class="cinza" id="bot2">Entidade</button>
                        <button class="cinza" id="bot2">Usuário</button>
                    </div>
                </div> 
                <form>
                    <input type="text" placeholder="Tipo usuário" name="tipoUsuario" id="form1">
                    <button class="cinza" id="bot3">Editar</button>
                    <input type="text" placeholder="Nome Usuário" name="nomeUsuario" id="form2">
                    <button class="cinza" id="bot4">Editar</button>
                    <input type="text" placeholder="Sobrenome Usuário" name="sobrenomeUsuario" id="form3">
                    <button class="cinza" id="bot5">Editar</button>
                </form>
                <h2>Informações:</h2>
                <h4>Matricula/Siape:</h4>
                <h4>Data de criação:</h4>
                <h2>Motivo de banimento:</h2>
                <form>
                    <input type="text" placeholder="Motivo de banimento" name="sobrenomeUsuario" id="form3">
                    <button class="cinza" id="bot6">Banir Usuario</button>
                </form>
                
                
                <button class="cinza" id="bot6">Finalizar</button>
            </div>
            
        </div>
    <?php require('modules/footer.php'); ?>
</body>
</html>
