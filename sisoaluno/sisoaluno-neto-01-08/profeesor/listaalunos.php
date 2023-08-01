<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>lista aluno</title>
</head>
<body>
    


<?php 
/*
 * Melhor prática usando Prepared Statements
 * 
 */
  require_once('conexao.php');
   
  $retorno = $conexao->prepare('SELECT * FROM professor');
  $retorno->execute();

?>      

<div class="box">

<div class="heater heater-1">
    <h1>professores cadastrados</h1>
</div>

<div class="tabela">

        <table class="table"> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOME</th>
                    <th>IDADE</th>
                    <th>DATA NASCIMENTO</th>
                    <th>ENDEREÇO</th>
                    <th>STATUS</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <?php foreach($retorno->fetchall() as $value) { ?>
                        <tr>
                            <td class="td"> <p class="item-id-td"> <?php echo $value['id'] ?> </p>   </td> 
                            <td class="td"> <p class="item-td"> <?php echo $value['nome']?>  </td> 
                            <td class="td"> <p class="item-td"> <?php echo $value['idade']?> </td> 
                            <td class="td"> <p class="item-td"> <?php echo $value['datanascimento']?> </td> 
                            <td class="td"> <p class="item-td"> <?php echo $value['endereco']?> </td> 
                            <td class="td"> <p class="item-td"> <?php echo $value['estatus']?> </td> 
                            
                            <td  class="td">
                               <form method="POST" action="altaluno.php">
                                <div class="btn-lista-aluno">
                                        <input name="id" type="hidden" value="<?php echo $value['id'];?>"/>
                                        <button class="botao-cadastrar btn-alterar" name="alterar"  type="submit">Alterar</button>
                                        </div>
                                </form>

                             </td> 

                             <td class="td">
                               <form method="GET" action="crudaluno.php">
                               <div class="btn-lista-aluno">
                                        <input name="id" type="hidden" value="<?php echo $value['id'];?>"/>
                                        <input name="nome" type="hidden" value="<?php echo $value['nome'];?>"/>
                                        <button class="botao-cadastrar btn-excluir"  name="excluir"  type="submit">Excluir</button>
                                        </div>
                                </form>

                             </td> 
                                     
                             
                              
                            


                       
                      </tr>
                    <?php  }  ?> 
                 </tr>
            </tbody>
        </table>
        </div>

       
<div class="btn-footer">
   <a href='cadaluno.php'><button class='btn-footer-cadastrar'>cadastrar novo professor</button></a>
   <a href='index.php'> <button class='btn-footer-voltar'>voltar</button></a>
   </div>


</div>


</body>
</html>