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
                <button class="cinza" id="bot1">Secretaria</button>
                <button class="cinza" id="bot1">Colegiado</button>
                <button class="cinza" id="bot1">PRAE</button>
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
                    <input type="text" placeholder="Nome Entidade" name="nomeEntidade" id="form1">
                    <button class="cinza" id="bot3">Editar</button>
                    <input type="text" placeholder="Endereço Entidade" name="enderecoEntidade" id="form2">
                    <button class="cinza" id="bot4">Editar</button>
                    <input type="text" placeholder="Curso Vinculado" name="cursoVinculado" id="form3">
                    <button class="cinza" id="bot5">Editar</button>
                    <input type="text" placeholder="Descrição: " name="decricao" id="form3">
                    <button class="cinza" id="bot5">Editar</button>
                    <input type="text" placeholder="Código da Entidade" name="codEntidade" id="form3">
                    <button class="cinza" id="bot5">Editar</button>
                </form>
                <button class="cinza" id="bot6">Criar Entidade</button>
            </div>
            
        </div>
    <?php require('modules/footer.php'); ?>
</body>
</html>
