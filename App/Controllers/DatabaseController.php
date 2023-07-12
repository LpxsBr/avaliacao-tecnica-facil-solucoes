<?php
namespace App\Controllers;
use PDO;

class DatabaseController{

    protected $connection;

    protected $env;

    function __construct(){
        return $this->env = parse_ini_file('./.env');
    }

    function con(){
        $env = $this->env;
        try {
            $con = new PDO('mysql:host='.$env['DB_HOST'].';dbname='.$env['DB_NAME'], $env['DB_USERNAME'], $env['DB_PASSWORD']);
            return $this->connection = $con;
        } catch (PDOException $e) {
            return false;
        }
        return !($con) ? false : $this->connection = $con;
    }

    function fetch(){
        $con = $this->connection;
        $sql = 
            "
            SELECT
                ban.nome as nome_do_banco,
                conv.verba,
                con.codigo as codigo_do_contrato,
                con.data_inclusao,
                con.valor,
                con.prazo
            FROM
                tb_contrato con
            INNER JOIN tb_convenio conv ON con.convenio_servico = conv.codigo
            INNER JOIN tb_banco ban ON conv.codigo  = ban.codigo
            ";
        foreach ($con->query($sql) as $row){
            echo $row['nome_do_banco'].'|'.$row['verba'].'|'.$row['codigo_do_contrato'].'|'.$row['data_inclusao'].'|'.$row['valor'].'|'.$row['prazo']."\n";
            
            // testing if i'm using the browser
            if(isset($_SERVER['HTTP_USER_AGENT'])){
                echo '<br>';
            }else{
                // i will use the PHP_EOL if the cli to be the option
                echo PHP_EOL;
            }
        }
    }
}

?>