
<?php
##permite acesso as variáveis dentro do arquivo conexao
require_once('conexao.php');

## Função para validar o cadastro
function validarCadastro($nome, $idade, $datanascimento, $endereco, $estatus) {
    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($nome) || empty($idade) || empty($datanascimento) || empty($endereco) || empty($estatus)) {
        return "Todos os campos são obrigatórios.";
    }

    // Verifica se o nome contém apenas letras maiúsculas ou minúsculas
    if (!preg_match("/^[a-zA-Z]+$/", $nome)) {
        return "O nome deve conter apenas letras maiúsculas ou minúsculas.";
    }

    // Verifica se a idade é um número inteiro positivo
    if (!is_numeric($idade) || $idade <= 15 || floor($idade) != $idade) {
        return "A idade deve ser um número inteiro positivo. E o aluno a ser cadastrado deve ser maior de 16 anos";
    }

    // Verifica se a data de nascimento está em um formato válido (YYYY-MM-DD)
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $datanascimento)) {
        return "A data de nascimento deve estar no formato YYYY-MM-DD.";
    }

    // Retorna uma string vazia se a validação for bem-sucedida
    return "";
}

## Função para validar a alteração
function validarAlteracao($nome, $idade, $datanascimento, $endereco, $estatus) {
    // Verifica se todos os campos obrigatórios foram preenchidos
    if (empty($nome) || empty($idade) || empty($datanascimento) || empty($endereco) || empty($estatus)) {
        return "Todos os campos são obrigatórios.";
    }

    // Verifica se o nome contém apenas letras maiúsculas ou minúsculas
    if (!preg_match("/^[a-zA-Z]+$/", $nome)) {
        return "O nome deve conter apenas letras maiúsculas ou minúsculas.";
    }

    // Verifica se a idade é um número inteiro positivo
    if (!is_numeric($idade) || $idade <= 0 || floor($idade) != $idade) {
        return "A idade deve ser um número inteiro positivo.";
    }

    // Verifica se a data de nascimento está em um formato válido (YYYY-MM-DD)
    if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $datanascimento)) {
        return "A data de nascimento deve estar no formato YYYY-MM-DD.";
    }
    // Retorna uma string vazia se a validação for bem-sucedida
    return "";
}

##cadastrar
if(isset($_GET['cadastrar'])){
    ##dados recebidos pelo método GET
    $nome = $_GET["nomealuno"];
    $idade = $_GET["idade"];
    $datanascimento = $_GET["datanascimento"];
    $endereco = $_GET["endereco"];
    $estatus = $_GET["estatus"];

    ## Validar o cadastro antes de executar o SQL de inserção
    $validacao = validarCadastro($nome, $idade, $datanascimento, $endereco, $estatus);

    if (empty($validacao)) {
        ## Código SQL
        $sql = "INSERT INTO aluno(nome,idade,datanascimento,endereco,estatus) 
                VALUES('$nome','$idade','$datanascimento','$endereco','$estatus')";

        ## Junta o código SQL à conexão do banco
        $sqlcombanco = $conexao->prepare($sql);

        ## Executa o SQL no banco de dados
        if ($sqlcombanco->execute()) {
            echo "<strong>OK!</strong> O aluno $nome foi incluído com sucesso!";
            echo "<button class='button'><a href='index.php'>Voltar</a></button>";
        }
    } else {
        echo "<strong>Erro!</strong> $validacao";
        echo "<button class='button'><a href='index.php'>Voltar</a></button>";
    }
}

## Alterar (Update)
if(isset($_POST['update'])) {
    ##dados recebidos pelo método POST
    $nome = $_POST["nome"];
    $idade = $_POST["idade"];
    $datanascimento = $_POST["datanascimento"];
    $endereco = $_POST["endereco"];
    $estatus = $_POST["estatus"];
    $id = $_POST["id"];

    ## Validar a alteração antes de executar o SQL de atualização
    $validacao = validarAlteracao($nome, $idade, $datanascimento, $endereco, $estatus);

    if (empty($validacao)) {
        ## Código SQL para atualização
        $sql = "UPDATE aluno SET nome = :nome, idade = :idade, datanascimento = :datanascimento, endereco = :endereco, estatus = :estatus WHERE id = :id";

        ## Junta o código SQL à conexão do banco
        $stmt = $conexao->prepare($sql);

        ## Define os parâmetros e os tipos dos parâmetros
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':idade', $idade, PDO::PARAM_INT);
        $stmt->bindParam(':datanascimento', $datanascimento, PDO::PARAM_STR);
        $stmt->bindParam(':endereco', $endereco, PDO::PARAM_STR);
        $stmt->bindParam(':estatus', $estatus, PDO::PARAM_STR);

        $stmt->execute();

        if($stmt->execute()) {
            echo "<strong>OK!</strong> O aluno $nome foi alterado com sucesso!";
            echo "<button class='button'><a href='index.php'>Voltar</a></button>";
        }
    } else {
        echo "<strong>Erro!</strong> $validacao";
        echo "<button class='button'><a href='index.php'>Voltar</a></button>";
    }
}

if(isset($_GET['excluir'])){
    $id = $_GET['id'];

    // Verifica se o usuário confirmou a exclusão
    if (isset($_GET['confirm']) && $_GET['confirm'] === 'true') {
        // Código para excluir o aluno
        $sql ="DELETE FROM `aluno` WHERE id={$id}";
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
        $stmt = $conexao->prepare($sql);
        $stmt->execute();

        echo "<strong>OK!</strong> O aluno {$id} foi excluído!";
        echo " <button class='button'><a href='listaalunos.php'>Voltar</a></button>";
    } else {

             // Busca o nome do aluno associado ao ID
             $sql = "SELECT nome FROM `aluno` WHERE id={$id}";
             $stmt = $conexao->prepare($sql);
             $stmt->execute();
             $aluno = $stmt->fetch(PDO::FETCH_ASSOC);
     
             // Se o aluno foi encontrado, exibe a mensagem de confirmação com o nome
             if ($aluno) {
                 $nomeAluno = $aluno['nome'];
                 echo "<strong>Atenção!</strong> Tem certeza que deseja excluir o aluno {$id} - {$nomeAluno}?";
                 echo "<button class='button'><a href='?excluir=1&id=$id&confirm=true'>Sim</a></button>";
                 echo "<button class='button'><a href='listaalunos.php'>Não</a></button>";
             } else {
                 echo "<strong>Erro!</strong> Aluno não encontrado!";
                 echo "<button class='button'><a href='listaalunos.php'>Voltar</a></button>";
             }
         }
     }
     ?>