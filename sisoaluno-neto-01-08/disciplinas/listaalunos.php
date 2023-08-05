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
   
  $retorno = $conexao->prepare('SELECT * FROM disciplina');
  $retorno->execute();

?>      

<div class="box">

<div class="heater heater-1">
    <h1>Disciplinas cadastradas</h1>
</div>

<div class="tabela">

        <table class="table"> 
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOME DISCIPLINA</th>
                    <th>ID PROFESSOR</th>
                    <th>CARGA HORARIA</th>
                    <th>SEMESTRE</th>
                  
                </tr>
            </thead>

            <tbody>
                <tr>
                    <?php foreach($retorno->fetchall() as $value) { ?>
                        <tr>
                            <td class="td"> <p class="item-id-td"> <?php echo $value['id'] ?> </p>   </td> 
                            <td class="td"> <p class="item-td"> <?php echo $value['nomedisciplina']?>  </td> 
                            <td class="td"> <p class="item-td"> <?php echo $value['idprofessor']?> </td> 
                            <td class="td"> <p class="item-td"> <?php echo $value['ch']?> </td> 
                            <td class="td"> <p class="item-td"> <?php echo $value['semestre']?> </td> 
                           
                            
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
                                        <input name="nome" type="hidden" value="<?php echo $value['nomedisciplina'];?>"/>
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
   <a href='cadaluno.php'><button class='btn-footer-cadastrar'>cadastrar novos alunos</button></a>
   <a href="http://localhost/sisoaluno-neto-01-08/aluno/index.php"> <button class='btn-footer-voltar'>voltar</button></a>
   </div>


</div>


</body>
</html>