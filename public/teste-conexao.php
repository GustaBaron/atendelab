<?php


$host = "localhost";
$banco = "atendelab";
$usuario = "root";
$senha = "";
$porta = "3307";
    try{
        $pdo = new PDO(
            "mysql:host=$host;port=$porta;dbname=$banco;charset=utf8",
            $usuario,
            $senha,
        );
        echo "Conexão Realizada com Sucesso!";

    } catch (PDOException $e){
        echo "Erro:" . $e->getMessage();
    }