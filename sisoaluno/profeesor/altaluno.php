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
   $sql = "SELECT * FROM professor where id= :id";
   
   # junta o sql a conexao do banco
   $retorno = $conexao->prepare($sql);

   ##diz o paramentro e o tipo  do paramentros
   $retorno->bindParam(':id',$id, PDO::PARAM_INT);

   #executa a estrutura no banco
   $retorno->execute();

  #transforma o retorno em array
   $array_retorno=$retorno->fetch();
   
   ##armazena retorno em variaveis
   $nome = $array_retorno['nome'];
   $idade = $array_retorno['idade'];
   $datanascimento = $array_retorno['datanascimento'];
   $endereco = $array_retorno['endereco'];
   $estatus = $array_retorno['estatus'];


?>
<div class="heater heater-1">
    <h1> alterar alunos cadastrados</h1>
</div>

<div class="box-1">


  <div class="formulario"> 
  <form class="form-cadaluno" method="POST" action="crudaluno.php">
  <div class="intem-form item-1">
  <label for="">Nome aluno</label>
        <input type="text" name="nome" id="" value=<?php echo $nome?> >
        </div>
        <div class="intem-form">
        <label for="">Idade</label>
        <input type="text" name="idade" id="" value=<?php echo $idade ?> >
        </div>
        <div class="intem-form">
        <label for="">Data de Nascimento</label>
        <input type="date" name="datanascimento" id="" value=<?php echo $datanascimento ?> >
        </div>
        <div class="intem-form">
        <label for="">endereço</label>
        <input type="text" name="endereco" id="" value=<?php echo $endereco ?> >
        </div>
    
       <!-- <input type="text" name="estatus" id="" value=<?php echo $estatus ?> >  -->
       <div class="intem-form">
       <label for="">Status</label>
        <select class="input-item" id="" name="estatus">
            <option class="aprovado"  value=Aprovado <?php echo $estatus ?> > Aprovado</option>
            <option class="reprovado" value= Reprovado <?php echo $estatus ?> > Reprovado </option>
   
      </select>
      </div>

        <input type="hidden" name="id" id="" value=<?php echo $id ?> >
        
        <input  class="btn-footer-cadastrar cadastrar-1 btn-alterar"  type="submit" name="update" value="Alterar">


  </form>
          </div>
             </div>




</body>
</html>