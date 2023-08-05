<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>

<?php
    require_once('conexao.php');

   $id = $_POST['id'];

   ##sql para selecionar apens um aluno
   $sql = "SELECT * FROM disciplina where id= :id";
   
   # junta o sql a conexao do banco
   $retorno = $conexao->prepare($sql);

   ##diz o paramentro e o tipo  do paramentros
   $retorno->bindParam(':id',$id, PDO::PARAM_INT);

   #executa a estrutura no banco
   $retorno->execute();

  #transforma o retorno em array
   $array_retorno=$retorno->fetch();
   
   ##armazena retorno em variaveis
   $nome = $array_retorno['nomedisciplina'];
   $idade = $array_retorno['idprofessor'];
   $datanascimento = $array_retorno['ch'];
   $endereco = $array_retorno['semestre'];


?>
<div class="heater heater-1">
    <h1> alterar DISCIPLINAS cadastrados</h1>
</div>

<div class="box-1">


  <div class="formulario"> 
  <form class="form-cadaluno" method="POST" action="crudaluno.php">
  <div class="intem-form item-1">
  <label for="">Nome aluno :</label>
        <input type="text" name="nomedisciplina" id="" value=<?php echo $nomedisciplina?> >
        </div>
        <div class="intem-form">
        <label for="">Idade:</label>
        <input type="text" name="idprofessor" id="" value=<?php echo $idprofessor ?> >
        </div>
        <div class="intem-form">
        <label for="">Data de Nascimento:</label>
        <input type="date" name="ch" id="" value=<?php echo $ch ?> >
        </div>
        <div class="intem-form">
        <label for="">endereço:</label>
        <input type="text" name="semestre" id="" value=<?php echo $semestre ?> >
        </div>

        <input type="hidden" name="id" id="" value=<?php echo $id ?> >
        
        <input  class="btn-footer-cadastrar cadastrar-1 btn-alterar"  type="submit" name="update" value="Alterar">


  </form>
          </div>
             </div>




</body>
</html>