<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin_curso</title>
    <link rel="stylesheet" href="css/global.css">
    <link rel="stylesheet" href="css/templateAdminCurso.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Roboto|Press+Start+2P" rel="stylesheet">
</head>
<body>
    <?php require('modules/header.php'); ?>
        <div class="container " id= "templateAdminCurso">  
            <div  class="card" id="leftcard">
                <h2>Cursos</h2>
                <button class="cinza" id="bot1">Ciência da Computação</button>
                <button class="cinza" id="bot1">Engenharia da Computação</button>
                <button class="cinza" id="bot1">Nutrição</button>
            </div>
        
            <div class="card" id="rightcard">
                
                <div class="container" id="templateAdminCurso">
                    <div class="card" id="rigthcardson">
                        <button class="cinza" id="bot2">Curso</button>
                        <button class="cinza" id="bot2">Entidade</button>
                        <button class="cinza" id="bot2">Usuário</button>
                    </div>
                </div> 
                <input type="text" placeholder="Nome Curso" name="NomeCurso" id="form1">
                <button class="cinza" id="bot3">Editar</button>
                <button class="cinza" id="bot4">Finalizar</button>
            </div>
            
        </div>
    <?php require('modules/footer.php'); ?>
</body>
</html>
