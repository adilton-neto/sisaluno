<?php 
//Criar as constantes com as credencias de acesso ao banco de dados
define('localhost', 'localhost');
define('USUARIO', 'root');
define('SENHA', 'ifbaiano2023');
define('DBNAME', 'sisoaluno');

//Criar a conexão com banco de dados usando o PDO e a porta do banco de dados
//Utilizar o Try/Catch para verificar a conexão.
try {

    $conexao = new pdo('mysql:localhost=' . localhost . ';dbname=' .
                                     DBNAME, USUARIO, SENHA);
} catch (PDOException $e) {
    echo "Erro: Conexão com banco de dados não foi realizada com sucesso.
     Erro gerado " . $e->getMessage();
}


?>

<?php
//$servidor = 'Localhost';
//$usuario = 'root';
//$senha = 'ifbaiano2023' ;
//$dbname = 'sisoaluno';

//$conexao = new mysqli($servidor, $usuario, $senha, $dbname);

//if($conexao->connect_errno){
//echo "erro";

//}
//else{
//echo"coneção realizada com sucesso!!";

//}

?>