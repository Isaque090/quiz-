<?php

$dbhost='localhost';
$dbUsername='root';
$dbPassword='';
$dbName='rank_perguntas';

$conexao=new mysqli($dbhost,$dbUsername,$dbPassword,$dbName);

//if($conexao->connect_error){
  //  echo"Erro";
//}
//else{
 //echo"certo";
//}

$conexao->set_charset("utf8mb4");

?>