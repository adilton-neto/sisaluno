<?php
##permite acesso as variaves dentro do aquivo conexao
require_once('conexao.php');

## Função para validar o cadastro
function validarCadastro($nomedisciplina, $idprofessor, $ch, $semestre) {
    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($nomedisciplina) || empty($idprofessor) || empty($ch) || empty($semestre)) {
        return "Todos os campos são obrigatórios.";
    }

//     // Verifica se a idade é um número inteiro positivo
//     if (!is_numeric($idade) || $idade <= 0 || floor($idade) != $idade) {
//         return "A idade deve ser um número inteiro positivo.";
//     }

//     // Verifica se a data de nascimento está em um formato válido (YYYY-MM-DD)
//     if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $datanascimento)) {
//         return "A data de nascimento deve estar no formato YYYY-MM-DD.";
//     }

//     // Retorna uma string vazia se a validação for bem-sucedida
   return "";
}

## Função para validar a alteração
function validarAlteracao($nomedisciplina, $idprofessor, $ch, $semestre) {
    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($nomedisciplina) || empty($idprofessor) || empty($ch) || empty($semestre)) {
        return "Todos os campos são obrigatórios.";
    }

    // Verifica se a idade é um número inteiro positivo
    if (!is_numeric($ch) || $ch <= 0 || floor($ch) != $ch) {
        return "A idade deve ser um número inteiro positivo.";
    }

    // Retorna uma string vazia se a validação for bem-sucedida
    return "";
}


##cadastrar
if(isset($_GET['cadastrar'])){
    ##dados recebidos pelo metodo GET
    $nomedisciplina = $_GET["nomedisciplina"];
    $idprofessor = $_GET["idprofessor"];
    $ch = $_GET["ch"];
    $semestre = $_GET["semestre"];
   

    ## Validar o cadastro antes de executar o SQL de inserção
    $validacao = validarCadastro($nomedisciplina, $idprofessor, $ch, $semestre);

    if (empty($validacao)) {
        ## Código SQL
        $sql = "INSERT INTO disciplina(nomedisciplina,idprofessor,ch,semestre) 
                VALUES('$nomedisciplina','$idprofessor','$ch','$semestre')";

        ## Junta o código SQL à conexão do banco
        $sqlcombanco = $conexao->prepare($sql);

        ## Executa o SQL no banco de dados
        if ($sqlcombanco->execute()) {
            echo "<strong>OK!</strong> O aluno $nomedisciplina foi incluído com sucesso!";
            echo "<button class='button'><a href='http://localhost/sisoaluno-neto-01-08/aluno/index.php'>Voltar</a></button>";
        }
    } else {
        echo "<strong>Erro!</strong> $validacao";
        echo "<button class='button'><a href='http://localhost/sisoaluno-neto-01-08/aluno/index.php'>Voltar</a></button>";
    }
}


## Alterar (Update)
if(isset($_POST['update'])) {
    ##dados recebidos pelo metodo POST
    $nomedisciplina = $_POST["nomedisciplina"];
    $idprofessor = $_POST["idprofessor"];
    $ch = $_POST["ch"];
    $semestre = $_POST["semestre"];

    ## Validar a alteração antes de executar o SQL de atualização
    $validacao = validarAlteracao($nomedisciplina, $idprofessor, $ch, $semestre);

    if (empty($validacao)) {
        ## Código SQL para atualização
        $sql = "UPDATE disciplina SET nomedisciplina = :nomedisciplina, idprofessor = :idprofessor, ch = :ch, semestre = :semestre WHERE id = :id";

        ## Junta o código SQL à conexão do banco
        $stmt = $conexao->prepare($sql);

        ## Define os parâmetros e os tipos dos parâmetros
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nomedisciplina', $nomedisciplina, PDO::PARAM_STR);
        $stmt->bindParam(':idprofessor', $idprofessor, PDO::PARAM_INT);
        $stmt->bindParam(':ch', $ch, PDO::PARAM_STR);
        $stmt->bindParam(':semestre', $semestre, PDO::PARAM_STR);
       

        $stmt->execute();

        if($stmt->execute()) {
            echo "<strong>OK!</strong> O aluno $nomedisciplina foi alterado com sucesso!";
            echo "<button class='button'><a href='http://localhost/sisoaluno-neto-01-08/aluno/index.php'>Voltar</a></button>";
        }
    } else {
        echo "<strong>Erro!</strong> $validacao";
        echo "<button class='button'><a href='http://localhost/sisoaluno-neto-01-08/aluno/index.php'>Voltar</a></button>";
        ?>
        
       
<?php

    }
}
   



if(isset($_GET['excluir'])){
    $id = $_GET['id'];

    // Verifica se o usuário confirmou a exclusão
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
        // Código para excluir o aluno
        $sql ="DELETE FROM `disciplina` WHERE id={$id}";
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        echo "<strong>OK!</strong> O aluno {$id} foi excluído!";
        echo " <button class='button'><a href='listaalunos.php'>Voltar</a></button>";
    } else {
        // Busca o nome do aluno associado ao ID
        $sql = "SELECT nomedisciplina FROM `disciplina` WHERE id={$id}";
        $stmt = $conexao->prepare($sql);
        $stmt->execute();
        $disciplina = $stmt->fetch(PDO::FETCH_ASSOC);

        // Se o aluno foi encontrado, exibe a mensagem de confirmação com o nome
        if ($disciplina) {
            $nomedisciplina = $disciplina['nomedisciplina'];
            echo "<strong>Atenção!</strong> Tem certeza que deseja excluir a disciplina {$id} - {$nomedisciplina}?";
            echo "<button class='button'><a href='?excluir=1&id=$id&confirm=true'>Sim</a></button>";
            echo "<button class='button'><a href='listaalunos.php'>Não</a></button>";
        } else {
            echo "<strong>Erro!</strong> Aluno não encontrado!";
            echo "<button class='button'><a href='listaalunos.php'>Voltar</a></button>";
        }
    }
}
?>
