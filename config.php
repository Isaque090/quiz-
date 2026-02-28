<?php

$dbhost= $_ENV['MYSQLHOST'] ?? getenv('MYSQLHOST') ?? 'localhost';  // fallback pro local
$dbUsername=$_ENV['MYSQLUSER'] ?? getenv('MYSQLUSER') ?? 'root';
$dbPassword=$_ENV['MYSQLPASSWORD'] ?? getenv('MYSQLPASSWORD');
$dbName=$_ENV['MYSQLDATABASE'] ?? getenv('MYSQLDATABASE') ?? 'railway';


$conexao=new mysqli($dbhost,$dbUsername,$dbPassword,$dbName);

//if($conexao->connect_error){
  //  echo"Erro";
//}
//else{
 //echo"certo";
//}

$conexao->set_charset("utf8mb4");


?>
