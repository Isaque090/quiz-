<?php

$dbhost= $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST') ?? 'localhost';  
$port = $_ENV['MYSQLPORT'] ?? '3306';
$dbUsername=$_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER') ?? 'root';
$dbPassword=$_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD');
$dbName=$_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE') ?? 'railway';


$conexao=new mysqli($dbhost,$dbUsername,$dbPassword,$dbName,$port);

//if($conexao->connect_error){
  //  echo"Erro";
//}
//else{
 //echo"certo";
//}

$conexao->set_charset("utf8mb4");


?>

